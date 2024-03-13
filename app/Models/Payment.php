<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'amount',
        'currency',
        'status',
        'payment_method',
        'payment_date',
        'payment_for_month',
        'member_id',
        'company_id',
        'created_at',
        'member_name',
        'email',
        'contact_no',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
