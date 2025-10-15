@extends('layouts.freelancer')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-800">My Profile</h2>
                <a href="{{ route('profile.edit') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">
                    Edit Profile
                </a>
            </div>

            <!-- User Avatar and Basic Info -->
            <div class="flex items-center space-x-6 mb-8">
                <div class="flex-shrink-0">
                    @if(auth()->user()->getFirstMediaUrl('avatar'))
                        <img src="{{ auth()->user()->getFirstMediaUrl('avatar', 'thumb') }}"
                             alt="{{ auth()->user()->name }}"
                             class="w-24 h-24 rounded-full object-cover border-4 border-blue-500">
                    @else
                        <div class="w-24 h-24 rounded-full bg-blue-500 flex items-center justify-center text-white text-3xl font-bold border-4 border-blue-600">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                    @endif
                </div>
                <div class="flex-1">
                    <h3 class="text-2xl font-bold text-gray-900">{{ auth()->user()->name }}</h3>
                    <p class="text-gray-600">{{ auth()->user()->email }}</p>
                    @if(auth()->user()->profile && auth()->user()->profile->bio)
                        <p class="text-gray-700 mt-2">{{ auth()->user()->profile->bio }}</p>
                    @endif

                    <!-- Verification Badge -->
                    @if(auth()->user()->profile && auth()->user()->profile->is_verified)
                        <div class="mt-2">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-green-100 text-green-800">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                Verified Freelancer
                            </span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
                <div class="bg-blue-50 rounded-lg p-4">
                    <div class="text-blue-600 text-sm font-semibold mb-1">Active Services</div>
                    <div class="text-2xl font-bold text-blue-900">{{ auth()->user()->services()->where('status', 'active')->count() }}</div>
                </div>
                <div class="bg-green-50 rounded-lg p-4">
                    <div class="text-green-600 text-sm font-semibold mb-1">Total Bids</div>
                    <div class="text-2xl font-bold text-green-900">{{ auth()->user()->bids()->count() }}</div>
                </div>
                <div class="bg-purple-50 rounded-lg p-4">
                    <div class="text-purple-600 text-sm font-semibold mb-1">Bids This Month</div>
                    <div class="text-2xl font-bold text-purple-900">{{ auth()->user()->bids_used_this_month }}/{{ auth()->user()->getBidLimit() }}</div>
                </div>
                <div class="bg-yellow-50 rounded-lg p-4">
                    <div class="text-yellow-600 text-sm font-semibold mb-1">Completed Orders</div>
                    <div class="text-2xl font-bold text-yellow-900">{{ auth()->user()->ordersAsSeller()->where('status', 'completed')->count() }}</div>
                </div>
            </div>

            <!-- Subscription Info -->
            @php
                $subscription = auth()->user()->activeFreelancerSubscription();
            @endphp
            <div class="border-t pt-6">
                <h4 class="text-lg font-bold text-gray-800 mb-4">Subscription Plan</h4>
                @if($subscription)
                    <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg p-6 text-white">
                        <div class="flex justify-between items-start">
                            <div>
                                <h5 class="text-xl font-bold mb-2">{{ $subscription->plan->name }}</h5>
                                <p class="text-blue-100 mb-4">{{ $subscription->plan->description }}</p>
                                <div class="space-y-2 text-sm">
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                        {{ $subscription->plan->max_bids }} bids per month
                                    </div>
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                        {{ $subscription->plan->max_services ?? 'Unlimited' }} services
                                    </div>
                                    @if($subscription->plan->commission_rate)
                                        <div class="flex items-center">
                                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                            </svg>
                                            {{ $subscription->plan->commission_rate }}% commission
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="text-3xl font-bold">${{ number_format($subscription->plan->price, 2) }}</div>
                                <div class="text-blue-100 text-sm">per {{ $subscription->plan->billing_period }}</div>
                                <div class="mt-4 text-sm">
                                    <div>Expires: {{ $subscription->ends_at->format('M d, Y') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="bg-gray-100 rounded-lg p-6 text-center">
                        <p class="text-gray-600 mb-4">You don't have an active subscription</p>
                        <a href="{{ route('freelancer.plans') }}" class="inline-block bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg">
                            View Plans
                        </a>
                    </div>
                @endif
            </div>

            <!-- Profile Details -->
            <div class="border-t pt-6 mt-6">
                <h4 class="text-lg font-bold text-gray-800 mb-4">Profile Details</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">Member Since</label>
                        <p class="text-gray-900">{{ auth()->user()->created_at->format('F d, Y') }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">Email Verified</label>
                        <p class="text-gray-900">
                            @if(auth()->user()->email_verified_at)
                                <span class="text-green-600 font-semibold">Yes</span>
                            @else
                                <span class="text-red-600 font-semibold">No</span>
                            @endif
                        </p>
                    </div>
                    @if(auth()->user()->profile)
                        @if(auth()->user()->profile->location)
                            <div>
                                <label class="block text-sm font-medium text-gray-600 mb-1">Location</label>
                                <p class="text-gray-900">{{ auth()->user()->profile->location }}</p>
                            </div>
                        @endif
                        @if(auth()->user()->profile->phone)
                            <div>
                                <label class="block text-sm font-medium text-gray-600 mb-1">Phone</label>
                                <p class="text-gray-900">{{ auth()->user()->profile->phone }}</p>
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
