<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;
use App\Models\EmailSettings;

class EmailSettingsHelper
{
    public function mailsettings()
    {
        $userId = Auth::id();
        $company = EmailSettings::where('tenant_id', $userId)->first();

        return $company ? $company : null;
    }
}
