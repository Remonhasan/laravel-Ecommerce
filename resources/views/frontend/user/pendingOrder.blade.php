@extends('frontend.layouts.userMaster')

@section('page_title')
    Pending Order | nDolish
@endsection

@section('user-profile-content')
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
            <th>Status</th>
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
                <td>
                    @if ($order->status == 'pending')
                        <span class="badge bg-label-warning">{{ $order->status }}</span>
                    @elseif($order->status == 'approved')
                        <span class="badge bg-label-success">{{ $order->status }}</span>
                    @else
                        <span class="badge bg-label-danger">{{ $order->status }}</span>
                    @endif
                </td>
            </tr>
        @endforeach

    </table>

    <div class="row">
        <div class="col-lg-12">
            <span style="padding-top: 20px">
                {{ $orders->links('pagination::bootstrap-5') }}
            </span>
        </div>
    </div>
@endsection
