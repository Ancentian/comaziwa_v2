<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Employee;
use Illuminate\Support\Arr;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
             
        if(session('is_admin') == 1)
        {
            $tenant_id = optional(auth()->guard('employee')->user())->tenant_id;
        }else{
            $tenant_id = auth()->user()->id;
        }
        if (request()->ajax()) {
            if(session('is_admin') == 1)
            {
                $tenant_id = optional(auth()->guard('employee')->user())->tenant_id;
            }else{
                $tenant_id = auth()->user()->id;
            }
            $employee_id = $request->input('employee_id');
            $month = $request->input('month');

            if(empty($employee_id)){
                $employees = Employee::where('tenant_id', $tenant_id)->get();
            }else{
                $employees = Employee::where('id',$employee_id)->get();
            }
            
            $days = date('t',strtotime($month));
            $thismonth = date('m',strtotime($month));

            $attendance_array = array();
            $calendar_days = [];
    
            for($i=0; $i< (int)$days; $i++){
                $day = str_pad($i+1,2,0,STR_PAD_LEFT);
                $thisday = date("$day/$thismonth/Y");
                $calendar_days[] = $thisday;
            }
    
            foreach($employees as $one){
                $attended = [];
                for($i=0; $i< (int)$days; $i++){
                    $day = str_pad($i+1,2,0,STR_PAD_LEFT);
                    $thisday = date("Y-$thismonth-$day");
    
                    $did_attend = Attendance::where('tenant_id', $tenant_id)
                                    ->where('employee_id',$one->id)
                                    ->whereDate('date',$thisday)
                                    ->first(); 
                    $attended[] = !empty($did_attend) ? 1 : 0;
                }
    
                
                $attendance_array[] = ['employee_id' => $one->id, 'name' => $one->name, 'attendance' => $attended]; 
            }

            return view('employees.attendance.partials.attendance_table', compact('attendance_array', 'calendar_days'));
        }
        
        $employees = Employee::where('tenant_id', $tenant_id)->get();
        return view('employees.attendance.index', compact('employees'));
    }

    public function staff_attendances(Request $request)
    {
             
        $tenant_id = optional(auth()->guard('employee')->user())->tenant_id;
        if (request()->ajax()) {
            if(session('is_admin') == 1)
            {
                $tenant_id = optional(auth()->guard('employee')->user())->tenant_id;
            }else{
                $tenant_id = auth()->user()->id;
            }
            $employee_id = $request->input('employee_id');
            $month = $request->input('month');

            if(empty($employee_id)){
                $employees = Employee::where('tenant_id', $tenant_id)->get();
            }else{
                $employees = Employee::where('id',$employee_id)->get();
            }
            
            $days = date('t',strtotime($month));
            $thismonth = date('m',strtotime($month));

            $attendance_array = array();
            $calendar_days = [];
    
            for($i=0; $i< (int)$days; $i++){
                $day = str_pad($i+1,2,0,STR_PAD_LEFT);
                $thisday = date("$day/$thismonth/Y");
                $calendar_days[] = $thisday;
            }
    
            foreach($employees as $one){
                $attended = [];
                for($i=0; $i< (int)$days; $i++){
                    $day = str_pad($i+1,2,0,STR_PAD_LEFT);
                    $thisday = date("Y-$thismonth-$day");
    
                    $did_attend = Attendance::where('tenant_id', $tenant_id)
                                    ->where('employee_id',$one->id)
                                    ->whereDate('date',$thisday)
                                    ->first(); 
                    $attended[] = !empty($did_attend) ? 1 : 0;
                }
    
                
                $attendance_array[] = ['employee_id' => $one->id, 'name' => $one->name, 'attendance' => $attended]; 
            }

            return view('employees.attendance.partials.attendance_table', compact('attendance_array', 'calendar_days'));
        }
        
        $employees = Employee::where('tenant_id', $tenant_id)->get();
        return view('companies.staff.attendance.staff_attendances', compact('employees'));
    }

    public function staffAttendance()
    {
        if(session('is_admin') == 1)
        {
            $tenant_id = optional(auth()->guard('employee')->user())->tenant_id;
        }else{
            $tenant_id = auth()->user()->id;
        }
        $employee_id = optional(auth()->guard('employee')->user())->id;
        if (request()->ajax()) {
            

            $attendance = Attendance::where('tenant_id', $tenant_id)
                            ->where('employee_id', $employee_id)->get();
            
            $attendance_data = array();

            foreach($attendance as $one){
                $punch_ins = json_decode($one->punch_in);
                $punch_outs = json_decode($one->punch_out);

                foreach($punch_ins as $key => $punchin){
                    $attendance_data[] = array('date' => date('d/m/Y', strtotime($one->date)),'punch_in' => date('H:i:s',strtotime($punchin)), 'punch_out' => !empty($punch_outs[$key]) ? date('H:i:s',strtotime($punch_outs[$key])) : "");
                }
            }

            return DataTables::of($attendance_data)
            ->addColumn(
                'action',
                function ($row) {
                    $html = '';

                  return $html;
                }
            )
            ->rawColumns(['action'])
            ->make(true);
        }

        $attendance = Attendance::where('tenant_id', $tenant_id)
                            ->whereDate('date',date('Y-m-d'))
                            ->where('employee_id', $employee_id)->get();
        $attendance_data = array();
        foreach($attendance as $one){
            $punch_ins = json_decode($one->punch_in);
            $punch_outs = json_decode($one->punch_out);

            foreach($punch_ins as $key => $punchin){
                $attendance_data[] = array('type' => 'punch_in', 'time' => $punchin);
                if(!empty($punch_outs[$key])){
                    $attendance_data[] = array('type' => 'punch_out', 'time' => $punch_outs[$key]);
                }
                
            }
        }

        $attendance_summary = $this->fetchAttendanceSummary($employee_id);

        // dd($attendance_summary);

        return view('companies.staff.attendance.index',compact('attendance_data','attendance_summary','tenant_id','employee_id'));
    }

    function fetchAttendanceSummary($employee_id){

        $todays_hrs = 0;
        $todays_attendance = Attendance::where('employee_id', $employee_id)
                        ->whereDate('date',date('Y-m-d'))
                        ->where('employee_id', $employee_id)->get();
        foreach($todays_attendance as $today){
            $punch_ins = json_decode($today->punch_in);
            $punch_outs = json_decode($today->punch_out);

            foreach($punch_ins as $key => $punchin){
                if(!empty($punch_outs[$key])){
                    $todays_hrs += (strtotime($punch_outs[$key])-strtotime($punchin))/3600;
                }else{
                    $todays_hrs += (time()-strtotime($punchin))/3600;
                }
                
            }
        }

        $months_hrs = 0;
        $months_attendance = Attendance::where('employee_id', $employee_id)
                        ->whereDate('date','>=',date('Y-m-01'))
                        ->whereDate('date','<=',date('Y-m-t'))
                        ->where('employee_id', $employee_id)->get();
        foreach($months_attendance as $month){
            $punch_ins = json_decode($month->punch_in);
            $punch_outs = json_decode($month->punch_out);

            foreach($punch_ins as $key => $punchin){
                if(!empty($punch_outs[$key])){
                    // echo $punchin."---->".$punch_outs[$key]."<br>";
                    $months_hrs += (strtotime($punch_outs[$key])-strtotime($punchin))/3600;
                }else{
                    // echo $punchin."---->".date('H:i')."<br>";
                    $months_hrs += (time()-strtotime($punchin))/3600;
                }
                
            }
        }
        // Get the current date
        $currentDate = Carbon::now();

        // Set the start of the week (Monday)
        $startOfWeek = $currentDate->copy()->startOfWeek();

        // Set the end of the week (Sunday)
        $endOfWeek = $currentDate->copy()->endOfWeek();

        // Format the dates as desired
        $startDate = $startOfWeek->format('Y-m-d');
        $endDate = $endOfWeek->format('Y-m-d');
        
        
        $weeks_hrs = 0;
        $weeks_attendance = Attendance::where('employee_id', $employee_id)
                        ->whereDate('date','>=',$startDate)
                        ->whereDate('date','<=',$endDate)
                        ->where('employee_id', $employee_id)->get();
        foreach($weeks_attendance as $week){
            $punch_ins = json_decode($week->punch_in);
            $punch_outs = json_decode($week->punch_out);

            foreach($punch_ins as $key => $punchin){
                if(!empty($punch_outs[$key])){
                    $weeks_hrs += (strtotime($punch_outs[$key])-strtotime($punchin))/3600;
                }else{
                    $weeks_hrs += (time()-strtotime($punchin))/3600;
                }
                
            }
        }
        return array("weeks" => $weeks_hrs,"days" => $todays_hrs, "months" => $months_hrs);
    }

    public function store_punchIn(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tenant_id' => 'required',
            'employee_id' => 'required',
            'punch_in' => '',
            'punch_in_status' => '',
            'punch_out' => '',
            'punch_out_status' => '',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $date = date("Y-m-d");
        $time = date("Y-m-d H:i:s");
        $status = 1;

        DB::beginTransaction();
        try {
            $existingAttendance = Attendance::where('tenant_id', $request->tenant_id)
                ->where('employee_id', $request->employee_id)
                ->whereDate('date', $date)
                ->first();

            if ($existingAttendance) {
                $punch_ins = json_decode($existingAttendance->punch_in);
                $punch_ins[] = $time;

                $existingAttendance->punch_in = json_encode($punch_ins);
                $existingAttendance->punch_in_status = 1;
                $existingAttendance->punch_out_status = 0;
                $existingAttendance->save();
            } else {
                Attendance::create([
                    'tenant_id' => $request->tenant_id,
                    'employee_id' => $request->employee_id,
                    'date' => $date,
                    'punch_in' => json_encode([$time]),
                    'punch_in_status' => $status,
                    'punch_out' => $request->punch_out,
                ]);
            }

            DB::commit();

            return response()->json(['message' => 'Attendance Added Successfully']);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json(['message' => 'Failed to add attendance. Please try again.'], 500);
        }
    }

    public function store_punchOut(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tenant_id'     => 'required',
            'employee_id'   => 'required',
            'punch_in'      => '',
            'punch_out'     => '',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $date = date("Y-m-d");
        $time = date("Y-m-d H:i:s");
        $status = 0;

        DB::beginTransaction();
        try {
        $existingAttendance = Attendance::where('tenant_id', $request->tenant_id)
            ->where('employee_id', $request->employee_id)
            ->whereDate('date', $date)
            ->first();

        if ($existingAttendance) {
            // User already exists, update the punch-out time
            $punch_outs = json_decode($existingAttendance->punch_out);
            $punch_outs[] = $time;
            $existingAttendance->punch_out = json_encode($punch_outs);

            $existingAttendance->punch_in_status = 0;
            $existingAttendance->punch_out_status = 1;
            $existingAttendance->save();
        } else {
            // User does not exist, create a new record
            Attendance::create([
                'tenant_id'     => $request->tenant_id,
                'employee_id'   => $request->employee_id,
                'date'          => $date,
                'punch_in_status' =>$status,
                'punch_out'     => json_encode([$time]),
            ]);
        }

        DB::commit();

            return response()->json(['message' => 'Attendance Added Successfully']);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json(['message' => 'Failed to add attendance. Please try again.'], 500);
        }
    }

    public function checkPunchStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tenant_id' => 'required',
            'employee_id' => 'required',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
    
        $date = date("Y-m-d");
        $existingAttendance = Attendance::where('tenant_id', $request->tenant_id)
            ->where('employee_id', $request->employee_id)
            ->whereDate('date', $date)
            ->first();
    
        $punchedIn = false;
        $punchedOut = false;
    
        if ($existingAttendance) {
            $punchedIn = $existingAttendance->punch_in_status == 1;
            $punchedOut = $existingAttendance->punch_out_status == 1;
        }
    
        return response()->json(['punchedIn' => $punchedIn, 'punchedOut' => $punchedOut]);
    }    

}
