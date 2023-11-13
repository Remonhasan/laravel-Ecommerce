<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Homepage
     *
     * @return void
     */
    public function index()
    {
        $products = Product::latest()->where('status', 1)->get();

        return view('frontend.home', compact('products'));
    }

    /**
     * Get searched product
     * and pagination
     * @param  mixed $request
     * @return void
     */
    public function searchProduct(Request $request)
    {
        $searchItem       = $request->search;
        $searchedProducts = Product::where('name', 'like', '%' . $searchItem . '%')->paginate(3);

        return view('frontend.searchProduct', compact('searchedProducts'));
    }
}
