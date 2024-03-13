<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'company_id',
        'created_at',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function members()
    {
        return $this->hasMany(Member::class);
    }

}
