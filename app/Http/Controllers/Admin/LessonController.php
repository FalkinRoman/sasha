<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lesson;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class LessonController extends Controller
{
    public function index(): View
    {
        $lessons = Lesson::query()->orderBy('course_slug')->orderBy('order_index')->get();

        return view('admin.lessons.index', compact('lessons'));
    }

    public function create(): View
    {
        return view('admin.lessons.create');
    }

    public function store(Request $request): RedirectResponse|JsonResponse
    {
        $this->validateOptionalVideoUpload($request);

        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'video_url' => ['nullable', 'string', 'max:2048'],
        ]);

        if (! $request->hasFile('video_file') && ! filled($data['video_url'])) {
            throw ValidationException::withMessages([
                'video_file' => 'Загрузите видеофайл или укажите ссылку в блоке «Дополнительно».',
            ]);
        }

        $data['course_slug'] = 'modern-yoga';
        $data['slug'] = $this->uniqueSlugFromTitle($data['title']);
        $data['duration_minutes'] = 25;
        $data['subtitle'] = null;
        $data['short_description'] = null;
        $data['body'] = null;
        $data['calories_estimate'] = null;
        $data['is_preview_free'] = $request->boolean('is_preview_free');

        if ($request->hasFile('video_file')) {
            $data['video_path'] = $request->file('video_file')->store('lessons', 'public');
        }

        $maxOrder = (int) Lesson::query()
            ->where('course_slug', $data['course_slug'])
            ->max('order_index');

        Lesson::query()->create([
            ...$data,
            'order_index' => $maxOrder + 1,
        ]);

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Урок добавлен в курс.',
                'redirect' => route('admin.lessons.index'),
            ]);
        }

        return redirect()->route('admin.lessons.index')->with('ok', 'Урок добавлен в курс.');
    }

    private function uniqueSlugFromTitle(string $title): string
    {
        $base = Str::slug($title);
        if ($base === '') {
            $base = 'lesson-'.Str::lower(Str::random(8));
        }

        $slug = $base;
        $n = 0;
        while (Lesson::query()->where('slug', $slug)->exists()) {
            $n++;
            $slug = $base.'-'.$n;
        }

        return $slug;
    }

    public function edit(Lesson $lesson): View
    {
        return view('admin.lessons.edit', compact('lesson'));
    }

    public function update(Request $request, Lesson $lesson): RedirectResponse|JsonResponse
    {
        $this->validateOptionalVideoUpload($request);
        $data = $this->validated($request, $lesson);

        if ($request->boolean('remove_video_file')) {
            $this->deleteLessonVideoFromDisk($lesson);
            $data['video_path'] = null;
        }

        if ($request->hasFile('video_file')) {
            $this->deleteLessonVideoFromDisk($lesson);
            $data['video_path'] = $request->file('video_file')->store('lessons', 'public');
        }

        if ($request->boolean('remove_cover_image')) {
            $this->deleteLessonCoverFromDisk($lesson);
            $data['cover_image_path'] = null;
        }

        if ($request->hasFile('cover_image')) {
            $request->validate([
                'cover_image' => ['required', 'image', 'max:10240'],
            ]);
            $this->deleteLessonCoverFromDisk($lesson);
            $data['cover_image_path'] = $request->file('cover_image')->store('lesson-covers', 'public');
        }

        $data['released_at'] = $request->filled('released_at') ? $request->date('released_at') : null;

        $lesson->update($data);

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Сохранено.',
                'redirect' => route('admin.lessons.index'),
            ]);
        }

        return redirect()->route('admin.lessons.index')->with('ok', 'Сохранено.');
    }

    public function destroy(Lesson $lesson): RedirectResponse
    {
        $this->deleteLessonVideoFromDisk($lesson);
        $this->deleteLessonCoverFromDisk($lesson);
        $lesson->delete();

        return redirect()->route('admin.lessons.index')->with('ok', 'Урок удалён.');
    }

    private function validateOptionalVideoUpload(Request $request): void
    {
        if (! $request->hasFile('video_file')) {
            return;
        }

        $maxKb = (int) config('prostoy.lesson_video_max_mb', 2048) * 1024;

        $request->validate([
            'video_file' => [
                'required',
                'file',
                'max:'.$maxKb,
                'mimetypes:video/mp4,video/webm,video/quicktime,video/ogg',
            ],
        ]);
    }

    private function deleteLessonVideoFromDisk(Lesson $lesson): void
    {
        if (! $lesson->hasServerVideo()) {
            return;
        }

        Storage::disk('public')->delete($lesson->video_path);
    }

    private function deleteLessonCoverFromDisk(Lesson $lesson): void
    {
        if (! is_string($lesson->cover_image_path) || $lesson->cover_image_path === '') {
            return;
        }

        Storage::disk('public')->delete($lesson->cover_image_path);
    }

    /**
     * @return array<string, mixed>
     */
    private function validated(Request $request, ?Lesson $lesson): array
    {
        $slugRule = Rule::unique('lessons', 'slug');
        if ($lesson !== null) {
            $slugRule = $slugRule->ignore($lesson->id);
        }

        $rules = [
            'course_slug' => ['required', 'string', 'max:64'],
            'slug' => ['required', 'string', 'max:255', 'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/', $slugRule],
            'title' => ['required', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string', 'max:255'],
            'short_description' => ['nullable', 'string'],
            'body' => ['nullable', 'string'],
            'duration_minutes' => ['required', 'integer', 'min:1', 'max:600'],
            'calories_estimate' => ['nullable', 'integer', 'min:0', 'max:5000'],
            'video_url' => ['nullable', 'string', 'max:2048'],
        ];
        if ($lesson !== null) {
            $rules['order_index'] = ['required', 'integer', 'min:0', 'max:255'];
        }

        $data = $request->validate($rules);
        $data['is_preview_free'] = $request->boolean('is_preview_free');

        return $data;
    }
}
