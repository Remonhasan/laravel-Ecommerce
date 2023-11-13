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

        // $pendingOrders = $this->orderModel->getPendingOrder();
        $pendingOrders = Order::where('status', 'pending')->get();
        $orderId = $pendingOrders[0]['id'];
        $pendingOrderProducts = OrderProduct::where('order_id', $orderId)->get();
        $pendingOrderAddress = OrderProduct::where('order_id', $orderId)->first();
    
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

    public function allCompletedOrder ()
    {
        $completedOrders = $this->orderModel->getAllCompletedOrder();
        return view('admin.order.completedOrder', compact('completedOrders'));
    }

    public function allCancledOrder ()
    {
        $cancledOrders = $this->orderModel->getAllCancledOrder();
        return view('admin.order.cancledOrder', compact('cancledOrders'));
    }
}
