<?php

// app/AccessHelper.php

namespace App\Helper;

use App\Models\CompanyManager;

class AccessHelper
{
    public static function hasManagerAccess($user, $companyId)
    {
        $company = CompanyManager::where('user_id', auth()->user()->id)
            ->where('company_id', $companyId)
            ->first();

        if ($company) {
            return true;
        }

        return false;
    }
}
