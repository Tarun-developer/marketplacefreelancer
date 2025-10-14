<?php

namespace App\Modules\Payments\Services\Gateways;

abstract class AbstractPaymentGateway implements PaymentGatewayInterface
{
    protected array $config = [];
    protected bool $testMode = false;

    public function initialize(array $config): void
    {
        $this->config = $config;
        $this->testMode = $config['test_mode'] ?? false;
    }

    protected function getConfig(string $key, $default = null)
    {
        return $this->config[$key] ?? $default;
    }

    public function isAvailable(): bool
    {
        return !empty($this->config);
    }

    abstract public function getName(): string;
    abstract public function getType(): string;
}
