@extends('dashboard')

@section('main')
<div class="p-6 md:p-8">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-white">Visual Novels</h1>
        <a href="{{ route('staff.novels.create') }}"
           class="rounded-lg bg-blue-400 px-4 py-2 text-sm font-semibold text-black hover:bg-blue-300">
            + New Novel
        </a>
    </div>

    @if (session('status'))
        <div class="mb-4 rounded-lg bg-green-900/40 border border-green-700 px-4 py-3 text-sm text-green-200">
            {{ session('status') }}
        </div>
    @endif

    @if ($novels->isEmpty())
        <p class="text-gray-400">No visual novels yet. Add one to get started.</p>
    @else
        <div class="overflow-x-auto rounded-xl border border-gray-700">
            <table class="w-full text-sm">
                <thead class="bg-gray-800 text-gray-400 text-left">
                    <tr>
                        <th class="px-4 py-3 font-medium">Title</th>
                        <th class="px-4 py-3 font-medium">Developer</th>
                        <th class="px-4 py-3 font-medium">Release</th>
                        <th class="px-4 py-3 font-medium text-right">Reviews</th>
                        <th class="px-4 py-3 font-medium text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700">
                    @foreach ($novels as $novel)
                        <tr class="bg-gray-800/50">
                            <td class="px-4 py-3 text-white">
                                <a href="{{ route('novels.show', $novel) }}" class="hover:text-blue-400">
                                    {{ $novel->title }}
                                </a>
                            </td>
                            <td class="px-4 py-3 text-gray-300">{{ $novel->developer }}</td>
                            <td class="px-4 py-3 text-gray-400">
                                {{ $novel->release_date?->format('Y-m-d') ?? '—' }}
                            </td>
                            <td class="px-4 py-3 text-gray-400 text-right">{{ $novel->ratings_count }}</td>
                            <td class="px-4 py-3 text-right whitespace-nowrap">
                                <a href="{{ route('staff.novels.edit', $novel) }}"
                                   class="text-blue-400 hover:text-blue-300 mr-3">Edit</a>
                                <form method="POST" action="{{ route('staff.novels.destroy', $novel) }}" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="text-red-400 hover:text-red-300"
                                            data-confirm="Delete '{{ $novel->title }}'?">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-6">{{ $novels->links() }}</div>
    @endif
</div>
@endsection
