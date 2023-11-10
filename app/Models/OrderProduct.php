<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class OrderProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'phone_number',
        'address',
        'city',
        'postal_code',
        'quantity',
        'price'
    ];


    public function getOrderedProducts($oderId)
    {
        return DB::table('orders')
            ->leftjoin('order_products', 'orders.id', '=', 'order_products.order_id')
            ->leftjoin('products', 'order_products.product_id', '=', 'products.id')
            ->leftjoin('users', 'orders.user_id', '=', 'users.id')
            ->select(
                'orders.*',
                'orders.quantity as total_quantity',
                'products.name as product_name',
                'users.name as user_name',
                'order_products.quantity as quantity',
                'order_products.price as price'
            )
            ->where('order_products.order_id', $oderId)
            ->get();
    }
}
