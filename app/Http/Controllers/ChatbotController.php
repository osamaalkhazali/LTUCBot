<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use OpenAI;

class ChatbotController extends Controller
{
    /** @var \OpenAI\Client */
    private $client;

    /** Supported file extensions - Now accepts all common file types */
    private const SUPPORTED_EXTENSIONS = [
        // Documents
        'pdf',
        'docx',
        'doc',
        'xlsx',
        'xls',
        'csv',
        'pptx',
        'ppt',
        'odt',
        'ods',
        'odp',
        'rtf',
        // Text & Markup
        'txt',
        'md',
        'markdown',
        'rst',
        'tex',
        'log',
        'readme',
        'changelog',
        'license',
        // Data & Config
        'json',
        'xml',
        'yaml',
        'yml',
        'toml',
        'ini',
        'cfg',
        'conf',
        'properties',
        'env',
        // Programming Languages
        'js',
        'jsx',
        'ts',
        'tsx',
        'vue',
        'svelte',
        'react',
        'php',
        'py',
        'rb',
        'java',
        'kt',
        'scala',
        'groovy',
        'c',
        'cpp',
        'cc',
        'cxx',
        'h',
        'hpp',
        'hxx',
        'cs',
        'vb',
        'fs',
        'go',
        'rs',
        'swift',
        'dart',
        'r',
        'R',
        'matlab',
        'm',
        'octave',
        'pl',
        'pm',
        'lua',
        'sh',
        'bash',
        'zsh',
        'fish',
        'ps1',
        'bat',
        'cmd',
        // Web Technologies
        'html',
        'htm',
        'css',
        'scss',
        'sass',
        'less',
        'stylus',
        'sql',
        'mysql',
        'postgresql',
        'sqlite',
        'nosql',
        // Mobile Development
        'swift',
        'kotlin',
        'java',
        'dart',
        'xaml',
        // Data Science & AI
        'ipynb',
        'rmd',
        'jl',
        'nb',
        'mathematica',
        // Build & Deploy
        'dockerfile',
        'docker-compose',
        'makefile',
        'cmake',
        'gradle',
        'maven',
        'ant',
        'package',
        'lock',
        'requirements',
        'pipfile',
        'gemfile',
        'composer',
        // Version Control
        'gitignore',
        'gitattributes',
        'gitmodules',
        'hgignore',
        // Images
        'jpg',
        'jpeg',
        'png',
        'gif',
        'bmp',
        'webp',
        'svg',
        'ico',
        'tiff',
        'tif',
        // Archives
        'zip',
        'rar',
        '7z',
        'tar',
        'gz',
        'bz2',
        'xz',
        // Specialized
        'vim',
        'vimrc',
        'tmux',
        'zshrc',
        'bashrc',
        'profile',
        'editorconfig',
        'eslintrc',
        'prettierrc',
        'babelrc',
        'webpack',
        'tsconfig',
        'jsconfig',
        'tslint',
        'jshint',

        // Any extension (fallback)
        '*' // This allows any file type
    ];

    public function __construct()
    {
        // Build OpenAI client (disable SSL only in local dev)
        $httpOptions = [
            'verify'  => app()->environment('local') ? false : true,
            'timeout' => 60, // Increased timeout for vision API calls
            'connect_timeout' => 10,
        ];

        $this->client = OpenAI::factory()
            ->withApiKey(env('OPENAI_API_KEY'))
            ->withHttpClient(new \GuzzleHttp\Client($httpOptions))
            ->make();
    }

    /**
     * Parse PHP size string to bytes
     */
    private function parseSize(string $size): int
    {
        $size = trim($size);
        $last = strtolower($size[strlen($size) - 1]);
        $num = (int) $size;

        switch ($last) {
            case 'g':
                $num *= 1024;
            case 'm':
                $num *= 1024;
            case 'k':
                $num *= 1024;
        }

        return $num;
    }

    public function index()
    {
        return view('ltuc.chatbot', [
            'userName' => Auth::user()->name ?? 'Guest'
        ]);
    }

    public function chat(Request $request): JsonResponse
    {
        try {
            // Check PHP upload limits first
            $maxFileSize = min(
                $this->parseSize(ini_get('upload_max_filesize')),
                $this->parseSize(ini_get('post_max_size')),
                10 * 1024 * 1024 // Our 10MB limit
            );

            // Check if request size exceeds PHP limits
            $contentLength = $_SERVER['CONTENT_LENGTH'] ?? 0;
            if ($contentLength > $maxFileSize) {
                return response()->json([
                    'success' => false,
                    'message' => 'File too large for server configuration.',
                    'errors' => [
                        'files.*' => ["The file size exceeds server limits. Maximum allowed: " . ini_get('upload_max_filesize')]
                    ]
                ], 422);
            }

            // Conditional validation: require either message or files
            $hasFiles = $request->hasFile('files') && !empty($request->file('files'));
            $hasMessage = !empty($request->input('message'));

            if (!$hasMessage && !$hasFiles) {
                return response()->json([
                    'success' => false,
                    'message' => 'Please provide either a message or upload files.',
                ], 422);
            }

            // Validation with conditional message requirement
            $validationRules = [
                'files'     => 'nullable|array|max:5',
                'files.*'   => 'file|max:10240', // 10MB
                'clear_history' => 'nullable|boolean',
                'user_name' => 'nullable|string|max:255'
            ];

            if ($hasFiles && !$hasMessage) {
                // Files only - message is optional
                $validationRules['message'] = 'nullable|string|max:50000';
            } else {
                // Message required when no files or when both are present
                $validationRules['message'] = 'required|string|max:50000';
            }

            $request->validate($validationRules);

            // Handle conversation history
            $clearHistory = $request->boolean('clear_history', false);
            if ($clearHistory) {
                session()->forget('chat_history');
            }

            // Get existing conversation history
            $conversationHistory = session()->get('chat_history', []);

            $userMessage = $request->string('message')->toString();

            // Get user name for personalization
            $userName = $request->string('user_name')->toString() ?: 'Student';

            // Generate intelligent analysis prompt for file-only uploads
            if (!$hasMessage && $hasFiles) {
                $userMessage = $this->generateFileAnalysisPrompt($request->file('files'));
            }

            // Build messages array starting with system message
            $messages = [
                [
                    'role'    => 'system',
                    'content' => "You are LTUC Assistant, an AI learning companion for Luminus Technical University College (LTUC). You are currently helping {$userName}. Address them by name when appropriate and be helpful, encouraging, and professional in your responses.

🚀 ENHANCED FILE PROCESSING CAPABILITIES:

📋 **Documents & Data:**
- PDFs: Text extraction + image analysis (when possible)
- Word/Excel/PowerPoint: Text and embedded content
- Text files: Complete processing

💻 **Programming & Development:**
- ALL programming languages (Python, JavaScript, PHP, Java, C++, etc.)
- Web files (HTML, CSS, SQL)
- Config files (JSON, YAML, XML, ENV)
- Build files (Dockerfile, Makefile, package.json)
- Version control files (.gitignore, etc.)

📊 **Specialized Formats:**
- Jupyter notebooks: Full cell-by-cell analysis
- Images: Complete visual analysis with text extraction
- Archives: Guidance for extraction and analysis

🎯 **Code Analysis Expertise:**
- Read and explain code in any programming language
- Debug and suggest improvements
- Analyze project structure and dependencies
- Review algorithms and logic
- Explain coding concepts and best practices

📝 **FORMATTING GUIDELINES:**
Use markdown formatting to make your responses clear and well-structured:
- Use **bold** for important terms and concepts
- Use *italic* for emphasis
- Use `code` for inline code, variables, file names, or short snippets
- Use ```language blocks``` for multi-line code examples (ALWAYS specify the language)
- Use ## Headers for main sections
- Use ### Subheaders for subsections
- Use - or * for bullet lists
- Use 1. for numbered lists
- Use > for important quotes or notes
- Use [text](url) for links

💻 **CODE FORMATTING RULES:**
- ALWAYS wrap code in proper markdown blocks with language specification
- For PHP: ```php
- For JavaScript: ```javascript
- For HTML: ```html
- For CSS: ```css
- For JSON: ```json
- Use `backticks` for inline code, variables, and function names
- Provide complete, runnable code examples when possible
- Include comments in code to explain complex parts

🧠 **CONVERSATION CONTEXT:**
You have access to the full conversation history. Reference previous messages, files, and analyses when relevant to provide coherent, contextual responses. If a user asks about something from earlier in the conversation, refer back to it appropriately.

Always provide detailed, educational explanations and encourage learning through practical examples."
                ]
            ];

            // Add previous conversation history (limit to last 20 messages to avoid token limits)
            $recentHistory = array_slice($conversationHistory, -20);
            $messages = array_merge($messages, $recentHistory);

            // Prepare current user message
            $currentUserMessage = [
                'role'    => 'user',
                'content' => $userMessage,
            ];

            // Handle files for current message
            if ($request->hasFile('files')) {
                $attachmentsText = $this->buildAttachmentsContext($request->file('files'));
                if ($attachmentsText !== '') {
                    $currentUserMessage['content'] .= "\n\n---\nAttached files:\n" . $attachmentsText;
                }
            }

            // Add current message to conversation
            $messages[] = $currentUserMessage;

            // Call OpenAI
            $response = $this->client->chat()->create([
                'model'       => 'gpt-4o',
                'messages'    => $messages,
                'max_tokens'  => 16000, // Increased from 2000 to allow longer responses
                'temperature' => 0.7,
            ]);

            $reply = $response->choices[0]->message->content ?? 'Sorry, I could not generate a response.';

            // Save conversation to history
            $this->saveToConversationHistory($currentUserMessage, $reply);

            // Parse markdown and return both raw and HTML
            try {
                $htmlReply = $this->parseMarkdown($reply);
            } catch (\Throwable $markdownError) {
                Log::warning('Markdown parsing failed: ' . $markdownError->getMessage());
                $htmlReply = null; // Frontend will fall back to plain text
            }

            return response()->json([
                'success'   => true,
                'message'   => $reply,
                'html'      => $htmlReply,
                'timestamp' => now()->format('H:i'),
            ]);
        } catch (\Illuminate\Validation\ValidationException $ve) {
            Log::error('Validation Error: ' . json_encode($ve->errors()));
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors'  => $ve->errors(),
            ], 422);
        } catch (\Throwable $e) {
            Log::error('Chatbot error: ' . $e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine());

            // Check if it's a file upload error
            $errorMessage = 'Sorry, I encountered an error. Please try again in a moment.';

            if (
                str_contains($e->getMessage(), 'upload') ||
                str_contains($e->getMessage(), 'file') ||
                str_contains($e->getMessage(), 'size') ||
                $_SERVER['CONTENT_LENGTH'] > $maxFileSize ?? 0
            ) {

                $uploadLimit = ini_get('upload_max_filesize');
                $postLimit = ini_get('post_max_size');

                $errorMessage = "File upload error. Your file may be too large. Server limits: upload_max_filesize={$uploadLimit}, post_max_size={$postLimit}. Please try a smaller file or contact support.";
            }

            return response()->json([
                'success' => false,
                'message' => $errorMessage,
                'error'   => app()->environment('local') ? $e->getMessage() : null,
                'debug_info' => app()->environment('local') ? [
                    'upload_max_filesize' => ini_get('upload_max_filesize'),
                    'post_max_size' => ini_get('post_max_size'),
                    'max_file_uploads' => ini_get('max_file_uploads'),
                    'content_length' => $_SERVER['CONTENT_LENGTH'] ?? 'unknown'
                ] : null
            ], 500);
        }
    }

    /**
     * Build attachments text block with truncation and comprehensive file handling.
     */
    private function buildAttachmentsContext(array $files): string
    {
        $pieces = [];

        foreach ($files as $file) {
            if (!$file->isValid()) {
                $pieces[] = "- {$file->getClientOriginalName()}: invalid upload.";
                continue;
            }

            $name = $file->getClientOriginalName();
            $ext = strtolower($file->getClientOriginalExtension());
            $mimeType = $file->getMimeType() ?? '';
            $path = $file->getRealPath();

            // Check if file type is supported (now accepts all file types)
            if (!in_array($ext, self::SUPPORTED_EXTENSIONS) && !in_array('*', self::SUPPORTED_EXTENSIONS)) {
                $pieces[] = "- {$name}: Unsupported file type (.{$ext}).";
                continue;
            }

            $snippet = $this->extractFileContent($path, $ext, $mimeType, $name);
            $snippet = $this->cleanText($snippet);

            $pieces[] = "► File: {$name}\n{$snippet}";
        }

        $result = implode("\n\n", $pieces);

        return $result;
    }

    /**
     * Extract content from any supported file type.
     */
    private function extractFileContent(string $path, string $ext, string $mimeType, string $filename): string
    {
        try {
            // Handle images
            if ($this->isImageFile($ext)) {
                return $this->analyzeImageFile($path, $mimeType);
            }

            // Handle programming and text files
            if ($this->isTextBasedFile($ext, $mimeType)) {
                return $this->extractCodeOrTextFile($path, $ext, $filename);
            }

            // Handle PDFs
            if ($ext === 'pdf') {
                return $this->extractPdfContent($path, $filename);
            }

            // Handle Word documents
            if (in_array($ext, ['docx', 'doc', 'odt'])) {
                return $this->extractWordContent($path, $ext, $filename);
            }

            // Handle spreadsheets
            if (in_array($ext, ['xlsx', 'xls', 'csv', 'ods'])) {
                return $this->extractSpreadsheetContent($path, $ext, $filename);
            }

            // Handle presentations
            if (in_array($ext, ['pptx', 'ppt', 'odp'])) {
                return $this->extractPresentationContent($path, $ext, $filename);
            }

            // Handle archives
            if (in_array($ext, ['zip', 'rar', '7z', 'tar', 'gz'])) {
                return $this->extractArchiveContent($path, $ext, $filename);
            }

            // Handle Jupyter notebooks
            if ($ext === 'ipynb') {
                return $this->extractJupyterNotebook($path, $filename);
            }

            // Fallback: try as text file
            return $this->extractTextFile($path, $ext, $filename);
        } catch (\Throwable $e) {
            Log::error("File extraction error for {$filename}: " . $e->getMessage());
            return "File '{$filename}' could not be processed: " . $e->getMessage();
        }
    }

    /**
     * Check if file is an image
     */
    private function isImageFile(string $ext): bool
    {
        return in_array($ext, [
            'jpg',
            'jpeg',
            'png',
            'gif',
            'bmp',
            'webp',
            'svg',
            'ico',
            'tiff',
            'tif',
            'heic',
            'heif',
            'avif',
            'jfif',
            'pjpeg',
            'pjp',
            'apng',
            'raw',
            'cr2',
            'nef',
            'arw',
            'dng'
        ]);
    }

    /**
     * Check if file is text-based (programming, config, etc.)
     */
    private function isTextBasedFile(string $ext, string $mimeType): bool
    {
        $textExtensions = [
            // Programming languages
            'js',
            'jsx',
            'ts',
            'tsx',
            'vue',
            'svelte',
            'react',
            'php',
            'py',
            'rb',
            'java',
            'kt',
            'scala',
            'groovy',
            'c',
            'cpp',
            'cc',
            'cxx',
            'h',
            'hpp',
            'hxx',
            'cs',
            'vb',
            'fs',
            'go',
            'rs',
            'swift',
            'dart',
            'r',
            'R',
            'matlab',
            'm',
            'octave',
            'pl',
            'pm',
            'lua',
            'sh',
            'bash',
            'zsh',
            'fish',
            'ps1',
            'bat',
            'cmd',
            // Web technologies
            'html',
            'htm',
            'css',
            'scss',
            'sass',
            'less',
            'stylus',
            'sql',
            'mysql',
            'postgresql',
            'sqlite',
            'nosql',
            // Config and data
            'json',
            'xml',
            'yaml',
            'yml',
            'toml',
            'ini',
            'cfg',
            'conf',
            'properties',
            'env',
            'txt',
            'md',
            'markdown',
            'rst',
            'tex',
            'log',
            'readme',
            'changelog',
            'license',
            // Build files
            'dockerfile',
            'docker-compose',
            'makefile',
            'cmake',
            'gradle',
            'maven',
            'package',
            'lock',
            'requirements',
            'pipfile',
            'gemfile',
            'composer',
            'gitignore',
            'gitattributes',
            'gitmodules',
            'hgignore',
            // Editor configs
            'vim',
            'vimrc',
            'tmux',
            'zshrc',
            'bashrc',
            'profile',
            'editorconfig',
            'eslintrc',
            'prettierrc',
            'babelrc',
            'webpack',
            'tsconfig',
            'jsconfig',
            'tslint',
            'jshint'
        ];

        return in_array($ext, $textExtensions) || str_starts_with($mimeType, 'text/');
    }

    /**
     * Analyze image using GPT-4o vision with enhanced prompts.
     */
    private function analyzeImageFile(string $path, string $mimeType): string
    {
        try {
            // Validate the image file
            if (!file_exists($path)) {
                Log::error("Image file does not exist: {$path}");
                return 'Image file not found.';
            }

            $imageData = file_get_contents($path);
            if ($imageData === false) {
                Log::error("Failed to read image file: {$path}");
                return 'Unable to read image file.';
            }

            // Get file extension for format checking
            $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));

            // Validate image using getimagesize (skip for HEIC/HEIF as they may not be supported)
            $imageInfo = @getimagesize($path);
            if ($imageInfo === false && !in_array($ext, ['heic', 'heif', 'avif'])) {
                Log::error("Invalid image format or corrupted image: {$path}");
                return '❌ **Invalid Image**\n\nThe uploaded file appears to be corrupted or is not a valid image format.';
            }

            // Use the detected MIME type if available, otherwise use provided MIME type
            $actualMimeType = $imageInfo['mime'] ?? $mimeType;
            if ($actualMimeType !== $mimeType && $imageInfo !== false) {
                $mimeType = $actualMimeType;
            }

            // For HEIC/HEIF files, set proper MIME type if not detected
            if (in_array($ext, ['heic', 'heif']) && !str_contains($mimeType, 'heic') && !str_contains($mimeType, 'heif')) {
                $mimeType = $ext === 'heic' ? 'image/heic' : 'image/heif';
            }

            // Check image size constraints
            if (strlen($imageData) > 10 * 1024 * 1024) { // 10MB limit
                return '⚠️ **Image Too Large**\n\nThe image file is too large for analysis. Please resize the image to under 10MB and try again.';
            }

            $base64Data = base64_encode($imageData);

            $analysis = $this->analyzeImageData($mimeType, $base64Data, 'Analyze this image comprehensively. Extract ALL visible text exactly as written, describe any diagrams, charts, tables, formulas, educational content, handwritten notes, or important visual elements. Be thorough and detailed.');

            return $analysis;
        } catch (\Throwable $e) {
            Log::error('Image analysis failed: ' . $e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine());
            return "❌ **Image Analysis Error**\n\nI encountered an error while trying to analyze this image:\n" . $e->getMessage() . "\n\nPlease try uploading the image again or contact support if the issue persists.";
        }
    }

    /**
     * Analyze image data using GPT-4o vision with enhanced analysis.
     */
    private function analyzeImageData(string $mimeType, string $base64Data, string $prompt): string
    {
        try {
            // Validate the data URL format
            $dataUrl = "data:{$mimeType};base64,{$base64Data}";

            // For HEIC/HEIF, try to convert MIME type to something OpenAI might understand better
            $apiMimeType = $mimeType;
            if (str_contains($mimeType, 'heic') || str_contains($mimeType, 'heif')) {
                // OpenAI might handle these better as JPEG equivalent
                $apiMimeType = 'image/jpeg';
            }

            $apiDataUrl = "data:{$apiMimeType};base64,{$base64Data}";

            $response = $this->client->chat()->create([
                'model' => 'gpt-4o', // Use full gpt-4o model for better vision capabilities
                'messages' => [
                    [
                        'role' => 'user',
                        'content' => [
                            [
                                'type' => 'text',
                                'text' => $prompt . "\n\nPlease be very detailed and extract any text you see exactly as written. Include mathematical formulas, equations, code snippets, or any other textual content."
                            ],
                            [
                                'type' => 'image_url',
                                'image_url' => [
                                    'url' => $apiDataUrl,
                                    'detail' => 'high' // Request high detail analysis
                                ]
                            ]
                        ]
                    ]
                ],
                'max_tokens' => 1000, // Increased for more detailed analysis
            ]);

            $text = $response->choices[0]->message->content ?? '';

            if (empty($text)) {
                return "⚠️ Received empty response from vision analysis API. The image might be corrupted or in an unsupported format.";
            }

            // Check if OpenAI is indicating it cannot process the image
            if (
                str_contains(strtolower($text), "unable to analyze") ||
                str_contains(strtolower($text), "can't analyze") ||
                str_contains(strtolower($text), "cannot analyze") ||
                str_contains(strtolower($text), "i'm unable to") ||
                str_contains(strtolower($text), "i cannot") ||
                str_contains(strtolower($text), "sorry, i can't") ||
                str_contains(strtolower($text), "i'm having trouble") ||
                str_contains(strtolower($text), "provide a description") ||
                str_contains(strtolower($text), "convert the image") ||
                str_contains(strtolower($text), "try converting") ||
                str_contains(strtolower($text), "different format")
            ) {

                return "⚠️ **Image Processing Issue**\n\n" .
                    "The AI had difficulty processing this specific image. This can happen with:\n" .
                    "• Newer image formats (HEIC, HEIF, AVIF)\n" .
                    "• Very large or very small images\n" .
                    "• Images with unusual aspect ratios\n" .
                    "• Corrupted or partially uploaded files\n\n" .
                    "**Quick Fixes:**\n" .
                    "• Try uploading as JPG or PNG instead\n" .
                    "• Ensure good lighting and image quality\n" .
                    "• Check that the file uploaded completely\n\n" .
                    "**AI Response:** " . trim($text);
            }

            return "🔍 **Image Analysis:**\n" . trim($text);
        } catch (\Throwable $e) {
            Log::error('Vision API failed: ' . $e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine());

            $errorMessage = "❌ **Vision API Error**\n\n";

            // Provide specific error messages based on the error type
            if (str_contains($e->getMessage(), 'api_key')) {
                $errorMessage .= "API Key issue detected. Please check the OpenAI API key configuration.";
            } elseif (str_contains($e->getMessage(), 'rate_limit')) {
                $errorMessage .= "Rate limit exceeded. Please wait a moment and try again.";
            } elseif (str_contains($e->getMessage(), 'timeout') || str_contains($e->getMessage(), 'cURL error 28')) {
                $errorMessage .= "⏱️ **Network Timeout**\n\n" .
                    "The image analysis is taking longer than expected. This can happen with:\n" .
                    "• Large image files\n" .
                    "• Complex images with lots of text\n" .
                    "• Network connectivity issues\n\n" .
                    "**Solutions:**\n" .
                    "• Try resizing the image to a smaller size\n" .
                    "• Check your internet connection\n" .
                    "• Try again in a few moments";
            } elseif (str_contains($e->getMessage(), 'invalid_request')) {
                $errorMessage .= "Invalid request format. The image might be too large or in an unsupported format.";
            } else {
                $errorMessage .= "Error: " . $e->getMessage();
            }

            return $errorMessage;
        }
    }

    /**
     * Extract text from plain text files, code files, and other text-based content.
     */
    private function extractTextFile(string $path, ?string $ext = null, ?string $filename = null): string
    {
        $contents = @file_get_contents($path);
        if ($contents === false) {
            return 'Unable to read file.';
        }

        // Ensure UTF-8 encoding
        if (!mb_check_encoding($contents, 'UTF-8')) {
            $contents = mb_convert_encoding($contents, 'UTF-8', 'auto');
        }

        // Add file type context for better understanding
        $fileInfo = '';
        if ($ext && $filename) {
            $fileInfo = "📄 **{$filename}** (`.{$ext}` file)\n\n";

            // Add language context for code files
            $language = $this->getLanguageFromExtension($ext);
            if ($language) {
                $fileInfo .= "💻 **Programming Language**: {$language}\n\n";
            }
        }

        return $fileInfo . "```" . ($ext ?: 'text') . "\n" . trim($contents) . "\n```";
    }

    /**
     * Extract code or text files with proper formatting.
     */
    private function extractCodeOrTextFile(string $path, string $ext, string $filename): string
    {
        return $this->extractTextFile($path, $ext, $filename);
    }

    /**
     * Get programming language name from file extension.
     */
    private function getLanguageFromExtension(string $ext): ?string
    {
        $languages = ['js' => 'JavaScript', 'jsx' => 'JavaScript (React)', 'ts' => 'TypeScript', 'tsx' => 'TypeScript (React)', 'php' => 'PHP', 'py' => 'Python', 'rb' => 'Ruby', 'java' => 'Java', 'kt' => 'Kotlin', 'c' => 'C', 'cpp' => 'C++', 'cc' => 'C++', 'cxx' => 'C++', 'h' => 'C/C++ Header', 'cs' => 'C#', 'go' => 'Go', 'rs' => 'Rust', 'swift' => 'Swift', 'dart' => 'Dart', 'html' => 'HTML', 'css' => 'CSS', 'scss' => 'SCSS', 'sass' => 'Sass', 'sql' => 'SQL', 'sh' => 'Shell Script', 'bash' => 'Bash', 'ps1' => 'PowerShell', 'json' => 'JSON', 'xml' => 'XML', 'yaml' => 'YAML', 'yml' => 'YAML', 'dockerfile' => 'Docker', 'makefile' => 'Makefile', 'md' => 'Markdown'];

        return $languages[strtolower($ext)] ?? null;
    }

    /**
     * Extract content from presentation files.
     */
    private function extractPresentationContent(string $path, string $ext, string $filename): string
    {
        // For now, treat as unsupported but provide guidance
        return "📊 **Presentation File**: {$filename}\n\n" .
            "This appears to be a PowerPoint/presentation file. To analyze the content:\n" .
            "• Export slides as images (JPG/PNG) for visual analysis\n" .
            "• Copy text content and paste it directly\n" .
            "• Convert to PDF for text extraction\n\n" .
            "I can analyze exported slide images to read text and describe visual content!";
    }

    /**
     * Extract content from archive files.
     */
    private function extractArchiveContent(string $path, string $ext, string $filename): string
    {
        return "📦 **Archive File**: {$filename}\n\n" .
            "This is a compressed archive. To analyze the contents:\n" .
            "• Extract the files from the archive\n" .
            "• Upload individual files for analysis\n" .
            "• For code projects, upload key files like main source files\n\n" .
            "I can analyze any extracted files including code, documents, and images!";
    }

    /**
     * Extract content from Jupyter notebook files.
     */
    private function extractJupyterNotebook(string $path, string $filename): string
    {
        try {
            $contents = file_get_contents($path);
            if ($contents === false) {
                return 'Unable to read Jupyter notebook.';
            }

            $notebook = json_decode($contents, true);
            if (!$notebook || !isset($notebook['cells'])) {
                return 'Invalid Jupyter notebook format.';
            }

            $output = "📓 **Jupyter Notebook**: {$filename}\n\n";
            $cellCount = 0;

            foreach ($notebook['cells'] as $cell) {
                if ($cellCount >= 20) break; // Limit cells

                $cellType = $cell['cell_type'] ?? 'unknown';
                $source = $cell['source'] ?? [];

                if (is_array($source)) {
                    $content = implode('', $source);
                } else {
                    $content = (string)$source;
                }

                if (trim($content) !== '') {
                    $output .= "**Cell " . ($cellCount + 1) . " ({$cellType}):**\n";
                    $output .= "```" . ($cellType === 'code' ? 'python' : 'markdown') . "\n";
                    $output .= trim($content) . "\n```\n\n";
                    $cellCount++;
                }
            }

            return $output;
        } catch (\Throwable $e) {
            Log::error('Jupyter notebook extraction failed: ' . $e->getMessage());
            return "Jupyter notebook '{$filename}' could not be processed: " . $e->getMessage();
        }
    }

    /**
     * Extract content from PDF files with enhanced image analysis.
     */
    private function extractPdfContent(string $path, string $filename): string
    {
        $textContent = $this->extractPdfText($path);
        $imageAnalyses = [];

        // Enhanced PDF image analysis with higher resolution and more pages
        if (class_exists('Imagick')) {
            try {
                $imagickClass = '\\Imagick';
                $imagick = new $imagickClass();
                $imagick->setResolution(200, 200); // Higher resolution for better OCR
                $imagick->readImage($path . '[0-2]'); // First 3 pages
                $imagick->setImageFormat('jpeg');
                $imagick->setImageCompressionQuality(85); // Better quality

                foreach ($imagick as $i => $page) {
                    if ($i >= 3) break; // Limit to 3 pages
                    $page->setImageFormat('jpeg');
                    $page->setImageCompressionQuality(85);

                    // Enhance the image for better text recognition
                    $page->normalizeImage();
                    $page->contrastImage(true);

                    $blob = $page->getImageBlob();
                    if ($blob !== false) {
                        $b64 = base64_encode($blob);
                        $analysis = $this->analyzeImageData(
                            'image/jpeg',
                            $b64,
                            'Analyze this PDF page thoroughly. Extract ALL visible text, describe any images, diagrams, charts, tables, formulas, or educational content. Include any handwritten text or annotations you can see.'
                        );
                        $imageAnalyses[] = "📄 Page " . ($i + 1) . " visual analysis:\n" . $analysis;
                    }
                }
                $imagick->clear();
                $imagick->destroy();
            } catch (\Throwable $e) {
                Log::info('PDF to image conversion failed: ' . $e->getMessage());
            }
        } else {
            // Imagick not available - try alternative PDF image extraction
            Log::info('Imagick not available, attempting alternative PDF processing');
            $alternativeAnalysis = $this->extractPdfAlternative($path, $filename);
            if ($alternativeAnalysis) {
                $imageAnalyses[] = $alternativeAnalysis;
            } else if (!$textContent || trim($textContent) === '') {
                $imageAnalyses[] = "📄 **Scanned PDF Detected**\n\n" .
                    "This PDF appears to contain images or scanned content. I can help you analyze it if you convert it to images first!\n\n" .
                    "**🚀 Quick Solutions:**\n" .
                    "• **Best Option**: Convert PDF pages to JPG/PNG and upload them\n" .
                    "• **Online Tool**: Use smallpdf.com/pdf-to-jpg (free & fast)\n" .
                    "• **Mobile**: Use Adobe Scan or CamScanner to re-scan\n" .
                    "• **Copy/Paste**: If text is selectable, copy it directly\n\n" .
                    "💡 **Why Images Work Better**: I can analyze images using advanced vision AI to extract text, understand diagrams, read tables, and interpret any visual content!\n\n" .
                    "Ready to help once you have the images! 🎯📚";
            }
        }

        // Combine text and image analysis
        $result = [];
        if ($textContent && trim($textContent) !== '') {
            $result[] = "📝 PDF text content:\n" . $textContent;
        } else {
            $result[] = "📄 PDF '{$filename}' - text extraction failed (possibly scanned/image-based PDF).";
        }

        if (!empty($imageAnalyses)) {
            $result = array_merge($result, $imageAnalyses);
        } else if (!class_exists('Imagick') && (!$textContent || trim($textContent) === '')) {
            $result[] = "💡 **Tip**: For scanned PDFs, try converting pages to JPG/PNG images and uploading them separately - I can analyze images very effectively!";
        }

        return implode("\n\n", $result);
    }

    /**
     * Extract text from PDF using available libraries.
     */
    private function extractPdfText(string $path): ?string
    {
        // Try spatie/pdf-to-text with poppler
        if (class_exists(\Spatie\PdfToText\Pdf::class)) {
            try {
                $text = \Spatie\PdfToText\Pdf::getText($path);
                if (is_string($text) && trim($text) !== '') {
                    return $text;
                }
            } catch (\Throwable $e) {
                Log::info('Spatie PDF extraction failed: ' . $e->getMessage());
            }
        }

        // Try smalot/pdfparser as fallback
        if (class_exists(\Smalot\PdfParser\Parser::class)) {
            try {
                $parser = new \Smalot\PdfParser\Parser();
                $pdf = $parser->parseFile($path);
                $text = $pdf->getText();
                if (is_string($text) && trim($text) !== '') {
                    return $text;
                }
            } catch (\Throwable $e) {
                Log::info('Smalot PDF extraction failed: ' . $e->getMessage());
            }
        }

        return null;
    }

    /**
     * Alternative PDF processing when Imagick is not available.
     * This method attempts to extract embedded images or convert PDF using available tools.
     */
    private function extractPdfAlternative(string $path, string $filename): ?string
    {
        // Method 1: Try to extract embedded images from PDF
        $embeddedImages = $this->extractEmbeddedPdfImages($path);
        if (!empty($embeddedImages)) {
            $analyses = [];
            foreach ($embeddedImages as $i => $imageData) {
                [$mime, $b64] = $imageData;
                $analysis = $this->analyzeImageData(
                    $mime,
                    $b64,
                    'Analyze this image extracted from a PDF document. Extract ALL visible text exactly as written, describe any diagrams, charts, tables, formulas, or educational content.'
                );
                $analyses[] = "📄 Extracted Image " . ($i + 1) . ":\n" . $analysis;
            }
            return "🔍 **PDF Image Analysis Complete**\n\n" . implode("\n\n", $analyses);
        }

        // Method 2: Try using an online conversion service (if configured)
        $convertedImages = $this->convertPdfViaService($path);
        if (!empty($convertedImages)) {
            $analyses = [];
            foreach ($convertedImages as $i => $imageData) {
                [$mime, $b64] = $imageData;
                $analysis = $this->analyzeImageData(
                    $mime,
                    $b64,
                    'Analyze this PDF page converted to image. Extract ALL visible text, describe any diagrams, charts, tables, or educational content.'
                );
                $analyses[] = "📄 Page " . ($i + 1) . " Analysis:\n" . $analysis;
            }
            return "✅ **PDF Converted and Analyzed**\n\n" . implode("\n\n", $analyses);
        }

        // Method 3: Provide comprehensive guidance
        return $this->providePdfConversionGuidance($filename);
    }

    /**
     * Extract embedded images from PDF using smalot/pdfparser
     */
    private function extractEmbeddedPdfImages(string $path): array
    {
        $images = [];

        if (!class_exists(\Smalot\PdfParser\Parser::class)) {
            return $images;
        }

        try {
            $parser = new \Smalot\PdfParser\Parser();
            $pdf = $parser->parseFile($path);

            // Get document objects
            $objects = $pdf->getObjects();
            $imageCount = 0;

            foreach ($objects as $object) {
                if ($imageCount >= 3) break; // Limit to 3 images

                $header = $object->getHeader();
                $details = $object->getDetails();

                // Look for image objects
                if (
                    isset($details['Subtype']) &&
                    (strpos($details['Subtype'], 'Image') !== false || $details['Subtype'] === 'Image')
                ) {

                    $content = $object->getContent();
                    if ($content && strlen($content) > 200) { // Skip very small images

                        // Try to process the image data
                        $imageData = $this->processRawImageData($content, $details);
                        if ($imageData) {
                            $images[] = $imageData;
                            $imageCount++;
                        }
                    }
                }
            }
        } catch (\Throwable $e) {
            Log::info('PDF image extraction failed: ' . $e->getMessage());
        }

        return $images;
    }

    /**
     * Process raw image data from PDF
     */
    private function processRawImageData(string $content, array $details): ?array
    {
        try {
            // Handle different compression/filtering
            $processedContent = $content;

            if (isset($details['Filter'])) {
                $filter = is_array($details['Filter']) ? $details['Filter'][0] : $details['Filter'];

                switch ($filter) {
                    case 'FlateDecode':
                    case 'Fl':
                        $decompressed = @gzuncompress($content);
                        if ($decompressed !== false) {
                            $processedContent = $decompressed;
                        }
                        break;

                    case 'DCTDecode':
                        // JPEG data - use as is
                        break;

                    case 'CCITTFaxDecode':
                        // TIFF/Fax data - more complex to handle
                        Log::debug('CCITT Fax encoded image found - skipping');
                        return null;
                }
            }

            // Detect image format
            $header = substr($processedContent, 0, 10);

            // JPEG detection (FF D8 FF)
            if (substr($header, 0, 3) === "\xFF\xD8\xFF") {
                return ['image/jpeg', base64_encode($processedContent)];
            }

            // PNG detection (89 50 4E 47 0D 0A 1A 0A)
            if (substr($header, 0, 8) === "\x89PNG\r\n\x1a\n") {
                return ['image/png', base64_encode($processedContent)];
            }

            // If we can't detect format but it's substantial data, try as JPEG
            if (strlen($processedContent) > 1000) {
                Log::debug('Unknown image format, attempting as JPEG');
                return ['image/jpeg', base64_encode($processedContent)];
            }
        } catch (\Throwable $e) {
            Log::debug('Image data processing failed: ' . $e->getMessage());
        }

        return null;
    }

    /**
     * Convert PDF using external service (placeholder for future implementation)
     */
    private function convertPdfViaService(string $path): array
    {
        // This could be implemented to use services like:
        // - ConvertAPI
        // - PDF.co
        // - CloudConvert
        // For now, return empty array
        return [];
    }

    /**
     * Provide comprehensive PDF conversion guidance
     */
    private function providePdfConversionGuidance(string $filename): string
    {
        return "🔄 **PDF Image Conversion Guide**\n\n" .
            "I attempted to extract images from '{$filename}' but couldn't find processable image data. Here's how to convert it:\n\n" .
            "**📱 On Mobile/Tablet:**\n" .
            "• Use Adobe Scan, CamScanner, or Microsoft Office Lens\n" .
            "• Scan the document pages as individual images\n" .
            "• Upload the images here for analysis\n\n" .
            "**💻 On Computer:**\n" .
            "• Open PDF in Adobe Reader → File → Export To → Image → JPEG\n" .
            "• Or use online tools like SmallPDF, ILovePDF, or PDF24\n" .
            "• Save each page as JPG/PNG and upload here\n\n" .
            "**⚡ Quick Online Method:**\n" .
            "• Go to smallpdf.com/pdf-to-jpg\n" .
            "• Upload your PDF, download the images\n" .
            "• Upload the images to me for full analysis\n\n" .
            "Once you have the images, I can extract ALL text, analyze diagrams, and provide detailed insights! 🎯";
    }

    /**
     * Extract content from Word documents with enhanced embedded image analysis.
     */
    private function extractWordContent(string $path, string $ext, string $filename): string
    {
        $textContent = $this->extractWordText($path, $ext);
        $imageAnalyses = [];

        // Enhanced image extraction from DOCX/DOC
        if ($ext === 'docx' || ($ext === 'doc' && $textContent)) {
            $docxPath = $ext === 'docx' ? $path : $this->convertDocToDocx($path);
            if ($docxPath) {
                $images = $this->extractDocxImages($docxPath, 3); // Extract up to 3 images
                foreach ($images as $i => $imageData) {
                    [$mime, $b64] = $imageData;
                    $analysis = $this->analyzeImageData(
                        $mime,
                        $b64,
                        'Analyze this embedded document image in detail. Extract ALL visible text, describe any diagrams, charts, tables, formulas, screenshots, or educational content. Include any handwritten annotations or notes you can see.'
                    );
                    $imageAnalyses[] = "🖼️ Embedded image " . ($i + 1) . ":\n" . $analysis;
                }

                // Clean up temp file if DOC was converted
                if ($ext === 'doc' && $docxPath !== $path) {
                    @unlink($docxPath);
                }
            }
        }

        // Try alternative image extraction for DOC files if above fails
        if ($ext === 'doc' && empty($imageAnalyses)) {
            $altImages = $this->extractDocImagesAlternative($path);
            foreach ($altImages as $i => $imageData) {
                [$mime, $b64] = $imageData;
                $analysis = $this->analyzeImageData(
                    $mime,
                    $b64,
                    'Describe this image from the Word document, including any text or educational content.'
                );
                $imageAnalyses[] = "🖼️ Document image " . ($i + 1) . ":\n" . $analysis;
            }
        }

        // Combine text and image analysis
        $result = [];
        if ($textContent && trim($textContent) !== '') {
            $result[] = "📝 Document text:\n" . $textContent;
        } else {
            $result[] = "📄 Word document '{$filename}' - text extraction failed.";
        }

        if (!empty($imageAnalyses)) {
            $result = array_merge($result, $imageAnalyses);
        } else if ($ext === 'docx' || $ext === 'doc') {
            $result[] = "ℹ️ No embedded images found in this document.";
        }

        return implode("\n\n", $result);
    }

    /**
     * Extract text from Word documents.
     */
    private function extractWordText(string $path, string $ext): ?string
    {
        if ($ext === 'docx') {
            return $this->extractDocxText($path);
        }

        if ($ext === 'doc') {
            // Try to convert DOC to DOCX first
            $docxPath = $this->convertDocToDocx($path);
            if ($docxPath) {
                $text = $this->extractDocxText($docxPath);
                if ($docxPath !== $path) {
                    @unlink($docxPath);
                }
                return $text;
            }
        }

        return null;
    }

    /**
     * Convert DOC to DOCX using PHPWord.
     */
    private function convertDocToDocx(string $docPath): ?string
    {
        if (!class_exists(\PhpOffice\PhpWord\IOFactory::class)) {
            Log::warning('PHPWord not available for DOC conversion');
            return null;
        }

        try {
            $phpWord = \PhpOffice\PhpWord\IOFactory::load($docPath);
            $tempPath = sys_get_temp_dir() . '/' . uniqid() . '.docx';
            $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
            $objWriter->save($tempPath);
            return $tempPath;
        } catch (\Throwable $e) {
            Log::info('DOC to DOCX conversion failed: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Extract text from DOCX using ZIP parsing.
     */
    private function extractDocxText(string $path): ?string
    {
        if (!class_exists(\ZipArchive::class)) {
            Log::warning('ZipArchive not available for DOCX extraction');
            return 'DOCX extraction requires PHP Zip extension. Please enable ext-zip.';
        }

        try {
            $zip = new \ZipArchive();
            if ($zip->open($path) === true) {
                $xml = $zip->getFromName('word/document.xml');
                $zip->close();

                if ($xml !== false) {
                    // Convert paragraph breaks to newlines
                    $xml = preg_replace('/<\/w:p>/', "\n", $xml);
                    $text = strip_tags($xml);
                    $text = preg_replace('/\s+/', ' ', $text);
                    $text = preg_replace('/\n\s*\n/', "\n\n", $text);
                    return trim($text);
                }
            }
        } catch (\Throwable $e) {
            Log::info('DOCX text extraction failed: ' . $e->getMessage());
        }

        return null;
    }

    /**
     * Extract embedded images from DOCX with enhanced detection.
     */
    private function extractDocxImages(string $path, int $maxImages = 3): array
    {
        $images = [];
        if (!class_exists(\ZipArchive::class)) {
            return $images;
        }

        try {
            $zip = new \ZipArchive();
            if ($zip->open($path) === true) {
                for ($i = 0; $i < $zip->numFiles && count($images) < $maxImages; $i++) {
                    $stat = $zip->statIndex($i);
                    if (!$stat) continue;

                    $name = $stat['name'] ?? '';
                    // Look for images in both word/media/ and word/embeddings/
                    if (
                        (str_starts_with($name, 'word/media/') || str_starts_with($name, 'word/embeddings/')) &&
                        preg_match('/\.(png|jpe?g|gif|bmp|webp|tiff?|emf|wmf)$/i', $name)
                    ) {

                        $data = $zip->getFromIndex($i);
                        if ($data !== false && strlen($data) > 100) { // Skip tiny images
                            $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));
                            $mime = match ($ext) {
                                'jpg', 'jpeg' => 'image/jpeg',
                                'png' => 'image/png',
                                'gif' => 'image/gif',
                                'bmp' => 'image/bmp',
                                'webp' => 'image/webp',
                                'tif', 'tiff' => 'image/tiff',
                                'emf' => 'image/emf',
                                'wmf' => 'image/wmf',
                                default => 'image/jpeg'
                            };
                            $images[] = [$mime, base64_encode($data)];
                        }
                    }
                }
                $zip->close();
            }
        } catch (\Throwable $e) {
            Log::info('DOCX image extraction failed: ' . $e->getMessage());
        }

        return $images;
    }

    /**
     * Alternative method to extract images from DOC files using PHPWord.
     */
    private function extractDocImagesAlternative(string $path): array
    {
        $images = [];

        if (!class_exists(\PhpOffice\PhpWord\IOFactory::class)) {
            return $images;
        }

        try {
            $phpWord = \PhpOffice\PhpWord\IOFactory::load($path);

            // Try to extract images from sections
            foreach ($phpWord->getSections() as $section) {
                try {
                    $elements = $section->getElements();
                    $this->extractImagesFromElements($elements, $images, 2);
                } catch (\Throwable $e) {
                    Log::debug('Section element access failed: ' . $e->getMessage());
                }
                if (count($images) >= 2) break; // Limit to 2 images
            }
        } catch (\Throwable $e) {
            Log::info('DOC alternative image extraction failed: ' . $e->getMessage());
        }

        return $images;
    }

    /**
     * Recursively extract images from PHPWord elements.
     */
    private function extractImagesFromElements(array $elements, array &$images, int $maxImages): void
    {
        foreach ($elements as $element) {
            if (count($images) >= $maxImages) break;

            if ($element instanceof \PhpOffice\PhpWord\Element\Image) {
                try {
                    $imageSource = $element->getSource();
                    if ($imageSource && file_exists($imageSource)) {
                        $imageData = file_get_contents($imageSource);
                        if ($imageData !== false && strlen($imageData) > 100) {
                            $mime = mime_content_type($imageSource) ?: 'image/jpeg';
                            $images[] = [$mime, base64_encode($imageData)];
                        }
                    }
                } catch (\Throwable $e) {
                    Log::debug('Image element extraction failed: ' . $e->getMessage());
                }
            }

            // Recursively check nested elements if they have getElements method
            if (method_exists($element, 'getElements')) {
                try {
                    $nestedElements = $element->getElements();
                    if (is_array($nestedElements)) {
                        $this->extractImagesFromElements($nestedElements, $images, $maxImages);
                    }
                } catch (\Throwable $e) {
                    Log::debug('Nested element access failed: ' . $e->getMessage());
                }
            }
        }
    }

    /**
     * Extract content from spreadsheet files.
     */
    private function extractSpreadsheetContent(string $path, string $ext, string $filename): string
    {
        if ($ext === 'csv') {
            return $this->extractCsvContent($path);
        }

        if (!class_exists(\PhpOffice\PhpSpreadsheet\IOFactory::class)) {
            return "Spreadsheet '{$filename}' requires phpoffice/phpspreadsheet. Please install via Composer.";
        }

        if ($ext === 'xlsx' && !class_exists(\ZipArchive::class)) {
            return "XLSX file '{$filename}' requires PHP Zip extension. Please enable ext-zip.";
        }

        try {
            $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReaderForFile($path);
            $reader->setReadDataOnly(true);
            $spreadsheet = $reader->load($path);

            $output = [];
            $sheetLimit = 3;
            $sheets = $spreadsheet->getAllSheets();

            foreach ($sheets as $i => $sheet) {
                if ($i >= $sheetLimit) break;

                $title = $sheet->getTitle();
                $output[] = "Sheet: {$title}";

                $highestRow = min($sheet->getHighestRow(), 20); // Limit rows
                $highestCol = $sheet->getHighestColumn();
                $highestColIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestCol);
                $highestColIndex = min($highestColIndex, 10); // Limit columns

                for ($row = 1; $row <= $highestRow; $row++) {
                    $cells = [];
                    for ($col = 1; $col <= $highestColIndex; $col++) {
                        $colLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($col);
                        $cell = $sheet->getCell($colLetter . $row);
                        $value = trim((string)$cell->getFormattedValue());
                        $cells[] = $value;
                    }
                    $line = implode("\t", $cells);
                    if (trim($line) !== '') {
                        $output[] = $line;
                    }
                }
                $output[] = ''; // Empty line between sheets
            }

            return "Spreadsheet preview:\n" . implode("\n", $output);
        } catch (\Throwable $e) {
            Log::error("Spreadsheet extraction failed for {$filename}: " . $e->getMessage());
            return "Spreadsheet '{$filename}' could not be read: " . $e->getMessage();
        }
    }

    /**
     * Extract content from CSV files.
     */
    private function extractCsvContent(string $path): string
    {
        try {
            $rows = [];
            if (($handle = fopen($path, 'r')) !== false) {
                $limitRows = 20; // Limit rows
                while (($data = fgetcsv($handle)) !== false && $limitRows-- > 0) {
                    $rows[] = implode("\t", array_map('strval', $data));
                }
                fclose($handle);
            }

            return $rows ? "CSV preview:\n" . implode("\n", $rows) : 'CSV file is empty.';
        } catch (\Throwable $e) {
            Log::error('CSV extraction failed: ' . $e->getMessage());
            return 'CSV file could not be read.';
        }
    }

    /**
     * Clean and normalize text content.
     */
    private function cleanText(string $text): string
    {
        // Normalize line endings
        $text = str_replace(["\r\n", "\r"], "\n", $text);

        // Remove excessive whitespace
        $text = preg_replace('/[ \t]+/', ' ', $text);
        $text = preg_replace('/\n\s*\n\s*\n/', "\n\n", $text);

        // Ensure UTF-8 encoding
        if (!mb_check_encoding($text, 'UTF-8')) {
            $text = mb_convert_encoding($text, 'UTF-8', 'auto');
        }

        return trim($text);
    }

    /**
     * Parse markdown text to HTML with proper styling for LTUC theme
     */
    private function parseMarkdown(string $text): string
    {
        // Step 1: Handle code blocks and math expressions FIRST before any other processing
        $codeBlocks = [];
        $codeBlockCounter = 0;
        $mathBlocks = [];
        $mathBlockCounter = 0;

        // Extract math block expressions and replace with placeholders
        $text = preg_replace_callback('/\\\\\\[(.*?)\\\\\\]/s', function ($matches) use (&$mathBlocks, &$mathBlockCounter) {
            $mathContent = trim($matches[1]);
            $placeholder = "___MATHBLOCK_{$mathBlockCounter}___";

            $mathBlocks[$placeholder] = [
                'content' => $mathContent,
                'type' => 'block'
            ];

            $mathBlockCounter++;
            return $placeholder;
        }, $text);

        // Extract inline math expressions and replace with placeholders
        $text = preg_replace_callback('/\\\\\\((.*?)\\\\\\)/s', function ($matches) use (&$mathBlocks, &$mathBlockCounter) {
            $mathContent = trim($matches[1]);
            $placeholder = "___MATHBLOCK_{$mathBlockCounter}___";

            $mathBlocks[$placeholder] = [
                'content' => $mathContent,
                'type' => 'inline'
            ];

            $mathBlockCounter++;
            return $placeholder;
        }, $text);

        // Extract code blocks and replace with placeholders
        $text = preg_replace_callback('/```([a-zA-Z0-9+#-]*)\s*(.*?)\s*```/s', function ($matches) use (&$codeBlocks, &$codeBlockCounter) {
            $language = trim($matches[1]);
            $code = trim($matches[2]);
            $placeholder = "___CODEBLOCK_{$codeBlockCounter}___";

            $langDisplay = $language ? ucfirst($language) : 'Code';
            $uniqueId = 'code-' . uniqid();

            $codeBlocks[$placeholder] = [
                'language' => $language,
                'code' => $code,
                'display' => $langDisplay,
                'id' => $uniqueId
            ];

            $codeBlockCounter++;
            return "\n" . $placeholder . "\n";
        }, $text);

        // Step 2: Escape HTML for security (preserving placeholders)
        $text = htmlspecialchars($text, ENT_QUOTES, 'UTF-8');

        // Step 3: Parse other markdown elements
        $text = str_replace(["\r\n", "\r"], "\n", $text);

        // Headers
        $text = preg_replace_callback('/^(#{1,6})\s+(.+)$/m', function ($matches) {
            $level = strlen($matches[1]);
            $content = trim($matches[2]);
            $classes = [
                1 => 'text-2xl font-bold text-gray-900 mb-4 mt-6 border-b border-gray-200 pb-2',
                2 => 'text-xl font-bold text-gray-900 mb-3 mt-5',
                3 => 'text-lg font-semibold text-gray-800 mb-2 mt-4',
                4 => 'text-base font-semibold text-gray-800 mb-2 mt-3',
                5 => 'text-sm font-semibold text-gray-700 mb-1 mt-2',
                6 => 'text-sm font-medium text-gray-700 mb-1 mt-2'
            ];
            $class = $classes[$level] ?? $classes[6];
            return "<h{$level} class=\"{$class}\">{$content}</h{$level}>";
        }, $text);

        // Bold and italic
        $text = preg_replace('/\*\*(.*?)\*\*/', '<strong class="font-semibold text-gray-900">$1</strong>', $text);
        $text = preg_replace('/\*(.*?)\*/', '<em class="italic text-gray-800">$1</em>', $text);

        // Inline code
        $text = preg_replace('/`([^`]+)`/', '<code class="inline-code bg-gray-100 text-pink-600 px-2 py-1 rounded text-sm font-mono border">$1</code>', $text);

        // Links
        $text = preg_replace_callback('/\[([^\]]+)\]\(([^)]+)\)/', function ($matches) {
            $linkText = $matches[1];
            $url = $matches[2];
            if (filter_var($url, FILTER_VALIDATE_URL) || strpos($url, 'mailto:') === 0) {
                return "<a href=\"{$url}\" target=\"_blank\" class=\"text-blue-600 hover:text-blue-800 underline font-medium\">{$linkText}</a>";
            }
            return $matches[0];
        }, $text);

        // Step 4: Format math expressions
        foreach ($mathBlocks as $placeholder => $block) {
            $mathContent = $this->formatMathExpression($block['content']);

            if ($block['type'] === 'block') {
                $mathHtml = '<div class="math-block">
                    <div class="math-content">' . $mathContent . '</div>
                </div>';
            } else {
                $mathHtml = '<span class="math-inline">' . $mathContent . '</span>';
            }

            $text = str_replace($placeholder, $mathHtml, $text);
        }

        // Step 5: Restore code blocks with proper HTML
        foreach ($codeBlocks as $placeholder => $block) {
            $codeHtml = htmlspecialchars($block['code'], ENT_QUOTES, 'UTF-8');
            $langClass = $block['language'] ? ' data-language="' . $block['language'] . '"' : '';

            $codeBlockHtml = '<div class="code-block bg-gray-900 rounded-lg my-4 overflow-hidden border border-gray-700">
                <div class="code-header bg-gradient-to-r from-pink-500 to-purple-600 px-4 py-3 flex items-center justify-between">
                    <span class="text-sm font-semibold text-white">' . $block['display'] . '</span>
                    <button class="copy-btn text-xs bg-white bg-opacity-20 hover:bg-opacity-30 text-white px-3 py-1.5 rounded-md transition-all duration-200 font-medium" onclick="copyCode(\'' . $block['id'] . '\')">
                        <i class="fas fa-copy mr-1"></i>Copy
                    </button>
                </div>
                <div class="p-4 bg-gray-900">
                    <pre id="' . $block['id'] . '" class="font-mono whitespace-pre-wrap overflow-x-auto leading-relaxed border-0 m-0 p-0"' . $langClass . ' style="border-left: none; padding-left: 0; color: white !important; font-size: 14px;">' . $codeHtml . '</pre>
                </div>
            </div>';

            $text = str_replace($placeholder, $codeBlockHtml, $text);
        }

        // Step 6: Convert line breaks to paragraphs
        $paragraphs = explode("\n\n", $text);
        $paragraphs = array_map(function ($p) {
            $p = trim($p);
            if (empty($p)) return '';

            if (preg_match('/^<(h[1-6]|div|ul|ol|blockquote|hr|pre)/', $p)) {
                return $p;
            }

            $p = str_replace("\n", '<br>', $p);
            return "<p class=\"text-gray-800 leading-relaxed mb-3\">{$p}</p>";
        }, $paragraphs);

        return implode("\n", array_filter($paragraphs));
    }

    /**
     * Save user message and AI response to conversation history
     */
    private function saveToConversationHistory(array $userMessage, string $aiResponse): void
    {
        $conversationHistory = session()->get('chat_history', []);

        // Add user message
        $conversationHistory[] = $userMessage;

        // Add AI response
        $conversationHistory[] = [
            'role' => 'assistant',
            'content' => $aiResponse
        ];

        // Keep only the last 40 messages (20 exchanges) to manage memory and token usage
        if (count($conversationHistory) > 40) {
            $conversationHistory = array_slice($conversationHistory, -40);
        }

        session()->put('chat_history', $conversationHistory);
    }

    /**
     * Clear conversation history
     */
    public function clearHistory(Request $request): JsonResponse
    {
        session()->forget('chat_history');

        return response()->json([
            'success' => true,
            'message' => 'Conversation history cleared successfully.'
        ]);
    }

    /**
     * Get conversation history
     */
    public function getHistory(Request $request): JsonResponse
    {
        $conversationHistory = session()->get('chat_history', []);

        return response()->json([
            'success' => true,
            'history' => $conversationHistory,
            'count' => count($conversationHistory)
        ]);
    }

    /**
     * Format a mathematical expression with proper styling
     */
    private function formatMathExpression(string $expression): string
    {
        // Convert newlines to <br> tags
        $expression = str_replace("\n", "<br>", $expression);

        // Process LaTeX commands first

        // Process fractions (\frac{}{})
        $expression = preg_replace_callback('/\\\\frac\{(.*?)\}\{(.*?)\}/', function ($matches) {
            $numerator = $this->formatMathSubExpression($matches[1]);
            $denominator = $this->formatMathSubExpression($matches[2]);
            return '<span class="math-frac"><span class="math-frac-num">' . $numerator . '</span><span class="math-frac-line"></span><span class="math-frac-den">' . $denominator . '</span></span>';
        }, $expression);

        // Process multiplication (\times)
        $expression = str_replace('\\times', '<span class="math-op">×</span>', $expression);

        // Process division (\div)
        $expression = str_replace('\\div', '<span class="math-op">÷</span>', $expression);

        // Process other common LaTeX commands
        $latexCommands = [
            // Greek letters
            '\\alpha' => 'α',
            '\\beta' => 'β',
            '\\gamma' => 'γ',
            '\\delta' => 'δ',
            '\\epsilon' => 'ε',
            '\\zeta' => 'ζ',
            '\\eta' => 'η',
            '\\theta' => 'θ',
            '\\iota' => 'ι',
            '\\kappa' => 'κ',
            '\\lambda' => 'λ',
            '\\mu' => 'μ',
            '\\nu' => 'ν',
            '\\xi' => 'ξ',
            '\\pi' => 'π',
            '\\rho' => 'ρ',
            '\\sigma' => 'σ',
            '\\tau' => 'τ',
            '\\upsilon' => 'υ',
            '\\phi' => 'φ',
            '\\chi' => 'χ',
            '\\psi' => 'ψ',
            '\\omega' => 'ω',
            '\\Alpha' => 'Α',
            '\\Beta' => 'Β',
            '\\Gamma' => 'Γ',
            '\\Delta' => 'Δ',
            '\\Epsilon' => 'Ε',
            '\\Zeta' => 'Ζ',
            '\\Eta' => 'Η',
            '\\Theta' => 'Θ',
            '\\Iota' => 'Ι',
            '\\Kappa' => 'Κ',
            '\\Lambda' => 'Λ',
            '\\Mu' => 'Μ',
            '\\Nu' => 'Ν',
            '\\Xi' => 'Ξ',
            '\\Pi' => 'Π',
            '\\Rho' => 'Ρ',
            '\\Sigma' => 'Σ',
            '\\Tau' => 'Τ',
            '\\Upsilon' => 'Υ',
            '\\Phi' => 'Φ',
            '\\Chi' => 'Χ',
            '\\Psi' => 'Ψ',
            '\\Omega' => 'Ω',
            // Operations
            '\\pm' => '±',
            '\\mp' => '∓',
            '\\cdot' => '·',
            '\\neq' => '≠',
            '\\approx' => '≈',
            '\\equiv' => '≡',
            '\\leq' => '≤',
            '\\geq' => '≥',
            // Sets and logic
            '\\emptyset' => '∅',
            '\\in' => '∈',
            '\\notin' => '∉',
            '\\subset' => '⊂',
            '\\supset' => '⊃',
            '\\cup' => '∪',
            '\\cap' => '∩',
            '\\forall' => '∀',
            '\\exists' => '∃',
            '\\nexists' => '∄',
            '\\neg' => '¬',
            '\\land' => '∧',
            '\\lor' => '∨',
            // Calculus and misc
            '\\nabla' => '∇',
            '\\partial' => '∂',
            '\\infty' => '∞',
            '\\sum' => '∑',
            '\\prod' => '∏',
            '\\int' => '∫',
            '\\oint' => '∮',
        ];

        foreach ($latexCommands as $command => $symbol) {
            $expression = str_replace($command, '<span class="math-symbol">' . $symbol . '</span>', $expression);
        }

        // Process subscripts and superscripts
        // Subscripts with braces
        $expression = preg_replace_callback('/_{(.*?)}/', function ($matches) {
            return '<sub class="math-sub">' . $this->formatMathSubExpression($matches[1]) . '</sub>';
        }, $expression);

        // Superscripts with braces
        $expression = preg_replace_callback('/\^{(.*?)}/', function ($matches) {
            return '<sup class="math-sup">' . $this->formatMathSubExpression($matches[1]) . '</sup>';
        }, $expression);

        // Single character subscripts without braces
        $expression = preg_replace('/_([a-zA-Z0-9])/', '<sub class="math-sub">$1</sub>', $expression);

        // Single character superscripts without braces
        $expression = preg_replace('/\^([a-zA-Z0-9])/', '<sup class="math-sup">$1</sup>', $expression);

        // Process square roots
        $expression = preg_replace_callback('/\\\\sqrt\{(.*?)\}/', function ($matches) {
            $content = $this->formatMathSubExpression($matches[1]);
            return '<span class="math-sqrt">√<span class="math-sqrt-content">' . $content . '</span></span>';
        }, $expression);

        // Format variables (single letters) with special styling
        // But don't format if they are part of a LaTeX command
        $expression = preg_replace('/(?<!\\\\)\b([a-zA-Z])\b(?!\{)/', '<span class="math-var">$1</span>', $expression);

        // Format common mathematical operators with special styling
        $operators = [
            '+' => '<span class="math-op">+</span>',
            '-' => '<span class="math-op">-</span>',
            '*' => '<span class="math-op">*</span>',
            '/' => '<span class="math-op">/</span>',
            '=' => '<span class="math-op">=</span>',
            '<' => '<span class="math-op">&lt;</span>',
            '>' => '<span class="math-op">&gt;</span>',
        ];

        foreach ($operators as $op => $replacement) {
            // Use spacing to avoid replacing within variables or other text
            $expression = str_replace(' ' . $op . ' ', ' ' . $replacement . ' ', $expression);

            // Also handle operators at the beginning or end of the expression
            $expression = preg_replace('/^\\' . $op . ' /', $replacement . ' ', $expression);
            $expression = preg_replace('/ \\' . $op . '$/', ' ' . $replacement, $expression);
        }

        return $expression;
    }

    /**
     * Format a sub-expression within a larger math expression
     * This prevents double-formatting of nested elements
     */
    private function formatMathSubExpression(string $expression): string
    {
        // Simple formatting for sub-expressions to avoid over-processing
        // Format variables
        $expression = preg_replace('/(?<!\\\\)\b([a-zA-Z])\b(?!\{)/', '<span class="math-var">$1</span>', $expression);

        return $expression;
    }

    /**
     * Generate simple and direct analysis prompt for file-only uploads
     */
    private function generateFileAnalysisPrompt(array $files): string
    {
        $totalFiles = count($files);
        $fileNames = array_map(fn($file) => $file->getClientOriginalName(), $files);
        $fileList = implode(', ', array_map(fn($name) => "`{$name}`", $fileNames));

        if ($totalFiles === 1) {
            $file = $files[0];
            $extension = strtolower($file->getClientOriginalExtension());

            // Simple, direct prompts based on file type
            if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp', 'svg', 'heic', 'heif', 'avif', 'tiff'])) {
                return "Analyze this image. If it contains any questions or problems, solve them. Otherwise, describe what you see and ask me what I need help with.";
            } elseif (in_array($extension, ['pdf', 'doc', 'docx', 'txt', 'rtf'])) {
                return "Read and analyze this document. If it contains questions or exercises, solve them. Otherwise, summarize the content and ask what specific help I need.";
            } elseif (in_array($extension, ['php', 'js', 'html', 'css', 'py', 'java', 'cpp', 'c', 'cs', 'rb', 'go', 'rs', 'swift', 'kt', 'ts', 'jsx', 'vue', 'sql', 'json', 'xml', 'yaml', 'yml'])) {
                return "Review this code. Explain what it does and identify any issues or improvements. Ask me what specific help I need with it.";
            } elseif (in_array($extension, ['xls', 'xlsx', 'csv'])) {
                return "Analyze this spreadsheet data. Summarize the key information and ask what I need help with.";
            } else {
                return "Analyze this file and tell me what it contains. Ask me what specific help I need with it.";
            }
        } else {
            return "Analyze these {$totalFiles} files: {$fileList}. If any contain questions or problems, solve them. Otherwise, summarize what you found and ask what I need help with.";
        }
    }
}
