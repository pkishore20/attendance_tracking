<?php

namespace App\Http\Controllers;


use App\Models\attendance;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiResponseTrait;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;

class AttendanceController extends Controller
{
    use ApiResponseTrait;

   
    public function index()
    {
        try {
            $attendances = attendance::all();

            if ($attendances->isEmpty()) {
                return $this->sendErrorResponse('attendace not found successfully');
            }

          $data=[];
         foreach($attendances as $attendance){
            $data []=[
                'userName'     => $attendance->User_info->user->name,
                'userEmail'    => $attendance->User_info->user->email,
                'userMobile_no'=> $attendance->User_info->user->mobile_no,
                'department'   => $attendance->User_info->department->departments_name,
                'roles'        => $attendance->User_info->role->roles_name,
                'date'         => $attendance->date,
                'Int_time'     => $attendance->in_time,
                'Out_time'     => $attendance->out_time,
            ];
           }
            return $this->sendSuccessResponse('Attendance retervie successfully',$data);
        } catch (\Throwable $th) {
                   return $this->sendSuccessResponse($th);
        }
    }
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'users_info_id' => 'required|exists:users_infos,id',
                'date'          => 'required|date',
                'in_time'       => 'required|date_format:H:i',
                'out_time'      => 'required|date_format:H:i|after:in_time',
            ]);
    
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
    
            $data = new attendance();
            $data->users_info_id = $request->users_info_id;
            $data->date = $request->date;
            $data->in_time = $request->in_time;
            $data->out_time = $request->out_time;
    
            
            $data->total_hours =diff_time($data->in_time , $data->out_time);
    
            $data->save();
    
            return $this->sendSuccessResponse('Attendance created successfully', $data);
    
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1062) { 
                return $this->sendErrorResponse('Attendance for this user on the selected date already exists.');
            }
        } catch (\Throwable $th) {
            return $this->sendErrorResponse('An error occurred', $th->getMessage());
        }
    }
    public function show(string $id)
    {
        try{
            $attendance = attendance::where('id', $id)->first();

            $data=[
                'userName'     => $attendance->User_info->user->name,
                'userEmail'    => $attendance->User_info->user->email,
                'userMobile_no'=> $attendance->User_info->user->mobile_no,
                'department'   => $attendance->User_info->department->departments_name,
                'roles'        => $attendance->User_info->role->roles_name,
                'date'         => $attendance->date,
                'Int_time'     => $attendance->in_time,
                'Out_time'     => $attendance->out_time,
            ];

            if(!$attendance){
                return $this->sendErrorResponse('attendance not found successfully');
            }
            return $this->sendSuccessResponse('attendance retervie successfully',$data);
        }catch (\Throwable $th) {
            return $this->sendSuccessResponse($th);
        }   
    }
  
    public function update(Request $request, string $id)
    {
        
    }


    public function destroy(string $id)
    {
        
    }
}
