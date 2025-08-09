<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>LTUC AI Assistant - Intelligent Learning Companion</title>

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

        .ltuc-primary {
            background-color: #D60095;
        }

        .ltuc-secondary {
            background-color: #2E8570;
        }

        .ltuc-accent {
            background-color: #A84A9D;
        }

        .ltuc-dark {
            background-color: #333333;
        }

        .ltuc-light {
            background-color: #999999;
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

        .border-ltuc-primary {
            border-color: #D60095;
        }

        .border-ltuc-secondary {
            border-color: #2E8570;
        }

        .hover\:ltuc-primary:hover {
            background-color: #D60095;
        }

        .hover\:ltuc-secondary:hover {
            background-color: #2E8570;
        }

        .hover\:ltuc-accent:hover {
            background-color: #A84A9D;
        }

        .animate-float {
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-20px);
            }
        }

        .feature-card {
            transition: all 0.3s ease;
        }

        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        /* Mobile Navigation Styles */
        .mobile-menu {
            transition: all 0.3s ease;
        }

        .mobile-menu.hidden {
            opacity: 0;
            transform: translateY(-10px);
        }

        .mobile-menu:not(.hidden) {
            opacity: 1;
            transform: translateY(0);
        }

        @media (max-width: 768px) {
            .nav-links {
                flex-direction: column;
                gap: 1rem;
                width: 100%;
                padding: 1rem 0;
            }

            .nav-links a {
                text-align: center;
                padding: 0.75rem 1rem;
                border-radius: 0.5rem;
                width: 100%;
                min-height: 44px; /* Better touch target */
                display: flex;
                align-items: center;
                justify-content: center;
            }

            /* Ensure mobile menu button is large enough */
            #mobile-menu-button {
                min-height: 44px;
                min-width: 44px;
                display: flex;
                align-items: center;
                justify-content: center;
            }
        }
    </style>
</head>

<body class="bg-white text-gray-900 antialiased overflow-x-hidden">
    <!-- Background Animation -->
    <div class="fixed inset-0 bg-gray-50"></div>

    <!-- Floating Elements -->
    <div class="fixed top-20 left-10 w-20 h-20 ltuc-primary rounded-full opacity-10 animate-float"></div>
    <div class="fixed top-40 right-20 w-16 h-16 ltuc-secondary rounded-full opacity-10 animate-float"
        style="animation-delay: 2s;"></div>
    <div class="fixed bottom-20 left-1/4 w-12 h-12 ltuc-accent rounded-full opacity-10 animate-float"
        style="animation-delay: 4s;"></div>

    <div class="relative z-10 min-h-screen flex flex-col">
        <!-- Navigation -->
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

                    <!-- Mobile menu button -->
                    <div class="md:hidden">
                        <button id="mobile-menu-button" class="text-white hover:text-gray-300 focus:outline-none focus:text-gray-300 transition duration-300">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </button>
                    </div>

                    <!-- Navigation Links - Desktop -->
                    @if (Route::has('login'))
                        <div class="hidden md:flex items-center space-x-4">
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

                <!-- Mobile Navigation Menu -->
                @if (Route::has('login'))
                    <div id="mobile-menu" class="md:hidden hidden mobile-menu bg-black border-t border-gray-700">
                        <div class="nav-links flex flex-col space-y-2 px-4 py-4">
                            <a href="{{ route('documentation') }}"
                                class="text-white hover:text-gray-300 hover:bg-gray-800 transition duration-300 font-medium">
                                Documentation
                            </a>
                            @auth
                                <a href="{{ url('/dashboard') }}"
                                    class="text-white hover:text-gray-300 hover:bg-gray-800 transition duration-300 font-medium">
                                    Dashboard
                                </a>
                            @else
                                <a href="{{ route('login') }}"
                                    class="text-white hover:text-gray-300 hover:bg-gray-800 transition duration-300 font-medium">
                                    Log in
                                </a>

                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}"
                                        class="ltuc-primary text-white font-semibold hover:opacity-90 transition duration-300">
                                        Get Started
                                    </a>
                                @endif
                            @endauth
                        </div>
                    </div>
                @endif
            </div>
        </nav>

        <!-- Hero Section -->
        <section class="flex-1 flex items-center justify-center px-4 py-20">
            <div class="max-w-6xl mx-auto text-center">
                <!-- Main Heading -->
                <div class="mb-8">
                    <h1 class="text-5xl md:text-7xl font-bold mb-6 leading-tight">
                        <span class="block text-ltuc-dark">Meet Your</span>
                        <span class="block text-ltuc-primary">
                            AI Learning Companion
                        </span>
                    </h1>
                    <p class="text-xl md:text-2xl text-ltuc-light max-w-3xl mx-auto leading-relaxed">
                        Experience the future of education with LTUC's intelligent AI assistant.
                        Get instant answers, personalized learning paths, and 24/7 academic support.
                    </p>
                </div>

                <!-- CTA Buttons -->
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4 mb-12">
                    @auth
                        <a href="/ltuc/chatbot"
                            class="group px-8 py-4 ltuc-primary text-white rounded-xl font-semibold text-lg hover:opacity-90 transform hover:scale-105 transition duration-300 flex items-center space-x-3">
                            <span>Start Chatting</span>
                            <i class="fas fa-arrow-right group-hover:translate-x-1 transition duration-300"></i>
                        </a>
                        <a href="{{ url('/dashboard') }}"
                            class="px-8 py-4 bg-white text-ltuc-primary border-2 border-ltuc-primary rounded-xl font-semibold text-lg hover:ltuc-primary hover:text-white transition duration-300">
                            Go to Dashboard
                        </a>
                        <a href="/ltuc/chatbot"
                            class="group px-8 py-4 ltuc-secondary text-white rounded-xl font-semibold text-lg hover:opacity-90 transform hover:scale-105 transition duration-300 flex items-center space-x-3">
                            <span>Try Demo Again</span>
                            <i class="fas fa-redo group-hover:rotate-180 transition duration-300"></i>
                        </a>
                    @else
                        <a href="{{ route('register') }}"
                            class="group px-8 py-4 ltuc-primary text-white rounded-xl font-semibold text-lg hover:opacity-90 transform hover:scale-105 transition duration-300 flex items-center space-x-3">
                            <span>Create Account</span>
                            <i class="fas fa-user-plus"></i>
                        </a>
                        <a href="/ltuc/chatbot-demo"
                            class="group px-8 py-4 ltuc-secondary text-white rounded-xl font-semibold text-lg hover:opacity-90 transform hover:scale-105 transition duration-300 flex items-center space-x-3">
                            <span>Try Demo Again</span>
                            <i class="fas fa-redo group-hover:rotate-180 transition duration-300"></i>
                        </a>
                    @endauth

                    <!-- Documentation Button - Always Visible -->
                    <a href="{{ route('documentation') }}"
                        class="group px-8 py-4 bg-white text-ltuc-dark border-2 border-gray-300 rounded-xl font-semibold text-lg hover:bg-gray-50 transform hover:scale-105 transition duration-300 flex items-center space-x-3">
                        <span>Documentation</span>
                        <i class="fas fa-book group-hover:rotate-12 transition duration-300"></i>
                    </a>
                </div>

                <!-- Feature Preview -->
                <div class="max-w-4xl mx-auto">
                    <div class="bg-white rounded-2xl p-8 border border-gray-200 shadow-lg">
                        <div class="grid md:grid-cols-3 gap-8">
                            <!-- Quick Chat Preview -->
                            <div class="feature-card bg-gray-50 rounded-xl p-6 text-center border border-gray-100">
                                <div
                                    class="w-12 h-12 ltuc-primary rounded-lg mx-auto mb-4 flex items-center justify-center">
                                    <i class="fas fa-comments text-white"></i>
                                </div>
                                <h3 class="text-lg font-semibold mb-2 text-ltuc-dark">Instant Answers</h3>
                                <p class="text-ltuc-light text-sm">Get immediate responses to your academic questions
                                </p>
                            </div>

                            <!-- Smart Learning -->
                            <div class="feature-card bg-gray-50 rounded-xl p-6 text-center border border-gray-100">
                                <div
                                    class="w-12 h-12 ltuc-secondary rounded-lg mx-auto mb-4 flex items-center justify-center">
                                    <i class="fas fa-brain text-white"></i>
                                </div>
                                <h3 class="text-lg font-semibold mb-2 text-ltuc-dark">Smart Learning</h3>
                                <p class="text-ltuc-light text-sm">Personalized study recommendations and paths</p>
                            </div>

                            <!-- 24/7 Support -->
                            <div class="feature-card bg-gray-50 rounded-xl p-6 text-center border border-gray-100">
                                <div
                                    class="w-12 h-12 ltuc-accent rounded-lg mx-auto mb-4 flex items-center justify-center">
                                    <i class="fas fa-clock text-white"></i>
                                </div>
                                <h3 class="text-lg font-semibold mb-2 text-ltuc-dark">24/7 Available</h3>
                                <p class="text-ltuc-light text-sm">Always here when you need academic support</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section class="py-20 px-4 bg-gray-50">
            <div class="max-w-6xl mx-auto">
                <div class="text-center mb-16">
                    <h2 class="text-4xl md:text-5xl font-bold mb-6">
                        <span class="text-ltuc-dark">Powerful Features for</span>
                        <br>
                        <span class="text-ltuc-primary">
                            Better Learning
                        </span>
                    </h2>
                    <p class="text-xl text-ltuc-light max-w-2xl mx-auto">
                        Discover how our AI assistant can transform your educational experience
                    </p>
                </div>

                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <!-- Feature 1 -->
                    <div class="feature-card bg-white rounded-2xl p-8 border border-gray-100">
                        <div class="w-16 h-16 ltuc-primary rounded-xl mb-6 flex items-center justify-center">
                            <i class="fas fa-book-open text-white text-2xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold mb-4 text-ltuc-dark">Homework Help</h3>
                        <p class="text-ltuc-light leading-relaxed">
                            Get step-by-step guidance, hints, and explanations for assignments across subjects.
                        </p>
                    </div>

                    <!-- Feature 2 -->
                    <div class="feature-card bg-white rounded-2xl p-8 border border-gray-100">
                        <div class="w-16 h-16 ltuc-secondary rounded-xl mb-6 flex items-center justify-center">
                            <i class="fas fa-route text-white text-2xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold mb-4 text-ltuc-dark">Study Roadmaps</h3>
                        <p class="text-ltuc-light leading-relaxed">
                            Personalized learning paths with milestones and resources to reach your goals faster.
                        </p>
                    </div>

                    <!-- Feature 3 -->
                    <div class="feature-card bg-white rounded-2xl p-8 border border-gray-100">
                        <div class="w-16 h-16 ltuc-accent rounded-xl mb-6 flex items-center justify-center">
                            <i class="fas fa-file-image text-white text-2xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold mb-4 text-ltuc-dark">Files & Images Understanding</h3>
                        <p class="text-ltuc-light leading-relaxed">
                            Upload notes, PDFs, or screenshots—get summaries, answers, and insights instantly.
                        </p>
                    </div>

                    <!-- Feature 4 -->
                    <div class="feature-card bg-white rounded-2xl p-8 border border-gray-100">
                        <div class="w-16 h-16 ltuc-primary rounded-xl mb-6 flex items-center justify-center">
                            <i class="fas fa-bug text-white text-2xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold mb-4 text-ltuc-dark">Find & Fix Errors</h3>
                        <p class="text-ltuc-light leading-relaxed">
                            Spot mistakes in your work and get clear suggestions to correct them.
                        </p>
                    </div>

                    <!-- Feature 5 -->
                    <div class="feature-card bg-white rounded-2xl p-8 border border-gray-100">
                        <div class="w-16 h-16 ltuc-secondary rounded-xl mb-6 flex items-center justify-center">
                            <i class="fas fa-lightbulb text-white text-2xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold mb-4 text-ltuc-dark">Explain Any Concept</h3>
                        <p class="text-ltuc-light leading-relaxed">
                            Easy-to-understand explanations with examples, comparisons, and bite-sized summaries.
                        </p>
                    </div>

                    <!-- Feature 6 -->
                    <div class="feature-card bg-white rounded-2xl p-8 border border-gray-100">
                        <div class="w-16 h-16 ltuc-accent rounded-xl mb-6 flex items-center justify-center">
                            <i class="fas fa-chalkboard-teacher text-white text-2xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold mb-4 text-ltuc-dark">Practice & Learning Tools</h3>
                        <p class="text-ltuc-light leading-relaxed">
                            Generate quizzes, flashcards, and study plans to master topics effectively.
                        </p>
                    </div>
                </div>
            </div>
        </section>



        <!-- Footer -->
        <footer class="bg-black py-12">
            <div class="max-w-6xl mx-auto px-4">
                <div class="grid md:grid-cols-4 gap-8">
                    <!-- Logo and Description -->
                    <div class="md:col-span-2">
                        <div class="flex items-center space-x-3 mb-4">
                            <div class="w-10 h-10 ltuc-primary rounded-lg flex items-center justify-center">
                                <i class="fas fa-graduation-cap text-white text-lg"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-white">LTUC AI Assistant</h3>
                                <p class="text-xs text-gray-400">Intelligent Learning Companion</p>
                            </div>
                        </div>
                        <p class="text-gray-400 max-w-md">
                            Empowering students with cutting-edge AI technology to enhance learning experiences and
                            academic success.
                        </p>
                    </div>

                    <!-- Quick Links -->
                    <div>
                        <h4 class="text-white font-semibold mb-4">Quick Links</h4>
                        <ul class="space-y-2 text-gray-400">
                            <li><a href="/ltuc/chatbot" class="hover:text-white transition duration-300">AI
                                    Assistant</a></li>
                            @auth
                                <li><a href="{{ url('/dashboard') }}"
                                        class="hover:text-white transition duration-300">Dashboard</a></li>
                            @else
                                <li><a href="{{ route('login') }}"
                                        class="hover:text-white transition duration-300">Login</a></li>
                                <li><a href="{{ route('register') }}"
                                        class="hover:text-white transition duration-300">Register</a></li>
                            @endauth
                        </ul>
                    </div>

                    <!-- Contact -->
                    <div>
                        <h4 class="text-white font-semibold mb-4">Support</h4>
                        <ul class="space-y-2 text-gray-400">
                            <li>
                                <i class="fas fa-envelope mr-2"></i>
                                <span>support@ltuc.edu</span>
                            </li>
                            <li>
                                <i class="fas fa-phone mr-2"></i>
                                <span>+1 (555) 123-4567</span>
                            </li>
                            <li>
                                <i class="fas fa-clock mr-2"></i>
                                <span>24/7 AI Support</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="border-t border-white border-opacity-10 mt-8 pt-8 text-center text-gray-400">
                    <p>&copy; {{ date('Y') }} LTUC AI Assistant. All rights reserved. | Powered by Laravel
                        v{{ Illuminate\Foundation\Application::VERSION }}</p>
                </div>
            </div>
        </footer>
    </div>

    <script>
        // Mobile menu toggle functionality
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');

            if (mobileMenuButton && mobileMenu) {
                mobileMenuButton.addEventListener('click', function() {
                    mobileMenu.classList.toggle('hidden');
                });

                // Close mobile menu when clicking outside
                document.addEventListener('click', function(event) {
                    if (!mobileMenuButton.contains(event.target) && !mobileMenu.contains(event.target)) {
                        mobileMenu.classList.add('hidden');
                    }
                });

                // Close mobile menu when window is resized to desktop size
                window.addEventListener('resize', function() {
                    if (window.innerWidth >= 768) {
                        mobileMenu.classList.add('hidden');
                    }
                });
            }
        });
    </script>
</body>

</html>
