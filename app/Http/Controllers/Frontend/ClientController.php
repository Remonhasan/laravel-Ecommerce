<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Product;
use App\Models\Shipping;
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

    public function addProductCart(Request $request)
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

        return redirect()->route('customer.cart')->with('message', 'Item added to cart successfully!');
    }

    public function addCart()
    {
        $userId = Auth::id();
        $carts  = Cart::where('user_id', $userId)->get();

        return view('frontend.cart', compact('carts'));
    }

    public function cartRemove($id)
    {
        Cart::findOrFail($id)->delete();

        return redirect()->route('customer.cart')->with('message', 'Item removed from cart successfully!');
    }

    public function getShippingAddress()
    {
        return view('frontend.user.shippingAddress');
    }

    public function addShippingAddress(Request $request)
    {
        $userId = Auth::id();

        Shipping::insert([
            'user_id'      => $userId,
            'phone_number' => $request->phone_number,
            'city'         => $request->city,
            'address'      => $request->address,
            'postal_code'  => $request->postal_code
        ]);

        return redirect()->route('customer.checkout');
    }

    public function checkout()
    {
        $userId          = Auth::id();
        $carts           = Cart::where('user_id', $userId)->get();
        $shippingAddress = Shipping::where('user_id', $userId)->first();

        return view('frontend.user.checkout', compact('carts', 'shippingAddress'));
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
