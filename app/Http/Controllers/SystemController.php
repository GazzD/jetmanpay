<?php

namespace App\Http\Controllers;

use App\System;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;

class SystemController extends Controller
{
    public function __construct()
    {
        //Intialize the system balance if it wasn't initializated yet
        $system = System::where('status','ACTIVE')->first();
        if(!$system){
            $system = new System();
            $system->save();
        }
    }

    public function index(){
        $system = System::where('status','ACTIVE')->first();
        return view('pages.backend.system.index')
            ->with('system',$system)
            ;
    }

    public function fetch(){
        $system = System::all();

         // Return datatable
         return DataTables::of($system)->make(true);
    }

}
