<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductSpecification extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'group_id',
        'label',
        'value',
        'unit',
        'sort_order',
    ];

    protected $casts = [
        'sort_order' => 'integer',
    ];

    /**
     * Dòng xe sở hữu thông số này.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    /**
     * Nhóm thông số nếu có.
     */
    public function group(): BelongsTo
    {
        return $this->belongsTo(ProductSpecificationGroup::class, 'group_id');
    }
}
