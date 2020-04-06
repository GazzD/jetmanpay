<?php
namespace app\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Notification;

class DashboardController extends Controller
{
    public function index()
    {
        $notifications = Notification::latest()->limit(10)->get();
        
        return view('pages.backend.dashboard')
            ->with('notifications', $notifications)
        ;
    }
}

