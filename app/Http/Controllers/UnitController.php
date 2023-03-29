<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\Unit;
use Illuminate\Http\Response;
use Auth;
class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $unit = Unit::all();
        return view('unit.index',compact('unit'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $fetchCountry = Country::select("name", "id")->get();
        return view('unit.create',compact('fetchCountry'));
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $company_lastid = unitLastID();
        $get_perfectLast_id = str_pad($company_lastid, 4, '0', STR_PAD_LEFT);
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'unit_phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'street' => 'required',
            'city' => 'required',
            'state' => 'required',
            'country' => 'required',
            'zipcode' => 'required',
            'status' => 'required'
        ]);

        $create = Unit::create([
            'name'=> $request->name,
            'email'=> $request->email,
            'unit_phone'=> $request->unit_phone,
            'unit_code'=> $get_perfectLast_id,
            'street'=> $request->street,                            
            'city'=> $request->city,
            'state'=>$request->state,
            'country'=> $request->country,
            'zipcode'=> $request->zipcode,
            'status'=> $request->status,
        ]);
       
        return redirect()->route('unit.index')->with('success','Unit Created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $unit = Unit::join('countries', 'countries.id', '=', 'units.country')
        ->join('states', 'states.id', '=', 'units.state')
        ->join('cities', 'cities.id', '=', 'units.city')
        ->where('units.id', $id)
        ->get(['units.id','units.name','units.unit_code','units.unit_phone','units.email','units.street','countries.name as countryname','states.name as statename','cities.name as cityname','units.zipcode','units.status'])->first();
        return view('unit.show',compact('unit'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Unit $unit)
    {
        $fetchCountry = Country::select("name", "id")->get();
        $country = Country::select("name", "id")->where('id', $unit->country)->get()->first();
        $state = State::where('country_id',$unit->country)->get();
        $city = City::where('state_id',$unit->state)->get();
        return view('unit.create',compact('unit','fetchCountry','country','state','city'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Unit $unit)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'street' => 'required',
            'city' => 'required',
            'state' => 'required',
            'unit_phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'country' => 'required',
            'zipcode' => 'required',
            'status' => 'required'
        ]);
      
        $unit->update($request->all());
      
        return redirect()->route('unit.index')->with('success','Unit Updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Unit $unit)
    {
        $unit->delete();
       
        return redirect()->route('unit.index')->with('success','Unit Deleted successfully');
    }
}
