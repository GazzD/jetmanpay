<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Role;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    public function index(Request $request){
        $users = User::all();
        return view('pages.backend.users.index')
            ->with('users',$users)
        ;
    }
    
    public function profile(Request $request){
        $user = User::find(Auth::user()->id);
        
        return view('pages.backend.users.profile')
            ->with('user', $user)
        ;
    }
    
    public function changePassword(Request $request)
    {
        $request->validate([
            'password' => 'required',
            'passwordConfirmation' => 'required|same:password',
        ]);
        $password = $request->password;
        $user = User::find(Auth::user()->id);
        $user->password = Hash::make($password);
        $user->save();
        
        return redirect()->route('users/profile');
        
    }
    
    public function editProfile(Request $request){
        $user = User::find(Auth::user()->id);
        
        return view('pages.backend.users.edit-profile')
        ->with('user', $user)
        ;
    }
    
    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'phone' => 'required|max:255',
            'addressLine1' => 'required|max:255',
            'zipCode' => 'required|max:255',
            'country' => 'required|max:255',
            'state' => 'required|max:255',
        ]);
        $name = $request->name;
        $phone = $request->phone;
        $country = $request->country;
        $state = $request->state;
        $zipCode = $request->zipCode;
        $addressLine1 = $request->addressLine1;
        $addressLine2 = $request->addressLine2;
        
        $user = User::find(Auth::user()->id);
//         dd($user, $request->all());
        $user->name = $name;
        $user->phone = $phone;
        $user->country = $country;
        $user->state = $state;
        $user->zip_code = $zipCode;
        $user->name = $name;
        $user->address_line1 = $addressLine1;
        $user->address_line2 = $addressLine2;
        
        $user->save();
        
        return redirect()->route('users/profile');
        
    }

    public function create(Request $request){
        $roles = Role::all();
        return view('pages.backend.users.create')
            ->with('roles', $roles)
            ;
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'passwordConfirmation' => 'required|same:password',
            'roleId' => 'required',
        ]);
        $name = $request->name;
        $email = $request->email;
        $password = $request->password;
        $roleId = $request->roleId;

        $user = new User();
        $user->name = $name;
        $user->email = $email;
        $user->password = Hash::make($password);
        $user->role_id = $roleId;
        $user->save();

        return redirect()->route('users');

    }

    public function fetch()
    {
        return DataTables::of(
            User::with('role')
            ->get()
        )
        ->make(true)
        ;
    }
}
