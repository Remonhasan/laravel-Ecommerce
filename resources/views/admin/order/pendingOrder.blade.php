@extends('admin.layouts.master')

@section('page_title')
    Pending order
@endsection

@section('content')
 
<div class="container-xxl flex-grow-1 container-p-y">

    <div class="d-flex justify-content-between align-items-center">
        <h4 class="py-3 mb-4"><span class="text-muted fw-light">Oders /</span> Pending</h4>
    </div>

    <div class="card shadow">
        <h5 class="card-header">Pending Orders</h5>

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
                        <option value="pending">Pending</option>
                        <option value="Active">Active</option>
                        <option value="Inactive">Inactive</option>
                    </select>
                </div>
            </div>

        <div class="table-responsive text-nowrap">
            <table class="table" id="salesTable">

                <thead class="table-primary">
                    <tr>
                        <th>Customer</th>
                        <th>Address</th>
                        <th>Product Name</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody class="table-border-bottom-0">
                    @if(!empty($pendingOrders))
                    @foreach ($pendingOrders as $pendingOrder)
                        <tr>
                            @php 
                             $userName = App\Models\User::where('id', $pendingOrder->user_id)->value('name');
                            @endphp 
                            <td>
                                <span class="badge bg-label-info">{{ $pendingOrder->invoice_code }}</span>
                                {{ $userName }}
                            </td>
                            <td>
                                <ul>
                                    <li>Phone Number : {{ $pendingOrderAddress->phone_number}}</li>
                                    <li>Address : {{ $pendingOrderAddress->address}}</li>
                                    <li>City : {{ $pendingOrderAddress->city}}</li>
                                    <li>Postal Code : {{ $pendingOrderAddress->postal_code}}</li>
                                </ul>
                            </td>
                            <td>
                                @foreach($pendingOrderProducts as $pendingOrderProduct )
                                <ul>
                                    @php 
                                     $productName = App\Models\Product::where('id', $pendingOrderProduct->product_id)->value('name');
                                    @endphp 
                                    <li>{{ $productName }}</li>
                                </ul>
                                @endforeach
                            </td>
                            <td>{{ $pendingOrder->quantity }}</td>
                            <td>{{ $pendingOrder->total_price }}</td>
                            <td>
                                <span class="badge bg-label-warning">{{ $pendingOrder->status }}</span>
                            </td>
                            <td>
                                <a href="{{ route('approve.order', $pendingOrder->id) }}" class="btn btn-success mr-2">
                                    <i class="fa-solid fa-check"></i>
                                </a>
                                <a href="{{ route('cancled.order', $pendingOrder->id) }}" class="btn btn-danger">
                                    <i class="fa-solid fa-x"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    @endif
                </tbody>

            </table>
        </div>
    </div>
</div>

    @if(!empty($pendingOrders))
    <div class="row" style="margin-top: 15px">
        <div class="col-md-12">
            <span style="padding-top: 20px">
                {{ $pendingOrders->links('pagination::bootstrap-5') }}
            </span>
        </div>
    </div>
    @endif

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
                        "Active") || (filterStatus === "PENDING" && txtValueStatus.trim() ===
                        "pending") || (filterStatus === "INACTIVE" && txtValueStatus.trim() === "Inactive"));

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