<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function addJob(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'=>'required| unique:jobs,name',
            'description'=>'sometimes'
            ]);
        if(!$validator->fails()){
            $job = new Job;
            $job->name=$request->input('name');
        //    return response()->json(['The new job is ' =>$job->job ], $this-> successStatus);
                    if($job->save()){
                     return response()->json(['The new job is ' =>$job->name ], $this-> successStatus); 
                }
                else{
                    return response()->json(['errors'=>'can not save in the data base'],400);
                }
            }
            else{
                return response()->json(['error'=>$validator->errors()], 401);
            }
    }

}
