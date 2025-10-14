# Payment Gateway Integration Guide

This guide explains how to integrate and use the payment gateways in this marketplace application.

## Overview

The application supports 19 payment gateways across multiple categories:
- **Indian Gateways**: Razorpay, Paytm, PhonePe, Cashfree, Instamojo, CCAvenue
- **International**: Stripe, PayPal, Square, Authorize.Net, Mollie, Braintree
- **African**: Paystack, Flutterwave
- **Cryptocurrency**: Bitcoin, Ethereum, Coinbase Commerce, USDT
- **Internal**: Wallet system

## Currently Implemented Gateways

The following gateways have full service implementations:

1. **Stripe** - Credit/debit cards, digital wallets
2. **PayPal** - PayPal account, credit/debit cards
3. **Razorpay** - UPI, cards, net banking, wallets (India)
4. **Paytm** - Paytm wallet, UPI, cards, net banking (India)
5. **PhonePe** - UPI, PhonePe wallet (India)

## Installation & Setup

### 1. Install Required Packages

Each gateway requires its specific PHP SDK:

```bash
# Stripe
composer require stripe/stripe-php

# PayPal
composer require paypal/paypal-checkout-sdk

# Razorpay
composer require razorpay/razorpay

# Paytm
composer require paytm/paytmchecksum
```

### 2. Configure Gateway Credentials

Navigate to **Admin Panel → Payment Gateways** (`/admin/payment-gateways`)

For each gateway:
1. Click "Edit" on the gateway you want to configure
2. Add your API credentials in the "Live Credentials" tab
3. Add test credentials in the "Test/Sandbox Credentials" tab
4. Enable test mode for testing
5. Set the gateway as "Active"

### 3. Activate Gateways

By default, only the Internal Wallet is active. To activate other gateways:

**Via Admin Panel:**
- Go to `/admin/payment-gateways`
- Click the toggle button to activate/deactivate gateways

**Via Database:**
```sql
UPDATE payment_gateways SET is_active = 1 WHERE slug IN ('stripe', 'paypal', 'razorpay');
```

**Via Tinker:**
```bash
php artisan tinker
\App\Modules\Payments\Models\PaymentGateway::whereIn('slug', ['stripe', 'paypal', 'razorpay'])->update(['is_active' => true]);
```

## Gateway-Specific Configuration

### Stripe

**Required Credentials:**
- Live Public Key (pk_live_...)
- Live Secret Key (sk_live_...)
- Test Public Key (pk_test_...)
- Test Secret Key (sk_test_...)
- Webhook Secret (optional)

**API Documentation:** https://stripe.com/docs/api

**Test Cards:**
```
Success: 4242 4242 4242 4242
Decline: 4000 0000 0000 0002
Requires Auth: 4000 0025 0000 3155
```

### PayPal

**Required Credentials:**
- Client ID (Live & Sandbox)
- Secret Key (Live & Sandbox)

**API Documentation:** https://developer.paypal.com/docs/api/overview/

**Sandbox Testing:** https://developer.paypal.com/dashboard/

### Razorpay (India)

**Required Credentials:**
- Key ID (rzp_live_... or rzp_test_...)
- Key Secret

**API Documentation:** https://razorpay.com/docs/api/

**Test Mode:**
```
Test Card: 4111 1111 1111 1111
CVV: Any 3 digits
Expiry: Any future date
```

### Paytm (India)

**Required Credentials:**
- Merchant ID
- Merchant Key
- Website (DEFAULT for production, WEBSTAGING for testing)
- Industry Type (Retail, Education, etc.)

**API Documentation:** https://developer.paytm.com/docs/

**Testing:** Use Paytm staging environment credentials

### PhonePe (India)

**Required Credentials:**
- Merchant ID
- Salt Key
- Salt Index

**API Documentation:** https://developer.phonepe.com/v1/docs

**UAT Environment:** https://mercury-uat.phonepe.com/

## Using Payment Gateways in Code

### Creating a Payment

```php
use App\Modules\Payments\Services\PaymentGatewayFactory;

// Create gateway instance
$gateway = PaymentGatewayFactory::create('stripe'); // or 'paypal', 'razorpay', etc.

// Create payment
$result = $gateway->createPayment([
    'amount' => 100.00,
    'currency' => 'USD',
    'description' => 'Product purchase',
    'customer_id' => auth()->id(),
    'return_url' => route('payment.success'),
    'cancel_url' => route('payment.cancel'),
    'metadata' => [
        'order_id' => $order->id,
    ],
]);

if ($result['success']) {
    // Redirect user to payment page
    return redirect($result['redirect_url']);
} else {
    // Handle error
    return back()->with('error', $result['error']);
}
```

### Verifying a Payment

```php
$gateway = PaymentGatewayFactory::create('stripe');

$result = $gateway->verifyPayment($transactionId);

if ($result['success'] && $result['paid']) {
    // Payment successful
    $transaction->markAsCompleted();
}
```

### Processing Refunds

```php
$gateway = PaymentGatewayFactory::createById($transaction->payment_gateway_id);

$result = $gateway->refund(
    $transaction->transaction_id,
    $amount,
    'Customer requested refund'
);

if ($result['success']) {
    $transaction->update(['status' => 'refunded']);
}
```

### Handling Webhooks

```php
// In your webhook controller
public function handleWebhook(Request $request, $gateway)
{
    $gatewayInstance = PaymentGatewayFactory::create($gateway);

    // Verify signature
    $signature = $request->header('X-Signature') ?? $request->header('Stripe-Signature');
    $isValid = $gatewayInstance->verifyWebhookSignature(
        $request->getContent(),
        $signature
    );

    if (!$isValid) {
        return response()->json(['error' => 'Invalid signature'], 400);
    }

    // Handle webhook
    $result = $gatewayInstance->handleWebhook($request->all());

    switch ($result['event']) {
        case 'payment_completed':
            $transaction = Transaction::where('transaction_id', $result['transaction_id'])->first();
            $transaction->markAsCompleted();
            break;

        case 'payment_failed':
            $transaction = Transaction::where('transaction_id', $result['transaction_id'])->first();
            $transaction->markAsFailed($result['error']);
            break;
    }

    return response()->json(['status' => 'ok']);
}
```

## Database Structure

### Payment Gateways Table

```sql
payment_gateways
├── id
├── name (e.g., "Stripe")
├── slug (e.g., "stripe")
├── type (fiat/crypto/wallet)
├── is_active (boolean)
├── test_mode (boolean)
├── config (encrypted JSON with API credentials)
├── sandbox_config (encrypted JSON with test credentials)
├── supported_currencies (JSON array)
├── transaction_fee_percentage
├── transaction_fee_fixed
└── ... (more fields)
```

### Transactions Table

```sql
transactions
├── id
├── user_id
├── payment_gateway_id
├── transaction_id (from gateway)
├── type (purchase/role_purchase/subscription/etc.)
├── amount
├── fee_amount
├── currency
├── status (pending/completed/failed/refunded)
├── description
├── metadata (JSON)
└── timestamps
```

## Adding New Gateway Implementations

To add a new gateway:

1. **Create Gateway Class**

```php
// app/Modules/Payments/Services/Gateways/NewGateway.php
<?php

namespace App\Modules\Payments\Services\Gateways;

use Exception;

class NewGateway extends AbstractPaymentGateway
{
    public function getName(): string
    {
        return 'New Gateway';
    }

    public function getType(): string
    {
        return 'fiat'; // or 'crypto', 'wallet'
    }

    public function getSupportedCurrencies(): array
    {
        return ['USD', 'EUR'];
    }

    public function createPayment(array $data): array
    {
        // Implement payment creation
    }

    public function verifyPayment(string $transactionId): array
    {
        // Implement payment verification
    }

    public function refund(string $transactionId, float $amount, ?string $reason = null): array
    {
        // Implement refund
    }

    public function getTransactionDetails(string $transactionId): array
    {
        // Implement transaction details fetch
    }

    public function handleWebhook(array $payload): array
    {
        // Implement webhook handling
    }

    public function verifyWebhookSignature(string $payload, string $signature): bool
    {
        // Implement signature verification
    }
}
```

2. **Register in Factory**

```php
// app/Modules/Payments/Services/PaymentGatewayFactory.php
public static function getAvailableGateways(): array
{
    return [
        'stripe' => StripeGateway::class,
        'paypal' => PayPalGateway::class,
        'newgateway' => NewGateway::class, // Add here
        // ...
    ];
}

// Update match statement in createFromModel()
```

3. **Add to Seeder**

Update `database/seeders/PaymentGatewaySeeder.php` to include your new gateway configuration.

## Testing

### Test Mode

Enable test mode for a gateway:
1. Go to Admin → Payment Gateways
2. Click "Switch to Test Mode" button
3. Gateway will use sandbox credentials

### Manual Testing

```bash
# Create a test transaction
php artisan tinker

$gateway = \App\Modules\Payments\Services\PaymentGatewayFactory::create('stripe');
$result = $gateway->createPayment([
    'amount' => 10.00,
    'currency' => 'USD',
    'description' => 'Test payment',
]);

print_r($result);
```

## Security Best Practices

1. **Never expose API keys** - Use environment variables and encryption
2. **Always verify webhook signatures** - Prevent fraudulent callbacks
3. **Use HTTPS** - All payment communications must be encrypted
4. **Validate amounts** - Always verify payment amounts on server side
5. **Log transactions** - Keep audit trail of all payment activities
6. **Handle failures gracefully** - Implement proper error handling
7. **Test thoroughly** - Use test mode before going live

## Troubleshooting

### Gateway Not Showing in Checkout

1. Check if gateway is active: `is_active = true`
2. Check if credentials are configured
3. Verify gateway implementation exists in PaymentGatewayFactory

### Payment Failures

1. Check test mode vs live mode credentials
2. Verify API keys are correct
3. Check gateway API documentation for error codes
4. Review application logs

### Webhook Not Working

1. Verify webhook URL is publicly accessible
2. Check webhook signature verification
3. Ensure webhook secret is configured
4. Test webhook using gateway dashboard tools

## Support & Resources

- **Stripe**: https://stripe.com/docs
- **PayPal**: https://developer.paypal.com
- **Razorpay**: https://razorpay.com/docs
- **Paytm**: https://developer.paytm.com
- **PhonePe**: https://developer.phonepe.com

## License

This payment integration module is part of the marketplace application.
