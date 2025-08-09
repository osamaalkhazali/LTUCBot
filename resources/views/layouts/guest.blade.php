<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'LTUC') }} - AI Learning Platform</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('assets/images/fav.png') }}">

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
    </style>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-gray-900 antialiased bg-gray-50 relative overflow-hidden">
    <!-- Background -->
    <div class="fixed inset-0 ltuc-secondary opacity-10"></div>

    <!-- Floating Elements -->
    <div class="fixed top-20 left-10 w-20 h-20 ltuc-primary rounded-full opacity-20 animate-float"></div>
    <div class="fixed top-40 right-20 w-16 h-16 ltuc-accent rounded-full opacity-20 animate-float"
        style="animation-delay: 2s;"></div>
    <div class="fixed bottom-20 left-1/4 w-12 h-12 ltuc-secondary rounded-full opacity-20 animate-float"
        style="animation-delay: 4s;"></div>

    <div class="relative z-10 min-h-screen flex flex-col justify-center items-center py-8 px-4">
        <!-- Logo -->
        <div class="mb-6">
            <a href="/" class="flex items-center justify-center">
                <img src="{{ asset('assets/images/LTUCBot.png') }}" alt="LTUC" class="h-16 w-auto" />
            </a>
        </div>

        <!-- Auth Card -->
        <div class="w-full sm:max-w-md max-w-sm">
            <div class="bg-white shadow-2xl overflow-hidden sm:rounded-2xl p-6 sm:p-8 border border-gray-200">
                {{ $slot }}
            </div>

            <!-- Back to Home -->
            <div class="mt-4 text-center">
                <a href="/"
                    class="text-ltuc-light text-sm hover:text-ltuc-dark transition duration-300 flex items-center justify-center">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Back to Home
                </a>
            </div>
        </div>
    </div>
</body>

</html>
