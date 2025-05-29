<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShopifyStore extends Model
{

    protected $table = "shopify_stores";

    protected $fillable = [ 'access_token', 'shopify_domain' ];
}
