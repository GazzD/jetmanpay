<?php

namespace App\Http\Controllers;

use App\Plane;
use App\Client;
use Illuminate\Http\Request;

class ClientsController extends Controller
{
    public function fetchByPlane(Request $request, $id)
    {
        $plane = Plane::where('id', $id)
            ->with('client')
            ->first()
            ;
        return($plane->client);
    }
}
