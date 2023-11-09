@extends('admin.layouts.master')

@section('page_title')
    Cancled order
@endsection

@section('content')
 
<div class="container-xxl flex-grow-1 container-p-y">

    <div class="d-flex justify-content-between align-items-center">
        <h4 class="py-3 mb-4"><span class="text-muted fw-light">Oders /</span> Cancled</h4>
    </div>

    <div class="card shadow">
        <h5 class="card-header">Cancled Orders</h5>

        @if (session()->has('message'))
            <div class="alert alert-success">
                {{ session()->get('message') }}
            </div>
        @endif

        <div class="table-responsive text-nowrap">
            <table class="table">

                <thead class="table-light">
                    <tr>
                        <th>Customer</th>
                        <th>Address</th>
                        <th>Product Name</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody class="table-border-bottom-0">
                    @foreach ($cancledOrders as $cancledOrder)
                        <tr>
                            <td>{{ $cancledOrder->user_name }}</td>
                            <td>
                                <ul>
                                    <li>Phone Number : {{ $cancledOrder->phone_number}}</li>
                                    <li>Address : {{ $cancledOrder->address}}</li>
                                    <li>City : {{ $cancledOrder->city}}</li>
                                    <li>Postal Code : {{ $cancledOrder->postal_code}}</li>
                                </ul>
                            </td>
                            <td>{{ $cancledOrder->product_name }}</td>
                            <td>{{ $cancledOrder->quantity }}</td>
                            <td>{{ $cancledOrder->total_price }}</td>
                            <td>
                                <span class="badge bg-label-warning">{{ $cancledOrder->status }}</span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
    </div>
</div>


@endsection 