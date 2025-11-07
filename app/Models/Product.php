<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Product extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $table = 'products';

    protected $fillable = [
        'category_id',
        'subcategory_id',
        'name',
        'slug',
        'price',
        'old_price',
        'description',
        'material_description',
        'care_description',
        'delivery_description',
        'capacity_description',
        'is_new_collection',
        'sort',
        'status',
        'meta_title',
        'meta_description',
    ];

    protected $casts = [
        'status'   => 'boolean',
        'is_new_collection'   => 'boolean',
        'price'    => 'decimal:2',
        'old_price'=> 'decimal:2',
    ];

    public const STATUS_ACTIVE   = 1;
    public const STATUS_INACTIVE = 0;

    public static function statusOptions(): array
    {
        return [
            self::STATUS_ACTIVE   => __('app.status.active'),
            self::STATUS_INACTIVE => __('app.status.inactive'),
        ];
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class);
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function materials()
    {
        return $this->hasMany(ProductMaterial::class);
    }

    public function sizeValues()
    {
        return $this->hasMany(ProductSizeValue::class, 'product_id');
    }

    public function scopeNewActive($query)
    {
        return $query->where('is_new_collection', true)
            ->where('status', 1)
            ->where(function ($q) {
                $q->whereHas('variants', fn($sub) => $sub->where('status', 1))
                    ->orWhereHas('sizeValues', fn($sub) => $sub->where('status', 1));
            });
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1)
            ->where(function ($q) {
                $q->whereHas('variants', fn($sub) => $sub->where('status', 1))
                    ->orWhereHas('sizeValues', fn($sub) => $sub->where('status', 1));
            });
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('preview_image')->singleFile();
        $this->addMediaCollection('gallery');
    }

    public static function listOptions(): array
    {
        return static::query()
            ->where('status', true)
            ->orderBy('name')
            ->pluck('name', 'id')
            ->toArray();
    }

    public function scopeNewProducts($query)
    {
        return $query->where('status', 1)
            ->where(function ($q) {
                $q->whereHas('variants', fn($sub) => $sub->where('status', 1))
                    ->orWhereHas('sizeValues', fn($sub) => $sub->where('status', 1));
            });
    }

    public function scopeNewCollection($query)
    {
        return $query->where('is_new_collection', true)
            ->where('status', 1)
            ->where(function ($q) {
                $q->whereHas('variants', fn($sub) => $sub->where('status', 1))
                    ->orWhereHas('sizeValues', fn($sub) => $sub->where('status', 1));
            });
    }

}
