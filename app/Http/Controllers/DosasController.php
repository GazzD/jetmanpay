<?php
namespace app\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Notification;

class DosasController extends Controller
{
    public function index()
    {
        // Validate user
        $notifications = Notification::where('user_id', auth()->user()->id)->latest()->limit(10)->get();
        
        return view('pages.backend.dosas')
            ->with('notifications', $notifications)
        ;
    }
}

