# MarketFusion - Development Guide

## Project Overview

MarketFusion is a comprehensive Laravel-based marketplace platform that combines freelancing services and digital product sales. It features role-based access control, subscription packages, media management, and a complete API for mobile/web applications.

## Project Setup

### 1. Initial Setup

```bash
# Clone the repository
git clone git@github.com:Tarun-developer/marketplacefreelancer.git
cd marketplacefreelancer

# Install dependencies
composer install
npm install

# Environment setup
cp .env.example .env
php artisan key:generate

# Database setup
php artisan migrate
php artisan db:seed
```

### 2. Required Services

- PHP 8.4+
- MySQL 8.0+
- Redis (optional, for caching)
- Node.js 20+ & NPM

## Implementation Status

### ✅ Completed Features

#### 1. Authentication & Authorization
- **Laravel Sanctum** for API authentication
- **Spatie Laravel Permission** for role-based access control
- User roles: SuperAdmin, Admin, Vendor, Freelancer, Client, Support
- Dynamic auth links on homepage
- Beautiful header component with user dropdown

#### 2. Core Modules
- **Users Module**: CRUD operations, profiles, KYC verification
- **Products Module**: Digital product marketplace with categories, tags, media uploads
- **Services Module**: Freelance gigs with offers and delivery
- **Jobs Module**: Job posting and bidding system
- **Orders Module**: Unified order management for all types
- **Wallet Module**: Dual wallet system (currency + coins)
- **Reviews Module**: Rating and review system
- **Chat Module**: Real-time messaging between users
- **Disputes Module**: Dispute resolution system
- **Support Module**: Support ticket management

#### 3. Subscription System
- **Subscription Plans**: Basic and Pro plans for freelancers and vendors
- **Features**: Unlimited bids, featured listings, priority support
- **API Integration**: Subscribe, cancel, view plans

#### 4. Media Management
- **Spatie Media Library** integration
- **User Avatars**: Image uploads with conversions (thumb, medium)
- **Product Media**: Preview images and downloadable files
- **File Validation**: MIME type and size restrictions

#### 5. API Development
- **Comprehensive REST API** for all modules
- **61 API endpoints** covering CRUD operations
- **Authentication**: Bearer token-based auth
- **Testing**: PHPUnit tests for API endpoints
- **Media Uploads**: Support for images and files via API

#### 6. Admin Dashboard
- **Complete Admin Panel** with sidebar navigation
- **CRUD Operations** for users, products, categories, services, jobs, orders, disputes, transactions, support tickets, reviews, subscriptions
- **Settings Management**: Comprehensive settings with tabs for General, Security, Notifications, Maintenance, Integrations
- **Role-based Access**: Only admins can access admin features
- **Theme System**: Light/dark mode toggle with CSS variables
- **Role-Specific Layouts**: Separate layouts for admin, vendor, client, freelancer with tailored menus

#### 7. User Dashboards
- **Vendor Dashboard**: Product management, orders, earnings
- **Freelancer Dashboard**: Services, active jobs, earnings
- **Client Dashboard**: Orders, posted jobs, favorites
- **Support Dashboard**: Tickets, disputes, resolution tracking
- **Role-specific Features**: Each dashboard tailored to user role
- **Theme-Based Views**: Easy switching between light/dark modes and potential for other frameworks like Tailwind

#### 8. Frontend
- **Tailwind CSS** for modern, responsive design
- **Alpine.js** for interactive components
- **Blade Templates** for server-side rendering
- **Role-based dashboards** for different user types

### 🏗️ Architecture & Logic

#### Modular Structure
The application uses a modular architecture where each feature is organized into separate modules under `app/Modules/`. This promotes:
- **Separation of Concerns**: Each module handles its own models, controllers, and logic
- **Scalability**: Easy to add new features without affecting existing code
- **Maintainability**: Clear boundaries between different parts of the application

#### Role-Based Access Control (RBAC)
- **Spatie Laravel Permission** provides fine-grained permissions
- **Middleware**: Custom RoleMiddleware for route protection
- **User Roles**: 6 distinct roles with specific permissions
- **Multi-Role Support**: Users can have multiple roles (e.g., freelancer + client)
- **Role Switching**: UI to switch between roles and access corresponding dashboards
- **Common Dashboard**: Beautiful onboarding dashboard for role selection
- **Onboarding Flow**: First-time users select their primary role with clear, visual options
- **Logic**: Users can only access features based on their role and subscription

#### Subscription Logic
- **Freelancer Plans**: Basic (5 bids/month) and Pro (unlimited bids)
- **Vendor Plans**: Basic (10 products) and Pro (unlimited products)
- **Billing**: Monthly subscriptions with automatic renewal
- **Features**: Role-based feature gating based on active subscription

#### Media Management Logic
- **Collections**: Separate media collections for different purposes (avatar, preview, files)
- **Conversions**: Automatic image resizing for thumbnails and medium sizes
- **Validation**: Server-side validation for file types and sizes
- **Storage**: Files stored securely with Spatie Media Library

#### API Design
- **RESTful Endpoints**: Standard CRUD operations for all resources
- **Authentication**: Sanctum for stateless API authentication
- **Error Handling**: Proper HTTP status codes and error responses
- **Testing**: Comprehensive test coverage for API endpoints

### 📋 API Endpoints Summary

| Module | Endpoints | Description |
|--------|-----------|-------------|
| Users | 8 | User management, profiles, authentication |
| Products | 5 | Digital product CRUD with media |
| Services | 5 | Freelance service management |
| Jobs | 6 | Job posting and bidding |
| Orders | 5 | Order management |
| Chat | 4 | Messaging system |
| Disputes | 5 | Dispute resolution |
| Payments | 3 | Payment processing and transactions |
| Wallet | 4 | Wallet balance and transactions |
| Reviews | 5 | Review and rating system |
| Support | 5 | Support ticket management |
| Subscriptions | 4 | Subscription management |

### 🧪 Testing

- **PHPUnit Tests**: Feature tests for API endpoints
- **Database Refresh**: Tests use RefreshDatabase for clean state
- **Role Seeding**: Automatic role creation in test setup
- **Coverage**: Currently testing User API, expandable to all modules

### 🚀 Deployment Notes

- **Environment Variables**: Configure payment gateways, mail settings, etc.
- **Queue Worker**: Run `php artisan queue:work` for background jobs
- **Caching**: Use Redis for session and cache storage in production
- **Media Storage**: Configure S3 or local storage for media files

### 🔄 Next Steps

1. **Multi-Role System Implementation**: Allow users to have multiple roles and switch between dashboards
2. **Mobile App Development**: Use the API to build React Native/Flutter apps
3. **Payment Integration**: Implement real payment gateways (Stripe, PayPal)
4. **Real-time Features**: Add WebSocket support for chat
5. **Advanced Features**: AI-powered recommendations, advanced analytics
6. **Performance Optimization**: Database indexing, caching strategies

### 📚 Key Concepts Used

- **Laravel 12**: Latest framework features and best practices
- **Modular Architecture**: Clean separation of concerns
- **RBAC**: Fine-grained access control
- **Media Library**: Professional file management
- **API-First Design**: Mobile-ready backend
- **Subscription Model**: SaaS-style monetization
- **Modern Frontend**: Tailwind + Alpine.js for responsive UI

## Project Structure

```
app/
├── Modules/               # Feature modules (modular architecture)
│   ├── Users/            # User management
│   ├── Products/         # Digital product marketplace
│   ├── Services/         # Freelance services/gigs
│   ├── Jobs/             # Job posting & bidding
│   ├── Orders/           # Unified order system
│   ├── Payments/         # Payment processing
│   ├── Wallet/           # Wallet & transactions
│   ├── Reviews/          # Reviews & ratings
│   ├── Chat/             # Real-time messaging
│   ├── Disputes/         # Dispute management
│   └── Support/          # Support tickets
├── Enums/                # Enumeration classes
├── Helpers/              # Helper classes
├── Traits/               # Reusable traits
└── DTOs/                 # Data Transfer Objects
```

## Development Workflow

### 1. Feature Development

Each module follows this structure:
```
ModuleName/
├── Models/              # Eloquent models
├── Controllers/         # HTTP controllers
├── Requests/           # Form requests
├── Services/           # Business logic
├── Repositories/       # Data access layer
├── Events/             # Domain events
├── Listeners/          # Event listeners
├── Policies/           # Authorization policies
└── Notifications/      # Notification classes
```

### 2. Logging System

We use dedicated log channels for different features:

- `auth` - Authentication & authorization (30 days retention)
- `payments` - Payment transactions (90 days retention)
- `orders` - Order processing (60 days retention)
- `disputes` - Dispute handling (90 days retention)
- `api` - API requests (14 days retention)
- `chat` - Chat messages (7 days retention)
- `webhooks` - Webhook events (30 days retention)

Usage:
```php
use Illuminate\Support\Facades\Log;

Log::channel('payments')->info('Payment processed', ['order_id' => $order->id]);
```

### 3. Response Helper

Use the ResponseHelper for consistent API responses:

```php
use App\Helpers\ResponseHelper;

// Success response
return ResponseHelper::success($data, 'Operation successful');

// Error response
return ResponseHelper::error('Error message', 400);

// Paginated response
return ResponseHelper::paginated($paginator);

// Validation error
return ResponseHelper::validationError($errors);
```

### 4. User Roles & Permissions

Built on Spatie Laravel Permission. Available roles:

```php
use App\Enums\UserRole;

UserRole::SUPER_ADMIN
UserRole::ADMIN
UserRole::MANAGER
UserRole::VENDOR
UserRole::FREELANCER
UserRole::CLIENT
UserRole::SUPPORT
```

Check permissions:
```php
$user->hasRole(UserRole::ADMIN->value);
$user->can('edit-product');
```

## Testing

```bash
# Run all tests
php artisan test

# Run specific test suite
php artisan test --testsuite=Feature

# With coverage
php artisan test --coverage
```

## Code Standards

### Laravel Pint (Code Formatting)
```bash
./vendor/bin/pint
```

### Best Practices

1. Follow PSR-12 coding standards
2. Use type hints for all parameters and return types
3. Write descriptive commit messages
4. Keep controllers thin, use services for business logic
5. Use dependency injection
6. Write tests for all new features
7. Use Enums for constant values
8. Document all public methods

## Git Workflow

```bash
# Create feature branch
git checkout -b feature/feature-name

# Make changes and commit
git add .
git commit -m "Add: feature description"

# Push to remote
git push origin feature/feature-name

# Create pull request on GitHub
```

## Useful Commands

```bash
# Clear all caches
php artisan optimize:clear

# Generate IDE helper files
php artisan ide-helper:generate
php artisan ide-helper:models
php artisan ide-helper:meta

# Queue worker
php artisan queue:work --tries=3

# View logs in real-time
php artisan pail

# Run migrations
php artisan migrate

# Rollback migrations
php artisan migrate:rollback

# Fresh database with seeders
php artisan migrate:fresh --seed
```

## Environment Variables

Key environment variables are documented in `.env.example`. Important configurations:

### Marketplace Settings
- `MARKETPLACE_COMMISSION_RATE` - Platform commission percentage
- `MARKETPLACE_ENABLE_KYC` - Enable KYC verification
- `MARKETPLACE_ENABLE_2FA` - Enable two-factor authentication

### Payment Gateways
- Configure Stripe, PayPal, and Razorpay credentials
- Set webhook URLs for payment confirmations

### Logging
- `LOG_STACK` - Comma-separated log channels
- `LOG_DAILY_DAYS` - Log retention period

## Troubleshooting

### Permission Issues
```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

### Clear Cache
```bash
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
```

### Database Issues
```bash
php artisan migrate:fresh --seed
```

## Security

- Never commit `.env` file
- Keep dependencies updated
- Use prepared statements (Eloquent does this automatically)
- Validate all user inputs
- Use CSRF protection
- Enable rate limiting on routes
- Sanitize file uploads

## Performance Optimization

1. Enable query caching for frequently accessed data
2. Use eager loading to prevent N+1 queries
3. Queue heavy operations
4. Use Redis for session and cache storage
5. Optimize database indexes
6. Enable OpCache in production

## Support

For issues and questions:
- Create an issue on GitHub
- Check documentation in `README.md`
- Review the codebase for examples
