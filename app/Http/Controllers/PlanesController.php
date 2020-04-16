<?php
namespace app\Http\Controllers;

use App\Plane;
use App\Http\Controllers\Controller;
use function GuzzleHttp\json_decode;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class PlanesController extends Controller
{
    public function index()
    {
        return view('pages.backend.planes.index');
    }
    
    public function fetchPlanes(Request $request)
    {
        // Get clients
        $query = Plane::where('client_id', auth()->user()->client_id)->latest();
        
        // Return datatable
        return DataTables::of($query->get())
            ->make(true)
        ;
    }
}


