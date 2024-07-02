<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Employee;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Response;
use Illuminate\Http\JsonResponse;
use DB;
use PDF;

class ProjectsController extends Controller
{
    public function index()
    {
        if(session('is_admin') == 1)
        {
            $tenant_id = optional(auth()->guard('employee')->user())->tenant_id;
        }else{
            $tenant_id = auth()->user()->id;
        }
        $employees = Employee::where('tenant_id', $tenant_id)->get();
        if (request()->ajax()) {
            $tenant_id = auth()->user()->id;
            $projects = Project::join('employees','employees.id','=','projects.team_leader')
                            ->where('projects.tenant_id',$tenant_id)
                            ->select([
                                'employees.name as employeeName',
                                'projects.*'
                            ])->get();

            return DataTables::of($projects)
            ->editColumn('start_date', function ($row) {
                $html = format_date($row->start_date);
                return $html;
            })
            ->editColumn('due_date', function ($row) {
                $html = format_date($row->due_date);
                return $html;
            })
            ->addColumn(
                'action',
                function ($row) {
                    $html = '<div class="btn-group">
                    <button type="button" class="badge btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
                    <div class="dropdown-menu dropdown-menu-right">';
                    
                    if(staffCan('edit.project')){
                      $html .= '<a class="dropdown-item edit-button" data-action="'.url('projects/editProject',[$row->id]).'" href="#" ><i class="fa fa-pencil m-r-5"></i> Edit</a>';
                    }
                    
                    if(staffCan('delete.project')){
                      $html .= '<a class="dropdown-item delete-button" data-action="'.url('projects/deleteProject',[$row->id]).'" href="#" ><i class="fa fa-trash-o m-r-5"></i> Delete</a>';
                    }
                    
                    $html .= '
                    </div>
                  </div>';

                  return $html;
                })

                ->editColumn(
                    'project_team',
                function ($row) {
                    $employees = json_decode($row->project_team);
                    $html = "";
                    if(!empty($employees)){
                        foreach($employees as $one){
                            $staff = Employee::where('id',$one)->first();
                            if(!empty($staff)){
                                $html .= $staff->name.", ";
                            }
                        }
                    }
                    return $html;
                })

                ->editColumn(
                    'priority',
                    function ($row) {
                        $html = "" ;
                        if($row->priority == "high"){
                            $html = "<span class='badge text-danger'>High</span>";
                        }elseif($row->priority == "medium"){
                            $html = "<span class='badge text-info'>Medium</span>";
                        }else{
                            $html = "<span class='badge text-secondary'>Low</span>";
                        }

                        return $html;
                })

                ->editColumn(
                    'progress',
                    function ($row) {
                        $color = "";
                        if($row->progress < 50){
                            $color = "bg-danger";
                        }elseif($row->progress > 50 && $row->progress < 75){
                            $color = "bg-info";
                        }else{
                            $color = "bg-success";
                        }

                        $html = '<div class="progress mb-2" style="height: 5px;">
                                    <div class="progress-bar '.$color.'" role="progressbar" style="width:'.$row->progress.'%;" aria-valuenow="'.$row->progress.'" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>&nbsp;<b>'.$row->progress.'%</b>';

                        return $html;
                })
            
            ->rawColumns(['action','priority','progress'])
            ->make(true);
        }
        return view('companies.projects.index', compact('employees'));
    }

    public function all_staff_projects()
    {
        $tenant_id = optional(auth()->guard('employee')->user())->tenant_id;
        logger($tenant_id);
        $employees = Employee::where('tenant_id', $tenant_id)->get();
        if (request()->ajax()) {
            $tenant_id = optional(auth()->guard('employee')->user())->tenant_id;
            $projects = Project::join('employees','employees.id','=','projects.team_leader')
                            ->where('projects.tenant_id',$tenant_id)
                            ->select([
                                'employees.name as employeeName',
                                'projects.*'
                            ])->get();
                            logger($projects);

            return DataTables::of($projects)
            ->editColumn('start_date', function ($row) {
                $html = format_date($row->start_date);
                return $html;
            })
            ->editColumn('due_date', function ($row) {
                $html = format_date($row->due_date);
                return $html;
            })
            ->addColumn(
                'action',
                function ($row) {
                    $html = '<div class="btn-group">
                    <button type="button" class="badge btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
                    <div class="dropdown-menu dropdown-menu-right">';
                    
                    if(staffCan('edit.project')){
                      $html .= '<a class="dropdown-item edit-button" data-action="'.url('staff/editProject',[$row->id]).'" href="#" ><i class="fa fa-pencil m-r-5"></i> Edit</a>';
                    }
                    
                    if(staffCan('delete.project')){
                      $html .= '<a class="dropdown-item delete-button" data-action="'.url('projects/deleteProject',[$row->id]).'" href="#" ><i class="fa fa-trash-o m-r-5"></i> Delete</a>';
                    }
                    
                    $html .= '
                    </div>
                  </div>';

                  return $html;
                })

                ->editColumn(
                    'project_team',
                function ($row) {
                    $employees = json_decode($row->project_team);
                    $html = "";
                    if(!empty($employees)){
                        foreach($employees as $one){
                            $staff = Employee::where('id',$one)->first();
                            if(!empty($staff)){
                                $html .= $staff->name.", ";
                            }
                        }
                    }
                    return $html;
                })

                ->editColumn(
                    'priority',
                    function ($row) {
                        $html = "" ;
                        if($row->priority == "high"){
                            $html = "<span class='badge text-danger'>High</span>";
                        }elseif($row->priority == "medium"){
                            $html = "<span class='badge text-info'>Medium</span>";
                        }else{
                            $html = "<span class='badge text-secondary'>Low</span>";
                        }

                        return $html;
                })

                ->editColumn(
                    'progress',
                    function ($row) {
                        $color = "";
                        if($row->progress < 50){
                            $color = "bg-danger";
                        }elseif($row->progress > 50 && $row->progress < 75){
                            $color = "bg-info";
                        }else{
                            $color = "bg-success";
                        }

                        $html = '<div class="progress mb-2" style="height: 5px;">
                                    <div class="progress-bar '.$color.'" role="progressbar" style="width:'.$row->progress.'%;" aria-valuenow="'.$row->progress.'" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>&nbsp;<b>'.$row->progress.'%</b>';

                        return $html;
                })
            
            ->rawColumns(['action','priority','progress'])
            ->make(true);
        }
        return view('companies.staff.projects.all_staff_projects', compact('employees'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|min:3|max:100',
            'start_date' => 'required',
            'due_date' => 'required',
            'priority' => 'required',
            'team_leader' => 'required',
            'project_team' => 'required|array',
            'progress'     =>   'required',
            'notes'        => '',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        DB::beginTransaction();
        try {
        $team = json_encode($request->input('project_team'));
        
        if(session('is_admin') == 1)
        {
            $tenant_id = optional(auth()->guard('employee')->user())->tenant_id;
        }else{
            $tenant_id = auth()->user()->id;
        }
        Project::create([
            'tenant_id'     => $tenant_id,
            'title'         => $request->title,
            'start_date'    => $request->start_date,
            'due_date'      => $request->due_date, 
            'priority'      => $request->priority,
            'team_leader'   => $request->team_leader,
            'project_team'  => $team, 
            'progress'      => $request->progress,
            'notes'         => $request->notes,  
        ]);

        DB::commit();
            return response()->json(['message' => 'Project Added Successfully']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Data saving failed. Please try again.'], 500);
        }
  
    }
    //User Create Project
    public function storeStaffProject(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|min:3|max:100',
            'start_date' => 'required',
            'due_date' => 'required',
            'priority' => 'required',
            'team_leader' => 'required',
            'project_team' => 'required|array',
            'progress'     =>   'required',
            'notes'        => '',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        DB::beginTransaction();
        try {
        $team = json_encode($request->input('project_team'));
        
        Project::create([
            'tenant_id'     => optional(auth()->guard('employee')->user())->tenant_id,
            'title'         => $request->title,
            'start_date'    => $request->start_date,
            'due_date'      => $request->due_date, 
            'priority'      => $request->priority,
            'team_leader'   => $request->team_leader,
            'project_team'  => $team, 
            'progress'      => $request->progress,
            'notes'         => $request->notes,  
        ]);

        DB::commit();
            return response()->json(['message' => 'Project Added Successfully']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Data saving failed. Please try again.'], 500);
        }
  
    }

    public function edit($id){
        $project = Project::findOrFail($id);
        if(session('is_admin') == 1)
        {
            $tenant_id = optional(auth()->guard('employee')->user())->tenant_id;
        }else{
            $tenant_id = auth()->user()->id;
        }
        $employees = Employee::where('tenant_id', $tenant_id)->get();
        return view('companies.projects.edit',compact('project', 'employees'));
    }

    public function edit_project($id){
        $project = Project::findOrFail($id);
        $tenant_id = optional(auth()->guard('employee')->user())->tenant_id;
        $employees = Employee::where('tenant_id', $tenant_id)->get();
        return view('companies.staff.projects.edit_project',compact('project', 'employees'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|min:3|max:100',
            'start_date' => 'required',
            'due_date' => 'required',
            'priority' => 'required',
            'team_leader' => 'required',
            'project_team' => 'required|array',
            'progress'     =>   'required',
            'notes'        => '',
        ]);

        DB::beginTransaction();
        try {

            $project = Project::findOrFail($id);

            $team = json_encode($request->input('project_team'));

            $project->title = $request->title;
            $project->start_date = $request->start_date;
            $project->due_date = $request->due_date;
            $project->priority = $request->priority;
            $project->team_leader = $request->team_leader;
            $project->project_team = $team;
            $project->progress = $request->progress;
            $project->notes = $request->notes;
            $project->save();

            DB::commit();
            return response()->json(['message' => 'Data Updated successfully']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Data saving failed. Please try again.'], 500);
        }

    }
    

    public function print_project(Request $request)
    {
        if(session('is_admin') == 1)
        {
            $tenant_id = optional(auth()->guard('employee')->user())->tenant_id;
        }else{
            $tenant_id = auth()->user()->id;
        }
        $action = $request->input('action');
        $projects = Project::join('employees','employees.id','=','projects.team_leader')
                        ->where('projects.tenant_id',$tenant_id)
                        ->select([
                            'employees.name as employeeName',
                            'projects.*'
                        ])->get();
        logger($projects);
        $company = company()->mycompany();
        
        $today = date('d/m/Y');

        $company_name = $company->name;
        $period = date('M,Y', strtotime($today));
        $data = [
            'projects' => $projects,
            'company' => $company,
        ];

        
        if ($action === 'download') {
            $pdf = PDF::loadView('companies.projects.print_projects', $data);
            $pdf->setPaper('a4', 'portrait');
            $filename = $company->id . "#" . date('MY',strtotime($period)) . "ProjectsReport.pdf";
            $pdf->save(storage_path('app/public/exports/' . $filename)); // Save the PDF to a storage location
            $pdfUrl = url('payslip-exports/download-pdfs',[$filename]); // Get the URL of the saved PDF
            
            return response()->json(['pdfUrl' => $pdfUrl]);
        } elseif ($action === 'print') {
            return view('companies.projects.print_projects', compact('projects', 'company'));
        }
    }

    public function deleteProject($id)
    {
        DB::beginTransaction();
        try {

        $project = Project::findOrFail($id);
        $project->delete();

        DB::commit();
            return response()->json(['message' => 'Project Deleted Successfully']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Data saving failed. Please try again.'], 500);
        }

    }
}
