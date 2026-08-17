<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Models\Department;
use App\Models\Category;
use App\Models\Priority;
use App\Models\Notification;
use App\Models\Ticket;
use App\Models\Asset;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'users_count' => User::count(),
            'roles_count' => Role::count(),
            'departments_count' => Department::count(),
            'categories_count' => Category::count(),
            'priorities_count' => Priority::count(),
            'notifications_count' => Notification::count(),
            'tickets_count' => Ticket::count(),
            'assets_count' => Asset::count(),
        ];

        return view('dashboard', compact('stats'));
    }
}
