<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory, HasUuids,SoftDeletes;
    protected $primaryKey = 'prdt_id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'prdt_name',
        'prdt_description',
        'prdt_price',
        'stock_quantity',
    ];
    
}
