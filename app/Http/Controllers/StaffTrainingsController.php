<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Training;

use Illuminate\Support\Facades\Response;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use DB;
use App\Models\TrainingRequest;

class StaffTrainingsController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $tenant_id = optional(auth()->guard('employee')->user())->tenant_id;
            logger($tenant_id);
            $already_added = TrainingRequest::where('employee_id',auth()->guard('employee')->user()->id)->pluck('training_id');

            $training = Training::where('tenant_id', $tenant_id)
                // ->whereNotIn('id',$already_added)
                ->where('status', '!=', 2)
                ->where('tenant_id', $tenant_id)
                ->get();
            return DataTables::of($training)
            ->addColumn(
                'action',
                function ($row) use ($already_added) {
                    if(!in_array($row->id,$already_added->toArray())){
                        $html = '<div class="btn-group">
                            <button type="button" class="badge btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
                            <div class="dropdown-menu dropdown-menu-right">
                              <a class="dropdown-item expense-edit-button" data-id="1" data-action="'.url('staff/apply-training',[$row->id]).'" href="#" ><i class="fa fa-check m-r-5 text-success"></i> Apply</a>
                            </div>
                          </div>';
                    }else{
                        $html = "<span class='text-muted'>Added / Requested</span>";
                    }
                    

                  return $html;
                }
            )
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
                if ($row->status <= "1") {
                    $html = "<span><i class='fa fa-dot-circle-o text-success'></i> Active</span>";
                } 
                return $html;
            })
            
            ->rawColumns(['action', 'status', 'upload'])
            ->make(true);
        }
        return view('companies.staff.trainings.index');
    }

    public function all_staff_trainings()
    {
        if (request()->ajax()) {
            $tenant_id = optional(auth()->guard('employee')->user())->tenant_id;
            $training = Training::where('tenant_id', $tenant_id)->get();
            
            return DataTables::of($training)
            ->addColumn('action', function ($row) {
                $status = $row->status;
                $actionText = ($status == 1) ? 'Deactivate' : 'Activate';
                $actionIcon = ($status == 1) ? 'fa fa-times m-r-5 text-danger' : 'fa fa-check m-r-5 text-success';
            
                $html = '<div class="btn-group">
                    <button type="button" class="badge btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item edit-button" data-action="' . url('trainings/edit-training', [$row->id]) . '" href="#"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                        <a class="dropdown-item edit-button" data-action="' . url('trainings/invite-staff', [$row->id]) . '" href="#"><i class="fa fa-plus m-r-5"></i> Add individual Staff</a>
                        <a class="dropdown-item edit-button" data-action="' . url('trainings/invite-departments', [$row->id]) . '" href="#"><i class="fa fa-plus m-r-5"></i> Add by Departments</a>
                        <a class="dropdown-item delete-button" data-action="' . url('trainings/delete-training', [$row->id]) . '" href="#"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                    </div>
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
        return view('companies.staff.trainings.all_staff_trainings');
    }

    public function apply_training($id)
    {
        $training = Training::findorFail($id);
        return view('companies.staff.trainings.status', compact('training'));
    }

    public function listRequests()
    {
        if (request()->ajax()) {
            
            $training = TrainingRequest::join('trainings','trainings.id','training_requests.training_id')
                            ->join('employees','employees.id','training_requests.employee_id')
                            ->where('training_requests.employee_id', auth()->guard('employee')->user()->id)
                            ->where('training_requests.is_invited',0)
                            ->select(
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
                if($row->approval_status == 0 ){
                    $action .= '<a class="dropdown-item delete-button" data-action="' . url('trainings/delete-request', [$row->id]) . '" href="#"><i class="fa fa-trash-o m-r-5"></i> Delete</a>';                          
                
                    $html = '<div class="btn-group">
                        <button type="button" class="badge btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
                        <div class="dropdown-menu dropdown-menu-right">
                        '.$action.'
                        </div>
                    </div>';
                }else{
                    $html = "<span class='text-muted'>Already approved, can't delete</span>";
                }

                
                
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
            
            ->editColumn('upload', function ($row) {
                if($row->approval_status == 1 && $row->completion_status == 1){
                    return '<a class="badge btn-info edit-button" data-action="'.url('staff/upload-certificate', [$row->id]).'" <i class="fa fa-upload m-r-5"></i> Upload</a>'; 
                }
            })

            ->editColumn('certificate', function ($row) {
                if(!empty($row->certificate)){
                    return '<a class="badge btn-success" href="'.url('trainings/view-certificate', [$row->certificate]).'" target="_blank"><i class="fa fa-eye m-r-5"></i> Download</a>'; 
                }else{
                    return '<span class="text-muted">Not yet uploaded</span>'; 
                }
                
            })

            ->editColumn('created_at','{{date("d/m/Y H:i",strtotime($created_at))}}')
            ->rawColumns(['action', 'status','completion_status','approval_status','certificate', 'upload'])
            ->make(true);
        }
        return view('companies.staff.trainings.list-requests');
    }
    
    public function listInvites()
    {
        if (request()->ajax()) {
            
            $training = TrainingRequest::join('trainings','trainings.id','training_requests.training_id')
                            ->join('employees','employees.id','training_requests.employee_id')
                            ->where('training_requests.employee_id', auth()->guard('employee')->user()->id)
                            ->where('training_requests.is_invited',1)
                            ->select(
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
                if($row->approval_status == 2){
                    $action .= '<a class="dropdown-item expense-edit-button" data-id="1" data-action="' . url('trainings/edit-status', [$row->id]) . '" href="#"><i class="fa fa-check m-r-5 text-success" ></i>Accept</a>';                          
                }elseif($row->approval_status == 0){
                    $action .= '<a class="dropdown-item expense-edit-button" data-id="1" data-action="' . url('trainings/edit-status', [$row->id]) . '" href="#"><i class="fa fa-check m-r-5 text-success" ></i>Accept</a>';                          
                    //$action .= '<a class="dropdown-item expense-edit-button" data-id="2" data-action="'.url('trainings/edit-status',[$row->id]).'" href="#" ><i class="fa fa-times m-r-5 text-danger"></i> Decline</a>';
                    $action .= '<a class="dropdown-item edit-button" data-action="'.url('staff/decline-invite',[$row->id]).'" href="#" ><i class="fa fa-times m-r-5 text-danger"></i> Decline</a>';    
                }else{
                    //$action .= '<a class="dropdown-item expense-edit-button" data-id="2" data-action="'.url('trainings/edit-status',[$row->id]).'" href="#" ><i class="fa fa-times m-r-5 text-danger"></i> Decline</a>';
                    $action .= '<a class="dropdown-item edit-button" data-action="'.url('staff/decline-invite',[$row->id]).'" href="#" ><i class="fa fa-times m-r-5 text-danger"></i> Decline</a>';    
                }

                // if($row->completion_status == 0 && $row->approval_status == 1){
                //     $action .= '<a class="dropdown-item expense-edit-button" data-id="1" data-action="' . url('trainings/edit-complete-status', [$row->id]) . '" href="#"><i class="fa fa-check m-r-5 text-success" ></i>Completed</a>';
                //     $action .= '<a class="dropdown-item expense-edit-button" data-id="2" data-action="'.url('trainings/edit-complete-status',[$row->id]).'" href="#" ><i class="fa fa-times m-r-5 text-danger"></i> Not Completed</a>';    
                // }elseif($row->completion_status == 2 && $row->approval_status == 1){
                //     $action .= '<a class="dropdown-item expense-edit-button" data-id="1" data-action="' . url('trainings/edit-complete-status', [$row->id]) . '" href="#"><i class="fa fa-check m-r-5 text-success" ></i>Completed</a>';
                    
                // }else{
                //     if($row->approval_status == 1){
                //         $action .= '<a class="dropdown-item expense-edit-button" data-id="2" data-action="'.url('trainings/edit-complete-status',[$row->id]).'" href="#" ><i class="fa fa-times m-r-5 text-danger"></i> Not Completed</a>';    
                //     }
                    
                // }

                
                $html = '<div class="btn-group">
                    <button type="button" class="badge btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
                    <div class="dropdown-menu dropdown-menu-right">
                    '.$action.'
                         <a class="dropdown-item delete-button" data-action="' . url('trainings/delete-request', [$row->id]) . '" href="#" hidden><i class="fa fa-trash-o m-r-5"></i> Delete</a>
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
            ->rawColumns(['action', 'status','completion_status','approval_status','certificate'])
            ->make(true);
        }
        return view('companies.staff.trainings.list-invites');
    }


    public function post_apply_training(Request $request, $id)
    { 
        DB::beginTransaction();
        try {
        
            $data = [
                'employee_id' => auth()->guard('employee')->user()->id,
                'training_id' => $id
            ];

        $training = TrainingRequest::create($data);
        
        DB::commit();
            return response()->json(['message' => 'Training Applied Successfully']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Data saving failed. Please try again.'], 500);
        }

        return response()->json(['message' => 'Leave Approve successfully']);
    }
    
    public function upload_training_certificate($id)
    {
        $training = TrainingRequest::findorFail($id);
        return view('companies.staff.trainings.upload_certificate', compact('training'));
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

    public function decline_invite($id)
    {
        $training = TrainingRequest::findorFail($id);
        return view('companies.staff.trainings.decline-invite', compact('training'));
    }

    public function post_decline_invite(Request $request, $id)
    {
        $request->validate([
            'approval_status' => 'required',
            'decline_reasons' => 'required',
        ]);
        DB::beginTransaction();
        try {

        $training = TrainingRequest::findOrFail($id);
        $training->approval_status = $request->approval_status;
        $training->decline_reasons = $request->decline_reasons;
        $training->save();

        DB::commit();
            return response()->json(['message' => 'Training Successfully Declined']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Data saving failed. Please try again.'], 500);
        }

    }

}
