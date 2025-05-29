<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Website extends Model
{
    const TABLE = "websites";

    protected $table = Website::TABLE;

    protected $fillable = [
        'uuid',
        'url',
        'is_integration_api',
        'shop_type',
        'business_detail_id',
        'created_by',
        'updated_by',
        'deleted_at',
        'deleted_by'
    ];

    public function businessDetail(){
        return $this->belongsTo(BusinessDetail::class);
    }

}
