<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariantSize extends Model
{
    protected $table = 'product_variant_sizes';

    public const STATUS_ACTIVE   = 1;
    public const STATUS_INACTIVE = 0;

    protected $fillable = [
        'variant_id',
        'size_id',
        'stock',
        'dimensions',
        'sku',
        'status',
        'sort',
    ];

    protected $casts = [
        'status' => 'boolean',
        'stock' => 'integer',
    ];

    public static function statusOptions(): array
    {
        return [
            self::STATUS_ACTIVE   => __('app.status.active'),
            self::STATUS_INACTIVE => __('app.status.inactive'),
        ];
    }

    public function variant()
    {
        return $this->belongsTo(ProductVariant::class, 'variant_id');
    }

    public function size()
    {
        return $this->belongsTo(ProductSize::class, 'size_id');
    }

    /**
     * Check if this size is in stock
     */
    public function inStock(): bool
    {
        return $this->stock > 0 && $this->status;
    }

    /**
     * Get stock status text
     */
    public function getStockStatusAttribute(): string
    {
        if ($this->stock <= 0) {
            return 'Out of stock';
        }

        if ($this->stock <= 5) {
            return 'Low stock';
        }

        return 'In stock';
    }
}
