<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyManager extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'user_id',
        'company_admin_user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function adminUser()
    {
        return $this->belongsTo(User::class, 'company_admin_user_id');
    }
}
