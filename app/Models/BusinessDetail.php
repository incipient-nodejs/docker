<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BusinessDetail extends Model
{
    const TABLE = "business_details";

    protected $table = BusinessDetail::TABLE;

    protected $fillable = [
        'uuid',
        'phone_preference',
        'phone',
        'whatsapp',
        'email',
        'website_url',
        'category',
        'is_sell_product',
        'user_id',
        'created_by ',
        'updated_by',
        'deleted_at',
        'deleted_by'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function website(){
        return $this->hasOne(Website::class);
    }

}
