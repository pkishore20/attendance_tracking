<?php

namespace App\Http\Controllers;

use App\Http\Controllers\ApiResponseTrait;
use Illuminate\Http\Request;
use App\Models\departments;
use Illuminate\Support\Facades\Validator;

class DepartmentsController extends Controller
{
    use ApiResponseTrait;

    
    public function index()
    {

        try {
            $departments = departments::get();

            
            if(!$departments){
                return $this->sendErrorResponse('Departments not found successfully');
            }
            return $this->sendSuccessResponse('Departments retervie successfully',$departments);
        } catch (\Throwable $th) {
                   return $this->sendSuccessResponse($th);
        }
    }
    
    public function store(Request $request)
    {
        

      try {
        $validator = Validator::make($request->all(), [
            'departments_name' => 'required|unique:departments,departments_name|max:50',
          ]);
    
          if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
          }
    
         $data = departments::create([
            'departments_name' => $request->departments_name,
         ]);

           return $this->sendSuccessResponse('Departments retervie successfully',$data);

      } catch (\Throwable $th) {
            return $this->sendSuccessResponse($th);
     }
    }


    public function show(string $id)  
    {
        
        try{
            $departments = departments::where('id', $id)->first();


            if(!$departments){
                return $this->sendErrorResponse('Departments not found successfully');
             }
            return $this->sendSuccessResponse('Departments retervie successfully',$departments);
        }catch (\Throwable $th) {
            return $this->sendSuccessResponse($th);
        }
    }


       public function update(Request $request, string $id)
    {
        try {
            $departments = departments::where('id', $id)->first();
      
           if(!$departments){
              return $this->sendErrorResponse('Departments not found successfully');
           }
           departments::where('id', '=', $id)->update([
                'departments_name' => $request->departments_name,
           ]);
           return $this->sendSuccessResponse('Departments update successfully',   $departments);
           } catch (\Throwable $th) {
            return $this->sendSuccessResponse($th);
          } 
    }

 
    public function destroy(string $id)
    {
        try{
            $departments = departments::where('id', $id)->first();
            if(!$departments){
                return $this->sendErrorResponse('Departments not found successfully');
             }
             $departments->delete();
            return $this->sendSuccessResponse('Departments delete successfully',);
        }catch (\Throwable $th) {
            return $this->sendSuccessResponse($th);
        } 
    }
}
