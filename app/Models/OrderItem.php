<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class OrderItem extends Model
{
     use HasFactory, HasUuids;
    protected $primaryKey = 'item_id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'order_id',
        'prdt_id',
        'item_quantity',
        'item_price',
    ];

    /**
     * Get the product that belongs to the item.
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'prdt_id', 'prdt_id');
    }
}
