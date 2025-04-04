<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'address_id',
        'orderDate',
        'coupon_id',
        'status',
        'totalAmount'
    ];

    public function coupons()
    {
        return $this->hasOne(Coupon::class);
    }

    public function address()
    {
        return $this->hasOne(Address::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
