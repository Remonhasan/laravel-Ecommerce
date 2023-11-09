@extends('admin.layouts.master')

@section('page_title')
    Completed order
@endsection

@section('content')
 
<div class="container-xxl flex-grow-1 container-p-y">

    <div class="d-flex justify-content-between align-items-center">
        <h4 class="py-3 mb-4"><span class="text-muted fw-light">Oders /</span> Completed</h4>
    </div>

    <div class="card shadow">
        <h5 class="card-header">Completed Orders</h5>

        @if (session()->has('message'))
            <div class="alert alert-success">
                {{ session()->get('message') }}
            </div>
        @endif

        <div class="table-responsive text-nowrap">
            <table class="table">

                <thead class="table-light">
                    <tr>
                        <th>Invoice & Customer</th>
                        <th>Address</th>
                        <th>Product Name</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody class="table-border-bottom-0">
                    @foreach ($completedOrders as $completedOrder)
                        <tr>
                            <td>
                                <span class="badge bg-label-info"># {{ $completedOrder->invoice_code ?? '' }}</span> 
                                </br>
                                {{ $completedOrder->user_name }}
                            </td>
                            <td>
                                <ul>
                                    <li>Phone Number : {{ $completedOrder->phone_number}}</li>
                                    <li>Address : {{ $completedOrder->address}}</li>
                                    <li>City : {{ $completedOrder->city}}</li>
                                    <li>Postal Code : {{ $completedOrder->postal_code}}</li>
                                </ul>
                            </td>
                            <td>{{ $completedOrder->product_name }}</td>
                            <td>{{ $completedOrder->quantity }}</td>
                            <td>{{ $completedOrder->total_price }}</td>
                            <td>
                                <span class="badge bg-label-warning">{{ $completedOrder->status }}</span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
    </div>
</div>


@endsection 