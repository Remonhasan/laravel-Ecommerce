@extends('frontend.layouts.userMaster')

@section('page_title')
    Approved Order | nDolish
@endsection

@section('user-profile-content')
    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session()->get('message') }}
        </div>
    @endif

    <table class="table">
        <tr>
            <th>Invoice & Product Name</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Status</th>
        </tr>
        @foreach ($approvedOrders as $approvedOrder)
            <tr>
                <td>
                    <span class="badge bg-label-info">#{{ $approvedOrder->invoice_code ?? '' }}</span> 
                    </br>
                    {{ $approvedOrder->product_name }}
                </td>
                <td>{{ $approvedOrder->quantity }}</td>
                <td>{{ $approvedOrder->total_price }}</td>
                <td>
                    @if ($approvedOrder->status == 'pending')
                        <span class="badge bg-label-warning">{{ $approvedOrder->status }}</span>
                    @elseif($approvedOrder->status == 'approved')
                        <span class="badge bg-label-success">{{ $approvedOrder->status }}</span>
                    @else
                        <span class="badge bg-label-danger">{{ $approvedOrder->status }}</span>
                    @endif
                </td>
            </tr>
        @endforeach

    </table>
@endsection
