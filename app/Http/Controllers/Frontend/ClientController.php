<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function getCategory($id)
    {
        $category = Category::findOrFail($id);
        $products = Product::where('category_id', $id)->latest()->get();
        return view('frontend.category', compact('category', 'products'));
    }

    public function getProduct()
    {
        return view('frontend.product');
    }

    public function addCart()
    {
        return view('frontend.cart');
    }

    public function checkout()
    {
        return view('frontend.checkout');
    }

    public function userProfile()
    {
        return view('frontend.profile');
    }

    public function newRelease()
    {
        return view('frontend.newRelease');
    }

    public function todaysDeal()
    {
        return view('frontend.todaysDeal');
    }

    public function customerService()
    {
        return view('frontend.customerService');
    }
}
