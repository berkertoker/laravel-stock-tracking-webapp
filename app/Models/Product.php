<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'price'];

    protected $hidden = ['created_at', 'updated_at'];

    /**
     * Get the company that owns the price.
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function productImage()
    {
        return $this->hasMany(ProductImage::class);
    }

    /**
     * Get the company that owns the price.
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function stock()
    {
        return $this->hasOne(Stock::class);
    }


    /**
     * Get the company that owns the price.
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function orderItem()
    {
        return $this->hasOne(OrderItem::class);
    }
}
