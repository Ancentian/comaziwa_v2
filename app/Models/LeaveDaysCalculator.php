<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Leave;
use App\Models\Employee;
use App\Models\LeaveType;
class LeaveDaysCalculator extends Model
{
    use HasFactory;
 
    public static function calculateLeaveDays($employee_id,$type = null)
    {
        $leaveRecords = Leave::where('employee_id', $employee_id)->where('status','!=',2)->where('type',$type)->get();
        $employee = Employee::findOrFail($employee_id);
        $leave_type= LeaveType::findOrFail($type);
        

        $years = date('Y') - date('Y',strtotime($employee->created_at)) + 1;
        
        $value = $leave_type->leave_days; //config('leave.leave_days');
        
        $leave_days = $value*$years;

        $totalDaysTaken = 0;

        foreach ($leaveRecords as $leave) {
            $fromDate = strtotime($leave->date_from);
            $toDate = strtotime($leave->date_to);

            // Calculate the difference in seconds between the two dates
            $dateDiff = $toDate - $fromDate;

            // Convert the difference to days
            $leaveTaken = floor($dateDiff / (60 * 60 * 24));

            $totalDaysTaken += $leaveTaken;
        }

        
        return ['total' => $leave_days, 'taken' => $totalDaysTaken, 'balance' => $leave_days - $totalDaysTaken];
    }
    
    public static function calculateLeaveDaysCategory($employee_id,$category)
    {
        $leaveRecords = Leave::where('employee_id', $employee_id)->where('type',$category)->where('status','!=',2)->get();

        $totalDaysTaken = 0;

        foreach ($leaveRecords as $leave) {
            $fromDate = strtotime($leave->date_from);
            $toDate = strtotime($leave->date_to);

            // Calculate the difference in seconds between the two dates
            $dateDiff = $toDate - $fromDate;

            // Convert the difference to days
            $leaveTaken = floor($dateDiff / (60 * 60 * 24));

            $totalDaysTaken += $leaveTaken;
        }

        
        return $totalDaysTaken;;
    }

}
