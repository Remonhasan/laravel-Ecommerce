@extends('admin.layouts.master')

@section('page_title')
    Products
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        <div class="d-flex justify-content-between align-items-center">
            <h4 class="py-3 mb-4"><span class="text-muted fw-light">Product /</span> List</h4>
            <a href="{{ route('add.product') }}" class="btn btn-primary ml-25">Add</a>
        </div>

        <div class="card shadow">
            <h5 class="card-header">Products</h5>

            @if (session()->has('message'))
                <div class="alert alert-success">
                    {{ session()->get('message') }}
                </div>
            @endif

            <div class="table-responsive text-nowrap">
                <table class="table">

                    <thead class="table-light">
                        <tr>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Image</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody class="table-border-bottom-0">
                        @foreach ($products as $product)
                            <tr>
                                <td>{{ $product->id }}</td>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->category_name }}</td>
                                <td>
                                    <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" height="60"
                                        width="60">
                                </td>
                                <td>{{ $product->price }}</td>
                                <td>
                                    @if ($product->status == 1)
                                        <span class="badge bg-label-success">Active</span>
                                    @else
                                        <span class="badge bg-label-danger">Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('edit.product', $product->id) }}" class="btn btn-info mr-2">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                    <a href="{{ route('edit.product', $product->id) }}" class="btn btn-primary mr-2">
                                        <i class="fa-solid fa-file-pen"></i>
                                    </a>
                                    <a href="{{ route('delete.product', $product->id) }}" class="btn btn-danger">
                                        <i class="fa-solid fa-trash"></i>
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
