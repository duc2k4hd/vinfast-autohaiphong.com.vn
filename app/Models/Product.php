<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'category_id',
        'sku',
        'name',
        'slug',
        'short_description',
        'description_html',
        'regular_price',
        'sale_price',
        'price_on_request',
        'status',
        'featured',
        'sort_order',
        'thumbnail_media_id',
        'published_at',
    ];

    protected $casts = [
        'regular_price' => 'integer',
        'sale_price' => 'integer',
        'price_on_request' => 'boolean',
        'featured' => 'boolean',
        'published_at' => 'datetime',
    ];

    /**
     * Quan hệ danh mục sản phẩm.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }

    /**
     * Quan hệ các phiên bản xe.
     */
    public function variants(): HasMany
    {
        return $this->hasMany(ProductVariant::class, 'product_id')->orderBy('sort_order', 'asc');
    }

    /**
     * Quan hệ các thông số kỹ thuật.
     */
    public function specifications(): HasMany
    {
        return $this->hasMany(ProductSpecification::class, 'product_id')->orderBy('sort_order', 'asc');
    }

    /**
     * Scope lọc các sản phẩm đã được xuất bản ra công khai.
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published')
            ->where(function ($q) {
                $q->whereNull('published_at')
                    ->orWhere('published_at', '<=', now());
            });
    }

    /**
     * Scope lọc các dòng xe nổi bật.
     */
    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }
}
