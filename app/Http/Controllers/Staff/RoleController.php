<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class RoleController extends Controller
{
    //
    public function index(): View
    {
        $users = User::orderBy('username')->paginate(20);

        $roles = [
            User::ROLE_USER,
            User::ROLE_MODERATOR,
            User::ROLE_ADMIN,
        ];

        return view('staff.roles.index', compact('users', 'roles'));
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $this->authorize('changeRole', $user);

        $data = $request->validate([
            'role' => ['required', Rule::in([
                User::ROLE_USER,
                User::ROLE_MODERATOR,
                User::ROLE_ADMIN,
            ])],
        ]);

        $user->update([
            'role' => $data['role'],
        ]);

        return back()->with('success', "{$user->nickname} is now a {$user->role}.");
    }
}
