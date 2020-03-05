<?php
namespace app\Http\Controllers;

use App\Http\Controllers\Controller;

class PaymentsController extends Controller
{
    public function index()
    {
        return view('pages.backend.documents');
    }
}

