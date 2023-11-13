@extends('frontend.layouts.userMaster')

@section('page_title')
    Checkout | nDolish
@endsection

@section('main-content')

    <div class="row">

        @if (session()->has('message'))
            <div class="alert alert-success">
                {{ session()->get('message') }}
            </div>
        @endif

        <div class="col-4" style="margin-top: 80px">
            <div class="box_main">

                @if (!empty($shippingAddress->phone_number))
                    <h3>Product will send at : </h3>

                    <p>Phone Number: {{ $shippingAddress->phone_number }} </p>
                    <p>City/Division : {{ $shippingAddress->city }} </p>
                    <p>Street/Address : {{ $shippingAddress->address }} </p>
                    <p>Postal Code : {{ $shippingAddress->postal_code }} </p>
                @else
                    <h3>Product Ordered Products : </h3>
                @endif

            </div>
        </div>

        <div class="col-8" style="margin-top: 80px">
            <div class="box_main">
                Your Final Products are :
                <div class="table-responsive">

                    @if (!empty($shippingAddress->phone_number))
                        <table class="table">
                            <tr>
                                <th>Image</th>
                                <th>Product Name</th>
                                <th>Quantity</th>
                                <th>Price</th>
                            </tr>

                            @php
                                $total = 0;
                                $totalQuantity = 0;
                            @endphp

                            @foreach ($carts as $cart)
                                @php
                                    $productName = App\Models\Product::where('id', $cart->product_id)->value('name');
                                    $productImage = App\Models\Product::where('id', $cart->product_id)->value('image');
                                @endphp
                                <tr>
                                    <td>
                                        <img src="{{ asset($productImage) }}" alt="Product Image" height="50"
                                            width="60">
                                    </td>
                                    <td>{{ $productName }}</td>
                                    <td>{{ $cart->quantity }}</td>
                                    <td>{{ $cart->price }}</td>
                                    @php
                                        $total = $total + $cart->price;
                                        $totalQuantity = $totalQuantity + $cart->quantity;
                                    @endphp
                                </tr>
                            @endforeach

                            <tr>
                                <td></td>
                                <td style="font-weight: bold">Total</td>
                                <td style="font-weight: bold">{{ $totalQuantity }}</td>
                                <td style="font-weight: bold">{{ $total }}</td>
                                <td></td>
                            </tr>
                        </table>
                    @else
                        <table class="table">
                            <tr>
                                <th>Product Name & Quantity</th>
                                <th>Quantity</th>
                                <th>Price</th>
                            </tr>

                            @php
                                $userId = Illuminate\Support\Facades\Auth::id();
                                $placedOrders = App\Models\Order::where('user_id', $userId)
                                    ->where('quantity', $checkTotalQuantity)
                                    ->where('total_price', $checkTotalPrice)
                                    ->get();

                                if ($placedOrders->isNotEmpty()) {
                                    $orderId = $placedOrders[0]['id'];
                                    $orderTotalQuantity = $placedOrders[0]['quantity'];
                                    $orderTotalPrice = $placedOrders[0]['total_price'];
                                    $placedOrderProducts = App\Models\orderProduct::where('order_id', $orderId)->get();
                                }

                            @endphp

                            <tr>

                                @foreach ($placedOrders as $placedOrder)
                                    <td>
                                        @foreach ($placedOrderProducts as $placedOrderProduct)
                                            <ul>
                                                @php
                                                    $productName = App\Models\Product::where('id', $placedOrderProduct->product_id)->value('name');
                                                @endphp
                                                <li>{{ $productName }}
                                                    ({{ $placedOrderProduct->quantity }})
                                                </li>
                                            </ul>
                                        @endforeach
                                    </td>
                                    <td>{{ $placedOrder->quantity }}</td>
                                    <td>{{ $placedOrder->total_price }}</td>
                                @endforeach

                            </tr>
                        </table>
                    @endif
                </div>
            </div>
        </div>


        @php
            if (!empty($shippingAddress->phone_number)) {
                $userId = Illuminate\Support\Facades\Auth::id();
                $orders = App\Models\Order::where('user_id', $userId)
                    ->where('quantity', $totalQuantity)
                    ->where('total_price', $total)
                    ->get();

                if ($orders->isNotEmpty()) {
                    $orderId = $orders[0]['id'];
                    $orderTotalQuantity = $orders[0]['quantity'];
                    $orderTotalPrice = $orders[0]['total_price'];
                    $orderProducts = App\Models\orderProduct::where('order_id', $orderId)->get();
                }
            } else {
                $userId = Illuminate\Support\Facades\Auth::id();
                $orders = App\Models\Order::where('user_id', $userId)
                    ->where('quantity', $checkTotalQuantity)
                    ->where('total_price', $checkTotalPrice)
                    ->get();

                if ($orders->isNotEmpty()) {
                    $orderId = $orders[0]['id'];
                    $orderTotalQuantity = $orders[0]['quantity'];
                    $orderTotalPrice = $orders[0]['total_price'];
                    $orderProducts = App\Models\orderProduct::where('order_id', $orderId)->get();
                }
            }

        @endphp

        @if (empty($orderId))
            <form action="{{ route('place.order') }}" method="POST">
                @csrf

                <input type="hidden" value="{{ $totalQuantity }}" name="total_quantity" />
                <input type="hidden" value="{{ $total }}" name="total_price" />
                <input type="submit" value="Place order" class="btn btn-primary">
            </form>
        @else
            <input type="hidden" value="{{ $orderId }}" name="order_id">
            <a href="{{ route('stripe.payment', ['price' => $orderTotalPrice, 'order_id' => $orderId]) }}"
                class="btn btn-primary float-right mb-3">Pay Now</a>
        @endif


    </div>
    </div>
@endsection
