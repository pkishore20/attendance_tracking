<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiResponseTrait;
use App\Models\add_roles;
use Illuminate\Support\Facades\Validator;

class rolesController extends Controller
{
    use ApiResponseTrait;

    
    public function index()
    {
        try {
            $roles = add_roles::get();

            if(!$roles){
                return $this->sendErrorResponse('Roles not found successfully');
            }
            return $this->sendSuccessResponse('Roles retervie successfully',$roles);
        } catch (\Throwable $th) {
                   return $this->sendSuccessResponse($th);
        }
    }
    
    public function store(Request $request)
    {
        

        try {
            $validator = Validator::make($request->all(), [
                'roles_name' => 'required|unique:add_roles,roles_name|max:50',
                'guard_name' => 'required|unique:add_roles,guard_name|max:50',
            ]);
        
              if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
              }
        
             $data = add_roles::create([
                'roles_name' => $request->roles_name,
                'guard_name' => $request->guard_name
             ]);
    
               return $this->sendSuccessResponse('Roles create successfully',$data);
    
          } catch (\Throwable $th) {
                return $this->sendSuccessResponse($th);
         }
    }


    public function show(string $id)  
    {
        
        try{
            $roles = add_roles::where('id', $id)->first();
            if(!$roles){
                return $this->sendErrorResponse('Roles not found successfully');
             }
            return $this->sendSuccessResponse('Roles retervie successfully',$roles);
        }catch (\Throwable $th) {
            return $this->sendSuccessResponse($th);
        }
    }


       public function update(Request $request, string $id)
    {
        try {
            $roles = add_roles::where('id', $id)->first();
      
           if(!$roles){
              return $this->sendErrorResponse('Roles not found successfully');
           }
           add_roles::where('id', '=', $id)->update([
                'roles_name' => $request->roles_name,
           ]);
           return $this->sendSuccessResponse('Roles update successfully',   $roles);
           } catch (\Throwable $th) {
            return $this->sendSuccessResponse($th);
          } 
    }

 
    public function destroy(string $id)
    {
        try{
            $roles = add_roles::where('id', $id)->first();
            if(!$roles){
                return $this->sendErrorResponse('Roles not found successfully');
             }
             $roles->delete();
            return $this->sendSuccessResponse('Roles delete successfully',);
        }catch (\Throwable $th) {
            return $this->sendSuccessResponse($th);
        } 
    }
}
