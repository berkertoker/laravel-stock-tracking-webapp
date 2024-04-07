<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'amount'];

    protected $hidden = ['created_at', 'updated_at'];

    /**
     * Get the company that owns the price.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the company that owns the price.
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function stockDetail()
    {
        return $this->hasMany(StockDetail::class);
    }
}
