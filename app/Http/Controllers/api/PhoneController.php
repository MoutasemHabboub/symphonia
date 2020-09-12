<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PhoneController extends Controller
{
    public function addPhoneNumber(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone_number'=>'required'
            ]);
        if(!$validator->fails()){
            $user = Auth::user(); 
            $phone=$user->shcool->phoneNumers()->where('phone_number',$request->input('phone_number'))->first();
            if(is_null($phone)){
                $phone = new PhoneNumber;
            $phone->phone_number=$request->input('phone_number');
        //    return response()->json(['The new specialization is ' =>$specialization->specialization ], $this-> successStatus);
                    if($phone->save()){
                     return response()->json(['The new phone number is ' =>$phone->phone_number ], $this-> successStatus); 
                }
                else{
                    return response()->json(['errors'=>'can not save in the data base'],400);
                }
            }
            else{
                return response()->json(['errors'=>'alrady exist'],400);
  
            }
            }
            
            else{
                return response()->json(['error'=>$validator->errors()], 401);
            }
    }
    public function deletePhoneNumber($id)
    {
        $phone = PhoneNmber::find($id);

        if(!is_null($phone)){
            $user = Auth::user(); 
            if($phone->school_id==$user->id){
                  if($phone->delete()){
                     return response()->json(['deleted  ' =>$id ], $this-> successStatus); 
                }
                else{
                    return response()->json(['errors'=>'can not delete in the data base'],400);
                }
            }
            else{
                return response()->json(['errors'=>'unauthorized'],400);
  
            }
            }
            
            else{
                return response()->json(['error'=>'not exsit'], 401);
            }
    }


}
