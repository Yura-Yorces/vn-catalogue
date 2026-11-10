@extends('dashboard')

@section('main')
<div class="p-6 md:p-8 max-w-2xl">
    <a href="{{ route('staff.novels.index') }}"
       class="text-sm text-gray-400 hover:text-gray-200">&larr; Back to visual novels</a>

    <h1 class="text-2xl font-bold text-white mt-3 mb-6">
        {{ $novel->exists ? 'Edit Visual Novel' : 'New Visual Novel' }}
    </h1>

    @if ($errors->any())
        <div class="mb-4 rounded-lg bg-red-900/40 border border-red-700 px-4 py-3 text-sm text-red-200">
            <ul class="list-disc list-inside space-y-1">
                @foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach
            </ul>
        </div>
    @endif

    <form method="POST"
          action="{{ $novel->exists ? route('staff.novels.update', $novel) : route('staff.novels.store') }}"
          class="space-y-4 bg-gray-800 border border-gray-700 rounded-xl p-6">
        @csrf
        @if ($novel->exists) @method('PATCH') @endif

        <div>
            <label class="block text-sm font-medium text-gray-300 mb-1">Title</label>
            <input name="title" type="text" value="{{ old('title', $novel->title) }}" required
                   class="w-full rounded-lg bg-gray-900 border border-gray-700 px-3 py-2 text-gray-100 focus:border-blue-400 focus:ring-blue-400">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-300 mb-1">Cover image URL <span class="text-gray-500">(optional)</span></label>
            <input name="cover_image" type="url"
                value="{{ old('cover_image', $novel->cover_image) }}"
                placeholder="https://placehold.co/300"
                class="w-full rounded-lg bg-gray-900 border border-gray-700 px-3 py-2 text-gray-100 placeholder-gray-600 focus:border-blue-400 focus:ring-blue-400">
        </div>


        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-1">Developer</label>
                <input name="developer" type="text" value="{{ old('developer', $novel->developer) }}" required
                       class="w-full rounded-lg bg-gray-900 border border-gray-700 px-3 py-2 text-gray-100 focus:border-blue-400 focus:ring-blue-400">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-1">Publisher <span class="text-gray-500">(optional)</span></label>
                <input name="publisher" type="text" value="{{ old('publisher', $novel->publisher) }}"
                       class="w-full rounded-lg bg-gray-900 border border-gray-700 px-3 py-2 text-gray-100 focus:border-blue-400 focus:ring-blue-400">
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-300 mb-1">Release date <span class="text-gray-500">(optional)</span></label>
            <input name="release_date" type="date"
                   value="{{ old('release_date', $novel->release_date?->format('Y-m-d')) }}"
                   class="w-full rounded-lg bg-gray-900 border border-gray-700 px-3 py-2 text-gray-100 focus:border-blue-400 focus:ring-blue-400">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-300 mb-1">Description <span class="text-gray-500">(optional)</span></label>
            <textarea name="description" rows="5"
                      class="w-full rounded-lg bg-gray-900 border border-gray-700 px-3 py-2 text-gray-100 focus:border-blue-400 focus:ring-blue-400">{{ old('description', $novel->description) }}</textarea>
        </div>

        <div class="flex items-center gap-3 pt-2">
            <button type="submit"
                    class="rounded-lg bg-blue-400 px-4 py-2 text-sm font-semibold text-black hover:bg-blue-300">
                {{ $novel->exists ? 'Save changes' : 'Create novel' }}
            </button>
            <a href="{{ route('staff.novels.index') }}"
               class="text-sm text-gray-400 hover:text-gray-200">Cancel</a>
        </div>
    </form>
</div>
@endsection
