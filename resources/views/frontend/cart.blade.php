@extends('frontend.layouts.master')

@section('page_title')
    Cart | nDolish
@endsection

@section('main-content')
    <h1> Customer Cart Page !</h1>
        
    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session()->get('message') }}
        </div>
    @endif
    
    <div class="row">
        <div class="col-12">
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
                                    <a href="" class="btn btn-warning">Remove</a>
                                </td>

                                @php 
                                    $total = $total + $cart->price;
                                @endphp 
                            </tr>                            
                        @endforeach

                        <tr>
                            <td></td>
                            <td></td>
                            <td style="font-weight: bold">Total</td>
                            <td style="font-weight: bold">{{ $total }}</td>
                            <td></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
