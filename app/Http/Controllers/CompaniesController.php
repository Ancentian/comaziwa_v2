<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\CompanyProfile;
use App\Models\ContractType;
use App\Models\Employee;
use Flash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CompaniesController extends Controller
{
    public function index()
    {
        
        return view('companies.index');
    }

    public function createCompanyProfile()
    {
        $company = company()->mycompany();
        return view('companies.create_companyProfile',compact(['company']));
    }

    public function company_settings()
    {
        $tenant_id = auth()->user()->id;
        $graders = Employee::where('tenant_id', $tenant_id)->get();
        return view('companies.settings', compact('graders'));
    }

    public function company_profile()
    {
        $company = company()->mycompany();
        return view('companies.staff.company_profile', compact('company'));
    }

    public function storeCompany(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:3|max:100',
            'ssni_est' => 'required|string',
            'address' => 'required',
            'email' => 'required|string|email|max:255',
            'tel_no' => 'required',
            'logo' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if(session('is_admin') == 1)
        {
            $tenant_id = optional(auth()->guard('employee')->user())->tenant_id;
        }else{
            $tenant_id = auth()->user()->id;
        }
        $data = [
            'tenant_id' => $tenant_id,
            'name' => $request->name,
            'ssni_est' => $request->ssni_est,
            'address' => $request->address,
            'email' => $request->email,
            'tel_no' => $request->tel_no,
            'tin' => $request->tin,
            'secondary_email' => $request->secondary_email,
            'land_line' => $request->land_line
        ];
        DB::beginTransaction();
        try {
            if ($request->logo) {
                $logo = rand() . '.' . $request->logo->extension();
                $moved = $request->logo->move(storage_path('app/public/logos/'), $logo);
                $data['logo'] = $logo;
            } else {
                
            }

            if (empty(company()->mycompany())) {
                CompanyProfile::create($data);
            } else {
                $company = company()->mycompany();
                $company->update($data);
            }

            DB::commit();
            return redirect()->back()->with('success', 'Profile Created Successfully');
        } catch (\Exception $e) {
            
            DB::rollback();
            return redirect()->back()->with('error', 'Failed to create account. Please try again.');
        }
    }

    

    //Staff Update
    public function update_CompanyProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:3|max:100',
            'ssni_est' => 'required|string',
            'address' => 'required',
            'email' => 'required|string|email|max:255',
            'tel_no' => 'required',
            'logo' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = [
            'tenant_id' => optional(auth()->guard('employee')->user())->tenant_id,
            'name' => $request->name,
            'ssni_est' => $request->ssni_est,
            'address' => $request->address,
            'email' => $request->email,
            'tel_no' => $request->tel_no,
            'tin' => $request->tin,
            'secondary_email' => $request->secondary_email,
            'land_line' => $request->land_line
        ];
        DB::beginTransaction();
        try {
            if ($request->logo) {
                $logo = rand() . '.' . $request->logo->extension();
                $moved = $request->logo->move(storage_path('app/public/logos/'), $logo);
                $data['logo'] = $logo;
            } else {
                
            }

            if (empty(company()->mycompany())) {
                CompanyProfile::create($data);
            } else {
                $company = company()->mycompany();
                $company->update($data);
            }

            DB::commit();
            //Flash::success('Account Created Successfully', 'Success');
            return redirect()->back()->with('success', 'Profile Created Successfully');
        } catch (\Exception $e) {
            
            DB::rollback();

            //Flash::error('Failed to create account. Please try again.', 'Error');
            return redirect()->back()->with('error', 'Failed to create account. Please try again.');
        }
    }

}
