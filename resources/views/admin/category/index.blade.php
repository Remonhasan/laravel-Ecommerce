@extends('admin.layouts.master')

@section('page_title')
    Categories
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        <div class="d-flex justify-content-between align-items-center">
            <h4 class="py-3 mb-4"><span class="text-muted fw-light">Category /</span> List</h4>
            <a href="{{ route('add.category') }}" class="btn btn-primary ml-25">Add</a>
        </div>

        <div class="card shadow">

            <h5 class="card-header">Categories</h5>

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
                            <th>Total Subcategory</th>
                            <th>Slug</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody class="table-border-bottom-0">
                        @foreach ($categories as $category)
                            <tr>
                                <td>{{ $category->id }}</td>
                                <td>{{ $category->name }}</td>
                                <td>{{ $category->subcategory_count }}</td>
                                <td>{{ $category->slug }}</td>
                                <td>
                                    @if ($category->status == 1)
                                        <span class="badge bg-label-success">Active</span>
                                    @else
                                        <span class="badge bg-label-danger">Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('edit.category', $category->id) }}" class="btn btn-info mr-3">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                    <a href="{{ route('edit.category', $category->id) }}" class="btn btn-primary mr-3">
                                        <i class="fa-solid fa-file-pen"></i>
                                    </a>
                                    <a href="{{ route('delete.category', $category->id) }}" class="btn btn-danger">
                                        <i class="fa-solid fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>

        </div>
        <div class="row" style="margin-top: 15px">
            <div class="col-md-12">
                <span style="padding-top: 20px">
                    {{ $categories->links('pagination::bootstrap-5') }}
                </span>
            </div>
        </div>
    </div>
@endsection
