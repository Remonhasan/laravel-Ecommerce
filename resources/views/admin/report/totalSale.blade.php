@extends('admin.layouts.master')

@section('page_title')
    Products
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        <div class="d-flex justify-content-between align-items-center">
            <h4 class="py-3 mb-4"><span class="text-muted fw-light">Report /</span> Total Sale</h4>
        </div>

        <div class="card shadow">
            <h5 class="card-header">Datewise Total Sale Report</h5>

            <div class="container">
                <div class="row mb-4">
                    <div class="col-md-4">
                        <label for="dateFilter">Filter by Date:</label>
                        <input type="date" id="dateFilter" class="form-control" oninput="filterTable()">
                    </div>
                    <div class="col-md-4">
                        <label for="customerFilter">Filter by Customer:</label>
                        <input type="text" id="customerFilter" class="form-control" oninput="filterTable()">
                    </div>
                    <div class="col-md-4">
                        <label for="statusFilter">Filter by Status:</label>
                        <select id="statusFilter" class="form-control" onchange="filterTable()">
                            <option value="">All</option>
                            <option value="pending">Pending</option>
                            <option value="approved">Approved</option>
                            <option value="cancled">Cancled</option>
                        </select>
                    </div>
                </div>

                <div class="table-responsive text-nowrap">
                    <table class="table" id="salesTable">

                        <thead class="table-primary">
                            <tr>
                                <th>Date</th>
                                <th>Customer Name</th>
                                <th>Products</th>
                                <th>Quantity</th>
                                <th>Total Price</th>
                                <th>Status</th>
                            </tr>
                        </thead>

                        <tbody class="table-border-bottom-0">

                            @foreach ($orders as $order)
                                <tr>
                                    @php
                                        $userName = App\Models\User::where('id', $order->user_id)->value('name');
                                    @endphp
                                    <td>{{ $order->created_at->format('m-d-Y') }}</td>
                                    <td>{{ $userName }}</td>


                                    <td>
                                        @foreach ($totalSales as $totalSale)
                                            <ul>
                                                <li>{{ $totalSale->product_name }}</li>
                                            </ul>
                                        @endforeach
                                    </td>


                                    <td>{{ $order->quantity }}</td>
                                    <td>{{ $order->total_price }}</td>
                                    <td>{{ $order->status }}</td>
                                </tr>
                            @endforeach


                        </tbody>

                    </table>
                </div>
            </div>

            <div class="row" style="margin-top: 15px">
                <div class="col-md-12">
                    <span style="padding-top: 20px">
                        {{ $orders->links('pagination::bootstrap-5') }}
                    </span>
                </div>
            </div>

        </div>
    @endsection

    @push('script')
        <script>
            function filterTable() {

                var inputCustomer = document.getElementById("customerFilter").value.toUpperCase();
                var inputDate     = document.getElementById("dateFilter").value;
                var inputStatus   = document.getElementById("statusFilter").value;

                var table = document.getElementById("salesTable");
                var rows  = table.getElementsByTagName("tr");

                for (var i = 0; i < rows.length; i++) {
                    var customerCell = rows[i].getElementsByTagName("td")[1];  // Column index for Customer Name
                    var dateCell     = rows[i].getElementsByTagName("td")[0];  // Column index for Date
                    var statusCell   = rows[i].getElementsByTagName("td")[5];  // Column index for Status

                    if (customerCell && dateCell && statusCell) {
                        var customerValue = customerCell.textContent || customerCell.innerText;
                        var dateValue     = dateCell.textContent || dateCell.innerText;
                        var statusValue   = statusCell.textContent || statusCell.innerText;

                          // Format input date in the same format as displayed date (m-d-Y)
                        var formattedInputDate = new Date(inputDate).toLocaleDateString('en-US', {
                            year : 'numeric',
                            month: '2-digit',
                            day  : '2-digit'
                        }).replace(/\//g, '-');

                        var customerMatch = customerValue.toUpperCase().includes(inputCustomer);
                        var dateMatch     = inputDate   === '' || formattedInputDate === dateValue;
                        var statusMatch   = inputStatus === '' || inputStatus        === statusValue;

                        if (customerMatch && dateMatch && statusMatch) {
                            rows[i].style.display = "";
                        } else {
                            rows[i].style.display = "none";
                        }
                    }
                }
            }
        </script>
    @endpush
