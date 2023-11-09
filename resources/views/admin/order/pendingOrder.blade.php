@extends('admin.layouts.master')

@section('page_title')
    Pending order
@endsection

@section('content')
 
<div class="container-xxl flex-grow-1 container-p-y">

    <div class="d-flex justify-content-between align-items-center">
        <h4 class="py-3 mb-4"><span class="text-muted fw-light">Oders /</span> Pending</h4>
    </div>

    <div class="card shadow">
        <h5 class="card-header">Pending Orders</h5>

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
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody class="table-border-bottom-0">
                    @foreach ($pendingOrders as $pendingOrder)
                        <tr>
                            <td>{{ $pendingOrder->user_name }}</td>
                            <td>
                                <ul>
                                    <li>Phone Number : {{ $pendingOrder->phone_number}}</li>
                                    <li>Address : {{ $pendingOrder->address}}</li>
                                    <li>City : {{ $pendingOrder->city}}</li>
                                    <li>Postal Code : {{ $pendingOrder->postal_code}}</li>
                                </ul>
                            </td>
                            <td>{{ $pendingOrder->product_name }}</td>
                            <td>{{ $pendingOrder->quantity }}</td>
                            <td>{{ $pendingOrder->total_price }}</td>
                            <td>
                                <span class="badge bg-label-warning">{{ $pendingOrder->status }}</span>
                            </td>
                            <td>
                                <a href="{{ route('approve.order', $pendingOrder->id) }}" class="btn btn-success mr-2">
                                    <i class="fa-solid fa-check"></i>
                                </a>
                                <a href="{{ route('cancled.order', $pendingOrder->id) }}" class="btn btn-danger">
                                    <i class="fa-solid fa-x"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
    </div>
</div>


@endsection 