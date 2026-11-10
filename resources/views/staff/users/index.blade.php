@extends('dashboard')

@section('main')
<div class="p-6 md:p-8">
    <h1 class="text-2xl font-bold text-white mb-1">Users</h1>
    <p class="text-gray-400 mb-6">Ban or restore regular users. Banned users cannot log in.</p>

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
                <th class="px-4 py-3 font-medium">Role</th>
                <th class="px-4 py-3 font-medium">Status</th>
                <th class="px-4 py-3 font-medium text-right">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-700">
            @foreach ($users as $user)
                <tr class="bg-gray-800/50 {{ $user->trashed() ? 'opacity-60' : '' }}">
                    <td class="px-4 py-3 text-white">{{ $user->username }}</td>
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
                    <td class="px-4 py-3">
                        @if ($user->trashed())
                            <span class="text-red-400">Banned</span>
                        @else
                            <span class="text-green-400">Active</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-right whitespace-nowrap align-top">
                        @if ($user->trashed())
                            <div class="text-red-400 text-xs mb-1">
                                @if ($user->banned_until)
                                    Until {{ $user->banned_until->format('Y-m-d H:i') }}
                                    ({{ $user->banned_until->diffForHumans() }})
                                @else
                                    Permanent
                                @endif
                            </div>
                            @if ($user->ban_reason)
                                <div class="text-gray-500 text-xs italic mb-2 max-w-xs ml-auto truncate"
                                    title="{{ $user->ban_reason }}">
                                    “{{ $user->ban_reason }}”
                                </div>
                            @endif

                            @can('restore', $user)
                                <form method="POST" action="{{ route('staff.users.restore', $user->id) }}" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="text-green-400 hover:text-green-300 text-sm">Restore</button>
                                </form>
                            @endcan
                        @else
                            @can('ban', $user)
                                <button type="button"
                                        data-ban-trigger
                                        data-ban-action="{{ route('staff.users.ban', $user->id) }}"
                                        data-ban-nickname="{{ $user->nickname }}"
                                        class="text-red-400 hover:text-red-300 text-sm">
                                    Ban
                                </button>
                            @endcan
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

{{-- Ban modal lives OUTSIDE the scroll container --}}
<div id="ban-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4" aria-modal="true" role="dialog">
    <div class="absolute inset-0 bg-black/60" data-modal-close></div>

    <form id="ban-form" method="POST" action=""
          class="relative w-full max-w-lg bg-gray-900 border border-gray-700 rounded-2xl p-6 space-y-4 shadow-2xl">
        @csrf
        @method('DELETE')

        <div class="flex items-start justify-between gap-4">
            <h2 class="text-white font-semibold text-lg">
                Ban <span id="ban-modal-nickname" class="text-red-400"></span>
            </h2>
            <button type="button" data-modal-close
                    class="text-gray-500 hover:text-gray-300 leading-none text-2xl">&times;</button>
        </div>

        <div class="space-y-1">
            <label for="ban-reason" class="block text-xs font-medium text-gray-400">Reason (optional)</label>
            <textarea id="ban-reason" name="reason" rows="4" placeholder="Why is this user being banned?"
                      class="w-full rounded-lg bg-gray-800 border border-gray-700 px-3 py-2 text-gray-100 text-sm focus:border-blue-400 focus:ring-blue-400"></textarea>
        </div>

        <div class="space-y-1">
            <label for="ban-duration" class="block text-xs font-medium text-gray-400">Duration</label>
            <select id="ban-duration" name="duration"
                    class="w-full rounded-lg bg-gray-800 border border-gray-700 px-3 py-2 text-gray-100 text-sm focus:border-blue-400 focus:ring-blue-400">
                <option value="1d">1 day</option>
                <option value="3d">3 days</option>
                <option value="7d" selected>7 days</option>
                <option value="30d">30 days</option>
                <option value="permanent">Permanent</option>
            </select>
        </div>

        <div class="flex gap-3 pt-2">
            <button type="button" data-modal-close
                    class="flex-1 rounded-lg bg-gray-800 px-4 py-2.5 text-sm font-semibold text-gray-300 hover:bg-gray-700">
                Cancel
            </button>
            <button type="submit"
                    class="flex-1 rounded-lg bg-red-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-red-500"
                    data-confirm="Ban this user?">
                Confirm ban
            </button>
        </div>
    </form>
</div>

        <div class="mt-6">{{ $users->links() }}</div>
    @endif
</div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('ban-modal');
    const form = document.getElementById('ban-form');
    const nickname = document.getElementById('ban-modal-nickname');
    const reason = form.querySelector('[name="reason"]');
    let lastTrigger = null;

    document.querySelectorAll('[data-ban-trigger]').forEach(btn => {
        btn.addEventListener('click', () => {
            lastTrigger = btn;
            form.action = btn.dataset.banAction;
            nickname.textContent = btn.dataset.banNickname;
            form.reset();
            modal.classList.remove('hidden');
            reason.focus();
        });
    });

    const close = () => {
        modal.classList.add('hidden');
        lastTrigger?.focus();
    };

    modal.querySelectorAll('[data-modal-close]').forEach(el =>
        el.addEventListener('click', close));

    document.addEventListener('keydown', e => {
        if (e.key === 'Escape' && !modal.classList.contains('hidden')) close();
    });
});
</script>
