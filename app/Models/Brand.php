<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Brand extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'logo',
        'banner',
    ];
    /**
     * Get all of the outlets for the Brand
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function outlets(): HasMany
    {
        return $this->hasMany(Outlet::class, 'brand_id', 'id');
    }
    /**
     * Get all of the products for the Brand
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'brand_id', 'id');
    }
}
