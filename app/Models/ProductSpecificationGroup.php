<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductSpecificationGroup extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'sort_order',
    ];

    protected $casts = [
        'sort_order' => 'integer',
    ];

    /**
     * Danh sách thông số thuộc nhóm này.
     */
    public function specifications(): HasMany
    {
        return $this->hasMany(ProductSpecification::class, 'group_id');
    }
}

