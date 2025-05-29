<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserContactCounter extends Model
{

    protected $table =  "user_contact_counters";

    protected $fillable = [
        'user_id',
        'company_data_id',
        'contact_value',
        'contact_type',
        'counter',
    ];

    public function companyData()
    {
        return $this->belongsTo(CompanyData::class, 'company_data_id', 'id');
    }

}
