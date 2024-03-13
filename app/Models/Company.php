<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'contact_no',
        'address',
        'city',
        'country',
        'user_id',
    ];

    public function sections()
    {
        return $this->hasMany(Section::class);
    }

    public function members()
    {
        return $this->hasMany(Member::class);
    }

    public function managers()
    {
        return $this->belongsToMany(User::class, 'company_managers', 'company_id', 'user_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'company_manager', 'company_id', 'user_id')->withTimestamps();
    }
}
