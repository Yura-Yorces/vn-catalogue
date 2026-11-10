<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(): View
    {
        return view('profile.edit', ['user' => auth()->user()]);
    }

    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();
        $this->authorize('update', $user);

        $data = $request->validate([
            'nickname' => ['required', 'string', 'max:255'],
        ]);

        $user->update($data);

        return back()->with('success', 'Display name updated.');
    }
}
