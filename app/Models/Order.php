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
        'product_id',
        'phone_number',
        'address',
        'city',
        'postal_code',
        'quantity',
        'total_price',
        'status'
    ];

    public function getPendingOrder()
    {
        return DB::table('orders')
            ->leftjoin('products', 'orders.product_id', '=', 'products.id')
            ->leftjoin('users', 'orders.user_id', '=', 'users.id')
            ->select('orders.*', 'products.name as product_name', 'users.name as user_name')
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
}
