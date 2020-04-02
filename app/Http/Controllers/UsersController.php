<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Hash;
use App\User;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class UsersController extends Controller
{
    public function index(Request $request){
        // Display view
        return view('pages.backend.users.index');
    }
    
    public function profile(Request $request){
        // Realod current user
        $user = User::find(Auth::user()->id);
        
        // Display view
        return view('pages.backend.users.profile')
            ->with('user', $user)
        ;
    }
    
    public function changePassword(Request $request)
    {
        // Validate data
        $request->validate([
            'password' => 'required',
            'passwordConfirmation' => 'required|same:password',
        ]);
        $user = User::find(Auth::user()->id);
        $user->password = Hash::make($request->password);
        $user->save();
        
        // Redirect to profile
        return redirect()->route('users/profile');
        
    }
    
    public function editProfile(Request $request){
        // Realod current user
        $user = User::find(Auth::user()->id);
        
        // Display view
        return view('pages.backend.users.edit-profile')
            ->with('user', $user)
        ;
    }
    
    public function updateProfile(Request $request)
    {
        // Validate data
        $request->validate([
            'name' => 'required|max:255',
            'phone' => 'required|max:255',
            'addressLine1' => 'required|max:255',
            'zipCode' => 'required|max:255',
            'country' => 'required|max:255',
            'state' => 'required|max:255',
        ]);
        
        // Realod current user
        $user = User::find(Auth::user()->id);
        
        // Update data
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->country = $request->country;
        $user->state = $request->state;
        $user->zip_code = $request->zipCode;
        $user->address_line1 = $request->addressLine1;
        $user->address_line2 = $request->addressLine2;
        
        // Store record
        $user->save();
        
        // Redirect to profiles
        return redirect()->route('users/profile');
        
    }

    public function create(Request $request){
        // Find roles
        $roles = Role::where('name', 'MANAGER')->orWhere('name', 'OPERATOR')->get();
        
        // Render view
        return view('pages.backend.users.create')
            ->with('roles', $roles)
        ;
    }

    public function store(Request $request)
    {
        // Validate
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'passwordConfirmation' => 'required|same:password',
            'roleId' => 'required',
        ]);
        
        // Create new user
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role_id = $request->roleId;
        
        // Store record
        $user->save();
        
        // Redirect to list
        return redirect()->route('users');

    }

    public function fetch()
    {
        // Assign first role
        $users = User::with('roles')->get();
        foreach ($users as $i => $user) {
            $users[$i]->role = __('messages.'.strtolower($users[$i]->roles[0]->name));
        }
        
        // Return datatable
        return DataTables::of($users)->make(true);
    }
}
