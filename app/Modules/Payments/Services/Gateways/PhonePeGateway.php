<?php

namespace App\Modules\Payments\Services\Gateways;

use Exception;

class PhonePeGateway extends AbstractPaymentGateway
{
    public function getName(): string
    {
        return 'PhonePe';
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
            // PhonePe Payment Gateway Integration

            $merchantId = $this->testMode
                ? $this->getConfig('sandbox_merchant_id')
                : $this->getConfig('merchant_id');

            $saltKey = $this->testMode
                ? $this->getConfig('sandbox_salt_key')
                : $this->getConfig('salt_key');

            $saltIndex = $this->testMode
                ? $this->getConfig('sandbox_salt_index')
                : $this->getConfig('salt_index');

            if (empty($merchantId) || empty($saltKey)) {
                throw new Exception('PhonePe credentials not configured');
            }

            $transactionId = 'TXN_' . uniqid();
            $amount = $data['amount'] * 100; // Amount in paise

            // Example PhonePe payment request:
            // $payload = [
            //     'merchantId' => $merchantId,
            //     'merchantTransactionId' => $transactionId,
            //     'merchantUserId' => $data['user_id'] ?? 'USER_' . uniqid(),
            //     'amount' => $amount,
            //     'redirectUrl' => $data['redirect_url'] ?? url('/payment/callback'),
            //     'redirectMode' => 'POST',
            //     'callbackUrl' => $data['callback_url'] ?? url('/webhooks/phonepe'),
            //     'mobileNumber' => $data['mobile'] ?? '',
            //     'paymentInstrument' => [
            //         'type' => 'PAY_PAGE',
            //     ],
            // ];
            //
            // $jsonPayload = json_encode($payload);
            // $base64Payload = base64_encode($jsonPayload);
            //
            // $checksum = hash('sha256', $base64Payload . '/pg/v1/pay' . $saltKey) . '###' . $saltIndex;
            //
            // $url = $this->testMode
            //     ? 'https://api-preprod.phonepe.com/apis/pg-sandbox/pg/v1/pay'
            //     : 'https://api.phonepe.com/apis/hermes/pg/v1/pay';
            //
            // $response = Http::withHeaders([
            //     'Content-Type' => 'application/json',
            //     'X-VERIFY' => $checksum,
            // ])->post($url, [
            //     'request' => $base64Payload,
            // ]);

            // Mock response
            return [
                'success' => true,
                'transaction_id' => $transactionId,
                'status' => 'PENDING',
                'redirect_url' => $this->testMode
                    ? 'https://mercury-uat.phonepe.com/transact/' . $transactionId
                    : 'https://mercury.phonepe.com/transact/' . $transactionId,
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
            $merchantId = $this->testMode
                ? $this->getConfig('sandbox_merchant_id')
                : $this->getConfig('merchant_id');

            $saltKey = $this->testMode
                ? $this->getConfig('sandbox_salt_key')
                : $this->getConfig('salt_key');

            $saltIndex = $this->testMode
                ? $this->getConfig('sandbox_salt_index')
                : $this->getConfig('salt_index');

            // Example status check:
            // $checksum = hash('sha256', '/pg/v1/status/' . $merchantId . '/' . $transactionId . $saltKey) . '###' . $saltIndex;
            //
            // $url = $this->testMode
            //     ? "https://api-preprod.phonepe.com/apis/pg-sandbox/pg/v1/status/{$merchantId}/{$transactionId}"
            //     : "https://api.phonepe.com/apis/hermes/pg/v1/status/{$merchantId}/{$transactionId}";
            //
            // $response = Http::withHeaders([
            //     'Content-Type' => 'application/json',
            //     'X-VERIFY' => $checksum,
            //     'X-MERCHANT-ID' => $merchantId,
            // ])->get($url);

            // Mock response
            return [
                'success' => true,
                'status' => 'PAYMENT_SUCCESS',
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
            $merchantId = $this->testMode
                ? $this->getConfig('sandbox_merchant_id')
                : $this->getConfig('merchant_id');

            $saltKey = $this->testMode
                ? $this->getConfig('sandbox_salt_key')
                : $this->getConfig('salt_key');

            $saltIndex = $this->testMode
                ? $this->getConfig('sandbox_salt_index')
                : $this->getConfig('salt_index');

            // Example refund request:
            // $refundId = 'REFUND_' . uniqid();
            // $refundAmount = $amount * 100; // Amount in paise
            //
            // $payload = [
            //     'merchantId' => $merchantId,
            //     'merchantTransactionId' => $refundId,
            //     'originalTransactionId' => $transactionId,
            //     'amount' => $refundAmount,
            //     'callbackUrl' => url('/webhooks/phonepe/refund'),
            // ];
            //
            // $jsonPayload = json_encode($payload);
            // $base64Payload = base64_encode($jsonPayload);
            //
            // $checksum = hash('sha256', $base64Payload . '/pg/v1/refund' . $saltKey) . '###' . $saltIndex;
            //
            // $url = $this->testMode
            //     ? 'https://api-preprod.phonepe.com/apis/pg-sandbox/pg/v1/refund'
            //     : 'https://api.phonepe.com/apis/hermes/pg/v1/refund';

            return [
                'success' => true,
                'refund_id' => 'REFUND_' . uniqid(),
                'status' => 'PENDING',
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
        $response = $payload['response'] ?? $payload;
        $code = $response['code'] ?? '';

        switch ($code) {
            case 'PAYMENT_SUCCESS':
                return [
                    'event' => 'payment_completed',
                    'transaction_id' => $response['data']['merchantTransactionId'] ?? null,
                    'status' => 'completed',
                ];

            case 'PAYMENT_ERROR':
            case 'PAYMENT_DECLINED':
                return [
                    'event' => 'payment_failed',
                    'transaction_id' => $response['data']['merchantTransactionId'] ?? null,
                    'status' => 'failed',
                    'error' => $response['message'] ?? 'Payment failed',
                ];

            default:
                return [
                    'event' => 'unknown',
                    'data' => $payload,
                ];
        }
    }

    public function verifyWebhookSignature(string $payload, string $signature): bool
    {
        try {
            $saltKey = $this->testMode
                ? $this->getConfig('sandbox_salt_key')
                : $this->getConfig('salt_key');

            $saltIndex = $this->testMode
                ? $this->getConfig('sandbox_salt_index')
                : $this->getConfig('salt_index');

            if (empty($saltKey)) {
                return false;
            }

            // Example signature verification:
            // $base64Response = json_decode($payload, true)['response'] ?? '';
            // $calculatedChecksum = hash('sha256', $base64Response . $saltKey) . '###' . $saltIndex;
            //
            // return hash_equals($calculatedChecksum, $signature);

            // For demo, return true
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}
