<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductBanner extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'product_banners';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'product_id',
        'image_media_id',
        'image_path',
        'title',
        'subtitle',
        'sort_order',
        'is_active',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    /**
     * Get the product that owns the banner.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the media record of the banner image.
     */
    public function image(): BelongsTo
    {
        return $this->belongsTo(Media::class, 'image_media_id');
    }
}

