<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\SiteSetting;
use App\Models\Tariff;
use App\Services\CoursePurchaseService;
use App\Services\TelegramLeadNotifierService;
use App\Services\YooKassaPaymentService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    public function __construct(
        private CoursePurchaseService $purchaseService,
        private YooKassaPaymentService $yooKassa
    ) {}

    public function show(Tariff $tariff): View
    {
        $promo = old('promocode', request('promocode', session('checkout_promo')));

        return view('checkout', [
            'tariff' => $tariff,
            'yookassaConfigured' => $this->yooKassa->isConfigured(),
            'priceCalc' => $this->purchaseService->calculatePrices($tariff, $promo),
            'presaleManual' => (bool) config('prostoy.presale_manual_payment'),
            'presaleMode' => SiteSetting::cabinetPresaleMode(),
        ]);
    }

    public function store(Request $request, Tariff $tariff, TelegramLeadNotifierService $telegram): RedirectResponse
    {
        $user = $request->user();
        $storedDigits = preg_replace('/\D/', '', (string) ($user->phone ?? '')) ?? '';
        $hasStoredPhone = strlen($storedDigits) >= 10;

        $request->validate([
            'promocode' => ['nullable', 'string', 'max:32'],
            'phone' => [$hasStoredPhone ? 'nullable' : 'required', 'string', 'max:40'],
        ]);

        $rawPhone = $request->input('phone');
        $digits = ($hasStoredPhone && (! is_string($rawPhone) || trim((string) $rawPhone) === ''))
            ? $storedDigits
            : (preg_replace('/\D/', '', (string) $rawPhone) ?? '');
        if (strlen($digits) < 10) {
            throw ValidationException::withMessages([
                'phone' => 'Укажи номер телефона полностью — не меньше 10 цифр.',
            ]);
        }

        $user->update(['phone' => $digits]);

        $calc = $this->purchaseService->calculatePrices($tariff, $request->input('promocode'));

        $manual = (bool) config('prostoy.presale_manual_payment');
        $yookassaOn = $this->yooKassa->isConfigured();

        if ($calc['final'] === 0) {
            $purchase = DB::transaction(function () use ($user, $tariff, $calc, $digits, $telegram) {
                $p = $this->purchaseService->createPendingPurchase(
                    $user,
                    $tariff,
                    $calc['final'],
                    $calc['discount'],
                    $calc['promo'],
                    $digits
                );
                $telegram->notifyPurchaseIntent($p);
                $this->purchaseService->finalizePurchaseAsPaid($p);

                return $p->fresh('tariff');
            });

            return redirect()
                ->route('welcome')
                ->with('purchase_id', $purchase->id);
        }

        $purchase = $this->purchaseService->createPendingPurchase(
            $user,
            $tariff,
            $calc['final'],
            $calc['discount'],
            $calc['promo'],
            $digits
        );

        $telegram->notifyPurchaseIntent($purchase);

        if ($manual) {
            return redirect()
                ->route('dashboard')
                ->with('flash', 'Заявка принята. Тариф «'.$tariff->name.'». В ближайшее время с тобой свяжется менеджер.');
        }

        if (! $yookassaOn) {
            $this->purchaseService->finalizePurchaseAsPaid($purchase);

            return redirect()
                ->route('welcome')
                ->with('purchase_id', $purchase->id);
        }

        $returnUrl = route('checkout.yookassa.return', ['purchase' => $purchase->id], true);

        $result = $this->yooKassa->createPayment($purchase, $tariff, $returnUrl);
        $this->purchaseService->attachYooKassaPaymentId($purchase, $result['payment_id']);

        return redirect()->away($result['confirmation_url']);
    }

    public function yookassaReturn(Request $request, Purchase $purchase): RedirectResponse
    {
        abort_unless($purchase->user_id === $request->user()->id, 403);

        if (! $purchase->yookassa_payment_id) {
            return redirect()
                ->route('checkout.show', $purchase->tariff)
                ->with('flash', 'Платёж не найден. Попробуй оформить снова.');
        }

        $payment = $this->yooKassa->fetchPayment($purchase->yookassa_payment_id);

        if ($this->yooKassa->isSucceeded($payment)) {
            $this->purchaseService->finalizePurchaseAsPaid($purchase);

            return redirect()
                ->route('welcome')
                ->with('purchase_id', $purchase->id);
        }

        return redirect()
            ->route('checkout.show', $purchase->tariff)
            ->with('flash', 'Оплата ещё не подтверждена. Если деньги списались — зайди в кабинет через минуту или напиши в поддержку.');
    }
}
