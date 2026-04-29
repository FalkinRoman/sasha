<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use App\Models\SiteSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class LessonController extends Controller
{
    public function show(Lesson $lesson): View|RedirectResponse
    {
        $user = auth()->user();

        if (! $lesson->userCanOpen($user)) {
            return redirect()
                ->route('tariffs.index')
                ->with('flash', 'Чтобы смотреть этот урок, выбери тариф.');
        }

        if ($lesson->isVideoBlockedForUserTariff($user)) {
            return redirect()
                ->route('dashboard')
                ->with('flash', 'Этот урок недоступен на вашем тарифе. Проверь доступные тарифы в карточке урока.');
        }

        return view('lessons.show', [
            'lesson' => $lesson,
            'purchase' => $user->activePurchase(),
            'cabinetPresaleMode' => SiteSetting::cabinetPresaleMode(),
        ]);
    }
}
