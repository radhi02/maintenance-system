<?php

namespace App\Http\Controllers;
use App\Models\Company;
use App\Models\Equipment;
use App\Models\task;
use Illuminate\Http\Request;
use DB;
use Auth;
class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:task-index|task-create|task-show|task-destroy', ['only' => ['index','show']]);
         $this->middleware('permission:task-create', ['only' => ['create','store']]);
         $this->middleware('permission:task-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:task-destroy', ['only' => ['destroy']]);
    }
    public function index()
    {
        if(auth()->user()->can('task-index')) {
            $task = Equipment::select("equipment_name", "id","major","minor")->get();
            // dd($task);
            return view('task.index',compact('task'));
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
        if(auth()->user()->can('task-create')) {
            $equipment = Equipment::select("equipment_name", "id")->get();
            return view('task.create',compact('equipment'));
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
        // dd($request->all());
        if(auth()->user()->can('task-store')) {
            $datas=[];
            $otherdetails = $request->otherdetails;
            foreach($request->radioPrimary as $k=>$v){
                $datas[$v][] = $otherdetails[$k];
            }
            $minor = $major = NULL;
            if(isset($datas['Minor'])) $minor = implode(',',$datas['Minor']);
            if(isset($datas['Major'])) $major = implode(',',$datas['Major']);

            Equipment::where('equipment_id',$request->equipment_id)->update(
            [
                'minor'=> $minor,
                'major'=> $major
            ]);
    
            session()->flash('success', 'Task  Created Successfuly.');
            return redirect()->route('task.index');
        }else{
            $auth = Auth::user();
            return view('error.role_error',compact('auth'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(auth()->user()->can('task-edit')) {
            $task = Equipment::select("equipment_name", "id","major","minor")->where("id",$id)->get()->first();
            return view('task.create',compact('task'));
        }else{
            $auth = Auth::user();
            return view('error.role_error',compact('auth'));
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        if(auth()->user()->can('task-update')) {
            $datas=[];
            $otherdetails = $request->otherdetails;
            foreach($request->radioPrimary as $k=>$v){
                $datas[$v][] = $otherdetails[$k];
            }
        
            $minor = $major = NULL;
            if(isset($datas['Minor'])) $minor = implode(',',$datas['Minor']);
            if(isset($datas['Major'])) $major = implode(',',$datas['Major']);

            Equipment::where('id',$request->id)->update(
            [
                'minor'=> $minor,
                'major'=> $major
            ]);

            session()->flash('success', 'Task  Updated Successfuly.');
            return redirect()->route('task.index');
        }else{
            $auth = Auth::user();
            return view('error.role_error',compact('auth'));
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(task $task)
    {
        if(auth()->user()->can('task-destroy')) {
        $task->delete();
       
        return redirect()->route('task.index')->with('success','Task deleted successfully');
    }else{
        $auth = Auth::user();
        return view('error.role_error',compact('auth'));
       }
    }
    public function DestroyOther(Request $request)
    {
        $name =   $request->data;
         $id   =    $request->id;
         $string="";
         $datas =  DB::table('tasks')->select('otherdetails')->where('id','=',$id)->where('deleted_at','=',null)->first();
         
   
         $array_other_details =  explode(",", $datas->otherdetails);
           $key = array_search($name, $array_other_details);
            if(isset($key))
            {
                unset($array_other_details[$key]);
                $other =implode(",",$array_other_details);
                DB::table('tasks')->where('id',$id)->update(['otherdetails'=>$other]);
                return response()->json(['msg'=>1]);
            }                return response()->json(['msg'=>0]);
        }
}
