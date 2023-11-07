<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function pendingOrder (){
        return view('admin.order.pendingOrder');
    }
}
