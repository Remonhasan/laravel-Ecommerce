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
            <th>Product Name</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Status</th>
        </tr>
        @foreach ($pendingOrders as $pendingOrder)
            <tr>
                <td>{{ $pendingOrder->product_name }}</td>
                <td>{{ $pendingOrder->quantity }}</td>
                <td>{{ $pendingOrder->total_price }}</td>
                <td>
                    @if ($pendingOrder->status == 'pending')
                        <span class="badge bg-label-warning">{{ $pendingOrder->status }}</span>
                    @elseif($pendingOrder->status == 'approved')
                        <span class="badge bg-label-success">{{ $pendingOrder->status }}</span>
                    @else
                        <span class="badge bg-label-danger">{{ $pendingOrder->status }}</span>
                    @endif
                </td>
            </tr>
        @endforeach

    </table>
@endsection
