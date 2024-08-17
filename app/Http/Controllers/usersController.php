<?php

namespace App\Http\Controllers;

use App\Http\Controllers\ApiResponseTrait;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class usersController extends Controller
{
    use ApiResponseTrait;

    public function index()
    {

     try {
         $users = User::get();
         if(!$users){
            return $this->sendErrorResponse('users not found successfully');
         }
         return $this->sendSuccessResponse('users retervie successfully',   $users);
     } catch (\Throwable $th) {
                return $this->sendSuccessResponse($th);
     }


    }
    public function store(Request $request)
    {
     try{

      $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8',
        'mobile_no' => 'required|string|size:10|unique:users',
      ]);

      if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
      }

     $data = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => bcrypt($request->password),
        'mobile_no' => $request->mobile_no,
     ]);

     return $this->sendSuccessResponse('User created successfully', $data);

     } catch (\Throwable $th) {
     return $this->sendSuccessResponse($th);
     }
    }
    


    public function show(string $id)
    {
      try{
            $users = User::where('id', $id)->first();
            if(!$users){
                return $this->sendErrorResponse('users not found successfully');
             }
            return $this->sendSuccessResponse('users retervie successfully',   $users);
        }catch (\Throwable $th) {
            return $this->sendSuccessResponse($th);
        }

    }


    public function update(Request $request, string $id)
    {

     try {


     $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8',
        'mobile_no' => 'required|string|size:10|unique:users',
      ]);

      if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
      }
      $users = User::where('id', $id)->first();

     if(!$users){
        return $this->sendErrorResponse('users not found successfully');
     }
     User::where('id', '=', $id)->update([
          'name' => $request->name,
          'email' => $request->email,
          'password' => $request->password,
          'mobile_no' => $request->mobile_no,
     ]);
     return $this->sendSuccessResponse('users update successfully',$users);
     } catch (\Throwable $th) {
      return $this->sendSuccessResponse($th);
     }
    }

   
    public function destroy(string $id)
    {
        try{
            $users = User::where('id', $id)->first();
            if(!$users){
                return $this->sendErrorResponse('users not found successfully');
             }
             $users->delete();
            return $this->sendSuccessResponse('users delete successfully',);
        }catch (\Throwable $th) {
            return $this->sendSuccessResponse($th);
        }   

    }
}
