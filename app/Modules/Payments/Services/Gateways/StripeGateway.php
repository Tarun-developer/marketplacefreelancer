<?php

namespace App\Modules\Payments\Services\Gateways;

use Exception;

class StripeGateway extends AbstractPaymentGateway
{
    public function getName(): string
    {
        return 'Stripe';
    }

    public function getType(): string
    {
        return 'fiat';
    }

    public function getSupportedCurrencies(): array
    {
        return ['USD', 'EUR', 'GBP', 'CAD', 'AUD', 'JPY', 'INR'];
    }

    public function createPayment(array $data): array
    {
        try {
            // Note: Requires stripe/stripe-php package
            // composer require stripe/stripe-php

            $apiKey = $this->testMode
                ? $this->getConfig('test_secret_key')
                : $this->getConfig('live_secret_key');

            if (empty($apiKey)) {
                throw new Exception('Stripe API key not configured');
            }

            // \Stripe\Stripe::setApiKey($apiKey);

            // Example Payment Intent creation
            // $paymentIntent = \Stripe\PaymentIntent::create([
            //     'amount' => $data['amount'] * 100, // Convert to cents
            //     'currency' => strtolower($data['currency']),
            //     'description' => $data['description'] ?? 'Payment',
            //     'metadata' => $data['metadata'] ?? [],
            // ]);

            // For now, return mock response
            return [
                'success' => true,
                'transaction_id' => 'pi_' . uniqid(),
                'status' => 'requires_payment_method',
                'client_secret' => 'pi_secret_' . uniqid(),
                'redirect_url' => null,
                'requires_action' => true,
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    public function verifyPayment(string $transactionId): array
    {
        try {
            $apiKey = $this->testMode
                ? $this->getConfig('test_secret_key')
                : $this->getConfig('live_secret_key');

            // \Stripe\Stripe::setApiKey($apiKey);
            // $paymentIntent = \Stripe\PaymentIntent::retrieve($transactionId);

            // Mock response
            return [
                'success' => true,
                'status' => 'succeeded',
                'amount' => 10000,
                'currency' => 'usd',
                'paid' => true,
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    public function refund(string $transactionId, float $amount, ?string $reason = null): array
    {
        try {
            $apiKey = $this->testMode
                ? $this->getConfig('test_secret_key')
                : $this->getConfig('live_secret_key');

            // \Stripe\Stripe::setApiKey($apiKey);
            // $refund = \Stripe\Refund::create([
            //     'payment_intent' => $transactionId,
            //     'amount' => $amount * 100,
            //     'reason' => $reason,
            //]);

            return [
                'success' => true,
                'refund_id' => 're_' . uniqid(),
                'status' => 'succeeded',
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    public function getTransactionDetails(string $transactionId): array
    {
        return $this->verifyPayment($transactionId);
    }

    public function handleWebhook(array $payload): array
    {
        $event = $payload;

        switch ($event['type'] ?? '') {
            case 'payment_intent.succeeded':
                return [
                    'event' => 'payment_completed',
                    'transaction_id' => $event['data']['object']['id'] ?? null,
                    'status' => 'completed',
                ];

            case 'payment_intent.payment_failed':
                return [
                    'event' => 'payment_failed',
                    'transaction_id' => $event['data']['object']['id'] ?? null,
                    'status' => 'failed',
                    'error' => $event['data']['object']['last_payment_error']['message'] ?? 'Payment failed',
                ];

            default:
                return [
                    'event' => 'unknown',
                    'data' => $event,
                ];
        }
    }

    public function verifyWebhookSignature(string $payload, string $signature): bool
    {
        try {
            $webhookSecret = $this->getConfig('webhook_secret');

            if (empty($webhookSecret)) {
                return false;
            }

            // \Stripe\Webhook::constructEvent($payload, $signature, $webhookSecret);

            // For demo, return true
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}
