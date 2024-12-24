<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'status',
        'price',
        'sale_price',
        'image',
        'category_id',
        'description',
        'quantity',
    ];

    public function cate(){
        return $this->hasOne(Category::class, 'id', 'category_id');
    }

    // Mối quan hệ giữa Product và OrderItem
public function orderItems()
{
    return $this->hasMany(OrderItem::class);
}

}
