# MarketFusion - Development Guide

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
