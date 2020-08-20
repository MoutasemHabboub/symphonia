<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\Validator;

use Closure;

class TwoFactor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = Auth::user(); 
        if(!isset($user)){
            $error='error';
                  return response()->json(['error'=>$error], 401); 
                   }
                   else{              
                       if($user->two_factor_code){
                        $validator = Validator::make($request->all(), [
                            'two_factor_code' => 'integer|required',
                            ]);
                        if($validator->fails()){
                            return response()->json(['error'=>$validator->errors('two_factor_code')], 422); 
                        }
                        
                        if($request->input('two_factor_code') == $user->two_factor_code)
                        {
                            $user->resetTwoFactorCode();
                            return $next($request);
                        }else{
                            return response()->json(['error'=>'it is not valid code'], 422); 
                        }

                       }
                       else{
                        return $next($request);
                       }
                   }

        return $next($request);
    }
}
