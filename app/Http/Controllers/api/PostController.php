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
use App\Post;

use App\Notifications\TwoFactorCode;


class PostController extends Controller
{
    public function create(Request $request) 
    { 
        //php artisan serve --host=192.168.101.61 --port=8080
     //   return response()->json(['success'=>$request->all()], $this-> successStatus);
        $validator = Validator::make($request->all(), [ 
            'notes' => 'required', 
            'job_id' => 'sometimes| exists:jobs,id', 
            'gender'=>[
                'sometimes',
                Rule::in([true,false]),
            ],
            'year_of_experience' => 'sometimes|numeric |min:0',   
            'weekly_hours' => 'sometimes|numeric |min:0|max:30',   
            'students_gender' => 'sometimes|numeric |min:0|max:30',   
            'students_gender' => 'sometimes',   
            ]);
        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }
        else{
      return response()->json(['success'=>"success"], $this-> successStatus); 
        $input = $request->all(); 
        $user = Auth::user(); 
        $input['name']=$user->id;
        $post = Post::create($input); 
        return response()->json(['success'=>$success], $this-> successStatus); 
        return response()->json(['error'=>"sss"], 401);
        }
    
    }
}
