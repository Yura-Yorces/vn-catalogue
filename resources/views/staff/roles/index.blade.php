@extends('dashboard')

@section('main')
<div class="p-6 md:p-8">
    <h1 class="text-2xl font-bold text-white mb-1">Roles</h1>
    <p class="text-gray-400 mb-6">Promote or demote users. Your own role cannot be changed.</p>

    @if (session('status'))
        <div class="mb-4 rounded-lg bg-green-900/40 border border-green-700 px-4 py-3 text-sm text-green-200">
            {{ session('status') }}
        </div>
    @endif

    @if ($users->isEmpty())
        <p class="text-gray-400">No users.</p>
    @else
        <div class="overflow-x-auto rounded-xl border border-gray-700">
            <table class="w-full text-sm">
                <thead class="bg-gray-800 text-gray-400 text-left">
                    <tr>
                        <th class="px-4 py-3 font-medium">Username</th>
                        <th class="px-4 py-3 font-medium">Nickname</th>
                        <th class="px-4 py-3 font-medium">Current role</th>
                        <th class="px-4 py-3 font-medium text-right">Change</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700">
                    @foreach ($users as $user)
                        <tr class="bg-gray-800/50">
                            <td class="px-4 py-3 text-white">
                                {{ $user->username }}
                                @if ($user->id === auth()->id())
                                    <span class="text-xs text-gray-500 ml-1">(you)</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-gray-300">{{ $user->nickname }}</td>
                            <td class="px-4 py-3">
                                <span class="text-xs uppercase tracking-wide px-2 py-0.5 rounded
                                    @if ($user->role === \App\Models\User::ROLE_ADMIN) bg-purple-500/20 text-purple-300
                                    @elseif ($user->role === \App\Models\User::ROLE_MODERATOR) bg-blue-500/20 text-blue-300
                                    @else bg-gray-500/20 text-gray-400
                                    @endif">
                                    {{ $user->role }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-right whitespace-nowrap">
                                @if ($user->id === auth()->id())
                                    <span class="text-xs text-gray-500">You cannot change your own role.</span>
                                @else
                                    @can('changeRole', $user)
                                        <form method="POST" action="{{ route('staff.roles.update', $user) }}" class="inline-flex items-center gap-2">
                                            @csrf
                                            @method('PATCH')
                                            <select name="role"
                                                    data-confirm-label
                                                    class="rounded-lg bg-gray-900 border border-gray-700 px-2 py-1 text-gray-100 text-sm focus:border-blue-400 focus:ring-blue-400">
                                                @foreach ($roles as $role)
                                                    <option value="{{ $role }}" @selected($user->role === $role)>{{ $role }}</option>
                                                @endforeach
                                            </select>
                                            <button type="submit"
                                                    class="rounded-md bg-blue-400 px-3 py-1 text-xs font-semibold text-black hover:bg-blue-300"
                                                    data-confirm="Change {{ $user->nickname }}'s role to %s?">
                                                Save
                                            </button>
                                        </form>
                                    @endcan
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-6">{{ $users->links() }}</div>
    @endif
</div>
@endsection
