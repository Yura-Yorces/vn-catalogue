<?php

namespace App\Http\Controllers;

use App\Models\ReviewReply;
use App\Models\Rating;
use App\Http\Requests\StoreReviewReplyRequest;
use App\Http\Requests\UpdateReviewReplyRequest;
use Illuminate\Http\RedirectResponse;

class ReviewReplyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(StoreReviewReplyRequest $request, Rating $rating): RedirectResponse
    {
        $this->authorize('create', ReviewReply::class);

        $rating->replies()->create([
            'user_id' => $request->user()->id,
            'body' => $request->string('body'),
        ]);

        return back()->with('success', 'Reply posted');
    }

    /**
     * Display the specified resource.
     */
    public function show(ReviewReply $reviewReply)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ReviewReply $reviewReply)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateReviewReplyRequest $request, ReviewReply $reviewReply)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ReviewReply $reviewReply)
    {
        $this->authorize('delete', $reviewReply);
        $reviewReply->delete();

        return back()->with('success', 'Reply deleted');
    }
}
