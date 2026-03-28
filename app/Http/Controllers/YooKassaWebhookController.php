<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Services\CoursePurchaseService;
use App\Services\YooKassaPaymentService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use YooKassa\Model\Notification\NotificationFactory;
use YooKassa\Model\Notification\NotificationSucceeded;

class YooKassaWebhookController extends Controller
{
    public function __construct(
        private CoursePurchaseService $purchaseService,
        private YooKassaPaymentService $yooKassa
    ) {}

    public function __invoke(Request $request): Response
    {
        if (! $this->yooKassa->isConfigured()) {
            return response('OK', 200);
        }

        try {
            $data = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);
        } catch (\JsonException) {
            return response('Bad JSON', 400);
        }

        try {
            $notification = (new NotificationFactory)->factory($data);
        } catch (\Throwable) {
            return response('Bad payload', 400);
        }

        if (! $notification instanceof NotificationSucceeded) {
            return response('OK', 200);
        }

        $payment = $notification->getObject();
        $fresh = $this->yooKassa->fetchPayment($payment->getId());

        if (! $this->yooKassa->isSucceeded($fresh)) {
            return response('OK', 200);
        }

        $purchase = Purchase::query()->where('yookassa_payment_id', $fresh->getId())->first();

        if (! $purchase) {
            $meta = $fresh->getMetadata() !== null ? $fresh->getMetadata()->toArray() : [];
            $pid = $meta['purchase_id'] ?? null;
            if ($pid) {
                $purchase = Purchase::query()->find((int) $pid);
            }
        }

        if ($purchase) {
            $this->purchaseService->finalizePurchaseAsPaid($purchase);
        }

        return response('OK', 200);
    }
}
