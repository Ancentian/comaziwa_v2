<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Task;
use App\Models\Employee;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use DB;

class TasksController extends Controller
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
        $projects = Project::where('tenant_id', $tenant_id)->get();
        $completeTasks = Task::join('projects', 'projects.id', '=', 'tasks.project_id')
                ->join('employees', 'employees.id', '=', 'tasks.assigned_to')
                ->where('tasks.status', 'complete')
                ->select([
                    'projects.title as projectName',
                    'employees.name as employeeName',
                    'tasks.*'
                ])->latest()->get();

        $inprogressTasks = Task::join('projects', 'projects.id', '=', 'tasks.project_id')
                ->join('employees', 'employees.id', '=', 'tasks.assigned_to')
                ->where('tasks.status', 'inprogress')
                ->select([
                    'projects.title as projectName',
                    'employees.name as employeeName',
                    'tasks.*'
                ])->latest()->get();
        return view('companies.tasks.index', compact('employees', 'projects', 'completeTasks', 'inprogressTasks'));
    }

    public function all_staff_tasks()
    {
        $tenant_id = optional(auth()->guard('employee')->user())->tenant_id;
        $employees = Employee::where('tenant_id', $tenant_id)->get();
        $projects = Project::where('tenant_id', $tenant_id)->get();
        $completeTasks = Task::join('projects', 'projects.id', '=', 'tasks.project_id')
                ->join('employees', 'employees.id', '=', 'tasks.assigned_to')
                ->where('tasks.status', 'complete')
                ->select([
                    'projects.title as projectName',
                    'employees.name as employeeName',
                    'tasks.*'
                ])->latest()->get();

        $inprogressTasks = Task::join('projects', 'projects.id', '=', 'tasks.project_id')
                ->join('employees', 'employees.id', '=', 'tasks.assigned_to')
                ->where('tasks.status', 'inprogress')
                ->select([
                    'projects.title as projectName',
                    'employees.name as employeeName',
                    'tasks.*'
                ])->latest()->get();
        return view('companies.staff.tasks.all_staff_tasks', compact('employees', 'projects', 'completeTasks', 'inprogressTasks'));
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'project_id'    => 'required',
            'title'     => 'required',
            'assigned_to'   => 'required',
            'priority'  => 'required',
            'status'    => 'required',
            'notes'     => '',
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
        Task::create([
            'tenant_id'     => $tenant_id,
            'project_id'    => $request->project_id,
            'title'         => $request->title,
            'assigned_to'    => $request->assigned_to,
            'priority'      => $request->priority,
            'status'        => $request->status,
            'notes'         => $request->notes,  
        ]);

        DB::commit();
        return response()->json(['message' => 'Task Added Successfully']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Data saving failed. Please try again.'], 500);
        }
    }

    public function store_staff_task(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'project_id'    => 'required',
            'title'     => 'required',
            'assigned_to'   => 'required',
            'priority'  => 'required',
            'status'    => 'required',
            'notes'     => '',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        DB::beginTransaction();
        try {

        Task::create([
            'tenant_id'     => optional(auth()->guard('employee')->user())->tenant_id,
            'project_id'    => $request->project_id,
            'title'         => $request->title,
            'assigned_to'    => $request->assigned_to,
            'priority'      => $request->priority,
            'status'        => $request->status,
            'notes'         => $request->notes,  
        ]);

        DB::commit();
        return response()->json(['message' => 'Task Added Successfully']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Data saving failed. Please try again.'], 500);
        }
    }

    public function edit($id)
    {
        $task = Task::findorFail($id);
        if(session('is_admin') == 1)
        {
            $tenant_id = optional(auth()->guard('employee')->user())->tenant_id;
        }else{
            $tenant_id = auth()->user()->id;
        }
        $employees = Employee::where('tenant_id', $tenant_id)->get();
        $projects = Project::where('tenant_id', $tenant_id)->get();
        return view('companies.tasks.edit', compact('task', 'employees', 'projects'));
    }

    public function editTask($id)
    {
        $task = Task::findorFail($id);
        $tenant_id = optional(auth()->guard('employee')->user())->tenant_id;
        $employees = Employee::where('tenant_id', $tenant_id)->get();
        $projects = Project::where('tenant_id', $tenant_id)->get();
        return view('companies.staff.tasks.edit_task', compact('task', 'employees', 'projects'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'project_id'    => 'required',
            'title'     => 'required',
            'assigned_to'   => 'required',
            'priority'  => 'required',
            'status'    => 'required',
            'notes'     => '',
            'project_id' => 'required'
        ]);

        DB::beginTransaction();
        try {
        $task = Task::findOrFail($id);

        $task->project_id = $request->project_id;
        $task->title = $request->title;
        $task->assigned_to = $request->assigned_to;
        $task->priority = $request->priority;
        $task->status = $request->status;
        $task->notes = $request->notes;
        $task->save();

        DB::commit();
        return response()->json(['message' => 'Task Updated Successfully']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Data saving failed. Please try again.'], 500);
        }

    }

    public function delete($id)
    {
        DB::beginTransaction();
        try {
        $task = Task::findOrFail($id);
        $task->delete();

        DB::commit();
        return response()->json(['message' => 'Task Deleted Successfully']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Data saving failed. Please try again.'], 500);
        }

    }
}
