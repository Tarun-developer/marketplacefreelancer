<?php

namespace App\Modules\Payments\Services\Gateways;

interface PaymentGatewayInterface
{
    /**
     * Initialize the gateway with configuration
     */
    public function initialize(array $config): void;

    /**
     * Create a payment intent/session
     *
     * @param array $data Payment data (amount, currency, description, etc.)
     * @return array Returns payment intent data with redirect URL if needed
     */
    public function createPayment(array $data): array;

    /**
     * Verify a payment
     *
     * @param string $transactionId Gateway transaction ID
     * @return array Payment status and details
     */
    public function verifyPayment(string $transactionId): array;

    /**
     * Process a refund
     *
     * @param string $transactionId Original transaction ID
     * @param float $amount Amount to refund
     * @param string|null $reason Refund reason
     * @return array Refund result
     */
    public function refund(string $transactionId, float $amount, ?string $reason = null): array;

    /**
     * Get transaction details
     *
     * @param string $transactionId Gateway transaction ID
     * @return array Transaction details
     */
    public function getTransactionDetails(string $transactionId): array;

    /**
     * Handle webhook callback
     *
     * @param array $payload Webhook payload
     * @return array Processed webhook data
     */
    public function handleWebhook(array $payload): array;

    /**
     * Verify webhook signature
     *
     * @param string $payload Raw payload
     * @param string $signature Signature from headers
     * @return bool
     */
    public function verifyWebhookSignature(string $payload, string $signature): bool;

    /**
     * Get supported currencies
     *
     * @return array List of supported currency codes
     */
    public function getSupportedCurrencies(): array;

    /**
     * Check if gateway is available
     *
     * @return bool
     */
    public function isAvailable(): bool;

    /**
     * Get gateway name
     *
     * @return string
     */
    public function getName(): string;

    /**
     * Get gateway type (fiat, crypto, wallet)
     *
     * @return string
     */
    public function getType(): string;
}
