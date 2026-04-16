<?php

namespace App\Http\Controllers\Blogger;

use App\Http\Controllers\Controller;
use App\Models\Lesson;
use App\Models\SiteSetting;
use Illuminate\View\View;

class BloggerDashboardController extends Controller
{
    public function __invoke(): View
    {
        $user = auth()->user();

        $lessons = Lesson::query()
            ->where('course_slug', 'modern-yoga')
            ->orderBy('order_index')
            ->get();

        $promo = $user->ownedPromocodes()->first();

        return view('blogger.dashboard', [
            'lessons' => $lessons,
            'promo' => $promo,
            'cabinetPresaleMode' => SiteSetting::cabinetPresaleMode(),
        ]);
    }
}
