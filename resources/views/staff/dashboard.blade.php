@extends('dashboard')

@section('main')
<div class="p-6 md:p-8">
    <h1 class="text-2xl font-bold text-white mb-1">Staff Panel</h1>
    <p class="text-gray-400 mb-6">
        Signed in as {{ auth()->user()->nickname }}
        <span @class([
            'ml-2 text-xs uppercase tracking-wide px-2 py-0.5 rounded',
            'bg-purple-500/20 text-purple-300' => auth()->user()->isAdmin(),
            'bg-blue-500/20 text-blue-300' => ! auth()->user()->isAdmin(),
        ])>
            {{ auth()->user()->role }}
        </span>
    </p>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        @foreach ([
            ['label' => 'Visual Novels', 'count' => $novelsCount, 'url' => route('staff.novels.index')],
            ['label' => 'Active Users', 'count' => $usersCount,  'url' => null],
            ['label' => 'Ratings', 'count' => $ratingsCount,'url' => null],
        ] as $stat)
            @php $isLink = (bool) $stat['url']; @endphp

            <{{ $isLink ? 'a' : 'div' }}
                @if ($isLink) href="{{ $stat['url'] }}" @endif
                @class([
                    'bg-gray-800 border border-gray-700 rounded-xl p-5',
                    'hover:border-blue-400 transition' => $isLink,
                ])>
                <div class="text-sm text-gray-400">{{ $stat['label'] }}</div>
                <div class="text-3xl font-bold text-white mt-1">{{ $stat['count'] }}</div>
            </{{ $isLink ? 'a' : 'div' }}>
        @endforeach
    </div>
</div>
@endsection
