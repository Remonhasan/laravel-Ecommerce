@extends('admin.layouts.master')

@section('page_title')
    Edit Sub Category
@endsection

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="py-3 mb-4"><span class="text-muted fw-light">Sub Category /</span> Edit</h4>

    <div class="row">
        <div class="col">
            <div class="card shadow mb-4">

                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Edit Sub Category</h5> <small class="text-muted float-end">subcategory
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

                    <form action="{{ route('update.subcategory') }}" method="POST">
                        @csrf

                        <input type="hidden" value={{ $subcategoryInfo->id }} name="subcategory_id">

                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="category-name">Sub Category Name</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="name" id="name"
                                    value={{ $subcategoryInfo->name }} />
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="category-name">Category Name</label>
                            <div class="col-sm-10">
                                <select id="defaultSelect" class="form-select" name="category_id">
                                    <option>Select Category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" {{ $subcategoryInfo->category_id === $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="category-name">Status</label>
                            <div class="col-sm-10">
                                <select id="defaultSelect" class="form-select" name="status">
                                    <option value="1" {{ $subcategoryInfo->status === 1 ? 'selected' : '' }} >Active</option>
                                    <option value="2" {{ $subcategoryInfo->status === 2 ? 'selected' : '' }}>Inactive</option>
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
