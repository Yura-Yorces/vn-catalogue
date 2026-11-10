<?php

namespace App\Http\Controllers;

use App\Models\VisualNovel;
use App\Http\Requests\StoreVisualNovelRequest;
use App\Http\Requests\UpdateVisualNovelRequest;
use Illuminate\View\View;

class VisualNovelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        //
        $novels = VisualNovel::query()
            ->withAvg('ratings', 'rating')
            ->withCount('ratings')
            ->orderBy('title')
            ->paginate(10);

        return view('novels.index', compact('novels'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreVisualNovelRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(VisualNovel $visualNovel): View
    {
        $visualNovel->load([
            'ratings' => fn ($q) => $q->with('user', 'replies.user')->latest(),
        ]);

        $average = $visualNovel->ratings->avg('rating');
        $count = $visualNovel->ratings->count();

        $userRating = auth()->check()
            ? $visualNovel->ratings->firstWhere('user_id', auth()->id())
            : null;

        $isFavorited = auth()->check()
            && auth()->user()->favorites()
                ->where('visual_novels.id', $visualNovel->id)
                ->exists();

        return view('novels.show', compact(
            'visualNovel', 'average', 'count', 'userRating', 'isFavorited'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(VisualNovel $visualNovel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateVisualNovelRequest $request, VisualNovel $visualNovel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(VisualNovel $visualNovel)
    {
        //
    }
}
