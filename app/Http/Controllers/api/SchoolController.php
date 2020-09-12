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
use App\School;
use App\PhoneNumber;

use App\Notifications\TwoFactorCode;


class SchoolController extends Controller
{
    public function login(Request $request){ 
        
        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){ 
            $user = Auth::user(); 
            $school=$user->school;


         //   $success['token'] =  $user->createToken('MyApp')-> accessToken; 
            return response()->json(['token' =>  $user->createToken('MyApp')-> accessToken,
            'id'=>$user->id,'name'=>$school->name],
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
            
            ]);
        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }
        else{
            
        $input = $request->all(); 
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
    public function registerSchool(Request $request) 
    { 
        //php artisan serve --host=192.168.101.61 --port=8080
       // return response()->json(['success'=>$request->all()], $this-> successStatus);
        $validator = Validator::make($request->all(), [ 
            'phone_number' => 'required', 
            'address'=>'required',
            'name'=>'required|unique:schools,name',
            'email' => 'required| unique:users|email', 
            'password' => 'required', 
            'male_school_type'=>[
                'required',
                Rule::in([true,false]),
            ], 
            'femal_school_type'=>[
                'required',
                Rule::in([true,false]),
            ],   
            'first_school_level'=>[
                'required',
                Rule::in([true,false]),
            ], 'seconde_school_level'=>[
                'required',
                Rule::in([true,false]),
            ], 'third_school_level_litt'=>[
                'required',
                Rule::in([true,false]),
            ], 'third_school_level_sci'=>[
                'required',
                Rule::in([true,false]),
            ],           

            ]);
        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }
        else{
            
        $input = $request->all(); 
        $input['password'] = bcrypt($input['password']); 
        $user = User::create($input); 
        $input['id'] = $user->id; 
        if($input['femal_school_type']&&$input['male_school_type']){
            $input['students_gender']=1;
        }
        elseif($input['femal_school_type']&&!$input['male_school_type']){
            $input['students_gender']=2;

        }
        else{
            $input['students_gender']=3;
        }


        if($input['first_school_level']
        &&$input['seconde_school_level']
        &&$input['third_school_level_litt']
        &&$input['third_school_level_sci']){
            $input['teaching_phase']=1;
        }
        elseif(!$input['first_school_level']
        &&$input['seconde_school_level']
        &&$input['third_school_level_litt']
        &&$input['third_school_level_sci']){
            $input['teaching_phase']=2;
        }
        elseif(!$input['first_school_level']
        &&!$input['seconde_school_level']
        &&$input['third_school_level_litt']
        &&$input['third_school_level_sci']){
            $input['teaching_phase']=3;
        }
        elseif($input['first_school_level']
        &&$input['seconde_school_level']
        &&!$input['third_school_level_litt']
        &&!$input['third_school_level_sci']){
            $input['teaching_phase']=4;
        }
        elseif(!$input['first_school_level']
        &&$input['seconde_school_level']
        &&!$input['third_school_level_litt']
        &&$input['third_school_level_sci']){
            $input['teaching_phase']=5;
        }
        elseif(!$input['first_school_level']
        &&$input['seconde_school_level']
        &&$input['third_school_level_litt']
        &&!$input['third_school_level_sci']){
            $input['teaching_phase']=6;
        }
        elseif(!$input['first_school_level']
        &&!$input['seconde_school_level']
        &&!$input['third_school_level_litt']
        &&$input['third_school_level_sci']){
            $input['teaching_phase']=7;
        }
        else {
            $input['teaching_phase']=8;
        }

        /*
        $success['token'] =  $user->createToken('MyApp')-> accessToken; 
        $success['name'] =  $user->name;
        $success['token'] =  $user->createToken('MyApp')-> accessToken; 
        */
     //   return response()->json(['success'=>$success], $this-> successStatus); 
        
        try {
            $school=School::create($input);
            $success['token'] =  $user->createToken('MyApp')-> accessToken; 
            $success['name'] =  $school->name;
            $input['school_id']=$user->id;
            //return response()->json(['success'=>$success], $this-> successStatus); 

            $phone=PhoneNumber::create($input);

            
         return response()->json(['success'=>$success], $this-> successStatus); 
             } catch (\Illuminate\Database\QueryException  $e) {

            $user->delete();
    
           // abort(422, $e);
            return response()->json(['error'=>$e], 401);;
        }
        
        
    
        }
    
    }

}
