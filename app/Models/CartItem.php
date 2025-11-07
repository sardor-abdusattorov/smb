<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    protected $fillable = [
        'frontend_user_id','product_id','color','size','material','quantity'
    ];

    public function product() {
        return $this->belongsTo(\App\Models\Product::class, 'product_id');
    }

     // Agar FrontendUser modelingiz bo'lsa:
    public function frontendUser()
    {
        return $this->belongsTo(FrontendUser::class, 'frontend_user_id');
    }
}

// guest_cart = [
//   'items' => [
//      "pid|color|size|material" => ['product_id'=>1,'color'=>'Black','size'=>'M','material'=>'Cotton','qty'=>2],
//      ...
//   ],
//   'created_at' => 'Y-m-d H:i:s'
// ]
