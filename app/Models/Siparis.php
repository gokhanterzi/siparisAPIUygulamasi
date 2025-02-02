<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siparis extends Model
{
    use HasFactory;
    protected $primaryKey = 'orderCode';
    protected $fillable = [
        'productId',
        'quantity',
        'address',
        'shippingDate'
    ];
}
