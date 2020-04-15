<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\User;
use App\StaffProfile;

class StaffController extends Controller
{
    public function store(Request $request)
    {
         // Validate
         $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'passwordConfirmation' => 'required|same:password',
            'identification' => 'required|mimes:jpg,jpeg,png,bmp,tiff |max:4096',
            'license' => 'required|mimes:jpg,jpeg,png,bmp,tiff |max:4096',
            'passport' => 'required|mimes:jpg,jpeg,png,bmp,tiff |max:4096',
        ]);
        
        // Create new user
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);

        // Store record
        $user->save();
        
        // Create staff profile
        $staffProfile = new StaffProfile();
        $staffProfile->user_id = $user->id;

        // Defining file names
        $identificationName = Str::random(10).'.'.$request->identification->getClientOriginalExtension();
        $passportName = Str::random(10).'.'.$request->identification->getClientOriginalExtension();
        $licenseName = Str::random(10).'.'.$request->identification->getClientOriginalExtension();
        
        // Store files
        $request->identification->storeAs('public/payments/documents', $identificationName);
        $request->license->storeAs('public/payments/documents', $licenseName);
        $request->passport->storeAs('public/payments/documents', $passportName);

        // Save urls
        $staffProfile->identification = Storage::url('staff/documents/'.$identificationName);
        $staffProfile->license = Storage::url('staff/documents/'.$licenseName);
        $staffProfile->passport = Storage::url('staff/documents/'.$passportName);

        //Safe profile
        $staffProfile->save();

        // Assign role
        $user->assignRole(Role::findByName('STAFF'));
        
        // Redirect to login
        return redirect()->route('login');
    }
}
