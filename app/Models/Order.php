<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $validated)
 */
class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_name',
        'order_date',
        'status',
        'comment',
        'product_id',
        'quantity',
        'total_price'
    ];

    public function product(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
