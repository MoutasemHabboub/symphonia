<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use DB;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Teacher;
use App\Notifications\TwoFactorCode;

class TeacherController extends Controller
{

    public $successStatus = 200;
/** 
     * login api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function login(Request $request){ 
        
        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){ 
            $user = Auth::user(); 
         //   $success['token'] =  $user->createToken('MyApp')-> accessToken; 
            return response()->json(['token' =>  $user->createToken('MyApp')-> accessToken,
            'id'=>$user->id,'name'=>$user->name],
             $this-> successStatus); 
        } 
        else{ 
            return response()->json(['error'=>'email or password invalid'], 400); 
        } 
    }
/** 
     * Register api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function register(Request $request) 
    { 
        //php artisan serve --host=192.168.101.61 --port=8080
     //   return response()->json(['success'=>$request->all()], $this-> successStatus);
        $validator = Validator::make($request->all(), [ 
            'name' => 'sometimes', 
            'email' => 'required| unique:users|email', 
            'password' => 'required', 
            'phone_number' => 'sometimes', 
            'address'=>'sometimes',
            'main_specialization'=>'sometimes|exists:specializations,id'
            ,
            'university'=>'sometimes|numeric |min:0',
            'cv'=>'sometimes|file',
            'berthday'=>'sometimes|date|date_format:Y-m-d'
            ,'nationality'=>'sometimes|numeric |min:0',
            'Baccalaureate_type'=>[
                'sometimes',
                Rule::in([true,false]),
            ], 
            'gender'=>[
                'sometimes',
                Rule::in([true,false]),
            ],

            ]);
        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }
        else{
            
        $input = $request->all(); 
        $input['name']="koko";
        $input['password'] = bcrypt($input['password']); 
        $user = User::create($input); 
        $input['id'] = $user->id; 
        $success['token'] =  $user->createToken('MyApp')-> accessToken; 
        $success['name'] =  $user->name;
        $user->generateTwoFactorCode();
        $user->notify(new TwoFactorCode());
     return response()->json(['success'=>$success], $this-> successStatus); 
        
        try {
            $teacher=Teacher::create($input);
            $success['token'] =  $user->createToken('MyApp')-> accessToken; 
            $success['name'] =  $user->name;
            $user->generateTwoFactorCode();
            $user->notify(new TwoFactorCode());
         return response()->json(['success'=>$success], $this-> successStatus); 
             } catch (\Illuminate\Database\QueryException  $e) {

            $user->delete();
    
           // abort(422, $e);
            return response()->json(['error'=>$e], 401);;
        }
        
        
    
        }
    
    }
    public function registerTeacher(Request $request) 
    { 
        //php artisan serve --host=192.168.101.61 --port=8080
     //   return response()->json(['success'=>$request->all()], $this-> successStatus);
        $validator = Validator::make($request->all(), [ 
            'name' => 'required', 
            'phone_number' => 'required', 
            'address'=>'required',
            'main_specialization'=>'required|exists:specializations,id'
            ,
            'university'=>'required|numeric |min:0',
            'cv'=>'sometimes|file',
            'berthday'=>'required|date|date_format:Y-m-d'
            ,'nationality'=>'required|numeric |min:0',
            'Baccalaureate_type'=>[
                'required',
                Rule::in([true,false]),
            ], 
            'gender'=>[
                'required',
                Rule::in([true,false]),
            ],

            ]);
        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }
        else{
            
        $input = $request->all(); 
        $user = Auth::user(); 
        $input['id'] = $user->id; 
        $success['token'] =  $user->createToken('MyApp')-> accessToken; 
        $success['name'] =  $user->name;
        $user->generateTwoFactorCode();
        $user->notify(new TwoFactorCode());
     return response()->json(['success'=>$success], $this-> successStatus); 
        
        try {
            $teacher=Teacher::create($input);
            $success['token'] =  $user->createToken('MyApp')-> accessToken; 
            $success['name'] =  $user->name;
            $user->generateTwoFactorCode();
            $user->notify(new TwoFactorCode());
         return response()->json(['success'=>$success], $this-> successStatus); 
             } catch (\Illuminate\Database\QueryException  $e) {

            $user->delete();
    
           // abort(422, $e);
            return response()->json(['error'=>$e], 401);;
        }
        
        
    
        }
    
    }
/** 
     * details api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function details() 
    { 
        $user = Auth::user(); 
        return response()->json(['success' => $user->email], $this-> successStatus);

         
    } 
    protected function authenticated(Request $request, $user)
{
    $user->generateTwoFactorCode();
    $user->notify(new TwoFactorCode());
}
}
