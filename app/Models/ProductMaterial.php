<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductMaterial extends Model
{
    protected $table = 'product_materials';

    public const STATUS_ACTIVE = 1;
    public const STATUS_INACTIVE = 0;

    protected $fillable = [
        'name',
        'status',
        'sort',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public static function statusOptions(): array
    {
        return [
            self::STATUS_ACTIVE   => __('app.status.active'),
            self::STATUS_INACTIVE => __('app.status.inactive'),
        ];
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
