<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;




class AuthController extends Controller
{
     public function login(Request $req)
     {

         $credenciais=$req->all(["email","password"]);

         $token =auth('api')->attempt($credenciais);

         if($token){
            $arr = ['token'=>$token,'status'=>'success'];
            $status='200';
         }else{
            $arr = ['token'=>$token,'status'=>'error'];
            $status='403';
         }

          return response()->json($arr,$status);

     }
     public function logout()
     {
        $token = auth('api')->logout(['msg' => 'Log out realizado com Sucesso!']);
          return 'logout';
     }
     public function refresh()
     {
          $token = auth('api')->refresh();
          return  response()->json(['token' => $token]);
     }
     public function me()
     {
          $authUser = (auth()->user());

          return response()->json($authUser);
     }


}
