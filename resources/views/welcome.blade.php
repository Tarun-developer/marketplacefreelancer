<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MarketFusion - Freelance & Digital Marketplace</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 font-sans">
    @include('partials.header')

    <!-- Hero Section -->
    <section class="relative bg-gradient-to-br from-indigo-600 via-purple-600 to-pink-500 text-white py-24 overflow-hidden">
        <div class="absolute inset-0 bg-black opacity-10"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center">
                <h1 class="text-5xl md:text-7xl font-extrabold mb-6 leading-tight">
                    One Platform, <span class="text-yellow-300">Endless Opportunities</span>
                </h1>
                <p class="text-xl md:text-2xl mb-10 text-gray-100 max-w-3xl mx-auto">
                    Connect with talented freelancers, hire for jobs, and discover premium digital products all in one marketplace
                </p>
                <div class="flex flex-col sm:flex-row justify-center gap-4 mb-12">
                    @auth
                        <a href="{{ route('dashboard') }}" class="bg-white text-indigo-600 px-8 py-4 rounded-lg font-bold text-lg hover:bg-gray-100 transition shadow-lg">
                            Go to Dashboard
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="bg-white text-indigo-600 px-8 py-4 rounded-lg font-bold text-lg hover:bg-gray-100 transition shadow-lg">
                            Get Started Free
                        </a>
                        <a href="{{ route('login') }}" class="bg-transparent border-2 border-white px-8 py-4 rounded-lg font-bold text-lg hover:bg-white hover:text-indigo-600 transition">
                            Sign In
                        </a>
                    @endauth
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center mt-16">
                    <div>
                        <div class="text-4xl font-bold mb-2">{{ \App\Models\User::count() }}+</div>
                        <div class="text-gray-200">Active Users</div>
                    </div>
                    <div>
                        <div class="text-4xl font-bold mb-2">{{ \App\Modules\Services\Models\Service::where('status', 'active')->count() }}+</div>
                        <div class="text-gray-200">Active Services</div>
                    </div>
                    <div>
                        <div class="text-4xl font-bold mb-2">{{ \App\Modules\Products\Models\Product::where('is_approved', true)->count() }}+</div>
                        <div class="text-gray-200">Digital Products</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-center mb-12">Why Choose MarketFusion?</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center p-6 bg-gray-50 rounded-lg">
                    <div class="text-4xl text-indigo-600 mb-4">🚀</div>
                    <h3 class="text-xl font-semibold mb-2">Fast & Secure</h3>
                    <p>Lightning-fast transactions with top-notch security</p>
                </div>
                <div class="text-center p-6 bg-gray-50 rounded-lg">
                    <div class="text-4xl text-indigo-600 mb-4">💼</div>
                    <h3 class="text-xl font-semibold mb-2">Diverse Services</h3>
                    <p>From freelancing gigs to digital products</p>
                </div>
                <div class="text-center p-6 bg-gray-50 rounded-lg">
                    <div class="text-4xl text-indigo-600 mb-4">🌍</div>
                    <h3 class="text-xl font-semibold mb-2">Global Reach</h3>
                    <p>Connect with clients and sellers worldwide</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Categories Section -->
    <section class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-center mb-12">Popular Categories</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow">
                    <div class="text-3xl mb-3">💻</div>
                    <h3 class="font-semibold">Web Development</h3>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow">
                    <div class="text-3xl mb-3">🎨</div>
                    <h3 class="font-semibold">Design</h3>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow">
                    <div class="text-3xl mb-3">📱</div>
                    <h3 class="font-semibold">Mobile Apps</h3>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow">
                    <div class="text-3xl mb-3">📊</div>
                    <h3 class="font-semibold">Marketing</h3>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-indigo-600 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-bold mb-6">Ready to Get Started?</h2>
            <p class="text-xl mb-8">Join thousands of freelancers and businesses already using MarketFusion</p>
            <a href="#" class="bg-white text-indigo-600 px-8 py-3 rounded-md font-semibold hover:bg-gray-100">Join Now</a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-xl font-bold mb-4">MarketFusion</h3>
                    <p>Your one-stop marketplace for freelance services and digital products.</p>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Services</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="hover:text-indigo-400">Find Freelancers</a></li>
                        <li><a href="#" class="hover:text-indigo-400">Post a Job</a></li>
                        <li><a href="#" class="hover:text-indigo-400">Digital Products</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Support</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="hover:text-indigo-400">Help Center</a></li>
                        <li><a href="#" class="hover:text-indigo-400">Contact Us</a></li>
                        <li><a href="#" class="hover:text-indigo-400">Terms of Service</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Connect</h4>
                    <div class="flex space-x-4">
                        <a href="#" class="text-2xl hover:text-indigo-400">📘</a>
                        <a href="#" class="text-2xl hover:text-indigo-400">🐦</a>
                        <a href="#" class="text-2xl hover:text-indigo-400">💼</a>
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-700 mt-8 pt-8 text-center">
                <p>&copy; 2025 MarketFusion. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>