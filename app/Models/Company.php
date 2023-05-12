<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends Model
{
    use HasFactory;
    protected $primaryKey  = 'nit';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'nit',
        'image_url',
    ];
    /**
     * Get the company's products.
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
