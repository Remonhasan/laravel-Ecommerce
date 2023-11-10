@extends('frontend.layouts.userMaster')

@section('page_title')
    Checkout | nDolish
@endsection

@section('main-content')
  
    <div class="row">
        <div class="col-4" style="margin-top: 80px">
            <div class="box_main">
                <h3>Product will send at : </h3>

                <p>Phone Number: {{ $shippingAddress->phone_number }} </p>
                <p>City/Division : {{ $shippingAddress->city }} </p>
                <p>Street/Address : {{ $shippingAddress->address }} </p>
                <p>Postal Code : {{ $shippingAddress->postal_code }} </p>
            </div>
        </div>

        <div class="col-8" style="margin-top: 80px">
            <div class="box_main">
                Your Final Products are :
                <div class="table-responsive">
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
                                    <img src="{{ asset($productImage) }}" alt="Product Image" height="50" width="60">
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
                </div>
            </div>
        </div>
        
        
        <form action="" method="POST">
            @csrf 

            <input type="submit" value="Cancle order" class="btn btn-danger mr-3">
        </form>

        <form action="{{ route('place.order') }}" method="POST">
            @csrf 
            
            <input type="hidden" value="{{ $totalQuantity }}" name="total_quantity" />
            <input type="hidden" value="{{ $total }}" name="total_price" />
            <input type="submit" value="Place order" class="btn btn-primary">
        </form>

       </div>
    </div>
@endsection
