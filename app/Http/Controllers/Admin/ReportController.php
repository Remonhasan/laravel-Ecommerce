<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function totalSaleReport()
    {
        $orderModel = new Order();
        $orders     = Order::latest()->paginate(5);
        $orderId    = $orders[0]['id'];
        $totalSales = $orderModel->getTotalSaleReportByOrderId($orderId);

        return view('admin.report.totalSale', compact('orders', 'totalSales'));
    }
}
