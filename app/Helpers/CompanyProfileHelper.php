<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;
use App\Models\CompanyProfile;

class CompanyProfileHelper
{
    public function mycompany()
    {
        //$userId = Auth::id();
        $tenant_id = optional(auth()->guard('employee')->user())->tenant_id;
        $company = CompanyProfile::where('tenant_id', $tenant_id)->first();

        return $company ? $company : null;
    }
}
