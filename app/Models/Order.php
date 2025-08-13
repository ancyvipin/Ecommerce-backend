<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class order extends Model
{
    use HasFactory,HasUuids;
     protected $primaryKey = 'order_id'; 
     protected $keyType = 'string';
     public $incrementing = false;

     protected $fillable = [
        'user_id',
        'total_amount',
        'status',
    ];
     public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    /**
     * Get the items for the order.
     */
    public function items()
    {
        return $this->hasMany(OrderItem::class, 'order_id', 'order_id');
    }

}
