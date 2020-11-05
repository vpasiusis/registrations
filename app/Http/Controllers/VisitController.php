<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Visit;
use Validator;

class VisitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if($this->checkIfSuperrior(2)){
            return response()->json(Visit::get(),200);
        }else{
            return response()->json(["message"=>'Your user do not have permissions to do this'],400); 
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'info' => 'required|min:5',
            'type' => 'required|min:1',
            'specialist_id' => 'required|min:1',
            'bank_id' => 'required|min:1',
            'state' => 'required|min:1',
            'userId' => 'required|min:1',
            'starting_time' => 'required|date',
            'ending_time' => 'required|date',
        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){
            return response()->json(["message"=>$validator->errors()],400); 
        }
        $visit = Visit::create($request->all());
        return response()->json($visit,201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $visit = Visit::find($id);
        if(is_null($visit)){
            return response()->json(["message"=>"Records not found"],404); 
        }
        return response()->json(Visit::find($id),200);
    }

    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $visit = Visit::find($id);
        if(is_null($visit)){
            return response()->json(["message"=>"Record not found"],404); 
        }
      
        $visit->update($request->all());
        return response()->json($visit, 200);
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if($this->checkIfSuperrior(1)){
            $visit = Visit::find($id);
            if(is_null($visit)){
                return response()->json(["message"=>"Record not found"],404); 
            }
            $visit->delete();
            return response()->json("DELETED", 204);
        }else{
            return response()->json(["message"=>'Your user do not have permissions to do this'],400); 
        }
      
    }

    public function checkIfSuperrior($type) {
        if(auth('api')->user()->type<=$type){
            return true;
        }else{
            return false;
        }
    }
}
