<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiResponseTrait;
use App\Models\attendance;
use App\Models\departments;
use App\Models\User;
use App\Models\Users_info;
use Illuminate\Support\Facades\Auth;


class SearchController extends Controller
{

    use ApiResponseTrait;

    public function search(Request $request)
    {
        try {
                $query= Users_info::query();
                if($request->department){
                    $department = departments::where('departments_name', $request->department)->first();
                    $departments_id=$department->id;
                    $data=$query->where('department_id', $departments_id)->get();
                }
                if($request->username){
                   $username = User::where('name', $request->username)->first();
                   $user_id=$username->id;
                   $data=$query->where('user_id', $user_id)->get();
                }
                if ($request->has('date')) {
                    $date_ids = attendance::where('date', $request->date)->get()->pluck('users_info_id');;
                    $data = $query->whereIn('id', $date_ids)->get();
                }
                if ($data->isEmpty()) {
                    return $this->sendErrorResponse('No results found.');
                }
                 $data1 = [];
                    foreach ($data as $item) {
                         $data1[] = [
                             'userName'      => $item->user->name,
                             'userEmail'     => $item->user->email,
                             'userMobile_no' => $item->user->mobile_no,
                             'department'    => $item->department->departments_name,
                             'roles'         => $item->role->roles_name,
                             'date'          => $item->attendance->date ?? 'null',
                             'in_time'       => $item->attendance->in_time  ?? 'null',
                             'out_time'      => $item->attendance->out_time  ?? 'null',
                             'total_hours'   => diff_time($item->attendance->in_time, $item->attendance->out_time),
                        ];
                    }
            return $this->sendSuccessResponse('Search results retrieved successfully', $data1);
        } catch (\Throwable $th) {
            return $this->sendErrorResponse('No results found.');
        }
    }

    public function search_user(Request $request)
    {
        try {

            $user = Auth::user();
            $user_id = $user->id;

            $data = attendance::where(['date' => $request->date, 'users_id' => $user_id])->first();

            if($data){
                $data[] = [
                    'userName'      => $data->user->name,
                    'userEmail'     => $data->user->email,
                    'userMobile_no' => $data->user->mobile_no,
                    'department'    => $data->department->departments_name,
                    'roles'         => $data->role->roles_name,
                    'date'          => $data->attendance->date,
                    'in_time'       => $data->attendance->in_time,
                    'out_time'      => $data->attendance->out_time,
                    'total_hours'   => diff_time($data->attendance->in_time, $data->attendance->out_time),
               ];
            }
            else{
                return $this->sendErrorResponse('No results found.');
            }
            return $this->sendSuccessResponse('Search results retrieved successfully', $data);
        } catch (\Throwable $th) {
            return $this->sendErrorResponse('No results found.', $th);
        }
    }
}
