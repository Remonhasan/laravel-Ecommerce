@extends('admin.layouts.master')

@section('page_title')
    Edit Product
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 mb-4"><span class="text-muted fw-light">Product /</span> Edit</h4>

        <div class="row">
            <div class="col">
                <div class="card shadow mb-4">

                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">Edit Product</h5> <small class="text-muted float-end">product
                            information</small>
                    </div>

                    <div class="card-body">

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!-- catch section error -->
                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif

                        <form action={{ route('update.product') }} method="POST" enctype="multipart/form-data">
                            @csrf

                            <input type="hidden" value={{ $productInfo->id }} name="product_id">

                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="product-name">Product Name</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="name" id="name"
                                    value={{ $productInfo->name }} />
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="product-price">Product Price</label>
                                <div class="col-sm-10">
                                    <input type="number" min="0" class="form-control" name="price" id="price"
                                    value={{ $productInfo->price }} />
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="product-quantity">Product Quantity</label>
                                <div class="col-sm-10">
                                    <input type="number" min="0" class="form-control" name="quantity" id="quantity"
                                    value={{ $productInfo->quantity }} />
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="short-description">Short Description</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" name="short_description" id="short-description" cols="15" rows="5">
                                    {{ $productInfo->short_description }}
                                    </textarea>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="long-description">Long Description</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" name="long_description" id="long-description" cols="30" rows="10">
                                    {{ $productInfo->long_description }}
                                    </textarea>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="category-name">Category Name</label>
                                <div class="col-sm-10">
                                    <select id="categorySelect" class="form-select" name="category_id">
                                        <option>Select Category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ $productInfo->category_id === $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="category-name">Sub Category Name</label>
                                <div class="col-sm-10">
                                    <select id="subcategorySelect" class="form-select" name="subcategory_id">
                                        <option>Select Sub Category</option>
                                        @foreach ($subcategories as $subcategory)
                                            <option value="{{ $subcategory->id }}"
                                                {{ $productInfo->subcategory_id === $subcategory->id ? 'selected' : '' }}>
                                                {{ $subcategory->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="product-image">Product Image</label>
                                <div class="col-sm-10">
                                    <input type="file" class="form-control" name="image" id="image"
                                     value={{ $productInfo->image }} />
                                        <img src="{{ asset($productInfo->image) }}" alt="" height="60" width="60">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="category-name">Status</label>
                                <div class="col-sm-10">
                                    <select id="defaultSelect" class="form-select" name="status">
                                        <option value="1" {{ $productInfo->status === 1 ? 'selected' : '' }}>Active
                                        </option>
                                        <option value="2" {{ $productInfo->status === 2 ? 'selected' : '' }}>Inactive
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div class="row justify-content-end">
                                <div class="col-sm-10">
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#categorySelect').on('change', function() {
                var categoryId = $(this).val();
                if (categoryId) {
                    $.ajax({
                        type: 'GET',
                        url: '/get-subcategories/' + categoryId, // Replace with your route URL
                        success: function(data) {
                            $('#subcategorySelect').empty();
                            $('#subcategorySelect').append(
                                '<option>Select Subcategory</option>');
                            $.each(data, function(key, value) {
                                $('#subcategorySelect').append('<option value="' + key +
                                    '">' + value.name + '</option>');
                            });
                        }
                    });
                } else {
                    $('#subcategorySelect').empty();
                    $('#subcategorySelect').append('<option>Select Subcategory</option>');
                }
            });
        });
    </script>
@endpush
