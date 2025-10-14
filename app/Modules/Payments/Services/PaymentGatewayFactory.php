<?php

namespace App\Modules\Payments\Services;

use App\Modules\Payments\Models\PaymentGateway as PaymentGatewayModel;
use App\Modules\Payments\Services\Gateways\PaymentGatewayInterface;
use App\Modules\Payments\Services\Gateways\StripeGateway;
use App\Modules\Payments\Services\Gateways\PayPalGateway;
use App\Modules\Payments\Services\Gateways\RazorpayGateway;
use App\Modules\Payments\Services\Gateways\PaytmGateway;
use App\Modules\Payments\Services\Gateways\PhonePeGateway;
use Exception;

class PaymentGatewayFactory
{
    /**
     * Create a payment gateway instance based on slug
     */
    public static function create(string $slug): PaymentGatewayInterface
    {
        $gateway = PaymentGatewayModel::where('slug', $slug)->firstOrFail();

        return self::createFromModel($gateway);
    }

    /**
     * Create a payment gateway instance from model
     */
    public static function createFromModel(PaymentGatewayModel $gateway): PaymentGatewayInterface
    {
        $config = $gateway->getActiveConfig();
        $testMode = $gateway->test_mode;

        $instance = match ($gateway->slug) {
            'stripe' => new StripeGateway($config, $testMode),
            'paypal' => new PayPalGateway($config, $testMode),
            'razorpay' => new RazorpayGateway($config, $testMode),
            'paytm' => new PaytmGateway($config, $testMode),
            'phonepe' => new PhonePeGateway($config, $testMode),
            default => throw new Exception("Gateway {$gateway->slug} not implemented"),
        };

        return $instance;
    }

    /**
     * Create a payment gateway instance by ID
     */
    public static function createById(int $id): PaymentGatewayInterface
    {
        $gateway = PaymentGatewayModel::findOrFail($id);

        return self::createFromModel($gateway);
    }

    /**
     * Get all available gateway slugs
     */
    public static function getAvailableGateways(): array
    {
        return [
            'stripe' => StripeGateway::class,
            'paypal' => PayPalGateway::class,
            'razorpay' => RazorpayGateway::class,
            'paytm' => PaytmGateway::class,
            'phonepe' => PhonePeGateway::class,
        ];
    }

    /**
     * Check if a gateway is implemented
     */
    public static function isImplemented(string $slug): bool
    {
        return array_key_exists($slug, self::getAvailableGateways());
    }
}
