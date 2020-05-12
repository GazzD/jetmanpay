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

    public function edit(){
        $user = auth()->user();
        return view('pages.backend.clients.edit')
            ->with('client',$user->client)
            ;
    }

    public function update(Request $request){
        $client = Client::find(auth()->user()->client_id);
        $client->name = $request->name;
        $client->code = $request->code;
        $client->email = $request->email;
        $client->business_name = $request->businessName;
        $client->acronym = $request->acronym;
        $client->accounting_assistant = $request->accountingAssistant;
        $client->phone_number1 = $request->phoneNumber1;
        $client->phone_number2 = $request->phoneNumber2;
        $client->phone_number3 = $request->phoneNumber3;
        $client->web = $request->website;
        $client->president = $request->president;
        $client->contact_person = $request->contactPerson;
        $client->street = $request->street;
        $client->sector = $request->sector;
        $client->building = $request->building;
        $client->floor = $request->floor;
        $client->office = $request->office;
        $client->parish = $request->parish;
        $client->municipality = $request->municipality;
        $client->city = $request->city;
        $client->state = $request->state;
        $client->rm_number = $request->rmNumber;
        $client->rm_volume = $request->rmVolume;
        $client->rm_district = $request->rmDistrict;
        $client->rm_city = $request->rmCity;
        $client->rm_register = $request->rmRegister;
        $client->patent = $request->patent;
        $client->contractors_registration = $request->contractorsRegistration;
        $client->company_activity = $request->companyActivity;
        $client->aliquot = $request->aliquot;
        $client->account = $request->account;
        $client->num_credit = $request->numCredit;
        $client->num_debit = $request->numDebit;
        $client->save();
        return redirect()->route('users/profile');
    }
}
