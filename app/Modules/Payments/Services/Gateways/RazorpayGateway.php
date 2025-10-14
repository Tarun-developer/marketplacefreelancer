<?php

namespace App\Modules\Payments\Services\Gateways;

use Exception;

class RazorpayGateway extends AbstractPaymentGateway
{
    public function getName(): string
    {
        return 'Razorpay';
    }

    public function getType(): string
    {
        return 'fiat';
    }

    public function getSupportedCurrencies(): array
    {
        return ['INR'];
    }

    public function createPayment(array $data): array
    {
        try {
            // Note: Requires razorpay/razorpay package
            // composer require razorpay/razorpay

            $keyId = $this->testMode
                ? $this->getConfig('test_key_id')
                : $this->getConfig('key_id');

            $keySecret = $this->testMode
                ? $this->getConfig('test_key_secret')
                : $this->getConfig('key_secret');

            if (empty($keyId) || empty($keySecret)) {
                throw new Exception('Razorpay credentials not configured');
            }

            // Example Razorpay SDK usage:
            // $api = new \Razorpay\Api\Api($keyId, $keySecret);
            //
            // $order = $api->order->create([
            //     'amount' => $data['amount'] * 100, // Amount in paise
            //     'currency' => $data['currency'],
            //     'receipt' => 'rcpt_' . $data['transaction_id'] ?? uniqid(),
            //     'notes' => [
            //         'description' => $data['description'] ?? 'Payment',
            //     ],
            // ]);

            // Mock response
            return [
                'success' => true,
                'transaction_id' => 'order_' . uniqid(),
                'status' => 'created',
                'key_id' => $keyId,
                'amount' => $data['amount'] * 100,
                'currency' => $data['currency'] ?? 'INR',
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
            $keyId = $this->testMode
                ? $this->getConfig('test_key_id')
                : $this->getConfig('key_id');

            $keySecret = $this->testMode
                ? $this->getConfig('test_key_secret')
                : $this->getConfig('key_secret');

            // Example payment verification:
            // $api = new \Razorpay\Api\Api($keyId, $keySecret);
            // $payment = $api->payment->fetch($transactionId);
            //
            // Verify signature
            // $attributes = [
            //     'razorpay_order_id' => $payment->order_id,
            //     'razorpay_payment_id' => $payment->id,
            //     'razorpay_signature' => $signature,
            // ];
            // $api->utility->verifyPaymentSignature($attributes);

            // Mock response
            return [
                'success' => true,
                'status' => 'captured',
                'amount' => 10000,
                'currency' => 'INR',
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
            $keyId = $this->testMode
                ? $this->getConfig('test_key_id')
                : $this->getConfig('key_id');

            $keySecret = $this->testMode
                ? $this->getConfig('test_key_secret')
                : $this->getConfig('key_secret');

            // Example refund:
            // $api = new \Razorpay\Api\Api($keyId, $keySecret);
            // $payment = $api->payment->fetch($transactionId);
            // $refund = $payment->refund([
            //     'amount' => $amount * 100,
            //     'notes' => [
            //         'reason' => $reason,
            //     ],
            // ]);

            return [
                'success' => true,
                'refund_id' => 'rfnd_' . uniqid(),
                'status' => 'processed',
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
        $eventType = $event['event'] ?? '';

        switch ($eventType) {
            case 'payment.captured':
                return [
                    'event' => 'payment_completed',
                    'transaction_id' => $event['payload']['payment']['entity']['id'] ?? null,
                    'status' => 'completed',
                ];

            case 'payment.failed':
                return [
                    'event' => 'payment_failed',
                    'transaction_id' => $event['payload']['payment']['entity']['id'] ?? null,
                    'status' => 'failed',
                    'error' => $event['payload']['payment']['entity']['error_description'] ?? 'Payment failed',
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

            // Example webhook verification:
            // $api = new \Razorpay\Api\Api($keyId, $keySecret);
            // $api->utility->verifyWebhookSignature($payload, $signature, $webhookSecret);

            // For demo, return true
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}
