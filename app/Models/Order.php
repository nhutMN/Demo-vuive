<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'total_price', 'total_quantity', 'status', 'name', 'email', 'phone', 'address'];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function orderUser()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
