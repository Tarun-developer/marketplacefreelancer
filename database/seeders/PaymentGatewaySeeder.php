<?php

namespace Database\Seeders;

use App\Modules\Payments\Models\PaymentGateway;
use Illuminate\Database\Seeder;

class PaymentGatewaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $gateways = [
            [
                'name' => 'Stripe',
                'slug' => 'stripe',
                'type' => 'fiat',
                'description' => 'Accept credit cards, debit cards, and digital wallets from customers worldwide.',
                'logo' => 'stripe-logo.png',
                'supported_currencies' => ['USD', 'EUR', 'GBP', 'CAD', 'AUD', 'JPY', 'INR', 'SGD', 'HKD'],
                'supported_countries' => ['US', 'GB', 'CA', 'AU', 'IN', 'SG', 'HK'],
                'transaction_fee_percentage' => 2.9,
                'transaction_fee_fixed' => 0.30,
                'transaction_fee_currency' => 'USD',
                'min_amount' => 0.50,
                'max_amount' => 999999.99,
                'processing_time_minutes' => 1,
                'webhook_url' => '/webhooks/stripe',
                'test_mode' => true,
                'sort_order' => 1,
                'user_instructions' => 'Pay securely with your credit or debit card through Stripe.',
                'admin_notes' => 'Requires Stripe account and API keys. Install: composer require stripe/stripe-php',
                'is_active' => false,
                'config' => [
                    'live_public_key' => '',
                    'live_secret_key' => '',
                ],
                'sandbox_config' => [
                    'test_public_key' => '',
                    'test_secret_key' => '',
                ],
            ],
            [
                'name' => 'PayPal',
                'slug' => 'paypal',
                'type' => 'fiat',
                'description' => 'Accept PayPal, credit cards, and debit cards from customers worldwide.',
                'logo' => 'paypal-logo.png',
                'supported_currencies' => ['USD', 'EUR', 'GBP', 'CAD', 'AUD', 'JPY'],
                'supported_countries' => ['US', 'GB', 'CA', 'AU', 'DE', 'FR', 'IT', 'ES'],
                'transaction_fee_percentage' => 2.9,
                'transaction_fee_fixed' => 0.30,
                'transaction_fee_currency' => 'USD',
                'min_amount' => 1.00,
                'max_amount' => 10000.00,
                'processing_time_minutes' => 1,
                'test_mode' => true,
                'sort_order' => 2,
                'user_instructions' => 'Pay with your PayPal account or credit/debit card.',
                'admin_notes' => 'Requires PayPal Business account and API credentials.',
                'is_active' => false,
                'config' => [
                    'client_id' => '',
                    'secret' => '',
                    'mode' => 'live',
                ],
                'sandbox_config' => [
                    'client_id' => '',
                    'secret' => '',
                    'mode' => 'sandbox',
                ],
            ],
            [
                'name' => 'Razorpay',
                'slug' => 'razorpay',
                'type' => 'fiat',
                'description' => 'Accept payments via UPI, cards, net banking, and wallets. Popular in India.',
                'logo' => 'razorpay-logo.png',
                'supported_currencies' => ['INR'],
                'supported_countries' => ['IN'],
                'transaction_fee_percentage' => 2.0,
                'transaction_fee_fixed' => 0.00,
                'transaction_fee_currency' => 'INR',
                'min_amount' => 1.00,
                'max_amount' => 1000000.00,
                'processing_time_minutes' => 1,
                'test_mode' => true,
                'sort_order' => 3,
                'user_instructions' => 'Pay using UPI, cards, net banking, or popular wallets.',
                'admin_notes' => 'Best for Indian market. Supports UPI and local payment methods.',
                'is_active' => false,
                'config' => [
                    'key_id' => '',
                    'key_secret' => '',
                ],
                'sandbox_config' => [
                    'key_id' => '',
                    'key_secret' => '',
                ],
            ],
            [
                'name' => 'Bitcoin (BTC)',
                'slug' => 'bitcoin',
                'type' => 'crypto',
                'description' => 'Accept Bitcoin payments with on-chain confirmations.',
                'logo' => 'bitcoin-logo.png',
                'supported_currencies' => ['BTC'],
                'transaction_fee_percentage' => 1.0,
                'transaction_fee_fixed' => 0.00,
                'transaction_fee_currency' => 'BTC',
                'min_amount' => 0.0001,
                'max_amount' => 100.00,
                'processing_time_minutes' => 60, // ~10 minutes per confirmation, 6 confirmations typical
                'test_mode' => false,
                'sort_order' => 10,
                'user_instructions' => 'Send Bitcoin to the provided address. Requires 3 confirmations.',
                'admin_notes' => 'Requires Bitcoin node or payment processor integration.',
                'is_active' => false,
                'config' => [
                    'wallet_address' => '',
                    'required_confirmations' => 3,
                ],
            ],
            [
                'name' => 'Ethereum (ETH)',
                'slug' => 'ethereum',
                'type' => 'crypto',
                'description' => 'Accept Ethereum and ERC-20 tokens.',
                'logo' => 'ethereum-logo.png',
                'supported_currencies' => ['ETH', 'USDT', 'USDC'],
                'transaction_fee_percentage' => 1.0,
                'transaction_fee_fixed' => 0.00,
                'transaction_fee_currency' => 'ETH',
                'min_amount' => 0.001,
                'max_amount' => 1000.00,
                'processing_time_minutes' => 15,
                'test_mode' => false,
                'sort_order' => 11,
                'user_instructions' => 'Send Ethereum or ERC-20 tokens to the provided address.',
                'admin_notes' => 'Supports ETH and ERC-20 tokens like USDT and USDC.',
                'is_active' => false,
                'config' => [
                    'wallet_address' => '',
                    'required_confirmations' => 12,
                ],
            ],
            [
                'name' => 'Coinbase Commerce',
                'slug' => 'coinbase',
                'type' => 'crypto',
                'description' => 'Accept Bitcoin, Ethereum, Litecoin, and more through Coinbase Commerce.',
                'logo' => 'coinbase-logo.png',
                'supported_currencies' => ['BTC', 'ETH', 'LTC', 'BCH', 'USDC'],
                'transaction_fee_percentage' => 1.0,
                'transaction_fee_fixed' => 0.00,
                'transaction_fee_currency' => 'USD',
                'min_amount' => 1.00,
                'max_amount' => 100000.00,
                'processing_time_minutes' => 15,
                'test_mode' => true,
                'sort_order' => 12,
                'user_instructions' => 'Pay with your preferred cryptocurrency through Coinbase.',
                'admin_notes' => 'Requires Coinbase Commerce account and API key.',
                'is_active' => false,
                'config' => [
                    'api_key' => '',
                    'webhook_secret' => '',
                ],
            ],
            [
                'name' => 'Internal Wallet',
                'slug' => 'wallet',
                'type' => 'wallet',
                'description' => 'Pay using your account wallet balance.',
                'logo' => 'wallet-logo.png',
                'supported_currencies' => ['USD', 'EUR', 'GBP', 'INR'],
                'transaction_fee_percentage' => 0.0,
                'transaction_fee_fixed' => 0.00,
                'transaction_fee_currency' => 'USD',
                'min_amount' => 0.01,
                'max_amount' => 999999.99,
                'processing_time_minutes' => 0,
                'test_mode' => false,
                'sort_order' => 0,
                'user_instructions' => 'Instantly pay using your wallet balance.',
                'admin_notes' => 'Internal wallet system. No fees applied.',
                'is_active' => true,
                'config' => [],
            ],
        ];

        foreach ($gateways as $gateway) {
            PaymentGateway::updateOrCreate(
                ['slug' => $gateway['slug']],
                $gateway
            );
        }
    }
}
