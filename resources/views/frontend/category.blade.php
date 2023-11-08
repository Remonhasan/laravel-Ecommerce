@extends('frontend.layouts.master')

@section('page_title')
    Category | nDolish
@endsection

@section('main-content')
    <div class="fashion_section">
        <div id="main_slider" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <div class="container" style="margin-top: 100px">
                        <button type="button" class="btn btn-primary fashion_taital">
                            {{ $category->name }} <span class="badge badge-light">{{ $category->product_count }}</span>
                          </button>
                        <div class="fashion_section_2">
                            <div class="row">

                                @foreach ($products as $product)
                                    <div class="col-lg-4 col-sm-4">
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
                                                        
                                                        <input class="btn btn-warning" type="submit" value="Buy Now" >
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
