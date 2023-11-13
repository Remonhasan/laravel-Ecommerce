<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Models\Shipping;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ClientController extends Controller
{
    protected $productModel;
    protected $orderModel;
    protected $orderProductModel;

    public function __construct()
    {
        $this->productModel = new Product();
        $this->orderModel = new Order();
        $this->orderProductModel = new OrderProduct();
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

    public function placeOrder(Request $request)
    {
        $userId          = Auth::id();
        $carts           = Cart::where('user_id', $userId)->get();
        $shippingAddress = Shipping::where('user_id', $userId)->first();
        $checkTotalQuantity = $request->total_quantity;
        $checkTotalPrice = $request->total_price;
        
        $result = Order::insert([
            'user_id'      => $userId,
            'quantity'     => $request->total_quantity,
            'total_price'  => $request->total_price
        ]);

        if ($result) {

            $order = Order::where('user_id', $userId)
                ->where('quantity', $request->total_quantity)
                ->where('total_price', $request->total_price)
                ->first();

            foreach ($carts as $cartItem) {

                OrderProduct::insert([
                    'order_id'     => $order->id,
                    'product_id'   => $cartItem->product_id,
                    'phone_number' => $shippingAddress->phone_number,
                    'city'         => $shippingAddress->city,
                    'address'      => $shippingAddress->address,
                    'postal_code'  => $shippingAddress->postal_code,
                    'quantity'     => $cartItem->quantity,
                    'price'        => $cartItem->price
                ]);

                // Delete form cart after place order
                $cartId = $cartItem->id;
                Cart::findOrFail($cartId)->delete();
            }
        } 

        //Delete shipping address after place order
        Shipping::where('user_id', $userId)->first()->delete();

        // Get date after order placed
        $placeOrders = $this->orderModel->getPlacedOrders($userId,$checkTotalQuantity,$checkTotalPrice);
       
        $placeOrderId = $placeOrders->id;
        $placeOrder   = (object) ($placeOrders);

        $placeOrderDetails = OrderProduct::where('order_id', $placeOrderId)->get();
        
        return view('frontend.user.checkout', compact('checkTotalQuantity', 'checkTotalPrice'));
    }

    public function userProfile()
    {
        return view('frontend.profile');
    }

    public function pendingOrder()
    {
        $userId = Auth::id();
        $orders = Order::where('user_id', $userId)->paginate(1);

        if (filled($orders)) {
            $userName      = User::where('id', $userId);
            $oderId        = $orders[0]['id'];
            $orderProducts = $this->orderProductModel->getOrderedProducts($oderId);

            return view('frontend.user.pendingOrder', compact('orderProducts', 'orders', 'userName'));
        } else {
            return redirect()->route('user.profile');
        }
    }


    public function stripePayment(Request $request)
    {
        $stripe      = new \Stripe\StripeClient(env('STRIPE_SECRET'));
        $redirectUrl = route('stripe.payment.success', ['order_id' => $request->order_id]) . '?session_id={CHECKOUT_SESSION_ID}';

        $response = $stripe->checkout->sessions->create([
            'success_url'          => $redirectUrl,
            'customer_email'       => 'remon@yopmail.com',
            'payment_method_types' => ['link', 'card'],
            'line_items' => [
                [
                    'price_data' => [
                        'product_data' => [
                            'name' => 'Product',
                        ],
                        'unit_amount' => 100 * $request->price,
                        'currency'    => 'USD',
                    ],
                    'quantity' => 1
                ],
            ],

            'mode'                  => 'payment',
            'allow_promotion_codes' => true,
        ]);


        return redirect($response['url']);
    }

    public function stripePaymentSuccess(Request $request, $orderId)
    {
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));

        $response = $stripe->checkout->sessions->retrieve($request->session_id);

        if ($response->payment_status == 'paid') {

            $invoiceCode = strtoupper(Str::random(4) . mt_rand(1000, 9999));

            Order::findOrFail($orderId)->update([
                'invoice_code' => $invoiceCode,
                'status'       => 'paid'
            ]);
        }

        return redirect()->route('user.profile')->with('message', 'Payment successfully!');
    }

    public function approvedOrder()
    {
        $approvedOrders = $this->orderModel->getAllCompletedOrder();
        return view('frontend.user.approvedOrder', compact('approvedOrders'));
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
