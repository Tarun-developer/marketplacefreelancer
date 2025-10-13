<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - MarketFusion</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <div class="w-64 bg-gray-800 text-white">
            <div class="p-4">
                <h2 class="text-xl font-bold">Admin Panel</h2>
            </div>
            <nav class="mt-4">
                <a href="#" class="block py-2 px-4 hover:bg-gray-700">Dashboard</a>
                <a href="#" class="block py-2 px-4 hover:bg-gray-700">Users</a>
                <a href="#" class="block py-2 px-4 hover:bg-gray-700">Products</a>
                <a href="#" class="block py-2 px-4 hover:bg-gray-700">Orders</a>
                <a href="#" class="block py-2 px-4 hover:bg-gray-700">Reports</a>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1">
            <header class="bg-white shadow p-4">
                <h1 class="text-2xl font-bold">Admin Dashboard</h1>
            </header>
            <main class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                    <div class="bg-white p-6 rounded-lg shadow">
                        <h3 class="text-lg font-semibold">Total Users</h3>
                        <p class="text-2xl font-bold text-indigo-600">1,234</p>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow">
                        <h3 class="text-lg font-semibold">Total Sales</h3>
                        <p class="text-2xl font-bold text-green-600">$56,789</p>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow">
                        <h3 class="text-lg font-semibold">Active Orders</h3>
                        <p class="text-2xl font-bold text-blue-600">89</p>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow">
                        <h3 class="text-lg font-semibold">Pending Disputes</h3>
                        <p class="text-2xl font-bold text-red-600">12</p>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-lg shadow">
                    <h2 class="text-xl font-bold mb-4">Recent Activity</h2>
                    <p>Welcome to the admin dashboard. Here you can manage users, products, orders, and more.</p>
                </div>
            </main>
        </div>
    </div>
</body>
</html>