<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class JobCapableController extends Controller
{
    public function addJobCapable(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'job_id'=>'required| exists:jobs,id',
            ]);
        if(!$validator->fails()){
            $user = Auth::user();
            $jobCapable = new JobCapable;
            $jobCapable->job_id=$request->input('job_id');
            $jobCapable->teacher_id=$user->id;

        //    return response()->json(['The new job is ' =>$job->job ], $this-> successStatus);
                    if($jobCapable->save()){
                     return response()->json(['The new jobCapable is ' =>$jobCapable->id ], $this-> successStatus); 
                }
                else{
                    return response()->json(['errors'=>'can not save in the data base'],400);
                }
            }
            else{
                return response()->json(['error'=>$validator->errors()], 401);
            }
    }
    public function removeJobCapable(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'job_id'=>'required| exists:jobs,id',
            ]);
        if(!$validator->fails()){
            $user = Auth::user();
            $jobCapable = JobCapable::where('job_id', '=', $request->input('job_id'), ' and')->where('teacher_id', '=', $user->id)->first();
            if(!is_null($jobCapable)){
              //  $model_check = Work_in::where('workshop_id', '=', $request->input('workshop_id'), ' and')->where('employee_id', '=', $request->input('employee_id'))->delete();
                if($jobCapable->delete()){
                return response()->json(['The  jobCapable deleted '  ], $this-> successStatus); 
                }
                else{
                    return response()->json(['errors'=>'can not save in the data base'],400);
                }
            }
            else{
                return response()->json(['The  jobCapable deleted '  ], $this-> successStatus); 
 
            }
        
        //    return response()->json(['The new job is ' =>$job->job ], $this-> successStatus);  
            }
            else{
                return response()->json(['error'=>$validator->errors()], 401);
            }
    }

}
