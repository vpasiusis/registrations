<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;
use Validator;


class NewsController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($bank_id)
    {
        $news = News::where('bank_id', $bank_id)->get();
        return response()->json($news,200);
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
    public function store(Request $request,$bank_id)
    {
        $rules = [
            'content' => 'required|min:20',
            'title' => 'required|min:4',
            'specialist_id' => 'required|min:1',
            'expires_in' => 'required|date',
        ];
        
        $validator = Validator::make($request->all(), $rules);



        if($validator->fails()){
            return response()->json(["message"=>$validator->errors()],400); 
        }

        $news = News::create([
    		'content' => request('content'),
    		'title' => request('title'),
            'specialist_id' => request('specialist_id'),
            'expires_in' => request('expires_in'),
            'bank_id' => $bank_id
    	]);
      
        return response()->json($news,201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($bank_id,$id)
    {
        $news = News::where('bank_id', $bank_id)->find($id);
        if(is_null($news)){
            return response()->json(["message"=>"Record not found"],404); 
        }
        return response()->json(News::find($id),200);
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
    public function update(Request $request,$bank_id, $id)
    {
        $news = News::where('bank_id', $bank_id)->find($id);
        if(is_null($news)){
            return response()->json(["message"=>"Record not found"],404); 
        }
      
        $news->update($request->all());
        return response()->json($news, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($bank_id,$id)
    {
        $news = News::where('bank_id', $bank_id)->find($id);
        if(is_null($news)){
            return response()->json(["message"=>"Record not found"],404); 
        }
        $news->delete();
        return response()->json("DELETED", 204);
    }
}
