<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Auth;
class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:Company-index|Company-create|Company-edit|Company-destroy', ['only' => ['index','show']]);
         $this->middleware('permission:Company-create', ['only' => ['create','store']]);
         $this->middleware('permission:Company-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:Company-destroy', ['only' => ['destroy']]);
    }
    public function index()
    {
        if(auth()->user()->can('Company-index')) {
            $companies = Company::all();
            return view('companies.index',compact('companies'));
        }else{
            $auth = Auth::user();
            return view('error.role_error',compact('auth'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(auth()->user()->can('Company-create')) {
        $fetchCountry = Country::select("name", "id")->get();
        return view('companies.create',compact('fetchCountry'));
    }else{
        $auth = Auth::user();
        return view('error.role_error',compact('auth'));
       }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(auth()->user()->can('Company-store')) {
        $company_lastid = companyLastID();
        $get_perfectLast_id = str_pad($company_lastid, 4, '0', STR_PAD_LEFT);

        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'street' => 'required',
            'city' => 'required',
            'state' => 'required',
            'country' => 'required',
            'zipcode' => 'required',
            'status' => 'required'
        ]);

        $create = Company::create([
            'name'=> $request->name,
            'email'=> $request->email,
            'code'=> $get_perfectLast_id,
            'street'=> $request->street,                            
            'city'=> $request->city,
            'state'=>$request->state,
            'country'=> $request->country,
            'zipcode'=> $request->zipcode,
            'status'=> $request->status,
        ]);
       
        return redirect()->route('companies.index')->with('success','Company created successfully.');
    }else{
        $auth = Auth::user();
        return view('error.role_error',compact('auth'));
       }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company)
    {
        if(auth()->user()->can('Company-show')) {

        $company = Company::join('countries', 'countries.id', '=', 'companies.country')
        ->join('states', 'states.id', '=', 'companies.state')
        ->join('cities', 'cities.id', '=', 'companies.city')
        ->where('companies.id', $company->id)
        ->get(['companies.id','companies.name','companies.code','companies.email','companies.street','countries.name as countryname','states.name as statename','cities.name as cityname','companies.zipcode','companies.status'])->first();
        return view('companies.show',compact('company'));
    }else{
        $auth = Auth::user();
        return view('error.role_error',compact('auth'));
       }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $company)
    {
        if(auth()->user()->can('Company-edit')) {
        $fetchCountry = Country::select("name", "id")->get();
        $country = Country::select("name", "id")->where('id', $company->country)->get()->first();
        $state = State::where('country_id',$company->country)->get();
        $city = City::where('state_id',$company->state)->get();
        return view('companies.create',compact('company','fetchCountry','country','state','city'));
    }else{
        $auth = Auth::user();
        return view('error.role_error',compact('auth'));
       }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Company $company)
    {
        if(auth()->user()->can('Company-update')) {

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'street' => 'required',
            'city' => 'required',
            'state' => 'required',
            'country' => 'required',
            'zipcode' => 'required',
            'status' => 'required'
        ]);
      
        $company->update($request->all());
      
        return redirect()->route('companies.index')->with('success','Company updated successfully');
    }else{
        $auth = Auth::user();
        return view('error.role_error',compact('auth'));
       }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company)
    {
        if(auth()->user()->can('Company-destroy')) {

        $company->delete();
       
        return redirect()->route('companies.index')->with('success','Company deleted successfully');
    }else{
        $auth = Auth::user();
        return view('error.role_error',compact('auth'));
       }
    }
}
