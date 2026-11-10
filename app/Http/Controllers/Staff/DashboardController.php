<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Rating;
use App\Models\VisualNovel;
use App\Models\User;

class DashboardController extends Controller
{
    //
    public function index(): View
    {
        return view('staff.dashboard', [
            'novelsCount' => VisualNovel::count(),
            'usersCount' => User::count(),
            'ratingsCount' => Rating::count(),
        ]);
    }
}
