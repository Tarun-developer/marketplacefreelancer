<?php

namespace App\Modules\Payments\Services\Gateways;

use Exception;

class PaytmGateway extends AbstractPaymentGateway
{
    public function getName(): string
    {
        return 'Paytm';
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
            // Note: Requires paytm/paytmchecksum package
            // composer require paytm/paytmchecksum

            $merchantId = $this->testMode
                ? $this->getConfig('sandbox_merchant_id')
                : $this->getConfig('merchant_id');

            $merchantKey = $this->testMode
                ? $this->getConfig('sandbox_merchant_key')
                : $this->getConfig('merchant_key');

            $website = $this->testMode
                ? 'WEBSTAGING'
                : ($this->getConfig('website') ?? 'DEFAULT');

            if (empty($merchantId) || empty($merchantKey)) {
                throw new Exception('Paytm credentials not configured');
            }

            $orderId = 'ORDER_' . uniqid();
            $amount = number_format($data['amount'], 2, '.', '');

            // Example Paytm integration:
            // $paytmParams = [
            //     'MID' => $merchantId,
            //     'WEBSITE' => $website,
            //     'INDUSTRY_TYPE_ID' => $this->getConfig('industry_type') ?? 'Retail',
            //     'CHANNEL_ID' => 'WEB',
            //     'ORDER_ID' => $orderId,
            //     'CUST_ID' => $data['customer_id'] ?? 'CUST_' . uniqid(),
            //     'TXN_AMOUNT' => $amount,
            //     'CALLBACK_URL' => $data['callback_url'] ?? url('/webhooks/paytm'),
            // ];
            //
            // $checksum = \PaytmChecksum::generateSignature(json_encode($paytmParams), $merchantKey);
            //
            // $paytmUrl = $this->testMode
            //     ? 'https://securegw-stage.paytm.in/theia/api/v1/initiateTransaction'
            //     : 'https://securegw.paytm.in/theia/api/v1/initiateTransaction';

            // Mock response
            return [
                'success' => true,
                'transaction_id' => $orderId,
                'status' => 'pending',
                'redirect_url' => $this->testMode
                    ? 'https://securegw-stage.paytm.in/theia/processTransaction'
                    : 'https://securegw.paytm.in/theia/processTransaction',
                'requires_action' => true,
                'form_data' => [
                    'MID' => $merchantId,
                    'ORDER_ID' => $orderId,
                    'TXN_AMOUNT' => $amount,
                ],
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

            $merchantKey = $this->testMode
                ? $this->getConfig('sandbox_merchant_key')
                : $this->getConfig('merchant_key');

            // Example status check:
            // $paytmParams = [
            //     'MID' => $merchantId,
            //     'ORDERID' => $transactionId,
            // ];
            //
            // $checksum = \PaytmChecksum::generateSignature(json_encode($paytmParams), $merchantKey);
            //
            // $url = $this->testMode
            //     ? 'https://securegw-stage.paytm.in/v3/order/status'
            //     : 'https://securegw.paytm.in/v3/order/status';
            //
            // // Make POST request to verify

            // Mock response
            return [
                'success' => true,
                'status' => 'TXN_SUCCESS',
                'amount' => 100.00,
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

            $merchantKey = $this->testMode
                ? $this->getConfig('sandbox_merchant_key')
                : $this->getConfig('merchant_key');

            // Example refund:
            // $paytmParams = [
            //     'MID' => $merchantId,
            //     'ORDERID' => $transactionId,
            //     'TXNID' => $transactionId,
            //     'REFID' => 'REFUND_' . uniqid(),
            //     'REFUNDAMOUNT' => number_format($amount, 2, '.', ''),
            //     'TXNTYPE' => 'REFUND',
            // ];
            //
            // $checksum = \PaytmChecksum::generateSignature(json_encode($paytmParams), $merchantKey);
            //
            // $url = $this->testMode
            //     ? 'https://securegw-stage.paytm.in/refund/apply'
            //     : 'https://securegw.paytm.in/refund/apply';

            return [
                'success' => true,
                'refund_id' => 'REFUND_' . uniqid(),
                'status' => 'pending',
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
        $status = $payload['STATUS'] ?? '';

        switch ($status) {
            case 'TXN_SUCCESS':
                return [
                    'event' => 'payment_completed',
                    'transaction_id' => $payload['ORDERID'] ?? null,
                    'status' => 'completed',
                ];

            case 'TXN_FAILURE':
                return [
                    'event' => 'payment_failed',
                    'transaction_id' => $payload['ORDERID'] ?? null,
                    'status' => 'failed',
                    'error' => $payload['RESPMSG'] ?? 'Transaction failed',
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
            $merchantKey = $this->testMode
                ? $this->getConfig('sandbox_merchant_key')
                : $this->getConfig('merchant_key');

            if (empty($merchantKey)) {
                return false;
            }

            // Example checksum verification:
            // $params = json_decode($payload, true);
            // $receivedChecksum = $params['CHECKSUMHASH'] ?? '';
            // unset($params['CHECKSUMHASH']);
            //
            // $isValid = \PaytmChecksum::verifySignature($params, $merchantKey, $receivedChecksum);
            // return $isValid;

            // For demo, return true
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}
