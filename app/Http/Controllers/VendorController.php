<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\Vendor;
use Auth;
class VendorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:Vendor-index|Vendor-create|Vendor-edit|Vendor-destroy', ['only' => ['index','show']]);
         $this->middleware('permission:Vendor-create', ['only' => ['create','store']]);
         $this->middleware('permission:Vendor-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:Vendor-destroy', ['only' => ['destroy']]);
    }
    public function index()
    {
        if(auth()->user()->can('Vendor-index')) {
            $vendors = Vendor::all();
            $vendors = Vendor::join('companies', 'companies.id', '=', 'vendors.company_id')
            ->get(['vendors.id','vendors.vendor_name','vendors.vendor_code','vendors.vendor_contactperson','vendors.vendor_email','vendors.vendor_phone','vendors.vendor_street','vendors.vendor_city','vendors.vendor_state','vendors.vendor_country','vendors.vendor_zipcode','vendors.company_id','vendors.vendor_status','companies.name as companyname']);
            return view('vendors.index',compact('vendors'));
        } else {
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
        if(auth()->user()->can('Vendor-create')) {
        $companies = Company::select("name", "id")->where('status', 1)->get();
        $fetchCountry = Country::select("name", "id")->get();
        return view('vendors.create',compact('companies','fetchCountry'));
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
        if(auth()->user()->can('Vendor-store')) {
        $vendor_lastid = vendorLastID();
        $get_perfectLast_id = str_pad($vendor_lastid, 4, '0', STR_PAD_LEFT);

        $request->validate([
            'vendor_name'=> 'required',
            'vendor_contactperson'=> 'required',
            'vendor_email'=> 'required',
            'vendor_phone'=> 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'vendor_street'=> 'required',
            'city_id'=> 'required',
            'state_id'=> 'required',
            'country_id'=> 'required',
            'vendor_zipcode'=> 'required',
            'company_id'=> 'required',
            'vendor_status'=>'required'
        ],[
            'city_id.required' => 'Please enter valid city!',
            'state_id.required' => 'Please enter valid state!',
            'country_id.required' => 'Please enter valid country!'
        ]);
        $create = Vendor::create([
                'vendor_name'=> $request->vendor_name,
                'vendor_code'=>$get_perfectLast_id,
                'vendor_contactperson'=> $request->vendor_contactperson,                            
                'vendor_email'=> $request->vendor_email,
                'vendor_phone'=>$request->vendor_phone,
                'vendor_street'=> $request->vendor_street,
                'vendor_city'=> $request->city_id,
                'vendor_state'=> $request->state_id,
                'vendor_country'=> $request->country_id,
                'vendor_zipcode'=> $request->vendor_zipcode,
                'company_id'=> $request->company_id,
                'vendor_status'=>$request->vendor_status,
        ]);
             
        return redirect()->route('vendors.index')->with('success','Vendor created successfully.');
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
    public function show(Vendor $vendor)
    {
        if(auth()->user()->can('Vendor-show')) {
        $vendor = Vendor::join('companies', 'companies.id', '=', 'vendors.company_id')
        ->join('countries', 'countries.id', '=', 'vendors.vendor_country')
        ->join('states', 'states.id', '=', 'vendors.vendor_state')
        ->join('cities', 'cities.id', '=', 'vendors.vendor_city')
        ->where('vendors.id', $vendor->id)
        ->get(['vendors.id','vendors.vendor_name','vendors.vendor_code','vendors.vendor_contactperson','vendors.vendor_email','vendors.vendor_phone','vendors.vendor_street','countries.name as countryname','states.name as statename','cities.name as cityname','vendors.vendor_zipcode','vendors.company_id','vendors.vendor_status','companies.name as companyname'])->first();
        return view('vendors.show',compact('vendor'));
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
    public function edit(Vendor $vendor)
    {
        if(auth()->user()->can('Vendor-edit')) {
        $companies = Company::select("name", "id")->where('status', 1)->get();
        $country = Country::select("name", "id")->where('id', $vendor->vendor_country)->get()->first();
        $state = State::where('country_id',$vendor->vendor_country)->get();
        $city = City::where('state_id',$vendor->vendor_state)->get();
        $fetchCountry = Country::select("name", "id")->get();
        return view('vendors.create',compact('vendor','companies','country','state','city','fetchCountry'));
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
    public function update(Request $request, Vendor $vendor)
    {
        if(auth()->user()->can('Vendor-update')) {
        $request->validate([
            'vendor_name'=> 'required',
            'vendor_contactperson'=> 'required',
            'vendor_email'=> 'required',
            'vendor_phone'=> 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'vendor_street'=> 'required',
            'city_id'=> 'required',
            'state_id'=> 'required',
            'country_id'=> 'required',
            'vendor_zipcode'=> 'required',
            'company_id'=> 'required',
            'vendor_status'=>'required'
        ],[
            'city_id.required' => 'Please enter valid city!',
            'state_id.required' => 'Please enter valid state!',
            'country_id.required' => 'Please enter valid country!'
        ]);

        $UpdateDetails = Vendor::where('id',$vendor->id)->update([
            'vendor_name'=> $request->vendor_name,
            'vendor_contactperson'=> $request->vendor_contactperson,                            
            'vendor_email'=> $request->vendor_email,
            'vendor_phone'=>$request->vendor_phone,
            'vendor_street'=> $request->vendor_street,
            'vendor_city'=> $request->city_id,
            'vendor_state'=> $request->state_id,
            'vendor_country'=> $request->country_id,
            'vendor_zipcode'=> $request->vendor_zipcode,
            'company_id'=> $request->company_id,
            'vendor_status'=>$request->vendor_status
        ]);      

        return redirect()->route('vendors.index')->with('success','Vendor updated successfully');
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
    public function destroy(Vendor $vendor)
    {
        if(auth()->user()->can('Vendor-destroy')) {
        $vendor->delete();
       
        return redirect()->route('vendors.index')->with('success','Vendor deleted successfully');
    }else{
        $auth = Auth::user();
        return view('error.role_error',compact('auth'));
       }
    }
}
