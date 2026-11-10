<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRatingRequest;
use App\Models\VisualNovel;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Models\Rating;

class RatingController extends Controller
{
    public function store(StoreRatingRequest $request, VisualNovel $visualNovel): RedirectResponse
    {
        $this->authorize('create', Rating::class);

        $visualNovel->ratings()->updateOrCreate(
            ['user_id' => $request->user()->id],
            [
                'rating' => $request->integer('rating'),
                'review' => $request->input('review'),
            ],
        );

        return back()->with('success', 'Your review has been saved.');
    }

    public function destroy(VisualNovel $visualNovel): RedirectResponse
    {
        $rating = $visualNovel->ratings()
            ->where('user_id', request()->user()->id)
            ->first();

        if ($rating) {
            $this->authorize('delete', $rating);
            $rating->delete();
        }

        return back()->with('success', 'Your review has been removed.');
    }

    public function mine()
    {
        $ratings = auth()->user()->ratings()
            ->with('visualNovel')
            ->latest()
            ->paginate(12);

        return view('profile.my-rating', compact('ratings'));
    }
}
