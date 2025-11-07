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

    public function variants()
    {
        return $this->belongsToMany(ProductVariant::class, 'product_material_variant', 'material_id', 'variant_id')
            ->withTimestamps();
    }

    public static function listOptions(): array
    {
        return self::query()
            ->where('status', self::STATUS_ACTIVE)
            ->orderBy('sort')
            ->pluck('name', 'id')
            ->toArray();
    }
}
