<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Specialization;

class SpecializationController extends Controller
{
    public $successStatus = 200;

    public function addSpecialization(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'=>'required| unique:specializations,name'
            ]);
        if(!$validator->fails()){
            $specialization = new Specialization;
            $specialization->name=$request->input('name');
        //    return response()->json(['The new specialization is ' =>$specialization->specialization ], $this-> successStatus);
                    if($specialization->save()){
                     return response()->json(['The new specialization is ' =>$specialization->specialization ], $this-> successStatus); 
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
