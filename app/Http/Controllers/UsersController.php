<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Role;

class UsersController extends Controller
{
    public function index(Request $request){
        $users = User::all();
        return view('pages.backend.users.index')
            ->with('users',$users)
            ;
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
