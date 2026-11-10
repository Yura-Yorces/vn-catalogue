<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\VisualNovel;
use App\Http\Requests\Staff\VisualNovelRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class VisualNovelController extends Controller
{
    //
    public function index(): View
    {
        $novels = VisualNovel::query()
            ->withAvg('ratings', 'rating')
            ->withCount('ratings')
            ->orderBy('title')
            ->paginate(10);

        return view('staff.novels.index', compact('novels'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $this->authorize('create', VisualNovel::class);

        return view('staff.novels.form', [
            'novel' => new VisualNovel(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(VisualNovelRequest $request): RedirectResponse
    {
        $this->authorize('create', VisualNovel::class);

        $data = $request->validated();
        $data['slug'] = $this->uniqueSlug($data['title']);

        VisualNovel::create($data);

        return redirect()
            ->route('staff.novels.index')
            ->with('success', 'Visual novel created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(VisualNovel $novel): View
    {
        $this->authorize('update', $novel);

        return view('staff.novels.form', compact('novel'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(VisualNovelRequest $request, VisualNovel $novel): RedirectResponse
    {
        $this->authorize('update', $novel);

        $novel->update($request->validated());

        return redirect()
            ->route('staff.novels.index')
            ->with('success', 'Visual novel updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(VisualNovel $novel): RedirectResponse
    {
        $this->authorize('delete', $novel);

        $novel->delete();

        return redirect()
            ->route('staff.novels.index')
            ->with('success', 'Visual novel deleted successfully.');
    }

    protected function uniqueSlug(string $title): string
    {
        $base = Str::slug($title);

        $slug = $base;
        $i = 2;

        while (VisualNovel::where('slug', $slug)->exists()) {
            $slug = "{$base}-{$i}";
            $i++;
        }

        return $slug;
    }
}
