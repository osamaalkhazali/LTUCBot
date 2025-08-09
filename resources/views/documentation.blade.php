<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>LTUC AI Assistant - Documentation</title>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="/favicon.ico">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <!-- Styles -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

    <style>
        .ltuc-primary {
            background-color: #D60095;
        }

        .ltuc-secondary {
            background-color: #2E8570;
        }

        .ltuc-accent {
            background-color: #A84A9D;
        }

        .text-ltuc-primary {
            color: #D60095;
        }

        .text-ltuc-secondary {
            color: #2E8570;
        }

        .text-ltuc-accent {
            color: #A84A9D;
        }

        .text-ltuc-dark {
            color: #333333;
        }

        .text-ltuc-light {
            color: #999999;
        }

        .bg-ltuc-primary {
            background-color: #D60095;
        }

        .bg-ltuc-secondary {
            background-color: #2E8570;
        }

        .toc {
            position: sticky;
            top: 2rem;
            max-height: calc(100vh - 4rem);
            overflow-y: auto;
        }

        .toc a {
            transition: all 0.2s ease;
        }

        .toc a:hover {
            color: #D60095;
            padding-left: 1rem;
        }

        .toc a.active {
            color: #D60095;
            font-weight: 600;
            border-left: 3px solid #D60095;
            padding-left: 1rem;
        }

        pre {
            background: #1a1a1a;
            color: #e2e8f0;
            border-radius: 0.5rem;
            overflow-x: auto;
        }

        code {
            font-family: 'JetBrains Mono', 'Fira Code', 'Courier New', monospace;
        }

        .code-block {
            background: #0d1117;
            border: 1px solid #30363d;
        }

        .code-block code {
            color: #c9d1d9;
        }

        .keyword {
            color: #ff7b72;
        }

        .string {
            color: #a5d6ff;
        }

        .comment {
            color: #8b949e;
        }

        /* Print Styles */
        @media print {
            .toc-container {
                display: none;
            }

            .main-content {
                width: 100% !important;
                margin: 0 !important;
            }

            .no-print {
                display: none;
            }

            body {
                font-size: 12pt;
                line-height: 1.5;
            }

            h1,
            h2,
            h3 {
                page-break-after: avoid;
            }

            pre,
            blockquote {
                page-break-inside: avoid;
            }

            img {
                max-width: 100% !important;
                page-break-inside: avoid;
            }
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-900 antialiased">
    <!-- Navigation -->
    <nav class="bg-black shadow-lg border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="/" class="flex items-center">
                        <img src="{{ asset('assets/images/LTUCBot.png') }}" alt="LTUC" class="h-12 w-auto" />
                    </a>
                </div>

                <!-- Navigation Links -->
                @if (Route::has('login'))
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('documentation') }}"
                            class="text-white hover:text-gray-300 transition duration-300 font-medium">
                            Documentation
                        </a>
                        @auth
                            <a href="{{ url('/dashboard') }}"
                                class="text-white hover:text-gray-300 transition duration-300 font-medium">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}"
                                class="text-white hover:text-gray-300 transition duration-300 font-medium">
                                Log in
                            </a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}"
                                    class="ltuc-primary text-white px-6 py-2 rounded-xl font-semibold hover:opacity-90 transition duration-300">
                                    Get Started
                                </a>
                            @endif
                        @endauth
                    </div>
                @endif
            </div>
        </div>
    </nav>

    <!-- Header Section -->
    <div class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="font-bold text-2xl text-ltuc-dark leading-tight flex items-center">
                        <i class="fas fa-book mr-3 text-ltuc-primary"></i>
                        Documentation
                    </h1>
                    <p class="text-ltuc-light mt-1">Complete guide to LTUC AI Assistant project and deployment.</p>
                </div>
                <div class="hidden md:block">
                    @auth
                        <a href="/ltuc/chatbot"
                            class="inline-flex items-center px-6 py-3 ltuc-primary text-white font-semibold rounded-xl hover:opacity-90 transform hover:scale-105 transition duration-300">
                            <i class="fas fa-robot mr-2"></i>
                            Open AI Assistant
                        </a>
                    @else
                        <a href="/ltuc/chatbot-demo"
                            class="inline-flex items-center px-6 py-3 ltuc-secondary text-white font-semibold rounded-xl hover:opacity-90 transform hover:scale-105 transition duration-300">
                            <i class="fas fa-robot mr-2"></i>
                            Try Demo
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </div>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Documentation Container -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="flex flex-col lg:flex-row">
                    <!-- Table of Contents Sidebar -->
                    <div class="lg:w-1/4 bg-gray-50 border-r border-gray-200 toc-container">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-ltuc-dark mb-4 flex items-center">
                                <i class="fas fa-list mr-2 text-ltuc-primary"></i>
                                Table of Contents
                            </h3>
                            <nav class="toc space-y-2">
                                <a href="#overview" class="block text-sm text-gray-600 hover:text-ltuc-primary py-1 transition">Overview</a>
                                <a href="#laravel-choice" class="block text-sm text-gray-600 hover:text-ltuc-primary py-1 transition">Why Laravel?</a>
                                <a href="#features" class="block text-sm text-gray-600 hover:text-ltuc-primary py-1 transition">Features</a>
                                <a href="#tech-stack" class="block text-sm text-gray-600 hover:text-ltuc-primary py-1 transition">Technology Stack</a>
                                <a href="#installation" class="block text-sm text-gray-600 hover:text-ltuc-primary py-1 transition">Installation</a>
                                <a href="#docker" class="block text-sm text-gray-600 hover:text-ltuc-primary py-1 transition">Docker Deployment</a>
                                <a href="#configuration" class="block text-sm text-gray-600 hover:text-ltuc-primary py-1 transition">Configuration</a>
                                <a href="#usage" class="block text-sm text-gray-600 hover:text-ltuc-primary py-1 transition">Usage</a>
                                <a href="#file-processing" class="block text-sm text-gray-600 hover:text-ltuc-primary py-1 transition">File Processing</a>
                                <a href="#live-deployments" class="block text-sm text-gray-600 hover:text-ltuc-primary py-1 transition">Live Deployments</a>
                                <a href="#api-integration" class="block text-sm text-gray-600 hover:text-ltuc-primary py-1 transition">API Integration</a>
                                <a href="#development" class="block text-sm text-gray-600 hover:text-ltuc-primary py-1 transition">Development</a>
                                <a href="#testing" class="block text-sm text-gray-600 hover:text-ltuc-primary py-1 transition">Testing</a>
                                <a href="#contributing" class="block text-sm text-gray-600 hover:text-ltuc-primary py-1 transition">Contributing</a>
                                <a href="#license" class="block text-sm text-gray-600 hover:text-ltuc-primary py-1 transition">License</a>
                            </nav>
                        </div>
                    </div>

                    <!-- Main Content -->
                    <div class="lg:w-3/4 main-content">
                        <div class="p-8">
                            <!-- Project Header -->
                            <div class="text-center mb-12">
                                <div class="flex justify-center mb-6">
                                    <img src="{{ asset('assets/images/LTUCBot.png') }}" alt="LTUC AI Assistant" class="h-20 w-auto">
                                </div>
                                <h1 class="text-4xl font-bold text-ltuc-dark mb-4">LTUC AI Assistant</h1>
                                <p class="text-xl text-ltuc-light max-w-3xl mx-auto">
                                    An intelligent learning companion for LTUC students, powered by OpenAI's advanced language models and built with Laravel.
                                </p>
                                <div class="flex justify-center space-x-4 mt-6">
                                    <span class="px-4 py-2 bg-ltuc-primary text-white rounded-full text-sm font-medium">Laravel 11.31</span>
                                    <span class="px-4 py-2 bg-ltuc-secondary text-white rounded-full text-sm font-medium">PHP 8.3</span>
                                    <span class="px-4 py-2 bg-ltuc-accent text-white rounded-full text-sm font-medium">OpenAI GPT</span>
                                </div>
                            </div>

                            <!-- Overview Section -->
                            <section id="overview" class="mb-12">
                                <h2 class="text-3xl font-bold text-ltuc-dark mb-6 flex items-center">
                                    <i class="fas fa-eye mr-3 text-ltuc-primary"></i>
                                    Overview
                                </h2>
                                <div class="prose max-w-none">
                                    <p class="text-lg text-gray-700 leading-relaxed mb-4">
                                        The LTUC AI Assistant is a sophisticated web application designed specifically for Luminus Technical University College students. It provides an intelligent, conversational interface that helps students with academic questions, learning support, and educational guidance.
                                    </p>
                                    <div class="grid md:grid-cols-3 gap-6 mt-8">
                                        <div class="bg-gradient-to-br from-purple-50 to-pink-50 p-6 rounded-xl border border-purple-100">
                                            <i class="fas fa-brain text-2xl text-ltuc-primary mb-3"></i>
                                            <h3 class="font-semibold text-ltuc-dark mb-2">Intelligent Responses</h3>
                                            <p class="text-sm text-gray-600">Powered by OpenAI's advanced language models for accurate and helpful responses.</p>
                                        </div>
                                        <div class="bg-gradient-to-br from-green-50 to-teal-50 p-6 rounded-xl border border-green-100">
                                            <i class="fas fa-users text-2xl text-ltuc-secondary mb-3"></i>
                                            <h3 class="font-semibold text-ltuc-dark mb-2">Student-Focused</h3>
                                            <p class="text-sm text-gray-600">Tailored specifically for LTUC students with academic context and support.</p>
                                        </div>
                                        <div class="bg-gradient-to-br from-blue-50 to-indigo-50 p-6 rounded-xl border border-blue-100">
                                            <i class="fas fa-clock text-2xl text-ltuc-accent mb-3"></i>
                                            <h3 class="font-semibold text-ltuc-dark mb-2">24/7 Availability</h3>
                                            <p class="text-sm text-gray-600">Always available to help with learning questions and academic support.</p>
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <!-- Laravel vs Python Section -->
                            <section id="laravel-choice" class="mb-12">
                                <h2 class="text-3xl font-bold text-ltuc-dark mb-6 flex items-center">
                                    <i class="fas fa-code mr-3 text-ltuc-primary"></i>
                                    Why Laravel over Python?
                                </h2>
                                <div class="bg-gradient-to-br from-red-50 to-orange-50 rounded-xl p-6 border border-red-100">
                                    <div class="bg-yellow-100 border-l-4 border-yellow-500 p-4 mb-6">
                                        <p class="text-yellow-800 font-medium">
                                            <i class="fas fa-info-circle mr-2"></i>
                                            While we acknowledge that <strong>Python is the dominant language in AI and machine learning</strong> ecosystems, we chose Laravel/PHP for this educational platform for several compelling reasons:
                                        </p>
                                    </div>

                                    <div class="grid md:grid-cols-2 gap-8">
                                        <div class="space-y-6">
                                            <div class="bg-white rounded-lg p-6 border border-red-200">
                                                <h3 class="text-lg font-semibold text-ltuc-dark mb-3 flex items-center">
                                                    <i class="fas fa-shield-alt mr-2 text-ltuc-primary"></i>
                                                    Superior Authentication & User Management
                                                </h3>
                                                <ul class="space-y-2 text-gray-700">
                                                    <li><strong>Built-in Laravel Breeze:</strong> Complete authentication system out of the box</li>
                                                    <li><strong>Robust Session Management:</strong> Secure user sessions and CSRF protection</li>
                                                    <li><strong>Role-Based Access Control:</strong> Easy implementation of user roles and permissions</li>
                                                    <li><strong>Password Security:</strong> Built-in hashing, password reset, and email verification</li>
                                                </ul>
                                            </div>

                                            <div class="bg-white rounded-lg p-6 border border-red-200">
                                                <h3 class="text-lg font-semibold text-ltuc-dark mb-3 flex items-center">
                                                    <i class="fas fa-rocket mr-2 text-ltuc-primary"></i>
                                                    Rapid Web Development
                                                </h3>
                                                <ul class="space-y-2 text-gray-700">
                                                    <li><strong>MVC Architecture:</strong> Clean, organized code structure for large applications</li>
                                                    <li><strong>Eloquent ORM:</strong> Intuitive database interactions with relationships</li>
                                                    <li><strong>Blade Templating:</strong> Powerful templating engine for dynamic UIs</li>
                                                    <li><strong>Artisan CLI:</strong> Hundreds of built-in commands for development efficiency</li>
                                                </ul>
                                            </div>
                                        </div>

                                        <div class="space-y-6">
                                            <div class="bg-white rounded-lg p-6 border border-red-200">
                                                <h3 class="text-lg font-semibold text-ltuc-dark mb-3 flex items-center">
                                                    <i class="fas fa-globe mr-2 text-ltuc-primary"></i>
                                                    Enterprise Web Features
                                                </h3>
                                                <ul class="space-y-2 text-gray-700">
                                                    <li><strong>Advanced Routing:</strong> RESTful routing with middleware and route caching</li>
                                                    <li><strong>Database Migrations:</strong> Version control for database schema changes</li>
                                                    <li><strong>Queue System:</strong> Background job processing for file handling</li>
                                                    <li><strong>Caching:</strong> Redis/Memcached integration for performance</li>
                                                </ul>
                                            </div>

                                            <div class="bg-white rounded-lg p-6 border border-red-200">
                                                <h3 class="text-lg font-semibold text-ltuc-dark mb-3 flex items-center">
                                                    <i class="fas fa-cogs mr-2 text-ltuc-primary"></i>
                                                    Production-Ready Infrastructure
                                                </h3>
                                                <ul class="space-y-2 text-gray-700">
                                                    <li><strong>Mature Ecosystem:</strong> 10+ years of enterprise-grade packages</li>
                                                    <li><strong>Horizontal Scaling:</strong> Easy deployment across multiple servers</li>
                                                    <li><strong>Error Handling:</strong> Comprehensive logging and debugging tools</li>
                                                    <li><strong>Security:</strong> Built-in protection against OWASP top 10 vulnerabilities</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <!-- Features Section -->
                            <section id="features" class="mb-12">
                                <h2 class="text-3xl font-bold text-ltuc-dark mb-6 flex items-center">
                                    <i class="fas fa-star mr-3 text-ltuc-primary"></i>
                                    Comprehensive AI Features
                                </h2>

                                <!-- Core AI Capabilities -->
                                <div class="mb-8">
                                    <h3 class="text-2xl font-semibold text-ltuc-dark mb-6 flex items-center">
                                        <i class="fas fa-brain mr-3 text-ltuc-primary"></i>
                                        🤖 Core AI Capabilities
                                    </h3>
                                    <div class="grid md:grid-cols-2 gap-6">
                                        <div class="bg-gradient-to-br from-purple-50 to-pink-50 p-6 rounded-xl border border-purple-100">
                                            <h4 class="font-semibold text-ltuc-dark mb-3 flex items-center">
                                                <i class="fas fa-comments mr-2 text-ltuc-primary"></i>
                                                Advanced Conversational AI
                                            </h4>
                                            <ul class="text-sm text-gray-700 space-y-1">
                                                <li>• Powered by OpenAI GPT-4o for natural, intelligent responses</li>
                                                <li>• Context-aware conversations with memory</li>
                                                <li>• Educational focus tuned for academic scenarios</li>
                                                <li>• Up to 16,000 tokens per response for detailed explanations</li>
                                            </ul>
                                        </div>
                                        <div class="bg-gradient-to-br from-blue-50 to-indigo-50 p-6 rounded-xl border border-blue-100">
                                            <h4 class="font-semibold text-ltuc-dark mb-3 flex items-center">
                                                <i class="fas fa-user-graduate mr-2 text-ltuc-secondary"></i>
                                                Personalized Learning Experience
                                            </h4>
                                            <ul class="text-sm text-gray-700 space-y-1">
                                                <li>• Personal chat history saved for registered users</li>
                                                <li>• Multiple chat sessions with individual titles</li>
                                                <li>• Contextual responses based on previous conversations</li>
                                                <li>• Progress tracking and learning patterns</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <!-- Advanced File Processing -->
                                <div class="mb-8">
                                    <h3 class="text-2xl font-semibold text-ltuc-dark mb-6 flex items-center">
                                        <i class="fas fa-file-alt mr-3 text-ltuc-primary"></i>
                                        📁 Advanced File Processing (Up to 10MB)
                                    </h3>
                                    <div class="grid md:grid-cols-3 gap-6">
                                        <div class="bg-gradient-to-br from-green-50 to-teal-50 p-6 rounded-xl border border-green-100">
                                            <h4 class="font-semibold text-ltuc-dark mb-3 flex items-center">
                                                <i class="fas fa-file-pdf mr-2 text-red-500"></i>
                                                Document Analysis
                                            </h4>
                                            <ul class="text-sm text-gray-700 space-y-1">
                                                <li>• <strong>PDFs:</strong> Text extraction + embedded images</li>
                                                <li>• <strong>Word Documents:</strong> .docx, .doc with images</li>
                                                <li>• <strong>Spreadsheets:</strong> .xlsx, .xls, .csv data analysis</li>
                                                <li>• <strong>PowerPoint:</strong> .pptx, .ppt presentations</li>
                                                <li>• <strong>Text Files:</strong> .txt, .rtf, .md, .rst</li>
                                            </ul>
                                        </div>
                                        <div class="bg-gradient-to-br from-orange-50 to-red-50 p-6 rounded-xl border border-orange-100">
                                            <h4 class="font-semibold text-ltuc-dark mb-3 flex items-center">
                                                <i class="fas fa-code mr-2 text-orange-500"></i>
                                                Programming & Code Analysis
                                            </h4>
                                            <ul class="text-sm text-gray-700 space-y-1">
                                                <li>• <strong>All Languages:</strong> Python, JavaScript, PHP, Java, C++, etc.</li>
                                                <li>• <strong>Web Files:</strong> HTML, CSS, SQL, JSON, XML</li>
                                                <li>• <strong>Config Files:</strong> YAML, TOML, ENV, Docker</li>
                                                <li>• <strong>Notebooks:</strong> Jupyter (.ipynb) cell-by-cell analysis</li>
                                                <li>• <strong>Build Files:</strong> Makefile, package.json, composer.json</li>
                                            </ul>
                                        </div>
                                        <div class="bg-gradient-to-br from-cyan-50 to-blue-50 p-6 rounded-xl border border-cyan-100">
                                            <h4 class="font-semibold text-ltuc-dark mb-3 flex items-center">
                                                <i class="fas fa-image mr-2 text-cyan-600"></i>
                                                Image & Visual Analysis
                                            </h4>
                                            <ul class="text-sm text-gray-700 space-y-1">
                                                <li>• <strong>GPT-4o Vision:</strong> Advanced image understanding</li>
                                                <li>• <strong>OCR:</strong> Text extraction from images</li>
                                                <li>• <strong>Formats:</strong> PNG, JPG, GIF, BMP, WEBP, SVG</li>
                                                <li>• <strong>Analysis:</strong> Diagrams, charts, handwritten notes</li>
                                                <li>• <strong>Educational:</strong> Math problems, homework images</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <!-- Academic & Educational Features -->
                                <div class="mb-8">
                                    <h3 class="text-2xl font-semibold text-ltuc-dark mb-6 flex items-center">
                                        <i class="fas fa-graduation-cap mr-3 text-ltuc-primary"></i>
                                        🎓 Academic & Educational Support
                                    </h3>
                                    <div class="grid md:grid-cols-2 gap-6">
                                        <div class="bg-gradient-to-br from-yellow-50 to-orange-50 p-6 rounded-xl border border-yellow-100">
                                            <h4 class="font-semibold text-ltuc-dark mb-3 flex items-center">
                                                <i class="fas fa-calculator mr-2 text-yellow-600"></i>
                                                Math & Problem Solving
                                            </h4>
                                            <ul class="text-sm text-gray-700 space-y-1">
                                                <li>• <strong>Math Equations:</strong> LaTeX formatting support</li>
                                                <li>• <strong>Calculus:</strong> Derivatives, integrals, limits</li>
                                                <li>• <strong>Algebra:</strong> Equations, matrices, polynomials</li>
                                                <li>• <strong>Statistics:</strong> Data analysis and interpretation</li>
                                                <li>• <strong>Homework Help:</strong> Step-by-step solutions</li>
                                            </ul>
                                        </div>
                                        <div class="bg-gradient-to-br from-pink-50 to-purple-50 p-6 rounded-xl border border-pink-100">
                                            <h4 class="font-semibold text-ltuc-dark mb-3 flex items-center">
                                                <i class="fas fa-book-open mr-2 text-pink-600"></i>
                                                Learning Assistance
                                            </h4>
                                            <ul class="text-sm text-gray-700 space-y-1">
                                                <li>• <strong>Concept Explanation:</strong> Complex topics simplified</li>
                                                <li>• <strong>Code Review:</strong> Bug detection and improvements</li>
                                                <li>• <strong>Research Help:</strong> Information synthesis</li>
                                                <li>• <strong>Writing Support:</strong> Essays, reports, documentation</li>
                                                <li>• <strong>Study Plans:</strong> Personalized learning paths</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <!-- Technical Features -->
                                <div class="mb-8">
                                    <h3 class="text-2xl font-semibold text-ltuc-dark mb-6 flex items-center">
                                        <i class="fas fa-cogs mr-3 text-ltuc-primary"></i>
                                        ⚙️ Technical Features
                                    </h3>
                                    <div class="grid md:grid-cols-2 gap-6">
                                        <div class="space-y-4">
                                            <div class="flex items-start space-x-3">
                                                <i class="fas fa-history text-ltuc-primary mt-1"></i>
                                                <div>
                                                    <h4 class="font-semibold text-ltuc-dark">Persistent Chat History</h4>
                                                    <p class="text-gray-600 text-sm">All conversations saved with full context retention and searchable history</p>
                                                </div>
                                            </div>
                                            <div class="flex items-start space-x-3">
                                                <i class="fas fa-upload text-ltuc-primary mt-1"></i>
                                                <div>
                                                    <h4 class="font-semibold text-ltuc-dark">Drag & Drop File Upload</h4>
                                                    <p class="text-gray-600 text-sm">Support for multiple files up to 10MB each with instant processing</p>
                                                </div>
                                            </div>
                                            <div class="flex items-start space-x-3">
                                                <i class="fas fa-code text-ltuc-primary mt-1"></i>
                                                <div>
                                                    <h4 class="font-semibold text-ltuc-dark">Syntax Highlighting</h4>
                                                    <p class="text-gray-600 text-sm">Beautiful code display with copy functionality and language detection</p>
                                                </div>
                                            </div>
                                            <div class="flex items-start space-x-3">
                                                <i class="fas fa-markdown text-ltuc-primary mt-1"></i>
                                                <div>
                                                    <h4 class="font-semibold text-ltuc-dark">Rich Text Formatting</h4>
                                                    <p class="text-gray-600 text-sm">Markdown support with tables, lists, and formatted content</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="space-y-4">
                                            <div class="flex items-start space-x-3">
                                                <i class="fas fa-mobile-alt text-ltuc-secondary mt-1"></i>
                                                <div>
                                                    <h4 class="font-semibold text-ltuc-dark">Mobile Responsive</h4>
                                                    <p class="text-gray-600 text-sm">Perfect experience on all devices with touch-optimized interface</p>
                                                </div>
                                            </div>
                                            <div class="flex items-start space-x-3">
                                                <i class="fas fa-shield-alt text-ltuc-secondary mt-1"></i>
                                                <div>
                                                    <h4 class="font-semibold text-ltuc-dark">Secure Authentication</h4>
                                                    <p class="text-gray-600 text-sm">Laravel Breeze with CSRF protection and secure sessions</p>
                                                </div>
                                            </div>
                                            <div class="flex items-start space-x-3">
                                                <i class="fas fa-tachometer-alt text-ltuc-secondary mt-1"></i>
                                                <div>
                                                    <h4 class="font-semibold text-ltuc-dark">Rate Limiting</h4>
                                                    <p class="text-gray-600 text-sm">Built-in API throttling for optimal performance and fair usage</p>
                                                </div>
                                            </div>
                                            <div class="flex items-start space-x-3">
                                                <i class="fas fa-eye text-ltuc-secondary mt-1"></i>
                                                <div>
                                                    <h4 class="font-semibold text-ltuc-dark">Demo Mode</h4>
                                                    <p class="text-gray-600 text-sm">Public demo access for testing without registration required</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- User Experience Features -->
                                <div>
                                    <h3 class="text-2xl font-semibold text-ltuc-dark mb-6 flex items-center">
                                        <i class="fas fa-paint-brush mr-3 text-ltuc-primary"></i>
                                        🎨 User Experience
                                    </h3>
                                    <div class="grid md:grid-cols-4 gap-4">
                                        <div class="bg-gradient-to-br from-indigo-50 to-blue-50 p-4 rounded-lg border border-indigo-100 text-center">
                                            <i class="fas fa-palette text-2xl text-indigo-600 mb-2"></i>
                                            <h4 class="font-semibold text-ltuc-dark text-sm">LTUC Branding</h4>
                                            <p class="text-xs text-gray-600">Beautiful pink-purple gradients matching university colors</p>
                                        </div>
                                        <div class="bg-gradient-to-br from-green-50 to-emerald-50 p-4 rounded-lg border border-green-100 text-center">
                                            <i class="fas fa-moon text-2xl text-green-600 mb-2"></i>
                                            <h4 class="font-semibold text-ltuc-dark text-sm">Dark Code Blocks</h4>
                                            <p class="text-xs text-gray-600">Professional ChatGPT-like code appearance</p>
                                        </div>
                                        <div class="bg-gradient-to-br from-orange-50 to-yellow-50 p-4 rounded-lg border border-orange-100 text-center">
                                            <i class="fas fa-mouse-pointer text-2xl text-orange-600 mb-2"></i>
                                            <h4 class="font-semibold text-ltuc-dark text-sm">Interactive Elements</h4>
                                            <p class="text-xs text-gray-600">Hover effects and smooth animations</p>
                                        </div>
                                        <div class="bg-gradient-to-br from-purple-50 to-pink-50 p-4 rounded-lg border border-purple-100 text-center">
                                            <i class="fas fa-copy text-2xl text-purple-600 mb-2"></i>
                                            <h4 class="font-semibold text-ltuc-dark text-sm">Copy to Clipboard</h4>
                                            <p class="text-xs text-gray-600">Easy code and text copying functionality</p>
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <!-- Technology Stack Section -->
                            <section id="tech-stack" class="mb-12">
                                <h2 class="text-3xl font-bold text-ltuc-dark mb-6 flex items-center">
                                    <i class="fas fa-cogs mr-3 text-ltuc-primary"></i>
                                    Technology Stack
                                </h2>
                                <div class="grid md:grid-cols-2 gap-8">
                                    <div>
                                        <h3 class="text-xl font-semibold text-ltuc-dark mb-4">Backend</h3>
                                        <div class="space-y-3">
                                            <div class="flex items-center space-x-3 p-3 bg-red-50 rounded-lg border border-red-100">
                                                <i class="fab fa-laravel text-red-600"></i>
                                                <span class="font-medium">Laravel 11.31</span>
                                                <span class="text-sm text-gray-500">- PHP Framework</span>
                                            </div>
                                            <div class="flex items-center space-x-3 p-3 bg-blue-50 rounded-lg border border-blue-100">
                                                <i class="fab fa-php text-blue-600"></i>
                                                <span class="font-medium">PHP 8.3-CLI</span>
                                                <span class="text-sm text-gray-500">- Server Runtime</span>
                                            </div>
                                            <div class="flex items-center space-x-3 p-3 bg-green-50 rounded-lg border border-green-100">
                                                <i class="fas fa-database text-green-600"></i>
                                                <span class="font-medium">MySQL/SQLite</span>
                                                <span class="text-sm text-gray-500">- Database</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <h3 class="text-xl font-semibold text-ltuc-dark mb-4">Frontend</h3>
                                        <div class="space-y-3">
                                            <div class="flex items-center space-x-3 p-3 bg-cyan-50 rounded-lg border border-cyan-100">
                                                <i class="fab fa-css3 text-cyan-600"></i>
                                                <span class="font-medium">TailwindCSS 3.1</span>
                                                <span class="text-sm text-gray-500">- Styling</span>
                                            </div>
                                            <div class="flex items-center space-x-3 p-3 bg-green-50 rounded-lg border border-green-100">
                                                <i class="fab fa-js text-green-600"></i>
                                                <span class="font-medium">Alpine.js 3.4</span>
                                                <span class="text-sm text-gray-500">- Interactivity</span>
                                            </div>
                                            <div class="flex items-center space-x-3 p-3 bg-purple-50 rounded-lg border border-purple-100">
                                                <i class="fas fa-bolt text-purple-600"></i>
                                                <span class="font-medium">Vite 6.0</span>
                                                <span class="text-sm text-gray-500">- Build Tool</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-8">
                                    <h3 class="text-xl font-semibold text-ltuc-dark mb-4">AI & Processing</h3>
                                    <div class="grid md:grid-cols-3 gap-4">
                                        <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded-lg border border-gray-100">
                                            <i class="fas fa-robot text-gray-600"></i>
                                            <span class="font-medium">OpenAI PHP Client 0.15</span>
                                        </div>
                                        <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded-lg border border-gray-100">
                                            <i class="fas fa-file-pdf text-gray-600"></i>
                                            <span class="font-medium">PHPOffice Suite</span>
                                        </div>
                                        <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded-lg border border-gray-100">
                                            <i class="fas fa-markdown text-gray-600"></i>
                                            <span class="font-medium">CommonMark</span>
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <!-- Installation Section -->
                            <section id="installation" class="mb-12">
                                <h2 class="text-3xl font-bold text-ltuc-dark mb-6 flex items-center">
                                    <i class="fas fa-download mr-3 text-ltuc-primary"></i>
                                    Installation
                                </h2>
                                <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
                                    <h3 class="text-lg font-semibold text-ltuc-dark mb-4">Prerequisites</h3>
                                    <ul class="list-disc list-inside space-y-2 text-gray-700 mb-6">
                                        <li>PHP 8.3 or higher</li>
                                        <li>Composer</li>
                                        <li>Node.js 20.x</li>
                                        <li>MySQL or SQLite</li>
                                        <li>OpenAI API Key</li>
                                    </ul>

                                    <h3 class="text-lg font-semibold text-ltuc-dark mb-4">Setup Steps</h3>
                                    <div class="space-y-4">
                                        <div class="code-block rounded-lg p-4">
                                            <code class="text-sm">
# Clone the repository<br>
git clone https://github.com/osamaalkhazali/LTUCBot.git<br>
cd LTUCBot<br><br>

# Install PHP dependencies<br>
composer install<br><br>

# Install Node.js dependencies<br>
npm install<br><br>

# Copy environment file<br>
cp .env.example .env<br><br>

# Generate application key<br>
php artisan key:generate<br><br>

# Run migrations<br>
php artisan migrate<br><br>

# Build assets<br>
npm run build<br><br>

# Start the development server<br>
php artisan serve
                                            </code>
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <!-- Docker Section -->
                            <section id="docker" class="mb-12">
                                <h2 class="text-3xl font-bold text-ltuc-dark mb-6 flex items-center">
                                    <i class="fab fa-docker mr-3 text-ltuc-primary"></i>
                                    Docker Deployment
                                </h2>
                                <div class="bg-blue-50 rounded-xl p-6 border border-blue-200">
                                    <p class="text-gray-700 mb-6">
                                        The application uses a multi-stage Docker build process optimized for production deployment.
                                        The Dockerfile creates a lightweight, secure container with all necessary dependencies.
                                    </p>

                                    <h3 class="text-lg font-semibold text-ltuc-dark mb-4">Docker Build Process</h3>
                                    <div class="grid md:grid-cols-2 gap-6 mb-6">
                                        <div>
                                            <h4 class="font-medium text-ltuc-dark mb-2">Stage 1: Node.js Build</h4>
                                            <ul class="text-sm text-gray-600 space-y-1">
                                                <li>• Node.js 20 Alpine base</li>
                                                <li>• Install npm dependencies</li>
                                                <li>• Build frontend assets with Vite</li>
                                                <li>• Optimize for production</li>
                                            </ul>
                                        </div>
                                        <div>
                                            <h4 class="font-medium text-ltuc-dark mb-2">Stage 2: PHP Runtime</h4>
                                            <ul class="text-sm text-gray-600 space-y-1">
                                                <li>• PHP 8.3-CLI Alpine base</li>
                                                <li>• Install required PHP extensions</li>
                                                <li>• Copy application code</li>
                                                <li>• Configure for production</li>
                                            </ul>
                                        </div>
                                    </div>

                                    <h3 class="text-lg font-semibold text-ltuc-dark mb-4">Quick Start with Docker</h3>
                                    <div class="code-block rounded-lg p-4">
                                        <code class="text-sm">
# Build and run with Docker<br>
docker build -t ltuc-ai-assistant .<br>
docker run -p 8000:8000 ltuc-ai-assistant<br><br>

# Or use Docker Compose<br>
docker-compose up -d
                                        </code>
                                    </div>
                                </div>
                            </section>

                            <!-- Configuration Section -->
                            <section id="configuration" class="mb-12">
                                <h2 class="text-3xl font-bold text-ltuc-dark mb-6 flex items-center">
                                    <i class="fas fa-cog mr-3 text-ltuc-primary"></i>
                                    Configuration
                                </h2>
                                <div class="space-y-8">
                                    <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
                                        <h3 class="text-lg font-semibold text-ltuc-dark mb-4">Environment Variables</h3>
                                        <p class="text-gray-700 mb-4">Create your <code class="bg-gray-200 px-2 py-1 rounded">.env</code> file with the following configurations:</p>
                                        <div class="code-block rounded-lg p-4">
                                            <code class="text-sm">
# Application<br>
APP_NAME="LTUC AI Assistant"<br>
APP_ENV=production<br>
APP_KEY=base64:your-generated-key<br>
APP_DEBUG=false<br>
APP_URL=https://ltucbot.up.railway.app<br><br>

# Database (Clever Cloud MySQL)<br>
DB_CONNECTION=mysql<br>
DB_HOST=your-clever-cloud-host<br>
DB_PORT=3306<br>
DB_DATABASE=your-database-name<br>
DB_USERNAME=your-username<br>
DB_PASSWORD=your-password<br><br>

# OpenAI Configuration<br>
OPENAI_API_KEY=your_openai_api_key_here<br>
OPENAI_ORGANIZATION=your_org_id_optional<br><br>

# File Upload Limits<br>
UPLOAD_MAX_FILESIZE=10M<br>
POST_MAX_SIZE=10M
                                            </code>
                                        </div>
                                    </div>

                                    <div class="bg-green-50 rounded-xl p-6 border border-green-200">
                                        <h3 class="text-lg font-semibold text-ltuc-dark mb-4">OpenAI API Setup</h3>
                                        <ol class="list-decimal list-inside space-y-2 text-gray-700">
                                            <li><strong>Get API Key:</strong> Visit <a href="https://platform.openai.com/api-keys" class="text-ltuc-primary hover:underline">OpenAI Platform</a></li>
                                            <li><strong>Create New Key:</strong> Generate a new secret key</li>
                                            <li><strong>Add to Environment:</strong> Set <code class="bg-gray-200 px-2 py-1 rounded">OPENAI_API_KEY</code> in your <code class="bg-gray-200 px-2 py-1 rounded">.env</code> file</li>
                                            <li><strong>Set Usage Limits:</strong> Configure billing and usage limits in OpenAI dashboard</li>
                                        </ol>
                                    </div>
                                </div>
                            </section>

                            <!-- Usage Section -->
                            <section id="usage" class="mb-12">
                                <h2 class="text-3xl font-bold text-ltuc-dark mb-6 flex items-center">
                                    <i class="fas fa-play mr-3 text-ltuc-primary"></i>
                                    Usage Guide
                                </h2>
                                <div class="space-y-8">
                                    <div class="bg-blue-50 rounded-xl p-6 border border-blue-200">
                                        <h3 class="text-lg font-semibold text-ltuc-dark mb-4">Access the Application</h3>
                                        <div class="grid md:grid-cols-3 gap-4">
                                            <div class="bg-white p-4 rounded-lg border border-blue-100">
                                                <h4 class="font-medium text-ltuc-dark mb-2">Production</h4>
                                                <a href="https://ltucbot.up.railway.app/" class="text-ltuc-primary hover:underline text-sm">ltucbot.up.railway.app</a>
                                            </div>
                                            <div class="bg-white p-4 rounded-lg border border-blue-100">
                                                <h4 class="font-medium text-ltuc-dark mb-2">Demo Mode</h4>
                                                <p class="text-gray-600 text-sm">Try without registration</p>
                                            </div>
                                            <div class="bg-white p-4 rounded-lg border border-blue-100">
                                                <h4 class="font-medium text-ltuc-dark mb-2">Full Features</h4>
                                                <p class="text-gray-600 text-sm">Register for chat history</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="grid md:grid-cols-2 gap-8">
                                        <div class="bg-purple-50 rounded-xl p-6 border border-purple-200">
                                            <h3 class="text-lg font-semibold text-ltuc-dark mb-4">Sample Text Questions</h3>
                                            <div class="space-y-3">
                                                <div class="bg-white p-3 rounded border border-purple-100">
                                                    <code class="text-sm text-gray-700">"Explain object-oriented programming"</code>
                                                </div>
                                                <div class="bg-white p-3 rounded border border-purple-100">
                                                    <code class="text-sm text-gray-700">"Help me understand calculus derivatives"</code>
                                                </div>
                                                <div class="bg-white p-3 rounded border border-purple-100">
                                                    <code class="text-sm text-gray-700">"Laravel development best practices"</code>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="bg-green-50 rounded-xl p-6 border border-green-200">
                                            <h3 class="text-lg font-semibold text-ltuc-dark mb-4">File-based Interactions</h3>
                                            <div class="space-y-3">
                                                <div class="bg-white p-3 rounded border border-green-100">
                                                    <code class="text-sm text-gray-700">"Analyze this code" + upload .php file</code>
                                                </div>
                                                <div class="bg-white p-3 rounded border border-green-100">
                                                    <code class="text-sm text-gray-700">"Extract key points" + upload PDF</code>
                                                </div>
                                                <div class="bg-white p-3 rounded border border-green-100">
                                                    <code class="text-sm text-gray-700">"What does this show?" + upload image</code>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <!-- File Processing Section -->
                            <section id="file-processing" class="mb-12">
                                <h2 class="text-3xl font-bold text-ltuc-dark mb-6 flex items-center">
                                    <i class="fas fa-file mr-3 text-ltuc-primary"></i>
                                    File Processing
                                </h2>
                                <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl p-6 border border-blue-200">
                                    <h3 class="text-lg font-semibold text-ltuc-dark mb-6">Supported File Types</h3>
                                    <div class="overflow-x-auto">
                                        <table class="w-full border-collapse border border-gray-300 bg-white rounded-lg">
                                            <thead>
                                                <tr class="bg-gray-100">
                                                    <th class="border border-gray-300 px-4 py-3 text-left font-semibold">Category</th>
                                                    <th class="border border-gray-300 px-4 py-3 text-left font-semibold">Extensions</th>
                                                    <th class="border border-gray-300 px-4 py-3 text-left font-semibold">Processing Method</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td class="border border-gray-300 px-4 py-3 font-medium">Documents</td>
                                                    <td class="border border-gray-300 px-4 py-3"><code class="text-sm">.pdf, .docx, .doc, .txt, .rtf</code></td>
                                                    <td class="border border-gray-300 px-4 py-3">Text extraction + AI analysis</td>
                                                </tr>
                                                <tr class="bg-gray-50">
                                                    <td class="border border-gray-300 px-4 py-3 font-medium">Spreadsheets</td>
                                                    <td class="border border-gray-300 px-4 py-3"><code class="text-sm">.xlsx, .xls, .csv</code></td>
                                                    <td class="border border-gray-300 px-4 py-3">Data parsing + structure analysis</td>
                                                </tr>
                                                <tr>
                                                    <td class="border border-gray-300 px-4 py-3 font-medium">Images</td>
                                                    <td class="border border-gray-300 px-4 py-3"><code class="text-sm">.png, .jpg, .jpeg, .gif, .bmp, .webp</code></td>
                                                    <td class="border border-gray-300 px-4 py-3">GPT-4o Vision API</td>
                                                </tr>
                                                <tr class="bg-gray-50">
                                                    <td class="border border-gray-300 px-4 py-3 font-medium">Code</td>
                                                    <td class="border border-gray-300 px-4 py-3"><code class="text-sm">.php, .js, .py, .java, .cpp, .html, .css</code></td>
                                                    <td class="border border-gray-300 px-4 py-3">Syntax-aware processing</td>
                                                </tr>
                                                <tr>
                                                    <td class="border border-gray-300 px-4 py-3 font-medium">Data</td>
                                                    <td class="border border-gray-300 px-4 py-3"><code class="text-sm">.json, .xml, .yaml, .sql</code></td>
                                                    <td class="border border-gray-300 px-4 py-3">Structure-aware parsing</td>
                                                </tr>
                                                <tr class="bg-gray-50">
                                                    <td class="border border-gray-300 px-4 py-3 font-medium">Archives</td>
                                                    <td class="border border-gray-300 px-4 py-3"><code class="text-sm">.zip</code></td>
                                                    <td class="border border-gray-300 px-4 py-3">Content extraction + analysis</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="mt-8 grid md:grid-cols-2 gap-6">
                                        <div class="bg-white rounded-lg p-4 border border-blue-100">
                                            <h4 class="font-medium text-ltuc-dark mb-3">Processing Features</h4>
                                            <ul class="space-y-2 text-sm text-gray-700">
                                                <li>• <strong>Automatic Type Detection</strong> - Smart MIME type analysis</li>
                                                <li>• <strong>Content Extraction</strong> - Text, code, and data extraction</li>
                                                <li>• <strong>Image Analysis</strong> - OCR and visual content understanding</li>
                                                <li>• <strong>Error Handling</strong> - Graceful fallbacks for unsupported files</li>
                                            </ul>
                                        </div>
                                        <div class="bg-white rounded-lg p-4 border border-blue-100">
                                            <h4 class="font-medium text-ltuc-dark mb-3">Size Limits</h4>
                                            <ul class="space-y-2 text-sm text-gray-700">
                                                <li>• <strong>Images:</strong> 10MB maximum for GPT-4o Vision</li>
                                                <li>• <strong>Documents:</strong> Configurable file size restrictions</li>
                                                <li>• <strong>Archives:</strong> Content extraction with size validation</li>
                                                <li>• <strong>Code Files:</strong> No specific size limit for text analysis</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <!-- Live Deployments Section -->
                            <section id="live-deployments" class="mb-12">
                                <h2 class="text-3xl font-bold text-ltuc-dark mb-6 flex items-center">
                                    <i class="fas fa-cloud mr-3 text-ltuc-primary"></i>
                                    Live Deployments
                                </h2>
                                <div class="grid md:grid-cols-3 gap-6">
                                    <div class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-xl p-6 border border-purple-200">
                                        <div class="text-center mb-4">
                                            <i class="fas fa-train text-3xl text-purple-600 mb-3"></i>
                                            <h3 class="text-lg font-semibold text-ltuc-dark">Railway (Primary)</h3>
                                        </div>
                                        <div class="space-y-3">
                                            <a href="https://ltucbot.up.railway.app/"
                                               class="block bg-white p-3 rounded-lg border border-purple-100 text-center hover:bg-purple-50 transition">
                                                <code class="text-sm text-ltuc-primary">ltucbot.up.railway.app</code>
                                            </a>
                                            <ul class="text-sm text-gray-600 space-y-1">
                                                <li>• Production environment</li>
                                                <li>• Automatic deployments</li>
                                                <li>• High availability</li>
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="bg-gradient-to-br from-blue-50 to-cyan-50 rounded-xl p-6 border border-blue-200">
                                        <div class="text-center mb-4">
                                            <i class="fas fa-server text-3xl text-blue-600 mb-3"></i>
                                            <h3 class="text-lg font-semibold text-ltuc-dark">Render (Backup)</h3>
                                        </div>
                                        <div class="space-y-3">
                                            <a href="https://ltucbot.onrender.com/"
                                               class="block bg-white p-3 rounded-lg border border-blue-100 text-center hover:bg-blue-50 transition">
                                                <code class="text-sm text-ltuc-primary">ltucbot.onrender.com</code>
                                            </a>
                                            <ul class="text-sm text-gray-600 space-y-1">
                                                <li>• Backup deployment</li>
                                                <li>• Docker-based hosting</li>
                                                <li>• Redundancy and failover</li>
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="bg-gradient-to-br from-green-50 to-teal-50 rounded-xl p-6 border border-green-200">
                                        <div class="text-center mb-4">
                                            <i class="fas fa-database text-3xl text-green-600 mb-3"></i>
                                            <h3 class="text-lg font-semibold text-ltuc-dark">Clever Cloud DB</h3>
                                        </div>
                                        <div class="space-y-3">
                                            <div class="bg-white p-3 rounded-lg border border-green-100 text-center">
                                                <code class="text-sm text-gray-600">MySQL Database</code>
                                            </div>
                                            <ul class="text-sm text-gray-600 space-y-1">
                                                <li>• Managed MySQL hosting</li>
                                                <li>• Automatic backups</li>
                                                <li>• Shared across deployments</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <!-- API Integration Section -->
                            <section id="api-integration" class="mb-12">
                                <h2 class="text-3xl font-bold text-ltuc-dark mb-6 flex items-center">
                                    <i class="fas fa-plug mr-3 text-ltuc-primary"></i>
                                    API Integration
                                </h2>
                                <div class="space-y-8">
                                    <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
                                        <h3 class="text-lg font-semibold text-ltuc-dark mb-4">OpenAI Configuration</h3>
                                        <p class="text-gray-700 mb-4">The application uses OpenAI's latest models for optimal performance:</p>
                                        <div class="grid md:grid-cols-2 gap-6">
                                            <div class="bg-white rounded-lg p-4 border border-gray-100">
                                                <h4 class="font-medium text-ltuc-dark mb-3">Chat Completions</h4>
                                                <div class="code-block rounded p-3">
                                                    <code class="text-sm">
'model' => 'gpt-4o',<br>
'max_tokens' => 16000,<br>
'temperature' => 0.7
                                                    </code>
                                                </div>
                                            </div>
                                            <div class="bg-white rounded-lg p-4 border border-gray-100">
                                                <h4 class="font-medium text-ltuc-dark mb-3">Vision API (Images)</h4>
                                                <div class="code-block rounded p-3">
                                                    <code class="text-sm">
'model' => 'gpt-4o-mini',<br>
'detail' => 'high'
                                                    </code>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="bg-blue-50 rounded-xl p-6 border border-blue-200">
                                        <h3 class="text-lg font-semibold text-ltuc-dark mb-4">Response Formatting</h3>
                                        <p class="text-gray-700 mb-4">All AI responses include multiple formats for optimal user experience:</p>
                                        <div class="grid md:grid-cols-2 gap-4">
                                            <div class="space-y-3">
                                                <div class="bg-white p-3 rounded border border-blue-100">
                                                    <strong>Raw Text:</strong> Original AI response
                                                </div>
                                                <div class="bg-white p-3 rounded border border-blue-100">
                                                    <strong>HTML:</strong> Parsed markdown with syntax highlighting
                                                </div>
                                            </div>
                                            <div class="space-y-3">
                                                <div class="bg-white p-3 rounded border border-blue-100">
                                                    <strong>Code Blocks:</strong> Formatted with copy functionality
                                                </div>
                                                <div class="bg-white p-3 rounded border border-blue-100">
                                                    <strong>File Analysis:</strong> Structured content extraction results
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <!-- Development Section -->
                            <section id="development" class="mb-12">
                                <h2 class="text-3xl font-bold text-ltuc-dark mb-6 flex items-center">
                                    <i class="fas fa-code mr-3 text-ltuc-primary"></i>
                                    Development
                                </h2>
                                <div class="space-y-8">
                                    <div class="bg-green-50 rounded-xl p-6 border border-green-200">
                                        <h3 class="text-lg font-semibold text-ltuc-dark mb-4">Development Environment Setup</h3>
                                        <div class="code-block rounded-lg p-4">
                                            <code class="text-sm">
# Install development dependencies<br>
composer install --dev<br>
npm install --dev<br><br>

# Set up testing database<br>
php artisan migrate --env=testing<br><br>

# Run development server with debugging<br>
php artisan serve --env=local
                                            </code>
                                        </div>
                                    </div>

                                    <div class="bg-purple-50 rounded-xl p-6 border border-purple-200">
                                        <h3 class="text-lg font-semibold text-ltuc-dark mb-4">Code Standards</h3>
                                        <div class="grid md:grid-cols-2 gap-6">
                                            <div class="bg-white rounded-lg p-4 border border-purple-100">
                                                <ul class="space-y-2 text-gray-700">
                                                    <li><strong>PSR-12:</strong> PHP coding standard compliance</li>
                                                    <li><strong>Laravel Conventions:</strong> Follow Laravel best practices</li>
                                                </ul>
                                            </div>
                                            <div class="bg-white rounded-lg p-4 border border-purple-100">
                                                <ul class="space-y-2 text-gray-700">
                                                    <li><strong>Documentation:</strong> Comment complex functions</li>
                                                    <li><strong>Testing:</strong> Write tests for new features</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <!-- Testing Section -->
                            <section id="testing" class="mb-12">
                                <h2 class="text-3xl font-bold text-ltuc-dark mb-6 flex items-center">
                                    <i class="fas fa-flask mr-3 text-ltuc-primary"></i>
                                    Testing
                                </h2>
                                <div class="bg-yellow-50 rounded-xl p-6 border border-yellow-200">
                                    <h3 class="text-lg font-semibold text-ltuc-dark mb-4">Test Suite</h3>
                                    <p class="text-gray-700 mb-4">The application includes comprehensive testing with PHPUnit:</p>
                                    <div class="grid md:grid-cols-2 gap-6">
                                        <div class="bg-white rounded-lg p-4 border border-yellow-100">
                                            <h4 class="font-medium text-ltuc-dark mb-3">Feature Tests</h4>
                                            <ul class="text-sm text-gray-700 space-y-1">
                                                <li>• Authentication flow testing</li>
                                                <li>• Chat functionality testing</li>
                                                <li>• File upload testing</li>
                                                <li>• API endpoint testing</li>
                                            </ul>
                                        </div>
                                        <div class="bg-white rounded-lg p-4 border border-yellow-100">
                                            <h4 class="font-medium text-ltuc-dark mb-3">Unit Tests</h4>
                                            <ul class="text-sm text-gray-700 space-y-1">
                                                <li>• File processing logic</li>
                                                <li>• Model relationships</li>
                                                <li>• Helper functions</li>
                                                <li>• Validation rules</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="mt-4 code-block rounded-lg p-4">
                                        <code class="text-sm">
# Run all tests<br>
php artisan test<br><br>

# Run specific test suite<br>
php artisan test --testsuite=Feature<br>
php artisan test --testsuite=Unit
                                        </code>
                                    </div>
                                </div>
                            </section>

                            <!-- Contributing Section -->
                            <section id="contributing" class="mb-12">
                                <h2 class="text-3xl font-bold text-ltuc-dark mb-6 flex items-center">
                                    <i class="fas fa-hands-helping mr-3 text-ltuc-primary"></i>
                                    Contributing
                                </h2>
                                <div class="bg-indigo-50 rounded-xl p-6 border border-indigo-200">
                                    <h3 class="text-lg font-semibold text-ltuc-dark mb-4">Development Workflow</h3>
                                    <div class="space-y-4">
                                        <div class="flex items-start space-x-3">
                                            <span class="bg-ltuc-primary text-white rounded-full w-6 h-6 flex items-center justify-center text-sm font-bold">1</span>
                                            <div>
                                                <h4 class="font-medium text-ltuc-dark">Fork the Repository</h4>
                                                <p class="text-gray-600 text-sm">Create your own fork of the project</p>
                                            </div>
                                        </div>
                                        <div class="flex items-start space-x-3">
                                            <span class="bg-ltuc-primary text-white rounded-full w-6 h-6 flex items-center justify-center text-sm font-bold">2</span>
                                            <div>
                                                <h4 class="font-medium text-ltuc-dark">Create Feature Branch</h4>
                                                <code class="text-sm text-gray-600">git checkout -b feature/amazing-feature</code>
                                            </div>
                                        </div>
                                        <div class="flex items-start space-x-3">
                                            <span class="bg-ltuc-primary text-white rounded-full w-6 h-6 flex items-center justify-center text-sm font-bold">3</span>
                                            <div>
                                                <h4 class="font-medium text-ltuc-dark">Make Changes</h4>
                                                <p class="text-gray-600 text-sm">Follow PSR-12 coding standards</p>
                                            </div>
                                        </div>
                                        <div class="flex items-start space-x-3">
                                            <span class="bg-ltuc-primary text-white rounded-full w-6 h-6 flex items-center justify-center text-sm font-bold">4</span>
                                            <div>
                                                <h4 class="font-medium text-ltuc-dark">Run Tests</h4>
                                                <p class="text-gray-600 text-sm">Ensure all tests pass</p>
                                            </div>
                                        </div>
                                        <div class="flex items-start space-x-3">
                                            <span class="bg-ltuc-primary text-white rounded-full w-6 h-6 flex items-center justify-center text-sm font-bold">5</span>
                                            <div>
                                                <h4 class="font-medium text-ltuc-dark">Submit Pull Request</h4>
                                                <p class="text-gray-600 text-sm">With detailed description of changes</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <!-- License Section -->
                            <section id="license" class="mb-12">
                                <h2 class="text-3xl font-bold text-ltuc-dark mb-6 flex items-center">
                                    <i class="fas fa-balance-scale mr-3 text-ltuc-primary"></i>
                                    License & Acknowledgments
                                </h2>
                                <div class="space-y-6">
                                    <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
                                        <h3 class="text-lg font-semibold text-ltuc-dark mb-4">License</h3>
                                        <p class="text-gray-700">
                                            This project is open-sourced software licensed under the
                                            <a href="https://opensource.org/licenses/MIT" class="text-ltuc-primary hover:underline">MIT license</a>.
                                        </p>
                                    </div>

                                    <div class="bg-gradient-to-br from-pink-50 to-purple-50 rounded-xl p-6 border border-pink-200">
                                        <h3 class="text-lg font-semibold text-ltuc-dark mb-4">Acknowledgments</h3>
                                        <div class="grid md:grid-cols-2 gap-4">
                                            <div class="space-y-2">
                                                <div class="flex items-center space-x-2">
                                                    <i class="fas fa-robot text-ltuc-primary"></i>
                                                    <span class="text-gray-700"><strong>OpenAI</strong> for providing the GPT-4o API</span>
                                                </div>
                                                <div class="flex items-center space-x-2">
                                                    <i class="fab fa-laravel text-red-500"></i>
                                                    <span class="text-gray-700"><strong>Laravel Community</strong> for the amazing framework</span>
                                                </div>
                                            </div>
                                            <div class="space-y-2">
                                                <div class="flex items-center space-x-2">
                                                    <i class="fas fa-cloud text-ltuc-secondary"></i>
                                                    <span class="text-gray-700"><strong>Railway & Render</strong> for reliable hosting</span>
                                                </div>
                                                <div class="flex items-center space-x-2">
                                                    <i class="fas fa-graduation-cap text-ltuc-accent"></i>
                                                    <span class="text-gray-700"><strong>LTUC</strong> for supporting educational technology</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="bg-blue-50 rounded-xl p-6 border border-blue-200 text-center">
                                        <div class="mb-4">
                                            <img src="{{ asset('assets/images/LTUCBot.png') }}" alt="LTUC AI Assistant" class="h-16 w-auto mx-auto mb-4">
                                        </div>
                                        <h3 class="text-xl font-bold text-ltuc-dark mb-2">Built with ❤️ for Education</h3>
                                        <p class="text-gray-600 mb-4">© 2025 LTUC AI Assistant | Powered by Laravel & OpenAI</p>
                                        <div class="flex justify-center space-x-4">
                                            <a href="https://github.com/osamaalkhazali/LTUCBot/issues"
                                               class="text-ltuc-primary hover:underline text-sm">
                                                <i class="fab fa-github mr-1"></i>GitHub Issues
                                            </a>
                                            <a href="https://ltucbot.up.railway.app/"
                                               class="text-ltuc-primary hover:underline text-sm">
                                                <i class="fas fa-external-link-alt mr-1"></i>Live Demo
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <!-- Continue with the rest of the sections... -->
                            <!-- This is just the first part to show the structure -->

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Table of Contents scroll behavior
        document.addEventListener('DOMContentLoaded', function() {
            const tocLinks = document.querySelectorAll('.toc a');
            const sections = document.querySelectorAll('section[id]');

            // Smooth scrolling
            tocLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const targetId = this.getAttribute('href').substring(1);
                    const targetSection = document.getElementById(targetId);
                    if (targetSection) {
                        targetSection.scrollIntoView({ behavior: 'smooth' });
                    }
                });
            });

            // Active section highlighting
            function highlightActiveSection() {
                let current = '';
                sections.forEach(section => {
                    const sectionTop = section.offsetTop;
                    const sectionHeight = section.clientHeight;
                    if (pageYOffset >= sectionTop - 200) {
                        current = section.getAttribute('id');
                    }
                });

                tocLinks.forEach(link => {
                    link.classList.remove('active');
                    if (link.getAttribute('href').substring(1) === current) {
                        link.classList.add('active');
                    }
                });
            }

            window.addEventListener('scroll', highlightActiveSection);
            highlightActiveSection(); // Initial call
        });
    </script>
</body>
</html>
