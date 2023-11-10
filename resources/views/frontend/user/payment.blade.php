@extends('frontend.layouts.userMaster')

@section('page_title')
    Payment | nDolish
@endsection

@section('main-content')
  
    <div class="row">
        <div class="col-12" style="margin-top: 80px">
            <div class="box_main">
                Your Final Odered Products are :
                <div class="table-responsive">
                        @if (session()->has('message'))
                            <div class="alert alert-success">
                                {{ session()->get('message') }}
                            </div>
                        @endif
                    <table class="table">
                        <tr>
                            <th>Product Name & Quantity</th>
                            <th>Quantity</th>
                            <th>Price</th>
                        </tr>
                        @foreach ($orders as $order)
                            <tr>
                                <td>
                                @foreach($orderProducts as $orderProduct)
                                    <ul>
                                        <li>{{ $orderProduct-> product_name }}
                                        ({{ $orderProduct-> quantity }})
                                        </li>
                                    </ul>
                                @endforeach
                               </td>
                                </td>
                                <td>{{ $order->quantity }}</td>
                                <td>{{ $order->total_price }}</td>
                            </tr>
                            <input type="hidden" value="{{ $order->id }}" name="order_id">
                            <a href="{{ route('stripe.payment', ['price' => $order->total_price, 'order_id' => $order->id ]) }}" class="btn btn-primary float-right mb-3">Pay Now</a>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
       </div>
    </div>
@endsection
