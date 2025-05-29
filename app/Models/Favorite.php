<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


use Illuminate\Notifications\Notifiable;

class Favorite extends Model
{

    use HasFactory,Notifiable;
    const TABLE = "favorites";

    protected $table = Favorite::TABLE;

    protected $fillable = [
        'user_id',
        'product_id',
        'service_id',
        'uuid',
    ];

    public function product() {
        return $this->belongsTo(Product::class);
    }
    
    public function service() {
        return $this->belongsTo(Service::class);
    }

}
