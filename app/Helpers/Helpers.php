<?php 


use Carbon\Carbon;


function diff_time($in_time ,$out_time)
{

    $inTime = Carbon::parse($in_time);
    $outTime = Carbon::parse($out_time);
    $totalDuration = $outTime->diff($inTime);
    $total_hours = $totalDuration->format('%H:%I:%S');

    return $total_hours;
}
