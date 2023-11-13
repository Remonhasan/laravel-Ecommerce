@extends('frontend.layouts.master')

@section('page_title')
    Search Product | nDolish
@endsection

@section('main-content')
    <div class="container">
        <div class="row">

            @foreach ($searchedProducts as $product)
                <div class="col-lg-4 col-sm-4" style="margin-top: 100px">
                    <div class="box_main">
                        <h4 class="shirt_text">{{ $product->name }}</h4>
                        <p class="price_text">Price <span style="color: #262626;">$
                                {{ $product->price }}</span></p>
                        <div class="tshirt_img"><img src="{{ asset($product->image) }}"></div>
                        <div class="btn_main">
                            <div class="buy_bt">
                                <form action="{{ route('add.productCart') }}" method="POST">
                                    @csrf

                                    <input type="hidden" value="{{ $product->id }}" name="product_id">
                                    <input type="hidden" value="{{ $product->price }}" name="price">
                                    <input type="hidden" value="1" name="quantity">

                                    <input class="btn btn-warning" type="submit" value="Buy Now">
                                </form>
                            </div>

                            <div class="seemore_bt">
                                <a href="{{ route('customer.product', [$product->id, $product->slug]) }}">
                                    See More
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>

        <div class="row">
            <div class="col-lg-12">
                <span style="padding-top: 20px">
                    {{ $searchedProducts->links('pagination::bootstrap-5') }}
                </span>
            </div>
        </div>
        
    </div>
@endsection
