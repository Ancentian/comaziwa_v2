<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;
use App\Models\CompanyProfile;

class CompanyHelper
{
    public function mycompany()
    {
        if(session('is_admin') == 1)
        {
            $tenant_id = optional(auth()->guard('employee')->user())->tenant_id;
        }else{
            $tenant_id = auth()->user()->id;
        }
        $company = CompanyProfile::where('tenant_id', $tenant_id)->first();

        return $company ? $company : null;
    }
}
