<?php

namespace App\Http\Controllers;

use App\Models\VisualNovel;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class FavoriteController extends Controller
{
    public function index(): View
    {
        $favorites = auth()->user()->favorites()
            ->withAvg('ratings', 'rating')
            ->withCount('ratings')
            ->orderByDesc('favorites.created_at')
            ->paginate(12);

        return view('profile.favorites', compact('favorites'));
    }

    public function store(VisualNovel $visualNovel): RedirectResponse
    {
        $this->authorize('create', \App\Models\Favorite::class);

        $result = request()->user()->favorites()->toggle($visualNovel->id);

        $added = count($result['attached']) > 0;

        return back()->with(
            'success',
            $added ? 'Added to favorites.' : 'Removed from favorites.'
        );
    }
}
