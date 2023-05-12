<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'quantity',
        'price',
        'image_url',
        'company_nit'
    ];

    /**
     * Get the company that owns the product.
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}
