<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Models\User;
use App\Notifications\CustomerEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    protected $productModel;
    protected $orderModel;

    public function __construct()
    {
        $this->productModel = new Product();
        $this->orderModel = new Order();
    }

    public function pendingOrder()
    {
        $pendingOrders        = Order::where('status', 'pending')->paginate(5);
        $orderId              = $pendingOrders[0]['id'];
        $pendingOrderProducts = OrderProduct::where('order_id', $orderId)->get();
        $pendingOrderAddress  = OrderProduct::where('order_id', $orderId)->first();

        return view('admin.order.pendingOrder', compact('pendingOrders', 'pendingOrderProducts', 'pendingOrderAddress'));
    }

    public function approvePendingOrder($id)
    {

        Order::where('id', $id)->update([
            'status' => 'approved'
        ]);

        // $message = 'Your order is placed successfully! Your invoice code is:'. $customerInvoiceCode ; 
        // $customer = User::find($customerId); // Replace with your logic to get the customer's user model
        // $customer->notify(new CustomerEmail($message));

        return redirect()->route('pending.order')->with('message', 'Order approved successfully');
    }

    public function cancledPendingOrder($id)
    {
        Order::where('id', $id)->update([
            'status' => 'cancled'
        ]);

        return redirect()->route('pending.order')->with('message', 'Order cancled successfully');
    }

    public function allCompletedOrder()
    {

        $completedOrders        = Order::where('status', 'pending')->paginate(5);
        $orderId                = $completedOrders[0]['id'];
        $completedOrderProducts = OrderProduct::where('order_id', $orderId)->get();
        $completedOrderAddress  = OrderProduct::where('order_id', $orderId)->first();

        return view('admin.order.completedOrder', compact('completedOrders', 'completedOrderProducts', 'completedOrderAddress'));
    }

    public function allCancledOrder()
    {
        $cancledOrders        = Order::where('status', 'pending')->paginate(5);
        $orderId              = $cancledOrders[0]['id'];
        $cancledOrderProducts = OrderProduct::where('order_id', $orderId)->get();
        $cancledOrderAddress  = OrderProduct::where('order_id', $orderId)->first();

        return view('admin.order.cancledOrder', compact('cancledOrders', 'cancledOrderProducts', 'cancledOrderAddress'));
    }
}
