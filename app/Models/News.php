<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class News extends Model implements HasMedia

{
    use InteractsWithMedia;

    protected $table = 'news';

    public const STATUS_ACTIVE = 1;
    public const STATUS_INACTIVE = 0;

        protected $fillable = [
        'title',
        'content',
        'sort',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    /** ───── Options ───── */
    public static function statusOptions(): array
    {
        return [
            self::STATUS_ACTIVE   => __('app.status.active'),
            self::STATUS_INACTIVE => __('app.status.inactive'),
        ];
    }

        public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('preview_image')
            ->singleFile();

        $this
            ->addMediaCollection('main_imae')
            ->singleFile();
    }

}
