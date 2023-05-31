@extends('layouts.templates')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h1>Welcome to Dashboard, {{ auth()->user()->name }}</h1>
                    <div class="row">
                        <div class="col-md-2">
                            <div class="card border-primary mb-3">
                                <div class="card-body">
                                    <h6 class="card-title">Total All Vendors</h6>
                                    <p class="card-text" id="totalVendor">Loading...</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="card border-info mb-3">
                                <div class="card-body">
                                    <h6 class="card-title">Registered Vendors</h6>
                                    <p class="card-text" id="registered">Loading...</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="card border-success mb-3">
                                <div class="card-body">
                                    <h6 class="card-title">Active Vendors</h6>
                                    <p class="card-text" id="active">Loading...</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="card border-warning mb-3">
                                <div class="card-body">
                                    <h6 class="card-title">Expired Vendors</h6>
                                    <p class="card-text" id="expired">Loading...</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="card border-danger mb-3">
                                <div class="card-body">
                                    <h6 class="card-title">Blacklisted Vendors</h6>
                                    <p class="card-text" id="blacklist">Loading...</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="card border-secondary mb-3">
                                <div class="card-body">
                                    <h6 class="card-title">Available Vendors</h6>
                                    <p class="card-text" id="notBlacklist">Loading...</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <h1>Data 5 Vendor Terakhir</h1>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Vendor Name</th>
                                    <th>Status</th>
                                    <th>Is Blacklist</th>
                                </tr>
                            </thead>
                            <tbody  id="latestVendorsTable">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <h1>Data 5 Pekerjaan Terakhir</h1>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Job Name</th>
                                    <th>Procurement Number</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody  id="latestProcurementTable">
                                <!-- Data will be populated dynamically -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Fungsi untuk mengambil data jumlah vendor terdaftar, aktif, dan kedaluwarsa melalui API
function fetchData() {
    fetch('{{ route('dashboard.vendor-count') }}')
    .then(response => response.json())
    .then(data => {
        if (data.success) {
        document.getElementById('totalVendor').textContent = data.totalVendor;
        document.getElementById('registered').textContent = data.registered;
        document.getElementById('active').textContent = data.active;
        document.getElementById('expired').textContent = data.expired;
        document.getElementById('blacklist').textContent = data.blacklist;
        document.getElementById('notBlacklist').textContent = data.notBlacklist;
        } else {
        console.log(data.message); // Menampilkan pesan error jika ada
        }
    })
    .catch(error => {
        console.log(error);
    });
}

// Memanggil fungsi fetchData saat halaman selesai dimuat
document.addEventListener('DOMContentLoaded', fetchData);

</script>
<script>
    // Populate table with data
function populateTable(data, tableId) {
    var table = document.getElementById(tableId);
    table.innerHTML = ''; // Clear existing table content

    for (var i = 0; i < data.length; i++) {
        var row = table.insertRow(i);

        // Create cells and fill them with data
        var cellIndex = row.insertCell(0);
        cellIndex.innerHTML = i + 1;

        var cellName = row.insertCell(1);
        cellName.innerHTML = data[i].name;

        if (tableId === 'latestVendorsTable') {
            var cellVendorStatus = row.insertCell(2);
            if (data[i].status === "0") {
                cellVendorStatus.innerHTML = '<span class="badge badge-info" style="background-color: blue; color: white;">Registered</span>';
            } else if (data[i].status === "1") {
                cellVendorStatus.innerHTML = '<span class="badge badge-success" style="background-color: green; color: white;">Active</span>';
            } else if (data[i].status === "2") {
                cellVendorStatus.innerHTML = '<span class="badge badge-warning" style="background-color: yellow; color: white;">Expired</span>';
            } else {
                cellVendorStatus.innerHTML = ''; // Handle case when status has unexpected value
            }

            var cellIsBlacklist = row.insertCell(3);
            if (data[i].is_blacklist === "1") {
                cellIsBlacklist.innerHTML = '<span class="badge badge-danger" style="background-color: red; color: white;">Blacklist</span>';
            } else if (data[i].is_blacklist === "0") {
                cellIsBlacklist.innerHTML = '<span class="badge badge-success" style="background-color: green; color: white;">Available</span>';
            } else {
                cellIsBlacklist.innerHTML = ''; // Handle case when is_blacklist has unexpected value
            }
        } else if (tableId === 'latestProcurementTable') {
            var cellProcurementNumber = row.insertCell(2);
            cellProcurementNumber.innerHTML = data[i].number;

            var cellStatus = row.insertCell(3);
            if (data[i].status === "0") {
                cellStatus.innerHTML = '<span class="badge badge-info" style="background-color: blue; color: white;">Process</span>';
            } else if (data[i].status === "1") {
                cellStatus.innerHTML = '<span class="badge badge-success" style="background-color: green; color: white;">Success</span>';
            } else if (data[i].status === "2") {
                cellStatus.innerHTML = '<span class="badge badge-warning" style="background-color: yellow; color: white;">Canceled</span>';
            } else {
                cellStatus.innerHTML = ''; // Handle case when status has unexpected value
            }
        }
    }
}

// Fetch data and populate vendor table
function fetchVendorData() {
    fetch('{{ route('dashboard.table-data-vendor') }}')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                populateTable(data.data, 'latestVendorsTable');
            } else {
                console.log(data.message); // Display error message if any
            }
        })
        .catch(error => {
            console.log(error);
        });
}

// Fetch data and populate procurement table
function fetchProcurementData() {
    fetch('{{ route('dashboard.table-data-procurement') }}')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                populateTable(data.data, 'latestProcurementTable');
            } else {
                console.log(data.message); // Display error message if any
            }
        })
        .catch(error => {
            console.log(error);
        });
}

// Call fetchData functions when the DOM content is loaded
document.addEventListener('DOMContentLoaded', () => {
    fetchVendorData();
    fetchProcurementData();
});
</script>
@endsection
