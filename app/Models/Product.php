<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'short_description',
        'long_description',
        'price',
        'quantity',
        'category_id',
        'subcategory_id',
        'image',
        'slug',
        'status'
    ];

    public function geProductList()
    {
        return DB::table('products')
            ->leftjoin('categories', 'products.category_id', '=', 'categories.id')
            ->leftjoin('subcategories', 'products.subcategory_id', '=', 'subcategories.id')
            ->select('products.*', 'categories.name as category_name', 'subcategories.name as subcategory_name')
            ->paginate(5);
    }

    public function getProductListById($id)
    {
        return DB::table('products')
            ->leftjoin('categories', 'products.category_id', '=', 'categories.id')
            ->leftjoin('subcategories', 'products.subcategory_id', '=', 'subcategories.id')
            ->select('products.*', 'categories.name as category_name', 'subcategories.name as subcategory_name')
            ->where('products.id', $id)
            ->first();
    }

    public function getRelatedProduct($subcategoryId)
    {
        return DB::table('products')
            ->leftjoin('categories', 'products.category_id', '=', 'categories.id')
            ->leftjoin('subcategories', 'products.subcategory_id', '=', 'subcategories.id')
            ->select('products.*', 'categories.name as category_name', 'subcategories.name as subcategory_name')
            ->where('products.subcategory_id', $subcategoryId)
            ->latest()->get();
    }
}
