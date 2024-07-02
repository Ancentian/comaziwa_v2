<?php

namespace App\Http\Controllers;

use App\Models\ContractType;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Training;
use App\Models\TrainingRequest;
use Illuminate\Support\Facades\Response;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use DB;
use Illuminate\Support\Facades\Storage;

class TrainingsController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            if(session('is_admin') == 1)
            {
                $tenant_id = optional(auth()->guard('employee')->user())->tenant_id;
            }else{
                $tenant_id = auth()->user()->id;
            }
            $training = Training::where('tenant_id', $tenant_id)->get();
            
            return DataTables::of($training)
            ->addColumn('action', function ($row) {
                $status = $row->status;
                $actionText = ($status == 1) ? 'Deactivate' : 'Activate';
                $actionIcon = ($status == 1) ? 'fa fa-times m-r-5 text-danger' : 'fa fa-check m-r-5 text-success';
            
                $html = '<div class="btn-group">
                    <button type="button" class="badge btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
                    <div class="dropdown-menu dropdown-menu-right">';
                    
                        if(staffCan("edit.training")) { 
                            $html .= '<a class="dropdown-item edit-button" data-action="' . url('trainings/edit-training', [$row->id]) . '" href="#"><i class="fa fa-pencil m-r-5"></i> Edit</a>';
                        } 
                        
                        if(staffCan("invite.individual")){ 
                            $html .= '<a class="dropdown-item edit-button" data-action="' . url('trainings/invite-staff', [$row->id]) . '" href="#"><i class="fa fa-plus m-r-5"></i> Add individual Staff</a>';
                        } 
                        
                        if(staffCan('invite.department')){ 
                            $html .= '<a class="dropdown-item edit-button" data-action="' . url('trainings/invite-departments', [$row->id]) . '" href="#"><i class="fa fa-plus m-r-5"></i> Add by Departments</a>';
                        } 
                        
                        if(staffCan("delete.training")){ 
                            $html .= '<a class="dropdown-item delete-button" data-action="' . url('trainings/delete-training', [$row->id]) . '" href="#"><i class="fa fa-trash-o m-r-5"></i> Delete</a>';
                        } 
                        
                    $html .= '</div>
                </div>';
                return $html;
            })
            ->editColumn('start_date', function ($row) {
                $html = format_date($row->start_date);
                return $html;
            })
            ->editColumn('end_date', function ($row) {
                $html = format_date($row->end_date);
                return $html;
            })

            ->editColumn(
                'status', 
            function ($row) {
                $html = '';
                if ($row->status == "2") {
                    $html = '<span><i class="fa fa-dot-circle-o text-danger"></i> Inactive</span>';
                } elseif ($row->status <= "1") {
                    $html = "<span><i class='fa fa-dot-circle-o text-success'></i> Active</span>";
                } 
                return $html;
            })
            ->rawColumns(['action', 'status'])
            ->make(true);
        }
        return view('companies.trainings.index');
    }

    public function pendingTrainings()
    {
        if (request()->ajax()) {
            if(session('is_admin') == 1)
            {
                $tenant_id = optional(auth()->guard('employee')->user())->tenant_id;
            }else{
                $tenant_id = auth()->user()->id;
            }
            $training = TrainingRequest::join('trainings','trainings.id','training_requests.training_id')
                            ->join('employees','employees.id','training_requests.employee_id')
                            ->where('training_requests.approval_status',0)
                            ->where('training_requests.is_invited',0)
                            ->where('trainings.tenant_id', $tenant_id)->select(
                                [
                                    'employees.name as employeeName',
                                    'trainings.name as trainingName',
                                    'training_requests.*',
                                    'trainings.type as trainingType'
                                ]
                            )->get();
            
            return DataTables::of($training)
            ->addColumn('action', function ($row) {
                $status = $row->status;

                
                $html = '<div class="btn-group">
                    <button type="button" class="badge btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
                    <div class="dropdown-menu dropdown-menu-right">';
                    
                        if(staffCan("approve.training")){ 
                            $html = '<a class="dropdown-item expense-edit-button" data-id="1" data-action="' . url('trainings/edit-status', [$row->id]) . '" href="#"><i class="fa fa-check m-r-5 text-success" ></i>Approve</a>';
                        } 
                        
                        if(staffCan("decline.training")){ 
                            $html = '<a class="dropdown-item expense-edit-button" data-id="2" data-action="'.url('trainings/edit-status',[$row->id]).'" href="#" ><i class="fa fa-times m-r-5 text-danger"></i> Decline</a>';
                        } 
                        
                        if(staffCan("delete.training")){ 
                            $html = '<a class="dropdown-item delete-button" data-action="' . url('trainings/delete-request', [$row->id]) . '" href="#"><i class="fa fa-trash-o m-r-5"></i> Delete</a>';
                        } 
                        
                        
                    $html = '</div>
                </div>';
                return $html;
            })
            ->editColumn('created_at','{{date("d/m/Y H:i",strtotime($created_at))}}')
            ->rawColumns(['action', 'status'])
            ->make(true);
        }
        return view('companies.trainings.list-pending');
    }

    public function listRequests()
    {
        if (request()->ajax()) {
            if(session('is_admin') == 1)
            {
                $tenant_id = optional(auth()->guard('employee')->user())->tenant_id;
            }else{
                $tenant_id = auth()->user()->id;
            }
            $training = TrainingRequest::join('trainings','trainings.id','training_requests.training_id')
                            ->join('employees','employees.id','training_requests.employee_id')
                            ->where('training_requests.approval_status','>',0)
                            ->where('trainings.tenant_id', $tenant_id)->select(
                                [
                                    'employees.name as employeeName',
                                    'trainings.name as trainingName',
                                    'training_requests.*',
                                    'trainings.type as trainingType'
                                ]
                            )->get();
            
            return DataTables::of($training)
            ->addColumn('action', function ($row) {
                $status = $row->status;
                $action = "";
                if($row->approval_status == 2 && $row->completion_status == 0 && staffCan('approve.training')){
                    $action .= '<a class="dropdown-item expense-edit-button" data-id="1" data-action="' . url('trainings/edit-status', [$row->id]) . '" href="#"><i class="fa fa-check m-r-5 text-success" ></i>Approve</a>';                          
                }else{
                    if($row->completion_status == 0 && staffCan('decline.training')){
                        $action .= '<a class="dropdown-item expense-edit-button" data-id="2" data-action="'.url('trainings/edit-status',[$row->id]).'" href="#" ><i class="fa fa-times m-r-5 text-danger"></i> Decline</a>';    
                    }
                    
                }

                if($row->completion_status == 0 && $row->approval_status == 1){
                    $action .= '<a class="dropdown-item expense-edit-button" data-id="1" data-action="' . url('trainings/edit-complete-status', [$row->id]) . '" href="#"><i class="fa fa-check m-r-5 text-success" ></i>Completed</a>';
                    $action .= '<a class="dropdown-item expense-edit-button" data-id="2" data-action="'.url('trainings/edit-complete-status',[$row->id]).'" href="#" ><i class="fa fa-times m-r-5 text-danger"></i> Not Completed</a>';    
                }elseif($row->completion_status == 2 && $row->approval_status == 1){
                    $action .= '<a class="dropdown-item expense-edit-button" data-id="1" data-action="' . url('trainings/edit-complete-status', [$row->id]) . '" href="#"><i class="fa fa-check m-r-5 text-success" ></i>Completed</a>';
                    
                }else{
                    if($row->approval_status == 1){
                        $action .= '<a class="dropdown-item expense-edit-button" data-id="2" data-action="'.url('trainings/edit-complete-status',[$row->id]).'" href="#" ><i class="fa fa-times m-r-5 text-danger"></i> Not Completed</a>
                        
                        <a class="dropdown-item delete-button" data-action="' . url('trainings/delete-request', [$row->id]) . '" href="#"><i class="fa fa-trash-o m-r-5"></i> Delete</a>';    
                    }
                    
                }

                
                $html = '<div class="btn-group">
                    <button type="button" class="badge btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
                    <div class="dropdown-menu dropdown-menu-right">
                    '.$action.'
                        <a class="dropdown-item edit-button" data-action="'.url('trainings/upload-certificate',[$row->id]).'" href="#" ><i class="fa fa-upload m-r-5 "></i> Upload Certificate</a>
                    </div>
                </div>';
                return $html;
            })
            ->editColumn(
                'approval_status', 
                function ($row) {
                    $html = '';
                    if ($row->approval_status == "2") {
                        $html = '<span><i class="fa fa-dot-circle-o text-danger"></i> Declined</span>';
                    } elseif ($row->approval_status == "1") {
                        $html = "<span><i class='fa fa-dot-circle-o text-success'></i> Approved</span>";
                    } elseif ($row->approval_status == "0") {
                        $html = "<span><i class='fa fa-dot-circle-o text-warning'></i> Pending</span>";
                    }
                    return $html;
            })

            ->editColumn(
                'completion_status', 
                function ($row) {
                    $html = '';
                    if ($row->completion_status == "2") {
                        $html = '<span><i class="fa fa-dot-circle-o text-danger"></i> Dropped Out</span>';
                    } elseif ($row->completion_status == "1") {
                        $html = "<span><i class='fa fa-dot-circle-o text-success'></i> Completed</span>";
                    } elseif ($row->completion_status == "0") {
                        $html = "<span><i class='fa fa-dot-circle-o text-warning'></i> Pending</span>";
                    }
                    return $html;
            })

            ->editColumn('certificate', function ($row) {
                if(!empty($row->certificate)){
                    return '<a class="badge btn-success" href="'.url('trainings/view-certificate', [$row->certificate]).'" target="_blank"><i class="fa fa-eye m-r-5"></i> Download</a>'; 
                }else{
                    return '<span class="text-muted">Not yet uploaded</span>'; 
                }
                
            })

            ->editColumn('created_at','{{date("d/m/Y H:i",strtotime($created_at))}}')
            ->rawColumns(['action', 'status','completion_status','approval_status', 'certificate'])
            ->make(true);
        }
        return view('companies.trainings.list-requests');
    }

    public function view_certificate($file)
    {      
        $filepath = Storage::path('public/certificates/') . $file;
        
        $headers = array('Content-Type: application/json');
        $response = response()->download($filepath,$file,$headers);
        
        if (ob_get_level() > 0) {
            ob_end_clean();
        }

        return $response;
    }

    public function store_training(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'type' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'description' => 'required',
            'vendor' => 'required',
            'time' => 'required',
            'location' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        DB::beginTransaction();
        try {
        
        if(session('is_admin') == 1)
        {
            $tenant_id = optional(auth()->guard('employee')->user())->tenant_id;
        }else{
            $tenant_id = auth()->user()->id;
        }
        Training::create([
            'tenant_id'     => $tenant_id,
            'name'       => $request->name,
            'type'       => $request->type, 
            'start_date'          => $request->start_date,
            'end_date'          => $request->end_date,
            'description'       => $request->description,
            'vendor' => $request->vendor,
            'time' => $request->time,
            'location' => $request->location,
        ]);
        
        DB::commit();
        return response()->json(['message' => 'Training Added Successfully']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Data saving failed. Please try again.'], 500);
        }
    }

    public function post_add_staff(Request $request,$id)
    {
        
        DB::beginTransaction();
        try {

        $training = Training::findOrFail($id);
        $approval = $training->type == 'compulsory' ? 1 : 0; 

        foreach($request->employees as $one){
            TrainingRequest::create([
                'training_id' => $id,
                'employee_id' => $one,
                'approval_status' => $approval,
                'is_invited' => 1,
                
                //Notify
                $training = Training::where('id', $id)->first(),
                $userdata = \App\Models\Employee::where('id', $one)->first(),
                $tenant_id = $userdata['tenant_id'],
                $company = \App\Models\CompanyProfile::where('tenant_id', $tenant_id)->first(),
                
                $build_data = ['company' => $company['name'], 'name' => $userdata['name'], 'training' => $training['name'], 'vendor' => $training['vendor'], 'email' => $userdata['email'], 'start_date' => format_date($training['start_date']),'end_date' => format_date($training['end_date']), 'to_phone' => $userdata['phone_no'], 'to_email' => $userdata['email'], 'location' => $training['location'], 'time' => $training['time']],
                $emaildata = \App\Models\TransactionalEmails::buildMsg('upcoming_training', $build_data),
            ]);
        }
        
        DB::commit();
        return response()->json(['message' => 'Added Successfully']);
        } catch (\Exception $e) {
            logger($e);
            DB::rollback();
            return response()->json(['message' => 'Data saving failed. Please try again.'], 500);
        }
    }

    public function post_add_by_department(Request $request,$id)
    {
        
        DB::beginTransaction();
        try {

        $already_added = TrainingRequest::where('training_id',$id)->pluck('employee_id');
        $training = Training::findOrFail($id);
        $approval = $training->type == 'compulsory' ? 1 : 0;
        $employees = Employee::where('tenant_id',auth()->user()->id)->whereIn('contract_type',$request->employees)->whereNotIn('id', $already_added)->get();

        foreach($employees as $one){
            
            TrainingRequest::create([
                'training_id' => $id,
                'employee_id' => $one->id,
                'approval_status' => $approval,
                'is_invited' => 1
            ]);
        }
        
        DB::commit();
        return response()->json(['message' => 'Added Successfully']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Data saving failed. Please try again.'], 500);
        }
    }

    public function edit_training($id)
    {
        $training = Training::findorFail($id);
        return view('companies.trainings.edit', compact('training'));
    }

    public function add_staff($id)
    {
        $already_added = TrainingRequest::where('training_id',$id)->pluck('employee_id');
        $training = Training::findorFail($id);
        if(session('is_admin') == 1)
        {
            $tenant_id = optional(auth()->guard('employee')->user())->tenant_id;
        }else{
            $tenant_id = auth()->user()->id;
        }
        $employees = Employee::where('tenant_id', $tenant_id)->whereNotIn('id', $already_added)->get();
        return view('companies.trainings.add_staff', compact('training','employees'));
    }

    public function add_by_department($id)
    {
        $training = Training::findorFail($id);
        if(session('is_admin') == 1)
        {
            $tenant_id = optional(auth()->guard('employee')->user())->tenant_id;
        }else{
            $tenant_id = auth()->user()->id;
        }
        $departments = ContractType::where('tenant_id', $tenant_id)->get();
        return view('companies.trainings.add_by_department', compact('training','departments'));
    }

    public function edit_status($id)
    {
        $training = TrainingRequest::findorFail($id);
        return view('companies.trainings.status', compact('training'));
    }

    public function edit_complete_status($id)
    {
        $training = TrainingRequest::findorFail($id);
        return view('companies.trainings.complete_status', compact('training'));
    }

    public function update_training(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'type' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'description' => 'required',
            'vendor' => 'required',
            'time' => 'required',
            'location' => 'required',
        ]);
        DB::beginTransaction();
        try {

        $training = Training::findOrFail($id);
        $training->name = $request->name;
        $training->type   = $request->type; 
        $training->start_date     = $request->start_date;
        $training->end_date     = $request->end_date;
        $training->description   = $request->description;
        $training->vendor   = $request->vendor;
        $training->time   = $request->time;
        $training->location  = $request->location;
        $training->save();

        DB::commit();
            return response()->json(['message' => 'Training Updated successfully']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Data saving failed. Please try again.'], 500);
        }
    }

    public function update_status(Request $request, $id)
    {
        $request->validate([
            'status' => 'required',
        ]);

        DB::beginTransaction();
        try {

        $training = TrainingRequest::findOrFail($id);
        $training->approval_status = $request->status;
        $training->save();

        DB::commit();
            return response()->json(['message' => 'Training Updated Successfully']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Data saving failed. Please try again.'], 500);
        }

        return response()->json(['message' => 'Leave Approve successfully']);
    }

    public function update_complete_status(Request $request, $id)
    {
        $request->validate([
            'status' => 'required',
        ]);

        DB::beginTransaction();
        try {

        $training = TrainingRequest::findOrFail($id);
        $training->completion_status = $request->status;
        $training->save();

        DB::commit();
            return response()->json(['message' => 'Training Updated Successfully']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Data saving failed. Please try again.'], 500);
        }

        return response()->json(['message' => 'Leave Approve successfully']);
    }

    public function upload_certificate($id)
    {
        $training = TrainingRequest::findorFail($id);
        return view('companies.trainings.upload_certificate', compact('training'));
    }

    public function update_certificate(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'certificate' => 'required|mimes:pdf',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $trainingRequest = TrainingRequest::find($id);
        $training = Training::find($trainingRequest->training_id);

        $employee_id = $trainingRequest->employee_id;

        $employee_name = Employee::where('id', $employee_id)->first()->name;

        $name = str_replace(' ', '-', strtolower("#$employee_id-".$employee_name."_".$training->name));

        $upload_file = $name . '.' . $request->file('certificate')->extension();

        DB::beginTransaction();
        try {
            $request->file('certificate')->move(storage_path('app/public/certificates/'), $upload_file);

            $training = TrainingRequest::findOrFail($id);
            $training->certificate = $upload_file;
            $training->save();

            DB::commit();

            return response()->json(['message' => 'Certificate Uploaded successfully']);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json(['message' => 'Failed to save data. Please try again.'], 500);
        }
    }


    public function delete_training($id)
    {
        DB::beginTransaction();
        try {
        $training = Training::findOrFail($id);
        $training->delete();

        DB::commit();
            return response()->json(['message' => 'Data Deleted Successfully']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Data saving failed. Please try again.'], 500);
        }
    }

    public function delete_request($id)
    {
        DB::beginTransaction();
        try {
        $training = TrainingRequest::findOrFail($id);
        $training->delete();

        DB::commit();
            return response()->json(['message' => 'Data Deleted Successfully']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Data saving failed. Please try again.'], 500);
        }
    }
}
