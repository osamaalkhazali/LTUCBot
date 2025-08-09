<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>LTUC AI Assistant</title>
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="shortcut icon" href="/favicon.ico">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        /* Brand colors */
        .ltuc-primary {
            background-color: #D60095;
        }

        .ltuc-secondary {
            background-color: #2E8570;
        }

        .ltuc-accent {
            background-color: #A84A9D;
        }

        .text-ltuc-dark {
            color: #333333;
        }

        .text-ltuc-light {
            color: #999999;
        }

        /* Bot icon styling */
        .bot-icon {
            width: 24px;
            height: 24px;
            object-fit: contain;
            /* filter: brightness(0) invert(1); Makes the icon white */
        }

        /* Message text wrapping */
        .message-content {
            word-wrap: break-word;
            overflow-wrap: break-word;
            word-break: break-word;
            hyphens: auto;
            max-width: 100%;
            min-width: 0;
        }

        /* Ensure proper text wrapping on all devices */
        .message-content p,
        .message-content div {
            word-wrap: break-word;
            overflow-wrap: break-word;
            word-break: break-word;
            max-width: 100%;
        }

        .message-animation {
            animation: slideIn 0.3s ease-out;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .typing-indicator {
            animation: pulse 1.5s infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 0.7;
            }

            50% {
                opacity: 1;
            }
        }

        .scroll-smooth::-webkit-scrollbar {
            width: 6px;
        }

        .scroll-smooth::-webkit-scrollbar-track {
            background: #f1f5f9;
        }

        .scroll-smooth::-webkit-scrollbar-thumb {
            background: #D60095;
            /* primary */
            border-radius: 3px;
        }

        /* quick actions removed */

        .file-chip {
            display: inline-flex;
            align-items: center;
            padding: 6px 10px;
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 0.75rem;
            font-size: 0.75rem;
            color: #6b7280;
            animation: slideIn 0.2s ease-out;
            max-width: 200px;
        }

        /* Math expression styles */
        .math-block {
            background-color: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 0.5rem;
            padding: 12px 16px;
            margin: 10px 0;
            overflow-x: auto;
            font-family: 'Cambria Math', 'STIX Two Math', serif;
        }

        .math-inline {
            font-family: 'Cambria Math', 'STIX Two Math', serif;
            padding: 2px 4px;
            background-color: #f9fafb;
            border-radius: 4px;
            display: inline-block;
            margin: 0 2px;
        }

        .math-content {
            font-size: 1.05rem;
            line-height: 1.5;
            color: #1f2937;
        }

        /* Style for variables */
        .math-var {
            color: #D60095;
            /* LTUC primary color */
            font-style: italic;
        }

        /* Style for operators */
        .math-op {
            color: #2E8570;
            /* LTUC secondary color */
            font-weight: 500;
        }

        /* Style for mathematical symbols */
        .math-symbol {
            color: #2E8570;
            font-weight: 500;
        }

        /* Style for fractions */
        .math-frac {
            display: inline-block;
            vertical-align: middle;
            text-align: center;
            margin: 0 3px;
        }

        .math-frac-num {
            display: block;
            padding: 0 3px;
            border-bottom: 1px solid #2E8570;
        }

        .math-frac-den {
            display: block;
            padding: 0 3px;
        }

        /* Style for square roots */
        .math-sqrt {
            position: relative;
            display: inline-block;
        }

        .math-sqrt-content {
            padding: 0 2px 0 0;
            border-top: 1px solid #2E8570;
            margin-left: 2px;
        }

        /* Style for subscripts and superscripts */
        .math-sub {
            font-size: 0.75em;
            position: relative;
            bottom: -0.4em;
            color: #D60095;
        }

        .math-sup {
            font-size: 0.75em;
            position: relative;
            top: -0.5em;
            color: #D60095;
        }

        .file-chip button {
            margin-left: 6px;
            color: #ef4444;
            transition: color 0.2s;
            flex-shrink: 0;
        }

        .file-chip button:hover {
            color: #dc2626;
        }

        /* Toaster Notifications */
        .toaster-container {
            position: relative;
            margin-bottom: 8px;
        }

        .toaster {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 12px 16px;
            margin-bottom: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08), 0 2px 4px rgba(0, 0, 0, 0.04);
            animation: toasterSlideDown 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
            position: relative;
            overflow: hidden;
            backdrop-filter: blur(10px);
        }

        .toaster::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, #D60095, #A84A9D);
            border-radius: 12px 12px 0 0;
        }

        .toaster.success::before {
            background: linear-gradient(90deg, #2E8570, #10b981);
        }

        .toaster.warning::before {
            background: linear-gradient(90deg, #f59e0b, #fbbf24);
        }

        .toaster.info::before {
            background: linear-gradient(90deg, #3b82f6, #60a5fa);
        }

        .toaster-removing {
            animation: toasterSlideUp 0.3s ease-in forwards;
        }

        @keyframes toasterSlideDown {
            from {
                opacity: 0;
                transform: translateY(-20px) scale(0.95);
                max-height: 0;
                margin-bottom: 0;
                padding-top: 0;
                padding-bottom: 0;
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
                max-height: 200px;
                margin-bottom: 8px;
                padding-top: 12px;
                padding-bottom: 12px;
            }
        }

        @keyframes toasterSlideUp {
            from {
                opacity: 1;
                transform: translateY(0) scale(1);
                max-height: 200px;
                margin-bottom: 8px;
                padding-top: 12px;
                padding-bottom: 12px;
            }

            to {
                opacity: 0;
                transform: translateY(-20px) scale(0.95);
                max-height: 0;
                margin-bottom: 0;
                padding-top: 0;
                padding-bottom: 0;
            }
        }

        .toaster-progress {
            position: absolute;
            bottom: 0;
            left: 0;
            height: 2px;
            background: linear-gradient(90deg, rgba(214, 0, 149, 0.3), rgba(168, 74, 157, 0.3));
            transition: width linear;
            border-radius: 0 0 12px 12px;
        }

        .toaster.success .toaster-progress {
            background: linear-gradient(90deg, rgba(46, 133, 112, 0.3), rgba(16, 185, 129, 0.3));
        }

        .toaster.warning .toaster-progress {
            background: linear-gradient(90deg, rgba(245, 158, 11, 0.3), rgba(251, 191, 36, 0.3));
        }

        .toaster.info .toaster-progress {
            background: linear-gradient(90deg, rgba(59, 130, 246, 0.3), rgba(96, 165, 250, 0.3));
        }

        .toaster-icon {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            margin-top: 2px;
            background: linear-gradient(135deg, #D60095, #A84A9D);
            box-shadow: 0 2px 8px rgba(214, 0, 149, 0.3);
        }

        .toaster.success .toaster-icon {
            background: linear-gradient(135deg, #2E8570, #10b981);
            box-shadow: 0 2px 8px rgba(46, 133, 112, 0.3);
        }

        .toaster.warning .toaster-icon {
            background: linear-gradient(135deg, #f59e0b, #fbbf24);
            box-shadow: 0 2px 8px rgba(245, 158, 11, 0.3);
        }

        .toaster.info .toaster-icon {
            background: linear-gradient(135deg, #3b82f6, #60a5fa);
            box-shadow: 0 2px 8px rgba(59, 130, 246, 0.3);
        }

        .toaster-content {
            flex: 1;
            min-width: 0;
            padding-top: 2px;
        }

        .toaster-title {
            font-weight: 600;
            font-size: 14px;
            line-height: 1.3;
            margin-bottom: 4px;
            color: #1f2937;
            font-family: 'Inter', sans-serif;
        }

        .toaster-message {
            font-size: 13px;
            line-height: 1.4;
            color: #6b7280;
            white-space: pre-line;
            font-family: 'Inter', sans-serif;
        }

        .toaster-close {
            width: 24px;
            height: 24px;
            border-radius: 6px;
            background: rgba(107, 114, 128, 0.1);
            border: none;
            color: #9ca3af;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            flex-shrink: 0;
            margin-top: 2px;
        }

        .toaster-close:hover {
            background: rgba(239, 68, 68, 0.1);
            color: #ef4444;
            transform: scale(1.1);
        }

        .toaster-close:active {
            transform: scale(0.95);
        }

        /* Image Preview Styles */
        .image-preview-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
            gap: 8px;
            margin-top: 12px;
            max-width: 400px;
        }

        .image-preview-item {
            position: relative;
            border-radius: 8px;
            overflow: hidden;
            background: #f3f4f6;
            aspect-ratio: 1;
            cursor: pointer;
            transition: all 0.2s ease;
            border: 2px solid transparent;
        }

        .image-preview-item:hover {
            transform: scale(1.02);
            border-color: #D60095;
            box-shadow: 0 4px 12px rgba(214, 0, 149, 0.2);
        }

        .image-preview-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .image-preview-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(45deg, rgba(0, 0, 0, 0.1), rgba(0, 0, 0, 0.3));
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.2s ease;
        }

        .image-preview-item:hover .image-preview-overlay {
            opacity: 1;
        }

        .image-preview-icon {
            color: white;
            font-size: 18px;
            text-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
        }

        /* Image Modal */
        .image-modal {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.9);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            backdrop-filter: blur(8px);
        }

        .image-modal.active {
            opacity: 1;
            visibility: visible;
        }

        .image-modal-content {
            position: relative;
            max-width: 90vw;
            max-height: 90vh;
            transform: scale(0.8);
            transition: transform 0.3s ease;
        }

        .image-modal.active .image-modal-content {
            transform: scale(1);
        }

        .image-modal img {
            max-width: 100%;
            max-height: 90vh;
            object-fit: contain;
            border-radius: 12px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }

        .image-modal-close {
            position: absolute;
            top: -40px;
            right: 0;
            width: 32px;
            height: 32px;
            background: rgba(255, 255, 255, 0.2);
            border: none;
            border-radius: 50%;
            color: white;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
            backdrop-filter: blur(10px);
        }

        .image-modal-close:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: scale(1.1);
        }

        .image-modal-info {
            position: absolute;
            bottom: -50px;
            left: 0;
            right: 0;
            text-align: center;
            color: rgba(255, 255, 255, 0.8);
            font-size: 14px;
            font-weight: 500;
        }

        /* AI Response Styling */
        .ai-response {
            line-height: 1.6;
            word-wrap: break-word;
            overflow-wrap: break-word;
            word-break: break-word;
            hyphens: auto;
        }

        .ai-response h1,
        .ai-response h2,
        .ai-response h3,
        .ai-response h4,
        .ai-response h5,
        .ai-response h6 {
            font-family: 'Inter', sans-serif;
        }

        .ai-response h1:first-child,
        .ai-response h2:first-child,
        .ai-response h3:first-child,
        .ai-response h4:first-child,
        .ai-response h5:first-child,
        .ai-response h6:first-child {
            margin-top: 0 !important;
        }

        .ai-response p:last-child {
            margin-bottom: 0;
        }

        /* General text content styling */
        p,
        .ai-response p {
            word-wrap: break-word;
            overflow-wrap: break-word;
            word-break: break-word;
            hyphens: auto;
        }

        .ai-response ul {
            padding-left: 0;
        }

        .ai-response ol {
            padding-left: 0;
        }

        .ai-response pre {
            max-width: 100%;
            overflow-x: auto;
        }

        .ai-response code {
            font-family: 'Courier New', Consolas, Monaco, monospace;
        }

        .ai-response blockquote {
            margin: 1rem 0;
        }

        .ai-response a {
            text-decoration-color: rgba(59, 130, 246, 0.3);
            text-underline-offset: 2px;
        }

        .ai-response a:hover {
            text-decoration-color: rgba(59, 130, 246, 0.8);
        }

        /* Code Block Styling */
        .code-block {
            font-family: 'Courier New', Consolas, Monaco, monospace;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .code-header {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        }

        .copy-btn {
            font-size: 11px;
            transition: all 0.2s ease;
            border: none;
            cursor: pointer;
        }

        .copy-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .copy-btn.copied {
            background-color: #10b981 !important;
        }

        .copy-btn.copied:hover {
            background-color: #059669 !important;
        }

        .code-block pre {
            margin: 0;
            line-height: 1.5;
            font-size: 13px;
            color: white !important;
        }

        /* Ensure ALL text inside code blocks is white */
        .code-block pre,
        .code-block pre *,
        .code-block pre code,
        .code-block pre span,
        .code-block pre p {
            color: white !important;
            border: none !important;
            background: transparent !important;
        }

        .code-block code {
            background: none !important;
            padding: 0 !important;
            border-radius: 0 !important;
            color: inherit !important;
        }

        /* Inline code styling */
        .inline-code {
            font-family: 'Courier New', Consolas, Monaco, monospace;
            font-weight: 600;
            border: 1px solid #e5e7eb;
            background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%);
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        }

        /* Language specific highlighting hints */
        .code-block pre[data-language="php"] {
            border-left: 3px solid #777bb4;
        }

        .code-block pre[data-language="javascript"],
        .code-block pre[data-language="js"] {
            border-left: 3px solid #f7df1e;
        }

        .code-block pre[data-language="python"] {
            border-left: 3px solid #3776ab;
        }

        .code-block pre[data-language="html"] {
            border-left: 3px solid #e34f26;
        }

        .code-block pre[data-language="css"] {
            border-left: 3px solid #1572b6;
        }

        .code-block pre[data-language="json"] {
            border-left: 3px solid #000000;
        }

        /* Responsive adjustments */
        @media (max-width: 640px) {

            /* Overall mobile layout */
            body {
                overflow-x: hidden;
            }

            /* Message containers on mobile */
            .message-content {
                max-width: calc(100vw - 100px);
                min-width: 0;
            }

            /* Chat messages container */
            #chatMessages {
                padding: 0.75rem;
                gap: 1rem;
            }

            /* Message bubbles */
            .message-animation {
                margin-bottom: 1rem;
                gap: 0.5rem;
            }

            .message-animation .bg-white {
                max-width: calc(100vw - 120px);
                word-break: break-word;
                overflow-wrap: break-word;
                font-size: 0.9rem;
                line-height: 1.4;
            }

            /* Avatar sizing */
            .message-animation>div:first-child {
                width: 2rem;
                height: 2rem;
                flex-shrink: 0;
            }

            .bot-icon {
                width: 18px;
                height: 18px;
            }

            /* Input area */
            .bg-white.border-t {
                padding: 0.75rem;
            }

            /* Input container responsiveness */
            .bg-gray-50.rounded-2xl {
                padding: 0.5rem;
            }

            /* Textarea on mobile */
            #messageInput {
                font-size: 16px;
                /* Prevents zoom on iOS */
                min-height: 40px;
            }

            /* Action buttons row */
            .flex.items-center.justify-between>div:last-child {
                display: none;
                /* Hide the hint text on mobile */
            }

            /* Action buttons spacing */
            .flex.gap-1 {
                gap: 0.25rem;
            }

            .w-9.h-9 {
                width: 2rem;
                height: 2rem;
            }

            /* Character count */
            #charCount {
                position: absolute !important;
                bottom: -1.25rem !important;
                right: 0.5rem !important;
                font-size: 0.75rem;
                z-index: 10;
                background: rgba(255, 255, 255, 0.9);
                padding: 0.125rem 0.25rem;
                border-radius: 0.25rem;
                backdrop-filter: blur(4px);
            }

            .ai-response h1 {
                font-size: 1.5rem;
            }

            .ai-response h2 {
                font-size: 1.25rem;
            }

            .ai-response pre {
                padding: 0.75rem;
                font-size: 0.8rem;
            }

            .code-block {
                margin: 1rem -1rem;
                border-radius: 0;
            }

            .code-block pre {
                font-size: 12px;
            }
        }
    </style>
</head>

<body class="bg-gray-50 h-screen flex flex-col md:flex-row">
    <!-- Sidebar -->
    <div id="sidebar"
        class="fixed inset-y-0 left-0 w-80 bg-white shadow-lg flex flex-col z-40 transform -translate-x-full transition-transform md:static md:translate-x-0">
        <!-- Sidebar Header -->
        <div class="p-6 border-b border-gray-100 bg-black text-white relative">
            <!-- Close (mobile) -->
            <button id="closeSidebar"
                class="md:hidden absolute top-4 right-4 w-9 h-9 rounded-lg hover:bg-white/10 flex items-center justify-center"
                aria-label="Close sidebar">
                <i class="fas fa-times text-white"></i>
            </button>
            <div class="flex items-center mb-4">
                <img src="{{ asset('assets/images/LTUCBot.png') }}" alt="LTUC" class="h-10 w-auto" />
            </div>

            <button id="newChatBtn"
                class="w-full ltuc-primary text-white py-3 px-4 rounded-xl font-medium hover:opacity-90 transition-opacity">
                <i class="fas fa-plus mr-2"></i>
                New Chat
            </button>
        </div>

        <!-- Sidebar Content: Demo Information -->
        <div class="p-6 flex-1 flex flex-col overflow-y-auto">
            <!-- About LTUC AI Assistant -->
            <div class="mb-4">
                <h3 class="text-base font-semibold text-gray-800 mb-2 flex items-center">
                    <i class="fas fa-robot text-ltuc-primary mr-2"></i>
                    LTUC AI Assistant
                </h3>
                <div class="text-sm text-gray-600 mb-3">
                    <p class="mb-2">AI-powered learning companion for students and educators.</p>
                    <div class="bg-gray-50 p-2 rounded text-xs">
                        <div class="grid grid-cols-2 gap-1">
                            <div>• 📚 Homework help</div>
                            <div>• 🖼️ Image analysis</div>
                            <div>• 📄 Document processing</div>
                            <div>• 💬 24/7 support</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Demo Notice -->
            <div class="mb-4">
                <div class="bg-blue-50 border-l-4 border-blue-400 p-3 rounded">
                    <div class="flex items-center text-sm text-blue-700 mb-2">
                        <i class="fas fa-info-circle mr-2"></i>
                        <span class="font-medium">Demo Limitations</span>
                    </div>
                    <div class="space-y-1 text-xs text-blue-600">
                        <div>• Only 10 messages per chat</div>
                        <div>• No chat history saved</div>
                        <div>• File uploads limited to 2MB</div>
                        <div>• No personalized features</div>
                    </div>
                    <div class="mt-2 pt-2 border-t border-blue-200">
                        <p class="text-xs text-blue-700 font-medium">
                            🚀 Sign up for unlimited conversations & full features!
                        </p>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="mt-auto space-y-2">
                <a href="{{ route('login') }}"
                    class="w-full flex items-center justify-center px-4 py-2 bg-white border-2 border-gray-300 text-gray-700 rounded-lg font-medium text-sm hover:bg-gray-50 hover:border-gray-400 transition duration-300">
                    <i class="fas fa-sign-in-alt mr-2"></i>
                    Log in
                </a>

                <a href="{{ route('register') }}"
                    class="w-full flex items-center justify-center px-4 py-2 ltuc-primary text-white rounded-lg font-medium text-sm hover:opacity-90 transition duration-300">
                    <i class="fas fa-rocket mr-2"></i>
                    Start Now
                </a>
            </div>
        </div>

        <!-- Sidebar Footer -->
        <div class="p-4 border-t border-gray-100 bg-gray-50">
            <div class="text-center">
                <div class="flex items-center justify-center text-xs text-gray-500 space-x-4">
                    <span class="flex items-center">
                        <i class="fas fa-shield-alt mr-1"></i>
                        Secure
                    </span>
                    <span class="flex items-center">
                        <i class="fas fa-clock mr-1"></i>
                        24/7
                    </span>
                </div>
                <p class="text-xs text-gray-400 mt-1">© 2025 LTUC</p>
            </div>
        </div>
    </div>

    <!-- Mobile Sidebar Backdrop -->
    <div id="sidebarBackdrop" class="fixed inset-0 bg-black/30 z-30 hidden md:hidden"></div>

    <!-- Modal -->
    <div id="sidebarModal" class="fixed inset-0 bg-black/30 hidden items-center justify-center z-50">
        <div class="bg-white w-full max-w-2xl rounded-2xl shadow-xl overflow-hidden">
            <div class="flex items-center justify-between px-4 py-3 border-b border-gray-100">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 ltuc-primary rounded-lg"></div>
                    <h3 id="modalTitle" class="text-base font-semibold text-gray-800">Title</h3>
                </div>
                <button id="modalClose" class="w-8 h-8 rounded-lg hover:bg-gray-100 flex items-center justify-center">
                    <i class="fas fa-times text-gray-500"></i>
                </button>
            </div>
            <div id="modalBody" class="p-4 max-h-[70vh] overflow-y-auto"></div>
        </div>
    </div>

    <!-- Main Chat Area -->
    <div class="flex-1 flex flex-col min-w-0">
        <!-- Chat Header -->
        <div class="bg-black text-white border-b border-gray-800 p-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <!-- Open (mobile) -->
                    <button id="openSidebar"
                        class="md:hidden mr-3 w-9 h-9 rounded-lg hover:bg-white/10 flex items-center justify-center"
                        aria-label="Open sidebar">
                        <i class="fas fa-bars text-white"></i>
                    </button>
                    <img src="{{ asset('assets/images/LTUCBot.png') }}" alt="LTUC" class="h-8 w-auto mr-3" />
                    <div>
                        <h2 class="text-lg font-bold text-white">AI Chatbot</h2>
                        <p class="text-gray-300 text-xs">Ready to help with your questions</p>
                    </div>
                </div>

            </div>
        </div>

        <!-- Chat Messages -->
        <div id="chatMessages" class="flex-1 overflow-y-auto p-4 sm:p-6 space-y-4 scroll-smooth">
            <!-- Welcome Message -->
            <div class="flex items-start space-x-3 message-animation">
                <div class="w-10 h-10 bg-black rounded-full flex items-center justify-center flex-shrink-0">
                    <img src="{{ asset('assets/images/bot-icon.png') }}" alt="Bot" class="bot-icon" />
                </div>
                <div
                    class="bg-white rounded-2xl rounded-tl-sm p-4 shadow-sm max-w-2xl border border-gray-100 message-content">
                    <p class="text-gray-800 leading-relaxed">
                        Welcome to LTUC Learning Assistant! 🎓 I'm here to help you with information about our programs,
                        courses, and academic support.
                        <br><br>
                        How can I assist you with your studies at Luminus Technical University College today?
                    </p>
                    <div class="text-xs text-gray-500 mt-2">Just now</div>
                </div>
            </div>
        </div>

        <!-- File Preview Area -->
        <div id="filePreview" class="px-6 py-2 hidden">
            <div class="bg-gray-50 rounded-lg p-3">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm font-medium text-gray-700">Attached Files</span>
                    <button id="clearFiles" class="text-xs text-gray-500 hover:text-red-500">
                        <i class="fas fa-times"></i> Clear All
                    </button>
                </div>
                <div id="fileList" class="space-y-2">
                    <!-- Files will be added here -->
                </div>
            </div>
        </div>

        <!-- Input Area -->
        <div class="bg-white border-t border-gray-200 p-3 sm:p-4">
            <!-- Main Input Container -->
            <div class="bg-gray-50 rounded-2xl p-2 sm:p-3 border border-gray-200">
                <!-- Toaster Container -->
                <div id="toasterContainer" class="toaster-container">
                    <!-- Toaster notifications will appear here -->
                </div>

                <!-- File Preview Row -->
                <div id="filePreviewRow" class="hidden mb-3">
                    <div class="flex flex-wrap gap-2" id="fileChips">
                        <!-- File chips will appear here -->
                    </div>
                </div>

                <!-- Input Row -->
                <div class="flex flex-col gap-2">
                    <!-- Text + Send Row -->
                    <div class="flex gap-2 ">
                        <!-- Text Input Container -->
                        <div class="flex-1 relative">
                            <textarea id="messageInput" placeholder="Type your message here..."
                                class="w-full min-h-[36px] max-h-[120px] px-4 py-2 bg-white border border-gray-200 rounded-xl resize-none focus:border-[#D60095] focus:outline-none focus:ring-2 focus:ring-[#D60095]/15 transition-all text-gray-800 placeholder-gray-400"
                                style="line-height: 1.4;" rows="1"></textarea>

                            <!-- Character Count -->
                            <div id="charCount"
                                class="absolute -bottom-5 right-2 text-xs text-gray-400 hidden z-10 bg-white bg-opacity-90 px-1 rounded">
                                0 characters
                            </div>
                        </div>

                        <!-- Send Button -->
                        <button id="sendBtn" title="Send Message"
                            class="w-10 h-10 ltuc-primary rounded-xl flex items-center justify-center hover:scale-105 active:scale-95 transition-all shadow-sm disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:scale-100"
                            disabled>
                            <i class="fas fa-paper-plane text-white text-sm"></i>
                        </button>
                    </div>

                    <!-- Action Buttons Row (moved to bottom) with hint on the right -->
                    <div class="flex items-center justify-between">
                        <div class="flex gap-1">
                            <button id="fileBtn" title="Attach File (Max 2MB - Demo)"
                                class="w-9 h-9 bg-white hover:bg-[#D60095]/10 border border-gray-200 hover:border-[#D60095]/40 rounded-xl flex items-center justify-center transition-all group">
                                <i class="fas fa-paperclip text-gray-500 group-hover:text-[#D60095] text-sm"></i>
                            </button>

                            <button id="imageBtn" title="Attach Image (Max 2MB - Demo)"
                                class="w-9 h-9 bg-white hover:bg-[#2E8570]/10 border border-gray-200 hover:border-[#2E8570]/40 rounded-xl flex items-center justify-center transition-all group">
                                <i class="fas fa-image text-gray-500 group-hover:text-[#2E8570] text-sm"></i>
                            </button>

                            <button id="voiceBtn" title="Voice Message"
                                class="w-9 h-9 bg-white hover:bg-[#A84A9D]/10 border border-gray-200 hover:border-[#A84A9D]/40 rounded-xl flex items-center justify-center transition-all group">
                                <i class="fas fa-microphone text-gray-500 group-hover:text-[#A84A9D] text-sm"></i>
                            </button>
                        </div>

                        <div class="flex items-center text-xs text-gray-500">
                            <i class="fas fa-info-circle mr-1"></i>
                            Max 2MB per file (Demo) • Press Enter to send
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Image Modal -->
    <div id="imageModal" class="image-modal">
        <div class="image-modal-content">
            <button class="image-modal-close" onclick="closeImageModal()">
                <i class="fas fa-times"></i>
            </button>
            <img id="modalImage" src="" alt="Preview">
            <div class="image-modal-info" id="modalImageInfo"></div>
        </div>
    </div>

    <script>
        // Global variables
        let uploadedFiles = [];
        let toasterCount = 0;
        let messageCount = 0; // Demo message counter
        const MAX_DEMO_MESSAGES = 10;

        // DOM Elements
        const messageInput = document.getElementById('messageInput');
        const sendBtn = document.getElementById('sendBtn');
        const chatMessages = document.getElementById('chatMessages');
        const newChatBtn = document.getElementById('newChatBtn');
        const clearBtn = document.getElementById('clearBtn');
        const fileBtn = document.getElementById('fileBtn');
        const imageBtn = document.getElementById('imageBtn');
        const voiceBtn = document.getElementById('voiceBtn');
        const filePreviewRow = document.getElementById('filePreviewRow');
        const fileChips = document.getElementById('fileChips');
        const charCount = document.getElementById('charCount');
        const toasterContainer = document.getElementById('toasterContainer');
        // Sidebar buttons & modal
        const tabImages = document.getElementById('tabImages');
        const tabFavorites = document.getElementById('tabFavorites');
        const sidebarModal = document.getElementById('sidebarModal');
        const modalTitle = document.getElementById('modalTitle');
        const modalBody = document.getElementById('modalBody');
        const modalClose = document.getElementById('modalClose');
        // Mobile sidebar
        const sidebar = document.getElementById('sidebar');
        const sidebarBackdrop = document.getElementById('sidebarBackdrop');
        const openSidebarBtn = document.getElementById('openSidebar');
        const closeSidebarBtn = document.getElementById('closeSidebar');

        // Auto-resize textarea and update send button state
        function autoResize() {
            messageInput.style.height = 'auto';
            messageInput.style.height = Math.min(messageInput.scrollHeight, 120) + 'px';

            // Check demo message limit
            if (messageCount >= MAX_DEMO_MESSAGES) {
                sendBtn.disabled = true;
                messageInput.disabled = true;
                messageInput.placeholder = 'Demo limit reached - Sign up for unlimited messages!';
                charCount.textContent = `Demo limit: ${messageCount}/${MAX_DEMO_MESSAGES} messages used`;
                charCount.style.color = '#ef4444';
                charCount.classList.remove('hidden');
                return;
            }

            // Update send button state
            const hasText = messageInput.value.trim().length > 0;
            const hasFiles = uploadedFiles.length > 0;
            sendBtn.disabled = !hasText && !hasFiles;

            // Update character count and demo counter
            const length = messageInput.value.length;
            const remainingMessages = MAX_DEMO_MESSAGES - messageCount;
            charCount.textContent = `${length} characters • ${remainingMessages} messages left in demo`;
            charCount.classList.toggle('hidden', length === 0 && remainingMessages === MAX_DEMO_MESSAGES);

            // Update color based on length and remaining messages
            if (remainingMessages <= 2) {
                charCount.style.color = '#ef4444';
            } else if (remainingMessages <= 5) {
                charCount.style.color = '#f59e0b';
            } else if (length > 2000) {
                charCount.style.color = '#ef4444';
            } else if (length > 1500) {
                charCount.style.color = '#f59e0b';
            } else {
                charCount.style.color = '#6b7280';
            }
        }

        // Sidebar controls (mobile)
        function openSidebarMobile() {
            sidebar?.classList.remove('-translate-x-full');
            sidebarBackdrop?.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeSidebarMobile() {
            sidebar?.classList.add('-translate-x-full');
            sidebarBackdrop?.classList.add('hidden');
            document.body.style.overflow = '';
        }

        openSidebarBtn?.addEventListener('click', openSidebarMobile);
        closeSidebarBtn?.addEventListener('click', closeSidebarMobile);
        sidebarBackdrop?.addEventListener('click', closeSidebarMobile);

        // Show typing indicator
        function showTyping() {
            const typingDiv = document.createElement('div');
            typingDiv.id = 'typing';
            typingDiv.className = 'flex items-start space-x-3 message-animation';
            typingDiv.innerHTML = `
                <div class="w-10 h-10 bg-black rounded-full flex items-center justify-center flex-shrink-0">
                    <img src="/assets/images/bot-icon.png" alt="Bot" class="bot-icon" />
                </div>
                <div class="bg-white rounded-2xl rounded-tl-sm p-4 shadow-sm border border-gray-100">
                    <div class="flex space-x-1">
                        <div class="w-2 h-2 bg-gray-400 rounded-full typing-indicator"></div>
                        <div class="w-2 h-2 bg-gray-400 rounded-full typing-indicator" style="animation-delay: 0.2s;"></div>
                        <div class="w-2 h-2 bg-gray-400 rounded-full typing-indicator" style="animation-delay: 0.4s;"></div>
                    </div>
                </div>
            `;
            chatMessages.appendChild(typingDiv);
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }

        function hideTyping() {
            const typing = document.getElementById('typing');
            if (typing) typing.remove();
        }

        // Toaster notification system
        function showToaster(title, message, type = 'error', duration = 6000) {
            const toasterId = `toaster-${++toasterCount}`;
            const typeConfig = {
                error: {
                    icon: 'fas fa-exclamation-circle',
                    iconColor: '#ffffff'
                },
                success: {
                    icon: 'fas fa-check-circle',
                    iconColor: '#ffffff'
                },
                warning: {
                    icon: 'fas fa-exclamation-triangle',
                    iconColor: '#ffffff'
                },
                info: {
                    icon: 'fas fa-info-circle',
                    iconColor: '#ffffff'
                }
            };

            const config = typeConfig[type] || typeConfig.error;

            const toaster = document.createElement('div');
            toaster.id = toasterId;
            toaster.className = `toaster ${type}`;
            toaster.innerHTML = `
                <div class="toaster-icon">
                    <i class="${config.icon}" style="color: ${config.iconColor}; font-size: 14px;"></i>
                </div>
                <div class="toaster-content">
                    <div class="toaster-title">${title}</div>
                    <div class="toaster-message">${message}</div>
                </div>
                <button class="toaster-close" onclick="removeToaster('${toasterId}')">
                    <i class="fas fa-times"></i>
                </button>
                <div class="toaster-progress" style="width: 100%;"></div>
            `;

            toasterContainer.appendChild(toaster);

            // Animate progress bar
            const progressBar = toaster.querySelector('.toaster-progress');
            setTimeout(() => {
                progressBar.style.width = '0%';
                progressBar.style.transition = `width ${duration}ms linear`;
            }, 100);

            // Auto remove after duration
            setTimeout(() => {
                removeToaster(toasterId);
            }, duration);

            return toasterId;
        }

        function removeToaster(toasterId) {
            const toaster = document.getElementById(toasterId);
            if (!toaster) return;

            toaster.classList.add('toaster-removing');
            setTimeout(() => {
                if (toaster.parentNode) {
                    toaster.remove();
                }
            }, 300);
        }

        // Convenience function for file errors (backward compatibility)
        function showFileError(message) {
            let title = 'File Error';
            let cleanMessage = message;

            if (message.includes('too large')) {
                title = 'File Size Exceeded';
                cleanMessage = message.replace('❌ File(s) too large:', '').trim();
            } else if (message.includes('upload error')) {
                title = 'Upload Failed';
                cleanMessage = message.replace('❌ File upload error', '').replace('\n\n', '').trim();
            } else if (message.includes('size limit exceeded')) {
                title = 'Size Limit Exceeded';
                cleanMessage = message.replace('❌ File size limit exceeded', '').replace('\n\n', '').trim();
            }

            showToaster(title, cleanMessage, 'error', 8000);
        }

        // Make removeToaster globally accessible
        window.removeToaster = removeToaster;

        // Add message to chat
        function addMessage(text, isUser = false, attachments = [], isHtml = false) {
            const messageDiv = document.createElement('div');
            messageDiv.className =
                `flex items-start space-x-3 message-animation ${isUser ? 'flex-row-reverse space-x-reverse' : ''}`;

            const time = new Date().toLocaleTimeString([], {
                hour: '2-digit',
                minute: '2-digit'
            });

            // Prepare content
            let contentHTML = '';
            if (text) {
                if (isHtml && !isUser) {
                    // For AI responses, use the parsed HTML directly
                    contentHTML += `<div class="ai-response">${text}</div>`;
                } else {
                    // For user messages or plain text, preserve line breaks
                    const formattedText = text.replace(/\n/g, '<br>');
                    contentHTML += `<p class="text-gray-800 leading-relaxed">${formattedText}</p>`;
                }
            }

            // Add image previews if any
            if (attachments.length > 0) {
                const images = attachments.filter(att => att.type === 'image');
                if (images.length > 0) {
                    contentHTML += `<div class="image-preview-grid">`;
                    images.forEach((img, index) => {
                        contentHTML += `
                            <div class="image-preview-item" onclick="openImageModal('${img.url}', '${img.name}')">
                                <img src="${img.url}" alt="${img.name}" loading="lazy">
                                <div class="image-preview-overlay">
                                    <i class="fas fa-expand-alt image-preview-icon"></i>
                                </div>
                            </div>
                        `;
                    });
                    contentHTML += `</div>`;
                }
            }

            messageDiv.innerHTML = `
                <div class="w-10 h-10 ${isUser ? 'bg-pink-500' : 'bg-black'} rounded-full flex items-center justify-center flex-shrink-0">
                    ${isUser ? '<i class="fas fa-user text-white text-sm"></i>' : '<img src="/assets/images/bot-icon.png" alt="Bot" class="bot-icon" />'}
                </div>
                <div class="bg-white rounded-2xl ${isUser ? 'rounded-tr-sm' : 'rounded-tl-sm'} p-4 shadow-sm max-w-2xl border border-gray-100 message-content">
                    ${contentHTML}
                    <div class="text-xs text-gray-500 mt-2">${time}</div>
                </div>
            `;

            chatMessages.appendChild(messageDiv);
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }

        // Image modal functions
        function openImageModal(imageSrc, imageName) {
            const modal = document.getElementById('imageModal');
            const modalImage = document.getElementById('modalImage');
            const modalInfo = document.getElementById('modalImageInfo');

            modalImage.src = imageSrc;
            modalInfo.textContent = imageName || 'Image Preview';
            modal.classList.add('active');

            // Prevent body scroll
            document.body.style.overflow = 'hidden';
        }

        function closeImageModal() {
            const modal = document.getElementById('imageModal');
            modal.classList.remove('active');

            // Restore body scroll
            document.body.style.overflow = '';
        }

        // Make functions globally accessible
        window.openImageModal = openImageModal;
        window.closeImageModal = closeImageModal;

        // Handle file upload
        function handleFileUpload(acceptTypes, fileType) {
            const input = document.createElement('input');
            input.type = 'file';
            input.accept = acceptTypes;
            input.multiple = true;
            input.onchange = (e) => {
                const files = Array.from(e.target.files);
                const maxSize = 2 * 1024 * 1024; // 2MB in bytes (Demo limitation)
                const validFiles = [];
                const invalidFiles = [];

                files.forEach(file => {
                    if (file.size > maxSize) {
                        invalidFiles.push(file);
                    } else {
                        validFiles.push(file);
                    }
                });

                // Show error for invalid files
                if (invalidFiles.length > 0) {
                    const fileNames = invalidFiles.map(f => f.name).join(', ');
                    showFileError(
                        `❌ File(s) too large: ${fileNames}\n\nDemo limitation: Maximum file size is 2MB. Sign up for 10MB uploads!`
                    );
                }

                // Add valid files
                validFiles.forEach(file => {
                    uploadedFiles.push({
                        file,
                        type: fileType
                    });
                    addFileToPreview(file, fileType);
                });

                // Show success message for valid files
                if (validFiles.length > 0) {
                    const fileText = validFiles.length === 1 ? 'file' : 'files';
                    const fileList = validFiles.length <= 2 ?
                        validFiles.map(f => f.name).join(', ') :
                        `${validFiles.length} ${fileText}`;
                    showToaster(
                        'Files Ready',
                        `Successfully attached ${fileList}`,
                        'success',
                        4000
                    );
                }

                updateFilePreview();
            };
            input.click();
        }

        function addFileToPreview(file, type) {
            const fileChip = document.createElement('div');
            fileChip.className = 'file-chip';
            fileChip.setAttribute('data-filename', file.name);

            const icon = type === 'image' ? 'fa-image' : 'fa-file';
            const iconColor = type === 'image' ? 'text-blue-500' : 'text-gray-500';

            // Format file size
            const formatSize = (bytes) => {
                if (bytes === 0) return '0 B';
                const k = 1024;
                const sizes = ['B', 'KB', 'MB', 'GB'];
                const i = Math.floor(Math.log(bytes) / Math.log(k));
                return parseFloat((bytes / Math.pow(k, i)).toFixed(1)) + ' ' + sizes[i];
            };

            fileChip.innerHTML = `
                <i class="fas ${icon} ${iconColor} mr-1 text-xs"></i>
                <span class="truncate max-w-20" title="${file.name} (${formatSize(file.size)})">${file.name}</span>
                <span class="text-xs text-gray-400 ml-1">(${formatSize(file.size)})</span>
                <button onclick="removeFile('${file.name}')" type="button">
                    <i class="fas fa-times text-xs"></i>
                </button>
            `;

            fileChips.appendChild(fileChip);
        }

        function updateFilePreview() {
            if (uploadedFiles.length > 0) {
                filePreviewRow.classList.remove('hidden');
            } else {
                filePreviewRow.classList.add('hidden');
            }
            autoResize(); // Update send button state
        }

        function removeFile(fileName) {
            uploadedFiles = uploadedFiles.filter(item => item.file.name !== fileName);
            const fileChip = fileChips.querySelector(`[data-filename="${fileName}"]`);
            if (fileChip) fileChip.remove();
            updateFilePreview();
        }

        function clearAllFiles() {
            uploadedFiles = [];
            fileChips.innerHTML = '';
            updateFilePreview();
        }

        // Send message
        let isSending = false; // Track if a message is currently being sent

        async function sendMessage() {
            // Check demo message limit
            if (messageCount >= MAX_DEMO_MESSAGES) {
                showToaster(
                    'Demo limit reached! You\'ve used all 10 messages. Please sign up for unlimited conversations.',
                    'warning');
                return;
            }

            const text = messageInput.value.trim();
            if (!text && uploadedFiles.length === 0) return;

            // Prevent duplicate sending
            if (isSending) return;
            isSending = true;

            // Increment message counter for demo
            messageCount++;

            // Disable send button and input
            sendBtn.disabled = true;
            messageInput.disabled = true;

            // Update send button to show loading state
            const originalContent = sendBtn.innerHTML;
            sendBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';

            // Prepare attachments for preview
            const attachments = [];

            // Create object URLs for image files to show previews
            uploadedFiles.forEach(item => {
                if (item.type === 'image') {
                    const objectUrl = URL.createObjectURL(item.file);
                    attachments.push({
                        type: 'image',
                        url: objectUrl,
                        name: item.file.name,
                        size: item.file.size
                    });
                }
            });

            // Create message content for non-image files
            let messageContent = '';
            const nonImageFiles = uploadedFiles.filter(item => item.type !== 'image');
            if (nonImageFiles.length > 0) {
                const fileNames = nonImageFiles.map(item => `📎 ${item.file.name}`).join('<br>');
                messageContent += fileNames;
                if (text) messageContent += '<br><br>';
            }

            // Add text message
            if (text) {
                messageContent += text;
            }

            // Add message with image previews
            addMessage(messageContent || 'Images attached', true, attachments);

            // Prepare form data for API
            const formData = new FormData();
            formData.append('message', text);

            // Add files to form data
            uploadedFiles.forEach((item, index) => {
                formData.append(`files[${index}]`, item.file);
            });

            // Clear input and files
            messageInput.value = '';
            messageInput.style.height = '48px';
            clearAllFiles();
            autoResize();

            // Show typing indicator
            showTyping();

            try {
                const response = await fetch('/api/chat', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute(
                            'content') || ''
                    }
                });

                const data = await response.json();
                hideTyping();

                if (data.success) {
                    // Use HTML content if available, otherwise fall back to plain text
                    let messageContent = data.message;
                    let isHtml = false;

                    if (data.html && data.html.trim()) {
                        messageContent = data.html;
                        isHtml = true;
                    }

                    addMessage(messageContent, false, [], isHtml);
                } else {
                    // Handle specific error types
                    if (data.errors && data.errors['files.*']) {
                        const fileErrors = data.errors['files.*'];
                        if (fileErrors.some(err => err.includes('max:') || err.includes('server limits'))) {
                            showFileError(
                                '❌ File size limit exceeded\n\nYour file is larger than the server allows. The server is currently configured for smaller files. Please try a file under 2MB or contact support.'
                            );
                        } else {
                            showFileError('❌ File upload error\n\n' + fileErrors.join('\n'));
                        }
                    } else if (data.message && data.message.includes('File too large for server')) {
                        showFileError(
                            '❌ Server Configuration Limit\n\nThe server upload limit is currently set lower than 10MB. Please contact your administrator or try a smaller file.'
                        );
                    } else if (data.message && data.message.includes('File upload error')) {
                        showFileError(
                            '❌ Upload Configuration Issue\n\n' + data.message
                        );
                    } else {
                        addMessage('Sorry, I encountered an error. Please try again in a moment.');
                    }
                    console.error('API Error:', data.error || data.errors);
                }
            } catch (error) {
                hideTyping();
                showToaster(
                    'Connection Failed',
                    'Unable to connect to the server. Please check your internet connection and try again.',
                    'error',
                    6000
                );
                console.error('Network Error:', error);
            } finally {
                // Restore button state regardless of success or error
                isSending = false;
                sendBtn.innerHTML = originalContent;
                messageInput.disabled = false;

                // Re-enable send button based on current input state
                const hasText = messageInput.value.trim();
                const hasFiles = uploadedFiles.length > 0;
                sendBtn.disabled = !hasText && !hasFiles;

                // Focus back to input
                messageInput.focus();
            }
        }

        function clearChat() {
            // Reset demo message counter
            messageCount = 0;

            // Re-enable input and reset placeholder
            messageInput.disabled = false;
            messageInput.placeholder = 'Type your message here...';

            const messages = chatMessages.querySelectorAll('.message-animation');
            messages.forEach((msg, index) => {
                if (index > 0) { // Keep welcome message
                    // Clean up object URLs to prevent memory leaks
                    const images = msg.querySelectorAll('.image-preview-item img');
                    images.forEach(img => {
                        if (img.src.startsWith('blob:')) {
                            URL.revokeObjectURL(img.src);
                        }
                    });

                    setTimeout(() => msg.remove(), index * 50);
                }
            });

            // Update the character count display
            autoResize();

            // Clear conversation history on server
            fetch('/api/chat/clear-history', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                }).then(response => response.json())
                .then(data => {
                    if (data.success) {
                        console.log('Conversation history cleared successfully');
                        // Update history status
                        const historyStatus = document.getElementById('historyStatus');
                        if (historyStatus) {
                            historyStatus.textContent = 'New conversation started';
                            setTimeout(() => {
                                historyStatus.textContent = 'Conversation history active';
                            }, 3000);
                        }
                    }
                }).catch(error => {
                    console.error('Error clearing conversation history:', error);
                });
        }

        // Event Listeners
        sendBtn?.addEventListener('click', sendMessage);

        messageInput?.addEventListener('keypress', (e) => {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                if (!isSending) { // Only send if not already sending
                    sendMessage();
                }
            }
        });

        messageInput?.addEventListener('input', (e) => {
            autoResize();
        });

        newChatBtn?.addEventListener('click', () => {
            clearChat();
            clearAllFiles();
        });

        clearBtn?.addEventListener('click', clearChat);

        fileBtn?.addEventListener('click', () => {
            handleFileUpload(
                '.pdf,.doc,.docx,.txt,.xlsx,.pptx,.json,.xml,.yaml,.yml,.js,.jsx,.ts,.tsx,.php,.py,.java,.cpp,.c,.cs,.rb,.go,.rs,.swift,.html,.css,.sql,.md,.csv,.zip,.rar',
                'file');
        });

        imageBtn?.addEventListener('click', () => {
            handleFileUpload(
                '.jpg,.jpeg,.png,.gif,.bmp,.webp,.svg,.tiff,.ico,.heic,.heif,.avif,.jfif,.pjpeg,.pjp,.apng,.raw,.cr2,.nef,.arw,.dng',
                'image');
        });

        voiceBtn?.addEventListener('click', () => {
            // Voice message simulation
            messageInput.value = "🎤 Voice message recorded (Demo feature)";
            autoResize();
            messageInput.focus();
        });

        // Make removeFile globally accessible
        window.removeFile = removeFile;

        // Modal helpers
        function openModal(title, contentHTML) {
            modalTitle.textContent = title;
            modalBody.innerHTML = contentHTML;
            sidebarModal.classList.remove('hidden');
            sidebarModal.classList.add('flex');
        }

        function closeModal() {
            sidebarModal.classList.add('hidden');
            sidebarModal.classList.remove('flex');
        }

        modalClose?.addEventListener('click', closeModal);
        sidebarModal?.addEventListener('click', (e) => {
            if (e.target === sidebarModal) closeModal();
        });

        // Button click -> open modal
        tabImages?.addEventListener('click', () => {
            const grid = `
                <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                    ${[1,2,3,4,5,6].map(i => (
                        `<div class=\"border border-gray-100 rounded-lg p-3 bg-white flex flex-col items-center justify-center h-28\">
                                                                                                        <i class=\"fas fa-image ${i % 2 ? 'text-[#2E8570]' : 'text-[#D60095]'}\"></i>
                                                                                                        <span class=\"text-xs text-gray-500 mt-2\">Image ${i}</span>
                                                                                                    </div>`
                    )).join('')}
                </div>`;
            openModal('Generated Images', grid);
        });

        tabFavorites?.addEventListener('click', () => {
            const list = `
                <div class="space-y-4 text-center">
                    <div class="text-gray-500">
                        <i class="fas fa-tools text-4xl mb-4"></i>
                        <h3 class="text-lg font-medium">Study Tools</h3>
                        <p class="text-sm">Additional study resources and tools will be available here soon.</p>
                    </div>
                </div>`;
            openModal('Study Tools', list);
        });

        // Code copy functionality
        function copyCode(codeId) {
            const codeElement = document.getElementById(codeId);
            if (!codeElement) return;

            const text = codeElement.textContent;

            // Use modern clipboard API if available
            if (navigator.clipboard && window.isSecureContext) {
                navigator.clipboard.writeText(text).then(() => {
                    showCopySuccess(codeId);
                }).catch(() => {
                    fallbackCopy(text, codeId);
                });
            } else {
                fallbackCopy(text, codeId);
            }
        }

        // Fallback copy method for older browsers
        function fallbackCopy(text, codeId) {
            const textArea = document.createElement('textarea');
            textArea.value = text;
            textArea.style.position = 'fixed';
            textArea.style.opacity = '0';
            document.body.appendChild(textArea);
            textArea.focus();
            textArea.select();

            try {
                const successful = document.execCommand('copy');
                if (successful) {
                    showCopySuccess(codeId);
                }
            } catch (err) {
                console.error('Copy failed:', err);
                showToaster('Copy Failed', 'Unable to copy code to clipboard', 'error', 3000);
            }

            document.body.removeChild(textArea);
        }

        // Show copy success feedback
        function showCopySuccess(codeId) {
            const copyBtn = document.querySelector(`button[onclick="copyCode('${codeId}')"]`);
            if (copyBtn) {
                const originalHTML = copyBtn.innerHTML;
                copyBtn.innerHTML = '<i class="fas fa-check mr-1"></i>Copied!';
                copyBtn.classList.add('copied');

                setTimeout(() => {
                    copyBtn.innerHTML = originalHTML;
                    copyBtn.classList.remove('copied');
                }, 2000);
            }

            // Show success toaster
            showToaster('Code Copied', 'Code has been copied to clipboard', 'success', 2000);
        }

        // Make copy function globally accessible
        window.copyCode = copyCode;

        // Initialize
        messageInput.focus();
        autoResize(); // Initialize the counter display

        // Image modal event listeners
        const imageModal = document.getElementById('imageModal');

        // Close modal when clicking outside the image
        imageModal?.addEventListener('click', (e) => {
            if (e.target === imageModal) {
                closeImageModal();
            }
        });

        // Close modal with Escape key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && imageModal?.classList.contains('active')) {
                closeImageModal();
            }
        });
    </script>
</body>

</html>
