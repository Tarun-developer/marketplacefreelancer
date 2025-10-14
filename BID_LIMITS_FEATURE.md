# Bid Limits Feature

## Overview
This feature implements a bid limit system for freelancers based on their subscription plans, with options for free limited bids and purchasing extra bids.

## Features
- **Subscription-based Limits**: Different bid limits based on subscription plans.
- **Free Tier**: Free users get 5 bids per month.
- **Paid Tiers**: Basic (20 bids), Pro (50 bids), Enterprise (100 bids).
- **Extra Bids**: Users can purchase additional bids using wallet balance.
- **Monthly Reset**: Bid counts reset monthly.
- **UI Integration**: Displays current usage and provides purchase options.

## Database Changes
- Added to `users` table:
  - `bids_used_this_month` (integer, default 0)
  - `bids_reset_date` (date, nullable)
  - `extra_bids` (integer, default 0)

## Updated Models
- **User Model**:
  - Added fields to `$fillable` and `$casts`.
  - Added methods: `getBidLimit()`, `canPlaceBid()`, `incrementBidCount()`, `resetBidsIfNeeded()`, `addExtraBids()`.

- **Subscription Plans**: Updated `max_bids` in seeder for each plan.

## Controller Changes
- **FreelancerJobController**:
  - Added bid limit check in `storeBid()`.
  - Added `buyBids()` and `purchaseBids()` methods.

## Views
- Updated `freelancer/proposals/index.blade.php` to show bid usage.
- Created `freelancer/buy-bids.blade.php` for purchasing extra bids.

## Routes
- Added routes for buying bids in `routes/freelancer.php`.

## Logic Flow
1. User attempts to place a bid.
2. System checks if `canPlaceBid()` returns true.
3. If limit reached, show error message.
4. If allowed, create bid and increment count.
5. Monthly reset happens automatically when checking limits.

## Future Enhancements
- Email notifications when approaching limit.
- Admin override for special cases.
- Integration with payment gateways for bid purchases.