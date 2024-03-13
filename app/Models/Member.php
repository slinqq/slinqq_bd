<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'contact_no',
        'join_date',
        'monthly_fee',
        'status',
        'address',
        'occupation',
        'member_id',
        'company_id',
        'section_id',
        'user_id',
        'advance_amount'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class)->orderBy('payment_for_month', 'desc');
    }

    public function currentMonthPayment()
    {
        return $this->hasOne(Payment::class)
            ->where('payment_for_month', date('Y-m'));
    }
}
