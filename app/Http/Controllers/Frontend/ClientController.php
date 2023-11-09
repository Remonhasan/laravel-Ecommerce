<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    protected $productModel;

    public function __construct()
    {
        $this->productModel = new Product;
    }

    public function getCategory($id)
    {
        $category = Category::findOrFail($id);
        $products = Product::where('category_id', $id)->latest()->get();

        return view('frontend.category', compact('category', 'products'));
    }

    public function getProduct($id)
    {
        $product         = $this->productModel->getProductListById($id);
        $subcategoryId   = Product::where('id', $id)->value('subcategory_id');
        $relatedProducts = $this->productModel->getRelatedProduct($subcategoryId);

        return view('frontend.product', compact('product', 'relatedProducts'));
    }

    public function addCart()
    {
        $userId = Auth::id();
        $carts = Cart::where('user_id', $userId)->latest()->get();
        return view('frontend.cart', compact('carts'));
    }

    public function addProductCart (Request $request)
    {
        $productId       = $request->product_id;
        $productPrice    = $request->price;
        $productQuantity = $request->quantity ?? 1;
        $totalPrice      = $productPrice * $productQuantity;

        Cart::insert([
            'product_id' => $productId,
            'user_id'    => Auth::id(),
            'quantity'   => $productQuantity,
            'price'      => $totalPrice
        ]);

        return redirect()->route('customer.cart')->with('message', 'Item added to cart successfully');
    }

    public function checkout()
    {
        return view('frontend.checkout');
    }

    public function userProfile()
    {
        return view('frontend.profile');
    }

    public function pendingOrder()
    {
        return view('frontend.user.pendingOrder');
    }

    public function userHistory()
    {
        return view('frontend.user.history');
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
