@extends('admin.layouts.master')

@section('page_title')
    Subcategories
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        <div class="d-flex justify-content-between align-items-center">
            <h4 class="py-3 mb-4"><span class="text-muted fw-light">Sub Category /</span> List</h4>
            <a href="{{ route('add.subcategory') }}" class="btn btn-primary ml-25">Add</a>
        </div>

        <div class="card shadow">
            <h5 class="card-header">Subcategories</h5>

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
                            <th>Category Name</th>
                            <th>Total Product</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody class="table-border-bottom-0">

                        @foreach ($subcategories as $subcategory)
                            <tr>
                                <td>{{ $subcategory->id }}</td>
                                <td>{{ $subcategory->name }}</td>
                                <td>{{ $subcategory->category_name }}</td>
                                <td>{{ $subcategory->product_count }}</td>
                                <td>
                                    @if ($subcategory->status == 1)
                                        <span class="badge bg-label-success">Active</span>
                                    @else
                                        <span class="badge bg-label-danger">Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('edit.subcategory', $subcategory->id) }}" class="btn btn-info mr-2">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                    <a href="{{ route('edit.subcategory', $subcategory->id) }}" class="btn btn-primary mr-2">
                                        <i class="fa-solid fa-file-pen"></i>
                                    </a>
                                    <a href="{{ route('delete.subcategory', $subcategory->id) }}" class="btn btn-danger">
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
                    {{ $subcategories->links('pagination::bootstrap-5') }}
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
                tdStatus   = tr[i].getElementsByTagName("td")[4];  // Column index for Status

                if (tdCustomer && tdStatus) {
                    txtValueCustomer = tdCustomer.textContent || tdCustomer.innerText;
                    txtValueStatus   = tdStatus.textContent || tdStatus.innerText;

                    var customerMatch = txtValueCustomer.toUpperCase().indexOf(filterCustomer) > -1;
                    var statusMatch   = (filterStatus === "ALL" || (filterStatus === "ACTIVE" && txtValueStatus.trim() ===
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
