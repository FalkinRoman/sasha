<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use App\Models\SiteSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View|RedirectResponse
    {
        $user = auth()->user();

        if ($user->is_blogger && ! $user->is_admin) {
            return redirect()->route('blogger.dashboard');
        }

        $lessons = Lesson::query()
            ->where('course_slug', 'modern-yoga')
            ->orderBy('order_index')
            ->get();

        return view('dashboard', [
            'lessons' => $lessons,
            'purchase' => $user->activePurchase(),
            'pendingPurchase' => $user->purchases()->where('status', 'pending')->with('tariff')->latest()->first(),
            'presaleManual' => (bool) config('prostoy.presale_manual_payment'),
            'cabinetPresaleMode' => SiteSetting::cabinetPresaleMode(),
        ]);
    }
}
