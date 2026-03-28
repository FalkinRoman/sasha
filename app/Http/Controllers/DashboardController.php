<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $lessons = Lesson::query()
            ->where('course_slug', 'modern-yoga')
            ->orderBy('order_index')
            ->get();

        return view('dashboard', [
            'lessons' => $lessons,
            'purchase' => auth()->user()->activePurchase(),
        ]);
    }
}
