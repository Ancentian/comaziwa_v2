<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Mail;

use App\Models\Employee;
use App\Mail\SendMail;

use App\Models\Email;
use App\Models\EmailSettings;
use App\Models\EmailTemplate;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Excel;

class EmailsController extends Controller
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
        $templates = EmailTemplate::where('tenant_id', $tenant_id)->get();

        if (request()->ajax()) {
            $emails = Email::where('tenant_id', $tenant_id)->latest()->get();

            return DataTables::of($emails)
                ->editColumn('message', function ($row) {
                    return '<a class="badge btn-success edit-button" data-action="'.url('communications/viewemail', [$row->id]).'" <i class="fa fa-trash-o m-r-5"></i> View</a>'; 
                })
                ->editColumn('created_at', function ($row) {
                    return date('d/m/Y H:i',strtotime($row->created_at));
                })
                ->rawColumns(['message'])
                ->make(true);
        }

        return view('communications.emails', compact('employees', 'templates'));
    }

    public function staff_emails()
    {
        $tenant_id = optional(auth()->guard('employee')->user())->tenant_id;
        $employees = Employee::where('tenant_id', $tenant_id)->get();
        $templates = EmailTemplate::where('tenant_id', $tenant_id)->get();

        if (request()->ajax()) {
            $emails = Email::where('tenant_id', $tenant_id)->latest()->get();

            return DataTables::of($emails)
                ->editColumn('message', function ($row) {
                    return '<a class="badge btn-success edit-button" data-action="'.url('communications/viewemail', [$row->id]).'" <i class="fa fa-trash-o m-r-5"></i> View</a>'; 
                })
                ->editColumn('created_at', function ($row) {
                    return date('d/m/Y H:i',strtotime($row->created_at));
                })
                ->rawColumns(['message'])
                ->make(true);
        }

        return view('companies.staff.communications.index', compact('employees', 'templates'));
    }

    public function view($id){
        $email = Email::findOrFail($id);
        return view('communications.viewemail',compact('email'));
    }

    public function email_templates()
    {
        if (request()->ajax()) {
            if(session('is_admin') == 1)
            {
                $tenant_id = optional(auth()->guard('employee')->user())->tenant_id;
            }else{
                $tenant_id = auth()->user()->id;
            }
            $template = EmailTemplate::where('tenant_id', $tenant_id)->get();

            return DataTables::of($template)
            ->editColumn('template', function ($row) {
                return '<a class="badge btn-success edit-button" data-action="'.url('communications/view-template', [$row->id]).'" <i class="fa fa-trash-o m-r-5"></i> View</a>'; 
            })
            ->addColumn(
                'action',
                function ($row) {
                    $html = '<div class="btn-group">
                    <button type="button" class="badge btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
                    <div class="dropdown-menu dropdown-menu-right">
                      <a class="dropdown-item edit-button" data-action="'.url('communications/edit-template',[$row->id]).'" href="#" ><i class="fa fa-pencil m-r-5"></i> Edit</a>
                      <a class="dropdown-item delete-button" data-action="'.url('communications/delete-template',[$row->id]).'" href="#" ><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                    </div>
                  </div>';

                  return $html;
                }
            )
            ->rawColumns(['action', 'template'])
            ->make(true);
        }
        return view('communications.email_templates');
    }

    public function staff_email_templates()
    {
        if (request()->ajax()) {
            $tenant_id = optional(auth()->guard('employee')->user())->tenant_id;
            $template = EmailTemplate::where('tenant_id', $tenant_id)->get();

            return DataTables::of($template)
            ->editColumn('template', function ($row) {
                return '<a class="badge btn-success edit-button" data-action="'.url('communications/view-template', [$row->id]).'" <i class="fa fa-trash-o m-r-5"></i> View</a>'; 
            })
            ->addColumn(
                'action',
                function ($row) {
                    $html = '<div class="btn-group">
                    <button type="button" class="badge btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
                    <div class="dropdown-menu dropdown-menu-right">
                      <a class="dropdown-item edit-button" data-action="'.url('communications/edit-template',[$row->id]).'" href="#" ><i class="fa fa-pencil m-r-5"></i> Edit</a>
                      <a class="dropdown-item delete-button" data-action="'.url('communications/delete-template',[$row->id]).'" href="#" ><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                    </div>
                  </div>';

                  return $html;
                }
            )
            ->rawColumns(['action', 'template'])
            ->make(true);
        }
        return view('companies.staff.communications.email_templates');
    }

    public function sendMail(Request $request)
    {
        $emails = $request->input('email'); 
        $subject = $request->input('subject');
        $message = $request->input('message');

        DB::beginTransaction();
        try {
            foreach ($emails as $email) {
                if(session('is_admin') == 1)
                {
                    $tenant_id = optional(auth()->guard('employee')->user())->tenant_id;
                }else{
                    $tenant_id = auth()->user()->id;
                }
                $mail = [
                    'tenant_id' => $tenant_id,
                    'email' => $email,
                    'subject' => $subject,
                    'message' => $message,
                ];

                Email::create($mail);
            }

            $mail = EmailSettings::getSettings();
            $mail->to($emails)->send(new SendMail($subject, $message));

            DB::commit();

            return response()->json(['message' => 'Mail sent successfully']);
        } catch (\Exception $e) {
            DB::rollback();
            logger($e);
            return response()->json(['message' => 'An error occurred while sending the mail'], 500);
        }
    }

    public function staff_sendMail(Request $request)
    {
        $emails = $request->input('email'); 
        $subject = $request->input('subject');
        $message = $request->input('message');

        DB::beginTransaction();
        try {
            foreach ($emails as $email) {
                $mail = [
                    'tenant_id' => optional(auth()->guard('employee')->user())->tenant_id,
                    'email' => $email,
                    'subject' => $subject,
                    'message' => $message,
                ];

                Email::create($mail);
            }

            $mail = EmailSettings::getSettings();
            $mail->to($emails)->send(new SendMail($subject, $message));

            DB::commit();

            return response()->json(['message' => 'Mail sent successfully']);
        } catch (\Exception $e) {
            DB::rollback();
            logger($e);
            return response()->json(['message' => 'An error occurred while sending the mail'], 500);
        }
    }


    public function send_bulkyMails(Request $request)
    {
        return view('communications.bulkymails');
    }

    public function send_bulkyEmails(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|mimes:csv,txt,xls,xlsx',
            'subject' => 'required',
            'message'  => 'required',
        ]);

        $file = $request->file('csv_file');
        
        $parsed_array = Excel::toArray([], $file);

        // Remove header row
        $csvData = array_splice($parsed_array[0], 1);

        $subject = $request->subject;
        $message = $request->message;

        DB::beginTransaction();
        try {
            foreach ($csvData as $row) {
                $email = $row[0]; // Assuming the email address is in the first column of the CSV file
                if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $mail = EmailSettings::getSettings();
                    $mail->to($email)->queue(new SendMail($subject, $message));

                    if(session('is_admin') == 1)
                    {
                        $tenant_id = optional(auth()->guard('employee')->user())->tenant_id;
                    }else{
                        $tenant_id = auth()->user()->id;
                    }
                    $mailData = [
                        'tenant_id' => $tenant_id,
                        'email' => $email,
                        'subject' => $subject,
                        'message' => $message,
                    ];

                    Email::create($mailData);
                }
            }

            DB::commit();

            return response()->json(['message' => 'Mail sent successfully']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'An error occurred while sending the mail'], 500);
        }
    }

    public function staff_sendBulkyEmails(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|mimes:csv,txt,xls,xlsx',
            'subject' => 'required',
            'message'  => 'required',
        ]);

        $file = $request->file('csv_file');
        
        $parsed_array = Excel::toArray([], $file);

        // Remove header row
        $csvData = array_splice($parsed_array[0], 1);

        $subject = $request->subject;
        $message = $request->message;

        DB::beginTransaction();
        try {
            foreach ($csvData as $row) {
                $email = $row[0]; // Assuming the email address is in the first column of the CSV file
                if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $mail = EmailSettings::getSettings();
                    $mail->to($email)->queue(new SendMail($subject, $message));

                    $mailData = [
                        'tenant_id' => optional(auth()->guard('employee')->user())->tenant_id,
                        'email' => $email,
                        'subject' => $subject,
                        'message' => $message,
                    ];

                    Email::create($mailData);
                }
            }

            DB::commit();

            return response()->json(['message' => 'Mail sent successfully']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'An error occurred while sending the mail'], 500);
        }
    }


    public function mailSettings(Request $request)
    {
        $settings = settings()->mailsettings();
        return view('communications.mailsettings', compact('settings'));
    }

    public function staff_mailSettings(Request $request)
    {
        $settings = settings()->mailsettings();
        return view('companies.staff.communications.mail_settings', compact('settings'));
    }

    public function store_mailSettings(Request $request)
    {
        $request->validate([
            'email_from' => 'required|string|email|max:255',
            'name' => 'required|string|min:3|max:100',
            'host' => 'required|string',
            'smtp_user' => 'required',
            'password' => 'required|string|max:255',
            'port' => 'required',
            'smtp_security' => ''
        ]);

        if(session('is_admin') == 1)
        {
            $tenant_id = optional(auth()->guard('employee')->user())->tenant_id;
        }else{
            $tenant_id = auth()->user()->id;
        }
        $data = [
            'tenant_id' => $tenant_id,
            'email_from' => $request->email_from,
            'name' => $request->name,
            'smtp_user' => $request->smtp_user,
            'password' => $request->password,
            'port' => $request->port,
            'smtp_security' => $request->smtp_security,
            'host' => $request->host
        ];

        DB::beginTransaction();

        try {
            if (empty(settings()->mailsettings())) {
                EmailSettings::create($data);
            } else {
                $setting = settings()->mailsettings();
                $setting->update($data);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }

        return redirect()->back();
    }

    public function store_staffMailSettings(Request $request)
    {
        $request->validate([
            'email_from' => 'required|string|email|max:255',
            'name' => 'required|string|min:3|max:100',
            'host' => 'required|string',
            'smtp_user' => 'required',
            'password' => 'required|string|max:255',
            'port' => 'required',
            'smtp_security' => ''
        ]);

        $data = [
            'tenant_id' => optional(auth()->guard('employee')->user())->tenant_id,
            'email_from' => $request->email_from,
            'name' => $request->name,
            'smtp_user' => $request->smtp_user,
            'password' => $request->password,
            'port' => $request->port,
            'smtp_security' => $request->smtp_security,
            'host' => $request->host
        ];

        DB::beginTransaction();

        try {
            if (empty(settings()->mailsettings())) {
                EmailSettings::create($data);
            } else {
                $setting = settings()->mailsettings();
                $setting->update($data);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }

        return redirect()->back();
    }

    public function store_email_templates(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'       => 'required',
            'template'       => 'required',
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
        EmailTemplate::create([
            'tenant_id' => $tenant_id,
            'name'       => $request->name,
            'template'       => $request->template,  
        ]);

        DB::commit();
        return response()->json(['message' => 'Email Template Added Successfully']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Data saving failed. Please try again.'], 500);
        }

    }

    public function staff_store_email_templates(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'       => 'required',
            'template'       => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        DB::beginTransaction();
        try {

        EmailTemplate::create([
            'tenant_id' => optional(auth()->guard('employee')->user())->tenant_id,
            'name'       => $request->name,
            'template'       => $request->template,  
        ]);

        DB::commit();
        return response()->json(['message' => 'Email Template Added Successfully']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Data saving failed. Please try again.'], 500);
        }

    }

    public function edit_template($id)
    {
        $template = EmailTemplate::findOrFail($id);
        return view('communications.edit_template', compact('template'));
    }

    public function view_template($id){
        $email = EmailTemplate::findOrFail($id);
        return view('communications.view_template',compact('email'));
    }

    public function fetch_template_message($id)
    {
        try {
            $emailTemplate = EmailTemplate::findOrFail($id);   
            return response()->json(['message' => $emailTemplate->template]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Template not found'], 404);
        }
    }

    public function update_template(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string',
            'template' => 'required',
        ]);
    
        try {
            DB::beginTransaction();
    
            $template = EmailTemplate::findOrFail($id);
    
            $template->name = $request->name;
            $template->template = $request->template;
    
            $template->save();
    
            DB::commit();
    
            return response()->json(['message' => 'Template Updated successfully']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'An error occurred while updating the data'], 500);
        }
    }

    public function delete_template($id)
    {
        DB::beginTransaction();
        try {
        $template = EmailTemplate::findOrFail($id);
        $template->delete();

        DB::commit();
            return response()->json(['message' => 'Template Deleted Successfully']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Failed to delete deduction. Please try again.'], 500);
        }

    }


}
