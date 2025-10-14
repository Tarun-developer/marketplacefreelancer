# Payment Gateway System - Complete Documentation

## Overview

This document provides comprehensive documentation for the **MarketFusion Payment Gateway System** - a flexible, secure, and extensible payment processing system that supports:

- **Fiat Currencies**: Stripe, PayPal, Razorpay
- **Cryptocurrencies**: Bitcoin, Ethereum, Coinbase Commerce
- **Internal Wallet**: Account balance payments
- **Multi-Currency Support**: Any currency or cryptocurrency
- **Secure Credential Storage**: Encrypted gateway configurations
- **Admin Management Interface**: Full CRUD operations

---

## Table of Contents

1. [Architecture Overview](#architecture-overview)
2. [Database Schema](#database-schema)
3. [Models](#models)
4. [Payment Gateway Interface](#payment-gateway-interface)
5. [Available Payment Gateways](#available-payment-gateways)
6. [Admin Management](#admin-management)
7. [Usage Examples](#usage-examples)
8. [Adding New Gateways](#adding-new-gateways)
9. [Security Features](#security-features)
10. [API Reference](#api-reference)

---

## Architecture Overview

```
app/Modules/Payments/
├── Models/
│   ├── PaymentGateway.php      (Enhanced with encryption)
│   ├── PaymentMethod.php        (User saved payment methods)
│   └── Transaction.php          (Enhanced transaction tracking)
├── Services/
│   └── Gateways/
│       ├── PaymentGatewayInterface.php    (Interface for all gateways)
│       ├── AbstractPaymentGateway.php     (Base class)
│       ├── StripeGateway.php              (Stripe implementation)
│       ├── PayPalGateway.php              (PayPal - to be implemented)
│       ├── RazorpayGateway.php            (Razorpay - to be implemented)
│       └── CoinbaseGateway.php            (Crypto - to be implemented)
└── Controllers/
    └── Admin/AdminPaymentGatewayController.php
```

---

## Database Schema

### 1. Payment Gateways Table

**Table**: `payment_gateways`

| Column                      | Type          | Description                                    |
|-----------------------------|---------------|------------------------------------------------|
| id                          | bigint        | Primary key                                    |
| name                        | varchar(255)  | Gateway name (e.g., "Stripe")                  |
| slug                        | varchar(255)  | Unique identifier (e.g., "stripe")             |
| type                        | enum          | Gateway type: fiat, crypto, wallet             |
| description                 | text          | Gateway description                            |
| logo                        | varchar(255)  | Logo filename                                  |
| supported_currencies        | json          | Array of supported currencies                  |
| supported_countries         | json          | Array of supported country codes               |
| transaction_fee_percentage  | decimal(5,2)  | Percentage fee (e.g., 2.9%)                    |
| transaction_fee_fixed       | decimal(10,2) | Fixed fee (e.g., $0.30)                        |
| transaction_fee_currency    | varchar(3)    | Currency for fixed fee                         |
| min_amount                  | decimal(15,2) | Minimum transaction amount                     |
| max_amount                  | decimal(15,2) | Maximum transaction amount                     |
| processing_time_minutes     | integer       | Average processing time                        |
| webhook_url                 | varchar(255)  | Webhook endpoint URL                           |
| webhook_secret              | varchar(255)  | Webhook secret for verification                |
| test_mode                   | boolean       | Test/Sandbox mode flag                         |
| sandbox_config              | text          | Encrypted sandbox credentials                  |
| sort_order                  | integer       | Display order                                  |
| user_instructions           | text          | Instructions for users                         |
| admin_notes                 | text          | Private admin notes                            |
| is_active                   | boolean       | Active status                                  |
| config                      | text          | Encrypted live credentials                     |
| last_used_at                | timestamp     | Last usage timestamp                           |
| total_transactions          | integer       | Total transaction count                        |
| total_volume                | decimal(20,2) | Total transaction volume                       |
| created_at                  | timestamp     | Creation timestamp                             |
| updated_at                  | timestamp     | Update timestamp                               |

### 2. Payment Methods Table

**Table**: `payment_methods`

| Column                | Type          | Description                                |
|-----------------------|---------------|--------------------------------------------|
| id                    | bigint        | Primary key                                |
| user_id               | bigint        | Foreign key to users                       |
| payment_gateway_id    | bigint        | Foreign key to payment_gateways            |
| nickname              | varchar(255)  | User-friendly name                         |
| type                  | varchar(255)  | Method type (card, bank, crypto_wallet)    |
| encrypted_data        | text          | Encrypted payment details                  |
| last_four             | varchar(255)  | Last 4 digits for display                  |
| brand                 | varchar(255)  | Brand (Visa, Mastercard, BTC, etc.)        |
| expiry_month          | varchar(255)  | Expiry month                               |
| expiry_year           | varchar(255)  | Expiry year                                |
| is_default            | boolean       | Default payment method flag                |
| is_verified           | boolean       | Verification status                        |
| verification_token    | varchar(255)  | Verification token                         |
| verified_at           | timestamp     | Verification timestamp                     |
| last_used_at          | timestamp     | Last usage timestamp                       |
| created_at            | timestamp     | Creation timestamp                         |
| updated_at            | timestamp     | Update timestamp                           |

### 3. Enhanced Transactions Table

**Table**: `transactions`

Additional columns added:

| Column                  | Type          | Description                              |
|-------------------------|---------------|------------------------------------------|
| payment_gateway_id      | bigint        | Foreign key to payment_gateways          |
| payment_method_id       | bigint        | Foreign key to payment_methods           |
| fee_amount              | decimal(10,2) | Transaction fee                          |
| net_amount              | decimal(10,2) | Amount after fees                        |
| exchange_rate           | decimal(20,8) | Exchange rate for conversions            |
| original_currency       | varchar(10)   | Original currency if converted           |
| original_amount         | decimal(15,2) | Original amount if converted             |
| crypto_address          | varchar(255)  | Cryptocurrency address                   |
| crypto_txn_hash         | varchar(255)  | Crypto transaction hash                  |
| confirmations           | integer       | Current confirmations                    |
| required_confirmations  | integer       | Required confirmations                   |
| failure_code            | varchar(255)  | Error code for failed transactions       |
| failure_message         | text          | Error message                            |
| ip_address              | varchar(45)   | User IP address                          |
| user_agent              | text          | User agent string                        |
| webhook_data            | json          | Webhook payload data                     |
| webhook_received_at     | timestamp     | Webhook received timestamp               |
| initiated_at            | timestamp     | Transaction initiated timestamp          |
| processed_at            | timestamp     | Processing started timestamp             |
| completed_at            | timestamp     | Completion timestamp                     |
| failed_at               | timestamp     | Failure timestamp                        |

---

## Models

### PaymentGateway Model

**Location**: `app/Modules/Payments/Models/PaymentGateway.php`

#### Key Features:
- **Encrypted Configuration Storage**: API keys and secrets are encrypted
- **Automatic Fee Calculation**: Calculate transaction fees automatically
- **Currency & Country Support**: Check if gateway supports specific currencies/countries
- **Test Mode Support**: Separate configurations for sandbox/live environments
- **Transaction Statistics**: Track usage and volume

#### Methods:

```php
// Check if gateway supports a currency
$gateway->supportsCurrency('USD'); // Returns: bool

// Calculate fee for an amount
$fee = $gateway->calculateFee(100.00); // Returns: float

// Get net amount after fees
$netAmount = $gateway->getNetAmount(100.00); // Returns: float

// Record a transaction
$gateway->recordTransaction(100.00); // Updates stats

// Get active configuration (test or live)
$config = $gateway->getActiveConfig(); // Returns: array

// Scopes
PaymentGateway::active()->get(); // Get only active gateways
PaymentGateway::fiat()->get(); // Get fiat gateways
PaymentGateway::crypto()->get(); // Get crypto gateways
```

### PaymentMethod Model

**Location**: `app/Modules/Payments/Models/PaymentMethod.php`

#### Key Features:
- **Encrypted Payment Data**: Card details stored securely
- **Expiry Checking**: Automatic expiry validation
- **Default Method Management**: Only one default per user
- **Verification Support**: Email/SMS verification flow

#### Methods:

```php
// Get decrypted payment data
$data = $method->getDecryptedData(); // Returns: array

// Set payment data (encrypted)
$method->setPaymentData(['card_number' => '4242...']); // Encrypts and saves

// Get masked display name
$display = $method->masked_display; // Returns: "Visa ending in 4242"

// Check if expired
$expired = $method->isExpired(); // Returns: bool

// Mark as default
$method->markAsDefault(); // Unsets other defaults

// Mark as verified
$method->markAsVerified(); // Sets verified status

// Scopes
PaymentMethod::default()->get(); // Get default methods
PaymentMethod::verified()->get(); // Get verified methods
PaymentMethod::active()->get(); // Get non-expired methods
```

### Transaction Model

**Location**: `app/Modules/Payments/Models/Transaction.php`

#### Enhanced Methods:

```php
// Mark transaction as completed
$transaction->markAsCompleted(); // Updates status and gateway stats

// Mark transaction as failed
$transaction->markAsFailed('insufficient_funds', 'Card has insufficient funds');

// Mark as refunded
$transaction->markAsRefunded();

// Check if crypto transaction
$isCrypto = $transaction->isCrypto(); // Returns: bool

// Check if crypto is confirmed
$confirmed = $transaction->isCryptoConfirmed(); // Returns: bool

// Get total amount (with fees)
$total = $transaction->total_amount; // Returns: float

// Get display amount
$display = $transaction->getDisplayAmount(); // Returns: "USD 100.00"

// Scopes
Transaction::completed()->get(); // Completed transactions
Transaction::pending()->get(); // Pending transactions
Transaction::failed()->get(); // Failed transactions
Transaction::payments()->get(); // Payment type
Transaction::refunds()->get(); // Refund type
```

---

## Payment Gateway Interface

**Location**: `app/Modules/Payments/Services/Gateways/PaymentGatewayInterface.php`

All payment gateways must implement this interface:

```php
interface PaymentGatewayInterface
{
    // Initialize with configuration
    public function initialize(array $config): void;

    // Create a payment
    public function createPayment(array $data): array;

    // Verify a payment
    public function verifyPayment(string $transactionId): array;

    // Process refund
    public function refund(string $transactionId, float $amount, ?string $reason = null): array;

    // Get transaction details
    public function getTransactionDetails(string $transactionId): array;

    // Handle webhook
    public function handleWebhook(array $payload): array;

    // Verify webhook signature
    public function verifyWebhookSignature(string $payload, string $signature): bool;

    // Get supported currencies
    public function getSupportedCurrencies(): array;

    // Check availability
    public function isAvailable(): bool;

    // Get gateway name
    public function getName(): string;

    // Get gateway type
    public function getType(): string;
}
```

---

## Available Payment Gateways

### 1. Stripe (Fiat)
- **Type**: fiat
- **Currencies**: USD, EUR, GBP, CAD, AUD, JPY, INR, SGD, HKD
- **Fee**: 2.9% + $0.30
- **Status**: Implementation ready (requires stripe/stripe-php package)

### 2. PayPal (Fiat)
- **Type**: fiat
- **Currencies**: USD, EUR, GBP, CAD, AUD, JPY
- **Fee**: 2.9% + $0.30
- **Status**: Ready for implementation

### 3. Razorpay (Fiat)
- **Type**: fiat
- **Currencies**: INR
- **Fee**: 2.0%
- **Status**: Ready for implementation (popular in India)

### 4. Bitcoin (Crypto)
- **Type**: crypto
- **Currencies**: BTC
- **Fee**: 1.0%
- **Confirmations**: 3 required
- **Status**: Ready for implementation

### 5. Ethereum (Crypto)
- **Type**: crypto
- **Currencies**: ETH, USDT, USDC
- **Fee**: 1.0%
- **Confirmations**: 12 required
- **Status**: Ready for implementation

### 6. Coinbase Commerce (Crypto)
- **Type**: crypto
- **Currencies**: BTC, ETH, LTC, BCH, USDC
- **Fee**: 1.0%
- **Status**: Ready for implementation

### 7. Internal Wallet
- **Type**: wallet
- **Currencies**: USD, EUR, GBP, INR
- **Fee**: 0%
- **Status**: Active

---

## Admin Management

### Routes

All admin routes are protected by `auth` and `role:super_admin|admin|manager` middleware:

```
GET    /admin/payment-gateways                     - List gateways
GET    /admin/payment-gateways/create              - Create form
POST   /admin/payment-gateways                     - Store gateway
GET    /admin/payment-gateways/{id}                - Show gateway
GET    /admin/payment-gateways/{id}/edit           - Edit form
PUT    /admin/payment-gateways/{id}                - Update gateway
DELETE /admin/payment-gateways/{id}                - Delete gateway
POST   /admin/payment-gateways/{id}/toggle-status  - Toggle active status
POST   /admin/payment-gateways/{id}/toggle-test-mode - Toggle test mode
POST   /admin/payment-gateways/{id}/update-config  - Update configuration
```

### Controller

**Location**: `app/Http/Controllers/Admin/AdminPaymentGatewayController.php`

#### Available Actions:

1. **index()** - List all gateways with filters
2. **create()** - Show create form
3. **store()** - Create new gateway
4. **show()** - View gateway details
5. **edit()** - Show edit form
6. **update()** - Update gateway
7. **destroy()** - Delete gateway (if no transactions)
8. **toggleStatus()** - Activate/deactivate gateway
9. **toggleTestMode()** - Switch between test/live mode
10. **updateConfig()** - Update gateway credentials

---

## Usage Examples

### 1. Creating a Payment Gateway

```php
use App\Modules\Payments\Models\PaymentGateway;

$gateway = PaymentGateway::create([
    'name' => 'My Custom Gateway',
    'slug' => 'custom-gateway',
    'type' => 'fiat',
    'description' => 'Custom payment processor',
    'supported_currencies' => ['USD', 'EUR'],
    'transaction_fee_percentage' => 3.0,
    'transaction_fee_fixed' => 0.50,
    'is_active' => true,
    'config' => [
        'api_key' => 'your-api-key',
        'api_secret' => 'your-api-secret',
    ],
]);
```

### 2. Processing a Payment

```php
use App\Modules\Payments\Models\PaymentGateway;
use App\Modules\Payments\Services\Gateways\StripeGateway;

$gateway = PaymentGateway::where('slug', 'stripe')->first();
$stripeGateway = new StripeGateway();
$stripeGateway->initialize($gateway->getActiveConfig());

$result = $stripeGateway->createPayment([
    'amount' => 100.00,
    'currency' => 'USD',
    'description' => 'Order #123',
    'metadata' => ['order_id' => 123],
]);

if ($result['success']) {
    // Payment initiated
    $transactionId = $result['transaction_id'];
} else {
    // Handle error
    $error = $result['error'];
}
```

### 3. Saving a Payment Method

```php
use App\Modules\Payments\Models\PaymentMethod;

$paymentMethod = PaymentMethod::create([
    'user_id' => auth()->id(),
    'payment_gateway_id' => $gateway->id,
    'nickname' => 'My Visa Card',
    'type' => 'card',
    'last_four' => '4242',
    'brand' => 'Visa',
    'expiry_month' => '12',
    'expiry_year' => '2025',
    'is_default' => true,
]);

// Set encrypted payment data
$paymentMethod->setPaymentData([
    'card_number' => '4242424242424242',
    'cvv' => '123',
]);
```

### 4. Recording a Transaction

```php
use App\Modules\Payments\Models\Transaction;

$transaction = Transaction::create([
    'user_id' => auth()->id(),
    'order_id' => $order->id,
    'amount' => 100.00,
    'currency' => 'USD',
    'gateway' => 'stripe',
    'payment_gateway_id' => $gateway->id,
    'payment_method_id' => $paymentMethod->id,
    'fee_amount' => $gateway->calculateFee(100.00),
    'net_amount' => $gateway->getNetAmount(100.00),
    'status' => 'pending',
    'type' => 'payment',
    'initiated_at' => now(),
]);

// Mark as completed
$transaction->markAsCompleted();
```

---

## Adding New Gateways

### Step 1: Create Gateway Class

Create a new class in `app/Modules/Payments/Services/Gateways/`:

```php
<?php

namespace App\Modules\Payments\Services\Gateways;

class MyCustomGateway extends AbstractPaymentGateway
{
    public function getName(): string
    {
        return 'My Custom Gateway';
    }

    public function getType(): string
    {
        return 'fiat'; // or 'crypto' or 'wallet'
    }

    public function getSupportedCurrencies(): array
    {
        return ['USD', 'EUR'];
    }

    public function createPayment(array $data): array
    {
        // Implement payment creation logic
    }

    public function verifyPayment(string $transactionId): array
    {
        // Implement payment verification
    }

    public function refund(string $transactionId, float $amount, ?string $reason = null): array
    {
        // Implement refund logic
    }

    public function getTransactionDetails(string $transactionId): array
    {
        // Implement transaction details retrieval
    }

    public function handleWebhook(array $payload): array
    {
        // Implement webhook handling
    }

    public function verifyWebhookSignature(string $payload, string $signature): bool
    {
        // Implement webhook signature verification
    }
}
```

### Step 2: Add to Database

```php
use App\Modules\Payments\Models\PaymentGateway;

PaymentGateway::create([
    'name' => 'My Custom Gateway',
    'slug' => 'my-custom-gateway',
    'type' => 'fiat',
    'description' => 'Custom payment processor',
    'supported_currencies' => ['USD', 'EUR'],
    'transaction_fee_percentage' => 2.5,
    'transaction_fee_fixed' => 0.30,
    'is_active' => true,
    'config' => [
        'api_key' => '',
        'api_secret' => '',
    ],
]);
```

---

## Security Features

### 1. Encrypted Credentials
- All API keys and secrets are encrypted using Laravel's `Crypt` facade
- Automatic encryption/decryption via model accessors/mutators

### 2. Secure Configuration Storage
- Separate test and live credentials
- Test mode flag prevents accidental live charges
- Hidden fields prevent credential exposure in API responses

### 3. Transaction Security
- IP address and user agent tracking
- Webhook signature verification
- Fraud detection metadata storage

### 4. Payment Method Security
- PCI-compliant encrypted storage
- Only last 4 digits displayed to users
- Verification token for added security

---

## API Reference

### Admin Controller Methods

#### `index(Request $request)`
List payment gateways with filters

**Query Parameters:**
- `type`: Filter by gateway type (fiat, crypto, wallet)
- `status`: Filter by status (active, inactive)
- `search`: Search by name, slug, or description

**Returns:** View with paginated gateways and statistics

#### `store(Request $request)`
Create new payment gateway

**Required Fields:**
- `name`: Gateway name
- `slug`: Unique slug
- `type`: Gateway type

**Returns:** Redirect to gateway detail page

#### `toggleStatus(PaymentGateway $paymentGateway)`
Toggle gateway active status

**Returns:** Redirect back with success message

---

## Configuration

### Environment Variables

Add these to your `.env` file:

```env
# Stripe
STRIPE_PUBLIC_KEY=pk_test_...
STRIPE_SECRET_KEY=sk_test_...

# PayPal
PAYPAL_CLIENT_ID=...
PAYPAL_SECRET=...
PAYPAL_MODE=sandbox

# Razorpay
RAZORPAY_KEY_ID=...
RAZORPAY_KEY_SECRET=...

# Crypto Wallets
BTC_WALLET_ADDRESS=...
ETH_WALLET_ADDRESS=...

# Coinbase Commerce
COINBASE_API_KEY=...
COINBASE_WEBHOOK_SECRET=...
```

---

## Testing

### Seed Test Data

```bash
php artisan db:seed --class=PaymentGatewaySeeder
```

This seeds 7 payment gateways:
1. Stripe (inactive - requires configuration)
2. PayPal (inactive - requires configuration)
3. Razorpay (inactive - requires configuration)
4. Bitcoin (inactive - requires wallet address)
5. Ethereum (inactive - requires wallet address)
6. Coinbase Commerce (inactive - requires API key)
7. Internal Wallet (active - no configuration needed)

---

## Next Steps

### To Complete the Implementation:

1. **Install Gateway SDKs**:
   ```bash
   composer require stripe/stripe-php
   composer require paypal/rest-api-sdk-php
   composer require razorpay/razorpay
   ```

2. **Create Admin Views**: Views for managing payment gateways (list, create, edit)

3. **Implement Remaining Gateways**: Complete PayPal, Razorpay, and crypto gateway implementations

4. **Add Webhook Routes**: Create webhook endpoints for each gateway

5. **Create Payment Service**: Main service for processing payments across gateways

6. **Create Currency Service**: Handle currency conversions and exchange rates

7. **Add Frontend Checkout**: User-facing payment selection and processing

---

## File Structure

```
Created/Modified Files:
- database/migrations/2025_10_14_040137_enhance_payment_gateways_table.php
- database/migrations/2025_10_14_040336_create_payment_methods_table.php
- database/migrations/2025_10_14_040353_enhance_transactions_table.php
- database/migrations/2025_10_14_040903_change_payment_gateways_config_to_text.php
- database/seeders/PaymentGatewaySeeder.php
- app/Modules/Payments/Models/PaymentGateway.php (Enhanced)
- app/Modules/Payments/Models/PaymentMethod.php (New)
- app/Modules/Payments/Models/Transaction.php (Enhanced)
- app/Modules/Payments/Services/Gateways/PaymentGatewayInterface.php (New)
- app/Modules/Payments/Services/Gateways/AbstractPaymentGateway.php (New)
- app/Modules/Payments/Services/Gateways/StripeGateway.php (New)
- app/Http/Controllers/Admin/AdminPaymentGatewayController.php (New)
- routes/admin.php (Updated)
```

---

## Support

For questions or issues with the payment gateway system, please refer to:
- Laravel Documentation: https://laravel.com/docs
- Stripe Documentation: https://stripe.com/docs
- PayPal Documentation: https://developer.paypal.com/docs
- Razorpay Documentation: https://razorpay.com/docs

---

**Document Version**: 1.0
**Last Updated**: 2025-10-14
**Author**: Claude (Anthropic)
