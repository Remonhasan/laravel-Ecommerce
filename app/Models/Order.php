<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_code',
        'user_id',
        'quantity',
        'total_price',
        'status'
    ];

    public function getPendingOrder()
    {
        return DB::table('orders')
            ->leftjoin('order_products', 'orders.id', '=', 'order_products.order_id')
            ->leftjoin('products', 'order_products.product_id', '=', 'products.id')
            ->leftjoin('users', 'orders.user_id', '=', 'users.id')
            ->select(
                'orders.*',
                'products.name as product_name',
                'users.name as user_name',
                'order_products.quantity as quantity',
                'order_products.price as price'
            )
            ->where('orders.status', 'pending')
            ->get();
    }

    public function getAllCompletedOrder()
    {
        return DB::table('orders')
            ->leftjoin('products', 'orders.product_id', '=', 'products.id')
            ->leftjoin('users', 'orders.user_id', '=', 'users.id')
            ->select('orders.*', 'products.name as product_name', 'users.name as user_name')
            ->where('orders.status', 'approved')
            ->get();
    }

    public function getAllCancledOrder()
    {
        return DB::table('orders')
            ->leftjoin('products', 'orders.product_id', '=', 'products.id')
            ->leftjoin('users', 'orders.user_id', '=', 'users.id')
            ->select('orders.*', 'products.name as product_name', 'users.name as user_name')
            ->where('orders.status', 'cancled')
            ->get();
    }

    public function getUserPendingOrder($id)
    {
        return DB::table('orders')
            ->leftjoin('order_products', 'orders.id', '=', 'order_products.order_id')
            ->leftjoin('products', 'order_products.product_id', '=', 'products.id')
            ->leftjoin('users', 'orders.user_id', '=', 'users.id')
            ->select(
                'orders.*',
                'products.name as product_name',
                'users.name as user_name',
                'order_products.quantity as quantity',
                'order_products.price as price'
            )
            ->where('orders.user_id', $id)
            ->where('orders.status', 'pending')
            ->get();
    }

    public function getOrderId($userId, $totalQuantity, $totalPrice)
    {
        return DB::table('orders')
            ->where('orders.user_id', $userId)
            ->where('orders.quantity', $totalQuantity)
            ->where('orders.total_price', $totalPrice)
            ->where('orders.status', 'pending')
            ->value('orders.id');
    }

    public function getPlacedOrders($userId, $totalQuantity, $totalPrice)
    {
        return DB::table('orders')
            ->leftjoin('users', 'orders.user_id', '=', 'users.id')
            ->where('orders.user_id', $userId)
            ->where('orders.quantity', $totalQuantity)
            ->where('orders.total_price', $totalPrice)
            ->select(
                'orders.*',
                'users.name as user_name',
                'orders.quantity as placed_quantity',
                'orders.total_price as placed_price'
            )
            ->where('orders.status', 'pending')
            ->first();
    }
}
