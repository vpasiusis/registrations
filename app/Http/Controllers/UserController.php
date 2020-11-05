<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;
use App\Models\User;
use Validator;
use DB;

class UserController extends Controller
{

    private $client;
    protected $request;
    /**
     * DefaultController constructor.
     */
    public function __construct(Request $request)
    {
        $this->client = DB::table('oauth_clients')->where('id', 1)->first();
        $this->request=$request;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($this->checkIfSuperrior(2)){
            return response()->json(User::get(),200);
        }else{
            return response()->json(["message"=>'Your user do not have permissions to do this'],400); 
        }
       
    }



    public function register(Request $request)
    {
      
        $rules = [
            'name' => 'required|min:5',
            'password' => 'required|min:8',
            'type' => 'required|min:1',
            'bank_id' => 'optional',
            'email' => 'email:rfc,dns',
        ];

        $validator = Validator::make($request->all(), $rules);
      
        if($validator->fails()){
            return response()->json(["message"=>$validator->errors()],400); 
        }
        
       try {
            $user = [
                'name' => request('name'),
                'email' => request('email'),
                'password' => bcrypt(request('password')),
                'type' => request('type'),
                'bank_id' => 0
            ];
            DB::table('users')->insert($user);
        } catch(\Illuminate\Database\QueryException $e){
            $errorCode = $e->errorInfo[1];
            if($errorCode == '1062'){
                return response()->json(["message"=>"Email already exists"],401); 
            }
        }
        return response()->json($user,201);
       
      
        
    }

    public function login(Request $request) {
       
        $request->validate([
             'email' => 'required|string|email',
             'password’ => ‘required|string'
           ]);
        $credentials = request(['email', 'password']);
    
        if(!Auth::attempt($credentials))
            return response()->json([
                'message' => 'Unauthorized'
            ],401);
        $user = $request->user();
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        if ($request->remember_me)
            $token->expires_at = Carbon::now()->addWeeks(1);
        $token->save();
        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString()
        ]);
   }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if($this->checkIfSuperrior(2)){
            $user = User::find($id);
            if(is_null($user)){
                return response()->json(["message"=>"Record not found"],404); 
            }
            return response()->json($user,200);
        }else{
            return response()->json(["message"=>'Your user do not have permissions to do this'],400); 
        }
     


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
        if($this->checkIfSuperrior(1)){
            $user = User::find($id);
            if(is_null($user)){
                return response()->json(["message"=>"Record not found"],404); 
            }
          
            $user->update($request->all());
            return response()->json($user, 200);
        }else{
            return response()->json(["message"=>'Your user do not have permissions to do this'],400); 
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
        if($this->checkIfSuperrior(1)){
            $rules = [
                'name' => 'required|min:5',
                'password' => 'required|min:8',
                'type' => 'required|min:1',
                'bank_id' => 'required|min:1',
                'email' => 'email:rfc,dns',
            ];
    
            $validator = Validator::make($request->all(), $rules);
    
            if($validator->fails()){
                return response()->json(["message"=>$validator->errors()],400); 
            }
            try {
                $user = [
                    'name' => request('name'),
                    'email' => request('email'),
                    'password' => bcrypt(request('password')),
                    'type' => request('type'),
                    'bank_id' => 0
                ];
                DB::table('users')->insert($user);
            } catch(\Illuminate\Database\QueryException $e){
                $errorCode = $e->errorInfo[1];
                if($errorCode == '1062'){
                    return response()->json(["message"=>"Email already exists"],401); 
                }
            }
            return response()->json($user,201);
        }else{
            return response()->json(["message"=>'Your user do not have permissions to do this'],400); 
        }
       
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
            $user = User::find($id);
            if(is_null($user)){
                return response()->json(["message"=>"Record not found"],404); 
            }
            $user->delete();
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
