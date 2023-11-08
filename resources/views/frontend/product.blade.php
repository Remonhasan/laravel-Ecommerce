@extends('frontend.layouts.master')

@section('page_title')
    Product | nDolish
@endsection

@section('main-content')
    <div class="container">
        <div class="row">
            <div class="col-lg-4" style="margin-top: 100px">
                <div class="box_main">
                    <div class="tshirt_img"><img src="{{ asset($product->image) }}"></div>

                </div>
            </div>
            <div class="col-lg-8" style="margin-top: 100px">
                <div class="box_main">
                    <div class="product-info">
                        <h4 class="shirt_text text-left">{{ $product->name }}</h4>
                        <p class="price_text text-left">Price <span style="color: #262626;">$ {{ $product->price }}</span></p>
                    </div>
                    <div class="my-3 product-details">
                        <p class="lead">
                            {{ $product->long_description }}
                        </p>
                        <ul class="p-2 bg-light my-2">
                            <li>Category - {{ $product->category_name }}</li>
                            <li>Sub Category - {{ $product->subcategory_name }}</li>
                            <li>Available Quantity - {{ $product->quantity }}</li>
                        </ul>
                    </div>
                    <div class="btn_main">
                        <div class="btn btn-warning"><a href="#">Add to Cart</a></div>
                    </div>
                </div>
            </div>

        </div>

        <div class="fashion_section">
            <div id="main_slider" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="container" style="margin-top: 100px">
                            <h1 class="fashion_taital">Related Products</h1>
                            <div class="fashion_section_2">
                                <div class="row">
    
                                    @foreach($relatedProducts as $relatedProduct)
                                    <div class="col-lg-4 col-sm-4">
                                        <div class="box_main">
                                            <h4 class="shirt_text">{{ $relatedProduct->name }}</h4>
                                            <p class="price_text">Price <span style="color: #262626;">$
                                                    {{  $relatedProduct->price }}</span></p>
                                            <div class="tshirt_img"><img src="{{ asset($relatedProduct->image) }}"></div>
                                            <div class="btn_main">
                                                <div class="buy_bt"><a href="#">Buy Now</a></div>
                                                <div class="seemore_bt">
                                                    <a href="{{ route('customer.product', [$relatedProduct->id, $relatedProduct->slug]) }}">
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
    </div>
@endsection
