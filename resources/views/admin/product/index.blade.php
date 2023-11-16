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

            <div class="container">
                <div class="row mb-4">

                    <div class="col-md-6">
                        <label for="customerFilter">Filter by Name:</label>
                        <input type="text" id="customerFilter" class="form-control" oninput="filterTable()">
                    </div>
                    <div class="col-md-6">
                        <label for="statusFilter">Filter by Status:</label>
                        <select id="statusFilter" class="form-control" onchange="filterTable()">
                            <option value="">All</option>
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                    </div>
                </div>


                <div class="table-responsive text-nowrap">
                    <table class="table" id="salesTable">

                        <thead class="table-primary">
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
                                        {{-- <a href="{{ route('edit.product', $product->id) }}" class="btn btn-info mr-2">
                                            <i class="fa-solid fa-eye"></i>
                                        </a> --}}
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

        <div class="row" style="margin-top: 15px">
            <div class="col-md-12">
                <span style="padding-top: 20px">
                    {{ $products->links('pagination::bootstrap-5') }}
                </span>
            </div>
        </div>

    </div>
@endsection

@push('script')
    <script>
        function filterTable() {
            var inputCustomer, inputStatus, filterCustomer, filterStatus, table, tr, tdCustomer, tdStatus, i,
                txtValueCustomer, txtValueStatus;

            inputCustomer = document.getElementById("customerFilter");
            inputStatus   = document.getElementById("statusFilter");

            filterCustomer = inputCustomer.value.toUpperCase();
            filterStatus   = inputStatus.value.toUpperCase();    // Ensure comparison in uppercase

            table = document.getElementById("salesTable");
            tr    = table.getElementsByTagName("tr");

            for (i = 0; i < tr.length; i++) {
                tdCustomer = tr[i].getElementsByTagName("td")[1];  // Column index for Customer Name
                tdStatus   = tr[i].getElementsByTagName("td")[5];  // Column index for Status

                if (tdCustomer && tdStatus) {
                    txtValueCustomer = tdCustomer.textContent || tdCustomer.innerText;
                    txtValueStatus   = tdStatus.textContent || tdStatus.innerText;

                    var customerMatch = txtValueCustomer.toUpperCase().indexOf(filterCustomer) > -1;
                    var statusMatch   = (filterStatus === "" || (filterStatus === "ACTIVE" && txtValueStatus.trim() ===
                        "Active") || (filterStatus === "INACTIVE" && txtValueStatus.trim() === "Inactive"));

                    if (customerMatch && statusMatch) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }
    </script>
@endpush
