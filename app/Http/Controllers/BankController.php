<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bank;
use Validator;

class BankController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Bank::get(),200);
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
            'name' => 'required|min:3',
            'location' => 'required|min:4',
            'workers_number' => 'required|min:1',
        ];
        
        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){
            return response()->json(["message"=>$validator->errors()],400); 
        }
        $bank = Bank::create($request->all());
        return response()->json($bank,201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $bank = Bank::find($id);
        if(is_null($bank)){
            return response()->json(["message"=>"Record not found"],404); 
        }
        return response()->json(Bank::find($id),200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $bank = Bank::find($id);
        
        if(is_null($bank)){
            return response()->json(["message"=>"Record not found"],404); 
        }
        $bank->update($request->all());
        return response()->json($bank, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $bank = Bank::find($id);
        if(is_null($bank)){
            return response()->json(["message"=>"Record not found"],404); 
        }
        $bank->delete();
        return response()->json("DELTED", 204);
    }
}
