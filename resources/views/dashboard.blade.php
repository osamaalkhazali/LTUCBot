<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-2xl text-ltuc-dark leading-tight flex items-center">
                    <i class="fas fa-tachometer-alt mr-3 text-ltuc-primary"></i>
                    Welcome back, {{ Auth::user()->name }}!
                </h2>
                <p class="text-ltuc-light mt-1">Here's what's happening with your learning journey today.</p>
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

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Quick Stats -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <!-- Total Study Hours (Dummy Data) -->
                <div
                    class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition duration-300 relative">
                    <div class="absolute top-2 right-2">
                        <span class="px-2 py-1 text-xs font-medium bg-gray-100 text-gray-500 rounded-full">Demo</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-12 h-12 ltuc-primary rounded-xl flex items-center justify-center opacity-60">
                            <i class="fas fa-clock text-white"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-ltuc-light">Study Hours <span class="text-xs text-gray-400">(Sample)</span></p>
                            <p class="text-2xl font-bold text-gray-400">24.5</p>
                        </div>
                    </div>
                </div>

                <!-- Completed Assignments (Dummy Data) -->
                <div
                    class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition duration-300 relative">
                    <div class="absolute top-2 right-2">
                        <span class="px-2 py-1 text-xs font-medium bg-gray-100 text-gray-500 rounded-full">Demo</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-12 h-12 ltuc-secondary rounded-xl flex items-center justify-center opacity-60">
                            <i class="fas fa-check-circle text-white"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-ltuc-light">Completed <span class="text-xs text-gray-400">(Sample)</span></p>
                            <p class="text-2xl font-bold text-gray-400">8/12</p>
                        </div>
                    </div>
                </div>

                <!-- AI Conversations (Real Data) -->
                <div
                    class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition duration-300">
                    <div class="flex items-center">
                        <div class="w-12 h-12 ltuc-secondary rounded-xl flex items-center justify-center">
                            <i class="fas fa-robot text-white"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-ltuc-light">AI Chats</p>
                            <p class="text-2xl font-bold text-ltuc-dark">{{ Auth::user()->chats()->count() }}</p>
                        </div>
                    </div>
                </div>

                <!-- Average Grade (Dummy Data) -->
                <div
                    class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition duration-300 relative">
                    <div class="absolute top-2 right-2">
                        <span class="px-2 py-1 text-xs font-medium bg-gray-100 text-gray-500 rounded-full">Demo</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-12 h-12 ltuc-accent rounded-xl flex items-center justify-center opacity-60">
                            <i class="fas fa-star text-white"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-ltuc-light">Average Grade <span class="text-xs text-gray-400">(Sample)</span></p>
                            <p class="text-2xl font-bold text-gray-400">92%</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column - Quick Actions & Recent Activity -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Quick Actions -->
                <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6 flex items-center">
                        <i class="fas fa-bolt mr-2 text-yellow-500"></i>
                        Quick Actions
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <a href="/ltuc/chatbot"
                            class="group p-4 rounded-xl border-2 border-dashed border-gray-200 hover:border-ltuc-primary hover:bg-white transition duration-300">
                            <div class="text-center">
                                <div
                                    class="w-12 h-12 mx-auto mb-3 ltuc-primary rounded-xl flex items-center justify-center group-hover:scale-110 transition duration-300">
                                    <i class="fas fa-robot text-white"></i>
                                </div>
                                <h4 class="font-medium text-gray-900">Ask AI Assistant</h4>
                                <p class="text-sm text-gray-500 mt-1">Get instant help with your studies</p>
                                <span class="inline-flex items-center px-2 py-1 mt-2 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <i class="fas fa-check mr-1"></i>Active
                                </span>
                            </div>
                        </a>

                        <div class="group p-4 rounded-xl border-2 border-dashed border-gray-200 bg-gray-50 cursor-not-allowed opacity-75 relative">
                            <div class="absolute top-2 right-2">
                                <span class="px-2 py-1 text-xs font-medium bg-gray-200 text-gray-600 rounded-full">Demo</span>
                            </div>
                            <div class="text-center">
                                <div class="w-12 h-12 mx-auto mb-3 bg-gray-300 rounded-xl flex items-center justify-center">
                                    <i class="fas fa-book text-gray-500"></i>
                                </div>
                                <h4 class="font-medium text-gray-500">View Courses</h4>
                                <p class="text-sm text-gray-400 mt-1">Access your enrolled courses</p>
                                <span class="inline-flex items-center px-2 py-1 mt-2 rounded-full text-xs font-medium bg-gray-200 text-gray-600">
                                    <i class="fas fa-eye-slash mr-1"></i>Not Available
                                </span>
                            </div>
                        </div>

                        <div class="group p-4 rounded-xl border-2 border-dashed border-gray-200 bg-gray-50 cursor-not-allowed opacity-75 relative">
                            <div class="absolute top-2 right-2">
                                <span class="px-2 py-1 text-xs font-medium bg-gray-200 text-gray-600 rounded-full">Demo</span>
                            </div>
                            <div class="text-center">
                                <div class="w-12 h-12 mx-auto mb-3 bg-gray-300 rounded-xl flex items-center justify-center">
                                    <i class="fas fa-chart-line text-gray-500"></i>
                                </div>
                                <h4 class="font-medium text-gray-500">Progress Report</h4>
                                <p class="text-sm text-gray-400 mt-1">Track your learning progress</p>
                                <span class="inline-flex items-center px-2 py-1 mt-2 rounded-full text-xs font-medium bg-gray-200 text-gray-600">
                                    <i class="fas fa-eye-slash mr-1"></i>Not Available
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 relative">
                    <div class="absolute top-4 right-4">
                        <span class="px-2 py-1 text-xs font-medium bg-orange-100 text-orange-600 rounded-full">Sample Data</span>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-6 flex items-center">
                        <i class="fas fa-history mr-2 text-blue-500"></i>
                        Recent Activity
                        <span class="text-sm text-gray-400 ml-2">(Demo)</span>
                    </h3>
                    <div class="space-y-4 opacity-75">
                        <div class="flex items-center p-3 bg-green-50 rounded-lg border border-green-100">
                            <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-check text-green-600 text-sm"></i>
                            </div>
                            <div class="ml-3 flex-1">
                                <p class="text-sm font-medium text-gray-700">Completed Mathematics Assignment #3</p>
                                <p class="text-xs text-gray-500">2 hours ago <span class="text-orange-500">(Sample)</span></p>
                            </div>
                        </div>

                        <div class="flex items-center p-3 bg-blue-50 rounded-lg border border-blue-100">
                            <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-robot text-blue-600 text-sm"></i>
                            </div>
                            <div class="ml-3 flex-1">
                                <p class="text-sm font-medium text-gray-700">Asked AI about calculus derivatives</p>
                                <p class="text-xs text-gray-500">5 hours ago <span class="text-orange-500">(Sample)</span></p>
                            </div>
                        </div>

                        <div class="flex items-center p-3 bg-purple-50 rounded-lg border border-purple-100">
                            <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-book text-purple-600 text-sm"></i>
                            </div>
                            <div class="ml-3 flex-1">
                                <p class="text-sm font-medium text-gray-700">Started Physics Chapter 7</p>
                                <p class="text-xs text-gray-500">1 day ago <span class="text-orange-500">(Sample)</span></p>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 text-center">
                        <p class="text-xs text-gray-400 italic">
                            <i class="fas fa-info-circle mr-1"></i>
                            This section shows example activity data for demonstration purposes
                        </p>
                    </div>
                </div>
            </div>

            <!-- Right Column - Announcements & Upcoming -->
            <div class="space-y-8">
                <!-- Announcements -->
                <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 relative">
                    <div class="absolute top-4 right-4">
                        <span class="px-2 py-1 text-xs font-medium bg-blue-100 text-blue-600 rounded-full">Sample</span>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-6 flex items-center">
                        <i class="fas fa-bullhorn mr-2 text-red-500"></i>
                        Announcements
                        <span class="text-sm text-gray-400 ml-2">(Demo)</span>
                    </h3>
                    <div class="space-y-4 opacity-75">
                        <div class="p-4 bg-white rounded-lg border border-ltuc-primary border-dashed">
                            <h4 class="font-medium text-gray-700 text-sm">New AI Features Available!</h4>
                            <p class="text-xs text-gray-600 mt-1">Enhanced document analysis and better conversation
                                memory</p>
                            <div class="mt-2 flex items-center justify-between">
                                <span
                                    class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-[#FDE7F3] text-[#D60095]">
                                    New
                                </span>
                                <span class="text-xs text-orange-500 italic">Example</span>
                            </div>
                        </div>

                        <div class="p-4 bg-blue-50 rounded-lg border border-blue-100 border-dashed">
                            <h4 class="font-medium text-gray-700 text-sm">Midterm Schedule Released</h4>
                            <p class="text-xs text-gray-600 mt-1">Check your course pages for specific dates and
                                times</p>
                            <div class="mt-2 text-right">
                                <span class="text-xs text-orange-500 italic">Example</span>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 text-center">
                        <p class="text-xs text-gray-400 italic">
                            <i class="fas fa-info-circle mr-1"></i>
                            Sample announcements for demo purposes
                        </p>
                    </div>
                </div>

                <!-- Upcoming Events -->
                <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 relative">
                    <div class="absolute top-4 right-4">
                        <span class="px-2 py-1 text-xs font-medium bg-purple-100 text-purple-600 rounded-full">Sample</span>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-6 flex items-center">
                        <i class="fas fa-calendar mr-2 text-orange-500"></i>
                        Upcoming Events
                        <span class="text-sm text-gray-400 ml-2">(Demo)</span>
                    </h3>
                    <div class="space-y-4 opacity-75">
                        <div class="flex items-center p-3 bg-orange-50 rounded-lg border border-orange-100 border-dashed">
                            <div class="w-8 h-8 bg-orange-100 rounded-lg flex items-center justify-center">
                                <span class="text-xs font-bold text-orange-600">15</span>
                            </div>
                            <div class="ml-3 flex-1">
                                <p class="text-sm font-medium text-gray-700">Physics Lab Due</p>
                                <p class="text-xs text-gray-500">Tomorrow at 11:59 PM <span class="text-orange-500">(Sample)</span></p>
                            </div>
                        </div>

                        <div class="flex items-center p-3 bg-red-50 rounded-lg border border-red-100 border-dashed">
                            <div class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center">
                                <span class="text-xs font-bold text-red-600">18</span>
                            </div>
                            <div class="ml-3 flex-1">
                                <p class="text-sm font-medium text-gray-700">Math Midterm Exam</p>
                                <p class="text-xs text-gray-500">Friday at 2:00 PM <span class="text-orange-500">(Sample)</span></p>
                            </div>
                        </div>

                        <div class="flex items-center p-3 bg-green-50 rounded-lg border border-green-100 border-dashed">
                            <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                                <span class="text-xs font-bold text-green-600">22</span>
                            </div>
                            <div class="ml-3 flex-1">
                                <p class="text-sm font-medium text-gray-700">Study Group Meeting</p>
                                <p class="text-xs text-gray-500">Next Tuesday at 4:00 PM <span class="text-orange-500">(Sample)</span></p>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 text-center">
                        <p class="text-xs text-gray-400 italic">
                            <i class="fas fa-info-circle mr-1"></i>
                            Sample calendar events for demo purposes
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</x-app-layout>
