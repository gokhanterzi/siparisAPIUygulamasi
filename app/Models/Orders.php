<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    protected $primaryKey = 'orderCode';
    use HasFactory;
    protected $fillable = [
        'productId',
        'quantity',
        'address',
        'shippingDate'
    ];
}
