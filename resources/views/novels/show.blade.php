@extends('dashboard')

@section('main')
<div class="hide-scrollbar w-full min-w-0 max-w-6xl mx-auto box-border px-4 py-6 sm:px-6 md:px-8 overflow-x-hidden">
    <a href="{{ route('novels.index') }}"
       class="text-sm text-gray-400 hover:text-gray-200">&larr; Back to all novels</a>

    @if (session('success'))
        <div class="mt-4 rounded-lg bg-green-900/40 border border-green-700 px-4 py-3 text-sm text-green-200">
            {{ session('success') }}
        </div>
    @endif

    <div class="mt-4 bg-gray-800 border border-gray-700 rounded-xl p-6">
        <div class="flex items-start gap-6 flex-wrap">
            @if ($visualNovel->cover_image)
                <img src="{{ $visualNovel->cover_image }}" alt="{{ $visualNovel->title }}"
                     class="w-32 h-44 object-cover rounded-lg bg-gray-900 shrink-0"
                     onerror="this.style.display='none'">
            @endif

            <div class="flex-1 min-w-0">
                <div class="flex items-start justify-between gap-4 flex-wrap">
                    <div>
                        <h1 class="text-3xl font-bold text-white">{{ $visualNovel->title }}</h1>
                        <p class="text-gray-400 mt-1">
                            {{ $visualNovel->developer }}
                            @if ($visualNovel->publisher && $visualNovel->publisher !== $visualNovel->developer)
                                &middot; {{ $visualNovel->publisher }}
                            @endif
                            @if ($visualNovel->release_date)
                                &middot; {{ $visualNovel->release_date->format('Y') }}
                            @endif
                        </p>
                    </div>

                    @auth
                        <form method="POST" action="{{ route('favorites.store', $visualNovel) }}">
                            @csrf
                            <button type="submit"
                                    class="rounded-md px-3 py-1.5 text-sm font-semibold border transition
                                        {{ $isFavorited
                                            ? 'bg-yellow-400/20 border-yellow-400/40 text-yellow-300 hover:bg-yellow-400/30'
                                            : 'bg-gray-900 border-gray-700 text-gray-300 hover:border-yellow-400/40 hover:text-yellow-300' }}">
                                {{ $isFavorited ? '★ Favorited' : '☆ Favorite' }}
                            </button>
                        </form>
                    @endauth
                </div>

                <div class="mt-3 flex items-center gap-4 text-sm">
                    <span class="text-yellow-400 font-semibold">
                        @if ($average) {{ number_format($average, 1) }} / 10 @else No ratings yet @endif
                    </span>
                    <span class="text-gray-500">{{ $count }} {{ Str::plural('review', $count) }}</span>
                </div>
            </div>
        </div>

        @if ($visualNovel->description)
            <p class="mt-5 text-gray-300 leading-relaxed">{{ $visualNovel->description }}</p>
        @endif
    </div>

    {{-- Rating form --}}
    <h2 class="text-xl font-semibold text-white mt-8 mb-3">
        {{ $userRating ? 'Edit your review' : 'Rate this novel' }}
    </h2>

    @auth
        @if (auth()->user()->role === \App\Models\User::ROLE_USER)
            <form method="POST" action="{{ route('ratings.store', $visualNovel) }}"
                  class="bg-gray-800 border border-gray-700 rounded-xl p-6 space-y-4">
                @csrf

                @if ($errors->any())
                    <div class="rounded-lg bg-red-900/40 border border-red-700 px-4 py-3 text-sm text-red-200">
                        <ul class="list-disc list-inside space-y-1">
                            @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                        </ul>
                    </div>
                @endif

                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1">Score (1–10)</label>
                    <select name="rating" required
                            class="rounded-lg bg-gray-900 border border-gray-700 px-3 py-2 text-gray-100 focus:border-blue-400 focus:ring-blue-400">
                        @for ($i = 10; $i >= 1; $i--)
                            <option value="{{ $i }}" @selected(old('rating', $userRating?->rating) == $i)>{{ $i }}</option>
                        @endfor
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1">Review <span class="text-gray-500">(optional)</span></label>
                    <textarea name="review" rows="4"
                              class="w-full rounded-lg bg-gray-900 border border-gray-700 px-3 py-2 text-gray-100 focus:border-blue-400 focus:ring-blue-400">{{ old('review', $userRating?->review) }}</textarea>
                </div>

                <div class="flex items-center gap-3">
                    <button type="submit"
                            class="rounded-lg bg-blue-400 px-4 py-2 text-sm font-semibold text-black hover:bg-blue-300">
                        {{ $userRating ? 'Update review' : 'Post review' }}
                    </button>
                </div>
            </form>
        @else
            <p class="text-gray-500 text-sm mb-3">
                Only regular users can post reviews.
            </p>
        @endif

        {{-- the delete-your-own-review block stays outside the @if,
             so a demoted user can still delete their old review --}}
        @if ($userRating)
            <form method="POST" action="{{ route('ratings.destroy', $visualNovel) }}" class="mt-3">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="text-sm text-red-400 hover:text-red-300"
                        data-confirm="Delete your review?">
                    Delete your review
                </button>
            </form>
        @endif
    @else
        <p class="text-gray-500">
            <a href="{{ route('login') }}" class="text-blue-400 hover:text-blue-300">Log in</a>
            to rate and review this visual novel.
        </p>
    @endauth

    {{-- Reviews list --}}
    <h2 class="text-xl font-semibold text-white mt-8 mb-3">Reviews</h2>

    @if ($visualNovel->ratings->isEmpty())
        <p class="text-gray-500">No reviews yet.</p>
    @else
        <ul class="space-y-3">
            @foreach ($visualNovel->ratings as $rating)
                <li class="bg-gray-800 border border-gray-700 rounded-xl p-4
                    {{ auth()->check() && $rating->user_id === auth()->id() ? 'ring-1 ring-blue-400/40' : '' }}">
                    <div class="flex items-center justify-between mb-2">
                        <span class="font-medium text-white">
                            {{ $rating->user?->nickname ?? 'Deleted user' }}
                            @if (auth()->check() && $rating->user_id === auth()->id())
                                <span class="text-xs text-blue-400 ml-1">(you)</span>
                            @endif
                        </span>
                        <span class="text-yellow-400 font-semibold">{{ $rating->rating }} / 10</span>
                    </div>
                    
                    @if ($rating->review)
                        <p class="text-gray-300 text-sm whitespace-pre-line">{{ $rating->review }}</p>
                    @endif
                    <p class="text-xs text-gray-500 mt-2">{{ $rating->created_at->diffForHumans() }}</p>

                    {{-- replies thread --}}
                    @if ($rating->replies->isNotEmpty())
                        <ul class="mt-3 ml-4 space-y-2 border-l-2 border-gray-700 pl-3">
                            @foreach ($rating->replies as $reply)
                                <li class="text-sm">
                                    <span class="text-gray-400 font-medium">
                                        {{ $reply->user?->nickname ?? 'Deleted user' }}
                                    </span>
                                    <span class="text-gray-500 text-xs ml-1">{{ $reply->created_at->diffForHumans() }}</span>

                                    @can('delete', $reply)
                                        <form method="POST" action="{{ route('replies.destroy', $reply) }}" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="text-red-400 hover:text-red-300 text-xs ml-1"
                                                    data-confirm="Delete this reply?">
                                                delete
                                            </button>
                                        </form>
                                    @endcan

                                    <p class="text-gray-300 whitespace-pre-line mt-1">{{ $reply->body }}</p>
                                </li>
                            @endforeach
                        </ul>
                    @endif

                    {{-- reply form (any authenticated user) --}}
                    @auth
                        <form method="POST" action="{{ route('replies.store', $rating) }}"
                            class="mt-3 ml-4 flex gap-2">
                            @csrf
                            <input name="body" type="text" required maxlength="2000"
                                placeholder="Write a reply…"
                                class="flex-1 rounded-lg bg-gray-900 border border-gray-700 px-3 py-1.5 text-sm text-gray-100 focus:border-blue-400 focus:ring-blue-400">
                            <button type="submit"
                                    class="rounded-lg bg-gray-700 px-3 py-1.5 text-xs font-semibold text-white hover:bg-gray-600">
                                Reply
                            </button>
                        </form>
                    @endauth
                </li>
            @endforeach
        </ul>
    @endif
</div>
@endsection
