<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductSpecHighlight extends Model
{
    use HasFactory;

    protected $table = 'product_spec_highlights';

    protected $fillable = [
        'product_id',
        'value',
        'unit',
        'subtitle',
        'label',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'sort_order' => 'integer',
        'is_active' => 'boolean',
    ];

    /**
     * Thuộc về một dòng xe / sản phẩm.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}

