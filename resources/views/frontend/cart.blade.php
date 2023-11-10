@extends('frontend.layouts.master')

@section('page_title')
    Cart | nDolish
@endsection

@section('main-content')
    <div class="row">

        <div class="col-12" style="margin-top: 60px">

            @if (session()->has('message'))
                <div class="alert alert-success">
                    {{ session()->get('message') }}
                </div>
            @endif

            <div class="box_main">
                <div class="table-responsive">
                    <table class="table">
                        <tr>
                            <th>Image</th>
                            <th>Product Name</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Action</th>
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
                                    <img src="{{ asset($productImage) }}" alt="Product Image" height="50" width="60">
                                </td>
                                <td>{{ $productName }}</td>
                                <td>{{ $cart->quantity }}</td>
                                <td>{{ $cart->price }}</td>
                                <td>
                                    <a href="{{ route('remove.cart', $cart->id) }}" class="btn btn-warning">Remove</a>
                                </td>

                                @php
                                    $total = $total + $cart->price;
                                    $totalQuantity = $totalQuantity + $cart->quantity;
                                @endphp
                            </tr>
                        @endforeach

                        <tr>
                            <td></td>
                            
                            @if ($total > 0)
                                <td style="font-weight: bold">Total</td>
                                <td style="font-weight: bold">{{ $totalQuantity }}</td>
                                <td style="font-weight: bold">{{ $total }}</td>
                            @else
                                <td>
                                    <div class="alert alert-warning" role="alert">
                                        No Items in Cart !
                                    </div>
                                </td>
                                <td></td>
                                <td></td>
                            @endif

                            @if ($total > 0)
                                <td>
                                    <a href="{{ route('shipping.address') }}" class="btn btn-sm btn-primary">Checkout Now</a>
                                </td>
                            @endif

                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
