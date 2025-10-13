@extends('layouts.admin')

@section('title', 'Services Management')
@section('page-title', 'Services Management')

@section('content')
<div class="space-y-6">
    <!-- Filters and Search -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <form action="{{ route('admin.services.index') }}" method="GET" class="flex flex-wrap gap-4">
            <div class="flex-1 min-w-[200px]">
                <input type="text" name="search" placeholder="Search services..."
                       value="{{ request('search') }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
            </div>
            <div>
                <select name="status" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                    <option value="">All Status</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                    <option value="suspended" {{ request('status') === 'suspended' ? 'selected' : '' }}>Suspended</option>
                </select>
            </div>
            <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                Search
            </button>
            <a href="{{ route('admin.services.index') }}" class="px-6 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600">
                Clear
            </a>
        </form>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-sm text-gray-600 font-medium">Total Services</h3>
            <p class="text-2xl font-bold text-gray-900 mt-2">{{ $services->total() }}</p>
        </div>
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-sm text-gray-600 font-medium">Active</h3>
            <p class="text-2xl font-bold text-green-600 mt-2">
                {{ \App\Modules\Services\Models\Service::where('status', 'active')->count() }}
            </p>
        </div>
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-sm text-gray-600 font-medium">Inactive</h3>
            <p class="text-2xl font-bold text-yellow-600 mt-2">
                {{ \App\Modules\Services\Models\Service::where('status', 'inactive')->count() }}
            </p>
        </div>
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-sm text-gray-600 font-medium">Suspended</h3>
            <p class="text-2xl font-bold text-red-600 mt-2">
                {{ \App\Modules\Services\Models\Service::where('status', 'suspended')->count() }}
            </p>
        </div>
    </div>

    <!-- Services Table -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Freelancer</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Delivery</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($services as $service)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">#{{ $service->id }}</td>
                        <td class="px-6 py-4 text-sm">
                            <div class="font-medium text-gray-900">{{ Str::limit($service->title, 40) }}</div>
                            <div class="text-gray-500 text-xs">{{ Str::limit($service->description, 60) }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $service->user->name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            ${{ number_format($service->price, 2) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $service->delivery_time }} days
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-3 py-1 text-xs font-medium rounded-full
                                @if($service->status === 'active') bg-green-100 text-green-800
                                @elseif($service->status === 'inactive') bg-yellow-100 text-yellow-800
                                @else bg-red-100 text-red-800 @endif">
                                {{ ucfirst($service->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm space-x-2">
                            <a href="{{ route('admin.services.show', $service) }}"
                               class="text-indigo-600 hover:text-indigo-900">View</a>
                            <a href="{{ route('admin.services.edit', $service) }}"
                               class="text-blue-600 hover:text-blue-900">Edit</a>

                            @if($service->status !== 'active')
                                <form action="{{ route('admin.services.approve', $service) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="text-green-600 hover:text-green-900">Approve</button>
                                </form>
                            @endif

                            @if($service->status !== 'suspended')
                                <form action="{{ route('admin.services.suspend', $service) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="text-red-600 hover:text-red-900"
                                            onclick="return confirm('Are you sure you want to suspend this service?')">
                                        Suspend
                                    </button>
                                </form>
                            @endif

                            <form action="{{ route('admin.services.destroy', $service) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900"
                                        onclick="return confirm('Are you sure you want to delete this service?')">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                            No services found
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Pagination -->
        @if($services->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $services->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
