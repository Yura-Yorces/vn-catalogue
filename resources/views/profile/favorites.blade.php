@extends('dashboard')

@section('main')
<div class="p-6 md:p-8">
    <h1 class="text-2xl font-bold text-white mb-1">My Favorites</h1>
    <p class="text-gray-400 mb-6">Visual novels you've bookmarked.</p>

    @if (session('success'))
        <div class="mb-4 rounded-lg bg-green-900/40 border border-green-700 px-4 py-3 text-sm text-green-200">
            {{ session('success') }}
        </div>
    @endif

    @if ($favorites->isEmpty())
        <p class="text-gray-400">
            You haven't favorited any novels yet.
            <a href="{{ route('novels.index') }}" class="text-blue-400 hover:text-blue-300">Browse the collection</a>.
        </p>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
            @foreach ($favorites as $novel)
                <a href="{{ route('novels.show', $novel) }}"
                   class="bg-gray-800 border border-gray-700 rounded-xl p-4 hover:border-yellow-400/40 transition flex flex-col">
                    <h2 class="font-semibold text-white text-lg leading-tight mb-1">
                        {{ $novel->title }}
                    </h2>
                    <p class="text-sm text-gray-400 mb-3">{{ $novel->developer }}</p>

                    <div class="mt-auto flex items-center justify-between text-sm">
                        <span class="text-yellow-400">
                            @if ($novel->ratings_avg_rating)
                                {{ number_format($novel->ratings_avg_rating, 1) }} / 10
                            @else
                                <span class="text-gray-500">No ratings</span>
                            @endif
                        </span>
                        <span class="text-gray-500">
                            {{ $novel->ratings_count }} {{ Str::plural('review', $novel->ratings_count) }}
                        </span>
                    </div>
                </a>
            @endforeach
        </div>

        <div class="mt-8">{{ $favorites->links() }}</div>
    @endif
</div>
@endsection
