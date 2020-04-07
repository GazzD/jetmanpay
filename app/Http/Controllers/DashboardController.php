<?php
namespace app\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Notification;

class DashboardController extends Controller
{
    public function index()
    {
        // Validate user
        if (auth()->user()->hasRole('CLIENT'))
            $notifications = Notification::where('user_id', auth()->user()->id)->latest()->limit(10)->get();
        else
            $notifications = Notification::where('user_id', null)->latest()->limit(10)->get();
                
        return view('pages.backend.dashboard')
            ->with('notifications', $notifications)
        ;
    }
}

