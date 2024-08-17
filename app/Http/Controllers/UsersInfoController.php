<?php

namespace App\Http\Controllers;

use App\Models\Users_info;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiResponseTrait;
use Illuminate\Support\Facades\Validator;

class UsersInfoController extends Controller
{

    use ApiResponseTrait;

    public function index()
    {
        try {
            $user_infos = Users_info::all();
    
            if ($user_infos->isEmpty()) {
                return $this->sendErrorResponse('Users_info not found successfully');
            }
    
            $data = [];
    
            foreach ($user_infos as $user_info) {
                $data[] = [
                    'userName'      => $user_info->user->name,
                    'userEmail'     => $user_info->user->email,
                    'userMobile_no' => $user_info->user->mobile_no,
                    'department'    => $user_info->department->departments_name,
                    'roles'         => $user_info->role->roles_name,
                ];
            }
    
            return $this->sendSuccessResponse('Users_info retrieved successfully', $data);
    
        } catch (\Throwable $th) {
            return $this->sendErrorResponse('An error occurred', $th->getMessage());
        }
    }

      public function store(Request $request)
      {
       try {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id|unique:users_infos,user_id',
            'department_id' => 'required|exists:departments,id',
            'add_roles_id' => 'required|exists:add_roles,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }


        $data = new Users_info();
        $data->user_id= $request->user_id;
        $data->department_id = $request->department_id;
        $data->add_roles_id  = $request->add_roles_id;
        $data->save();

        return $this->sendSuccessResponse('User info created successfully', $data);
      } catch (\Throwable $th) {
         return $this->sendErrorResponse('An error occurred', $th->getMessage());
      }
    }


    public function show(string $id)
    {
        try{
          $user_info = Users_info::where('id', $id)->first();

          $data=[
             'userName'      => $user_info->user->name,
             'userEmail'     => $user_info->user->email,
             'userMobile_no' => $user_info->user->mobile_no,
             'department'    => $user_info->department->departments_name,
             'roles'         => $user_info->role->roles_name,
         ];
            if(!$user_info){
                return $this->sendErrorResponse('user_info not found successfully');
            }
            return $this->sendSuccessResponse('user_info retervie successfully',$data);
         } catch (\Throwable $th) {
            return $this->sendErrorResponse('An error occurred', $th->getMessage());
        }
    }

    public function update(Request $request, string $id)
    {
        
    }
 
    public function destroy(string $id)
    {
        
    }
}
