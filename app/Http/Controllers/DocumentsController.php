<?php
namespace app\Http\Controllers;

use App\Http\Controllers\Controller;

class DocumentsController extends Controller
{
    public function index()
    {
        return view('pages.backend.documents');
    }
}

