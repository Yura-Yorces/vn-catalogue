@extends('dashboard')

@section('main')
<div class="p-6 md:p-8">
    <h1 class="text-2xl font-bold text-white mb-1">My Reviews</h1>
    <p class="text-gray-400 mb-6">Every novel you've rated or reviewed.</p>

    @if ($ratings->isEmpty())
        <p class="text-gray-400">
            You haven't rated any novels yet.
            <a href="{{ route('novels.index') }}" class="text-blue-400 hover:text-blue-300">Browse the collection</a>.
        </p>
    @else
        <ul class="space-y-3 max-w-3xl">
            @foreach ($ratings as $rating)
                <li class="bg-gray-800 border border-gray-700 rounded-xl p-4">
                    <div class="flex items-center justify-between mb-2 gap-4 flex-wrap">
                        <a href="{{ route('novels.show', $rating->visualNovel) }}"
                           class="font-medium text-white hover:text-blue-400">
                            {{ $rating->visualNovel->title }}
                        </a>
                        <span class="text-yellow-400 font-semibold shrink-0">
                            {{ $rating->rating }} / 10
                        </span>
                    </div>
                    @if ($rating->review)
                        <p class="text-gray-300 text-sm whitespace-pre-line">{{ $rating->review }}</p>
                    @endif
                    <p class="text-xs text-gray-500 mt-2">{{ $rating->created_at->diffForHumans() }}</p>
                </li>
            @endforeach
        </ul>

        <div class="mt-6">{{ $ratings->links() }}</div>
    @endif
</div>
@endsection
