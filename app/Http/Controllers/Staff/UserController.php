<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Carbon;

class UserController extends Controller
{
    //
    public function index(): View
    {
        $users = User::withTrashed()
            ->orderByRaw('deleted_at IS NOT NULL')
            ->orderBy('username')
            ->paginate(20);

        return view('staff.users.index', compact('users'));
    }

    public function ban(Request $request, int $id): RedirectResponse
{
    $user = User::findOrFail($id);
    $this->authorize('ban', $user);

    $data = $request->validate([
        'reason'   => ['nullable', 'string', 'max:1000'],
        'duration' => ['required', 'in:1d,3d,7d,30d,permanent'],
    ]);

    $bannedUntil = match ($data['duration']) {
        '1d'        => Carbon::now()->addDay(),
        '3d'        => Carbon::now()->addDays(3),
        '7d'        => Carbon::now()->addWeek(),
        '30d'       => Carbon::now()->addDays(30),
        'permanent' => null,
    };
    
    $user->forceFill([
        'banned_until' => $bannedUntil,
        'ban_reason'   => $data['reason'],
    ])->save();

    $user->delete();

    $when = $bannedUntil ? "until {$bannedUntil->toDayDateTimeString()}" : 'permanently';

    return back()->with('success', "{$user->nickname} banned {$when}.");
}

    public function restore(int $id): RedirectResponse
    {
        $user = User::withTrashed()->findOrFail($id);
        $this->authorize('restore', $user);

        $user->forceFill([
            'banned_until' => null,
            'ban_reason' => null,
        ])->save();
        $user->restore();

        return back()->with('success', "{$user->nickname} restored.");
    }
}
