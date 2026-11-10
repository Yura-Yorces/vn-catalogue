@extends('dashboard')

@section('main')
<div class="p-6 md:p-8">
    <h1 class="text-2xl font-bold text-white mb-6">Visual Novels</h1>

    @if ($novels->isEmpty())
        <p class="text-gray-400">No visual novels yet.</p>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">
            @foreach ($novels as $novel)
                <a href="{{ route('novels.show', $novel) }}"
                   class="bg-gray-800 border border-gray-700 rounded-xl p-4 hover:border-blue-400 transition flex gap-4">

                    @if ($novel->cover_image)
                        <img src="{{ $novel->cover_image }}"
                             alt="{{ $novel->title }}"
                             class="w-24 h-36 object-cover rounded-lg bg-gray-900 shrink-0"
                             loading="lazy">
                    @endif

                    <div class="flex flex-col flex-1 min-w-0">
                        <h2 class="font-semibold text-white text-lg leading-tight mb-1 line-clamp-2">
                            {{ $novel->title }}
                        </h2>

                        <p class="text-sm text-gray-400">{{ $novel->developer }}</p>

                        @if ($novel->publisher && $novel->publisher !== $novel->developer)
                            <p class="text-sm text-gray-500">{{ $novel->publisher }}</p>
                        @endif

                        <div class="mt-auto flex items-center justify-between text-sm pt-3">
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
                    </div>
                </a>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $novels->links() }}
        </div>
    @endif
</div>
@endsection
