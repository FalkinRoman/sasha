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

        return view('lessons.show', [
            'lesson' => $lesson,
            'purchase' => $user->activePurchase(),
            'cabinetPresaleMode' => SiteSetting::cabinetPresaleMode(),
        ]);
    }
}
