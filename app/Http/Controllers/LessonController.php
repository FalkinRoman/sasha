<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class LessonController extends Controller
{
    public function show(Lesson $lesson): View|RedirectResponse
    {
        $user = auth()->user();

        if (! $lesson->userCanWatch($user)) {
            return redirect()
                ->route('checkout.show', ['tariff' => 'base'])
                ->with('flash', 'Оформите доступ, чтобы смотреть этот урок.');
        }

        return view('lessons.show', [
            'lesson' => $lesson,
            'purchase' => $user->activePurchase(),
        ]);
    }
}
