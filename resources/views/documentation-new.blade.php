<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-2xl text-ltuc-dark leading-tight flex items-center">
                    <i class="fas fa-book mr-3 text-ltuc-primary"></i>
                    Documentation
                </h2>
                <p class="text-ltuc-light mt-1">Complete guide to LTUC AI Assistant project and deployment.</p>
            </div>
            <div class="hidden md:block">
                <a href="/ltuc/chatbot"
                    class="inline-flex items-center px-6 py-3 ltuc-primary text-white font-semibold rounded-xl hover:opacity-90 transform hover:scale-105 transition duration-300">
                    <i class="fas fa-robot mr-2"></i>
                    Open AI Assistant
                </a>
            </div>
        </div>
    </x-slot>

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
                                <a href="#overview"
                                    class="block text-sm text-gray-600 hover:text-ltuc-primary py-1 transition">Overview</a>
                                <a href="#features"
                                    class="block text-sm text-gray-600 hover:text-ltuc-primary py-1 transition">Features</a>
                                <a href="#tech-stack"
                                    class="block text-sm text-gray-600 hover:text-ltuc-primary py-1 transition">Technology
                                    Stack</a>
                                <a href="#installation"
                                    class="block text-sm text-gray-600 hover:text-ltuc-primary py-1 transition">Installation</a>
                                <a href="#docker"
                                    class="block text-sm text-gray-600 hover:text-ltuc-primary py-1 transition">Docker
                                    Deployment</a>
                                <a href="#usage"
                                    class="block text-sm text-gray-600 hover:text-ltuc-primary py-1 transition">Usage</a>
                                <a href="#laravel-choice"
                                    class="block text-sm text-gray-600 hover:text-ltuc-primary py-1 transition">Why
                                    Laravel?</a>
                                <a href="#live-deployments"
                                    class="block text-sm text-gray-600 hover:text-ltuc-primary py-1 transition">Live
                                    Deployments</a>
                                <a href="#development"
                                    class="block text-sm text-gray-600 hover:text-ltuc-primary py-1 transition">Development</a>
                                <a href="#testing"
                                    class="block text-sm text-gray-600 hover:text-ltuc-primary py-1 transition">Testing</a>
                                <a href="#contributing"
                                    class="block text-sm text-gray-600 hover:text-ltuc-primary py-1 transition">Contributing</a>
                                <a href="#license"
                                    class="block text-sm text-gray-600 hover:text-ltuc-primary py-1 transition">License</a>
                            </nav>
                        </div>
                    </div>

                    <!-- Main Content -->
                    <div class="lg:w-3/4 main-content">
                        <div class="p-8">
                            <!-- Project Header -->
                            <div class="text-center mb-12">
                                <div class="flex justify-center mb-6">
                                    <img src="{{ asset('assets/images/LTUCBot.png') }}" alt="LTUC AI Assistant"
                                        class="h-20 w-auto">
                                </div>
                                <h1 class="text-4xl font-bold text-ltuc-dark mb-4">LTUC AI Assistant</h1>
                                <p class="text-xl text-ltuc-light max-w-3xl mx-auto">
                                    An intelligent learning companion for LTUC students, powered by OpenAI's advanced
                                    language models and built with Laravel.
                                </p>
                                <div class="flex justify-center space-x-4 mt-6">
                                    <span
                                        class="px-4 py-2 bg-ltuc-primary text-white rounded-full text-sm font-medium">Laravel
                                        11.31</span>
                                    <span
                                        class="px-4 py-2 bg-ltuc-secondary text-white rounded-full text-sm font-medium">PHP
                                        8.3</span>
                                    <span
                                        class="px-4 py-2 bg-ltuc-accent text-white rounded-full text-sm font-medium">OpenAI
                                        GPT</span>
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
                                        The LTUC AI Assistant is a sophisticated web application designed specifically
                                        for Luminus Technical University College students. It provides an intelligent,
                                        conversational interface that helps students with academic questions, learning
                                        support, and educational guidance.
                                    </p>
                                    <div class="grid md:grid-cols-3 gap-6 mt-8">
                                        <div
                                            class="bg-gradient-to-br from-purple-50 to-pink-50 p-6 rounded-xl border border-purple-100">
                                            <i class="fas fa-brain text-2xl text-ltuc-primary mb-3"></i>
                                            <h3 class="font-semibold text-ltuc-dark mb-2">Intelligent Responses</h3>
                                            <p class="text-sm text-gray-600">Powered by OpenAI's advanced language
                                                models for accurate and helpful responses.</p>
                                        </div>
                                        <div
                                            class="bg-gradient-to-br from-green-50 to-teal-50 p-6 rounded-xl border border-green-100">
                                            <i class="fas fa-users text-2xl text-ltuc-secondary mb-3"></i>
                                            <h3 class="font-semibold text-ltuc-dark mb-2">Student-Focused</h3>
                                            <p class="text-sm text-gray-600">Tailored specifically for LTUC students
                                                with academic context and support.</p>
                                        </div>
                                        <div
                                            class="bg-gradient-to-br from-blue-50 to-indigo-50 p-6 rounded-xl border border-blue-100">
                                            <i class="fas fa-clock text-2xl text-ltuc-accent mb-3"></i>
                                            <h3 class="font-semibold text-ltuc-dark mb-2">24/7 Availability</h3>
                                            <p class="text-sm text-gray-600">Always available to help with learning
                                                questions and academic support.</p>
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <!-- Features Section -->
                            <section id="features" class="mb-12">
                                <h2 class="text-3xl font-bold text-ltuc-dark mb-6 flex items-center">
                                    <i class="fas fa-star mr-3 text-ltuc-primary"></i>
                                    Key Features
                                </h2>
                                <div class="grid md:grid-cols-2 gap-8">
                                    <div class="space-y-4">
                                        <div class="flex items-start space-x-3">
                                            <i class="fas fa-check-circle text-ltuc-primary mt-1"></i>
                                            <div>
                                                <h4 class="font-semibold text-ltuc-dark">Multi-Format Document
                                                    Processing</h4>
                                                <p class="text-gray-600 text-sm">Support for PDF, DOCX, TXT, and other
                                                    document formats</p>
                                            </div>
                                        </div>
                                        <div class="flex items-start space-x-3">
                                            <i class="fas fa-check-circle text-ltuc-primary mt-1"></i>
                                            <div>
                                                <h4 class="font-semibold text-ltuc-dark">Real-time Chat Interface</h4>
                                                <p class="text-gray-600 text-sm">Instant responses with typing
                                                    indicators and message history</p>
                                            </div>
                                        </div>
                                        <div class="flex items-start space-x-3">
                                            <i class="fas fa-check-circle text-ltuc-primary mt-1"></i>
                                            <div>
                                                <h4 class="font-semibold text-ltuc-dark">User Authentication</h4>
                                                <p class="text-gray-600 text-sm">Secure login system with personalized
                                                    chat history</p>
                                            </div>
                                        </div>
                                        <div class="flex items-start space-x-3">
                                            <i class="fas fa-check-circle text-ltuc-primary mt-1"></i>
                                            <div>
                                                <h4 class="font-semibold text-ltuc-dark">Mobile-Responsive Design</h4>
                                                <p class="text-gray-600 text-sm">Optimized for all devices and screen
                                                    sizes</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="space-y-4">
                                        <div class="flex items-start space-x-3">
                                            <i class="fas fa-check-circle text-ltuc-secondary mt-1"></i>
                                            <div>
                                                <h4 class="font-semibold text-ltuc-dark">Demo Mode</h4>
                                                <p class="text-gray-600 text-sm">Public demo without authentication for
                                                    trial access</p>
                                            </div>
                                        </div>
                                        <div class="flex items-start space-x-3">
                                            <i class="fas fa-check-circle text-ltuc-secondary mt-1"></i>
                                            <div>
                                                <h4 class="font-semibold text-ltuc-dark">Rate Limiting</h4>
                                                <p class="text-gray-600 text-sm">Built-in API rate limiting for optimal
                                                    performance</p>
                                            </div>
                                        </div>
                                        <div class="flex items-start space-x-3">
                                            <i class="fas fa-check-circle text-ltuc-secondary mt-1"></i>
                                            <div>
                                                <h4 class="font-semibold text-ltuc-dark">Docker Support</h4>
                                                <p class="text-gray-600 text-sm">Containerized deployment for easy
                                                    scaling and management</p>
                                            </div>
                                        </div>
                                        <div class="flex items-start space-x-3">
                                            <i class="fas fa-check-circle text-ltuc-secondary mt-1"></i>
                                            <div>
                                                <h4 class="font-semibold text-ltuc-dark">Modern UI/UX</h4>
                                                <p class="text-gray-600 text-sm">Clean, intuitive interface with LTUC
                                                    branding</p>
                                            </div>
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
                                            <div
                                                class="flex items-center space-x-3 p-3 bg-red-50 rounded-lg border border-red-100">
                                                <i class="fab fa-laravel text-red-600"></i>
                                                <span class="font-medium">Laravel 11.31</span>
                                                <span class="text-sm text-gray-500">- PHP Framework</span>
                                            </div>
                                            <div
                                                class="flex items-center space-x-3 p-3 bg-blue-50 rounded-lg border border-blue-100">
                                                <i class="fab fa-php text-blue-600"></i>
                                                <span class="font-medium">PHP 8.3-CLI</span>
                                                <span class="text-sm text-gray-500">- Server Runtime</span>
                                            </div>
                                            <div
                                                class="flex items-center space-x-3 p-3 bg-green-50 rounded-lg border border-green-100">
                                                <i class="fas fa-database text-green-600"></i>
                                                <span class="font-medium">MySQL/SQLite</span>
                                                <span class="text-sm text-gray-500">- Database</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <h3 class="text-xl font-semibold text-ltuc-dark mb-4">Frontend</h3>
                                        <div class="space-y-3">
                                            <div
                                                class="flex items-center space-x-3 p-3 bg-cyan-50 rounded-lg border border-cyan-100">
                                                <i class="fab fa-css3 text-cyan-600"></i>
                                                <span class="font-medium">TailwindCSS 3.1</span>
                                                <span class="text-sm text-gray-500">- Styling</span>
                                            </div>
                                            <div
                                                class="flex items-center space-x-3 p-3 bg-green-50 rounded-lg border border-green-100">
                                                <i class="fab fa-js text-green-600"></i>
                                                <span class="font-medium">Alpine.js 3.4</span>
                                                <span class="text-sm text-gray-500">- Interactivity</span>
                                            </div>
                                            <div
                                                class="flex items-center space-x-3 p-3 bg-purple-50 rounded-lg border border-purple-100">
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
                                        <div
                                            class="flex items-center space-x-3 p-3 bg-gray-50 rounded-lg border border-gray-100">
                                            <i class="fas fa-robot text-gray-600"></i>
                                            <span class="font-medium">OpenAI PHP Client 0.15</span>
                                        </div>
                                        <div
                                            class="flex items-center space-x-3 p-3 bg-gray-50 rounded-lg border border-gray-100">
                                            <i class="fas fa-file-pdf text-gray-600"></i>
                                            <span class="font-medium">PHPOffice Suite</span>
                                        </div>
                                        <div
                                            class="flex items-center space-x-3 p-3 bg-gray-50 rounded-lg border border-gray-100">
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
                                        The application uses a multi-stage Docker build process optimized for production
                                        deployment.
                                        The Dockerfile creates a lightweight, secure container with all necessary
                                        dependencies.
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
                        targetSection.scrollIntoView({
                            behavior: 'smooth'
                        });
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
</x-app-layout>
