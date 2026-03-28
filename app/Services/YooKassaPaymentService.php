<?php

namespace App\Services;

use App\Models\Purchase;
use App\Models\Tariff;
use Illuminate\Support\Str;
use YooKassa\Client;
use YooKassa\Model\Payment\PaymentInterface;
use YooKassa\Model\Payment\PaymentStatus;

class YooKassaPaymentService
{
    public function isConfigured(): bool
    {
        $shopId = config('services.yookassa.shop_id');
        $secret = config('services.yookassa.secret_key');

        return is_string($shopId) && $shopId !== ''
            && is_string($secret) && $secret !== '';
    }

    /**
     * @return array{confirmation_url: string, payment_id: string}
     */
    public function createPayment(Purchase $purchase, Tariff $tariff, string $returnUrl): array
    {
        $client = $this->client();

        $value = number_format($purchase->price_rub, 2, '.', '');
        $idempotenceKey = Str::uuid()->toString();

        $payment = $client->createPayment([
            'amount' => [
                'value' => $value,
                'currency' => 'RUB',
            ],
            'confirmation' => [
                'type' => 'redirect',
                'return_url' => $returnUrl,
            ],
            'capture' => true,
            'description' => 'ProstoYoga — '.$tariff->name,
            'metadata' => [
                'purchase_id' => (string) $purchase->id,
            ],
        ], $idempotenceKey);

        $confirmationUrl = $payment->getConfirmation()?->getConfirmationUrl();
        if (! $confirmationUrl) {
            throw new \RuntimeException('ЮKassa не вернула ссылку на оплату.');
        }

        return [
            'confirmation_url' => $confirmationUrl,
            'payment_id' => $payment->getId(),
        ];
    }

    public function fetchPayment(string $paymentId): PaymentInterface
    {
        return $this->client()->getPaymentInfo($paymentId);
    }

    public function isSucceeded(PaymentInterface $payment): bool
    {
        return $payment->getStatus() === PaymentStatus::SUCCEEDED;
    }

    private function client(): Client
    {
        $client = new Client;
        $client->setAuth(
            (string) config('services.yookassa.shop_id'),
            (string) config('services.yookassa.secret_key')
        );

        return $client;
    }
}
