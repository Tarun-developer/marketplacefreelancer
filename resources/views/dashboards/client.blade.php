<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Dashboard - MarketFusion</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
    @include('partials.header')

    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <div class="w-64 bg-gray-800 text-white">
            <div class="p-4">
                <h2 class="text-xl font-bold">Client Panel</h2>
            </div>
            <nav class="mt-4">
                <a href="{{ route('dashboard') }}" class="block py-2 px-4 bg-gray-700">Dashboard</a>
                <a href="#" class="block py-2 px-4 hover:bg-gray-700">My Orders</a>
                <a href="#" class="block py-2 px-4 hover:bg-gray-700">Post a Job</a>
                <a href="#" class="block py-2 px-4 hover:bg-gray-700">Favorites</a>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 p-6">
            <h1 class="text-2xl font-bold mb-6">Client Dashboard</h1>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-lg font-semibold">Active Orders</h3>
                    <p class="text-2xl font-bold text-indigo-600">2</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-lg font-semibold">Completed Projects</h3>
                    <p class="text-2xl font-bold text-green-600">8</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-lg font-semibold">Total Spent</h3>
                    <p class="text-2xl font-bold text-blue-600">$1,200</p>
                </div>
            </div>
            <div class="bg-white p-6 rounded-lg shadow">
                <h2 class="text-xl font-bold mb-4">Recent Orders</h2>
                <p>Welcome to your client dashboard. Track your orders and post new jobs here.</p>
            </div>
        </div>
    </div>
</body>
</html>