@extends('layouts.templates')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h1>Blacklist Vendor Data</h1>
                    <table class="table table-responsive" id="vendors-data">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Core Business</th>
                                <th>Classification</th>
                                <th>Address</th>
                                {{-- <th>Area</th>
                                <th>Director</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Capital</th> --}}
                                <th>Grade</th>
                                <th>Is Blacklist</th>
                                <th>Blacklist At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $('#vendors-data').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('vendors.data') }}',
            columns: [
                {
                data: null,
                render: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                },
                name: 'row_number',
                searchable: false,
                orderable: false,
                },
                { data: 'name', name: 'name' },
                {
                data: 'core_businesses',
                    render: function (data) {
                        return data.map(function (item, index) {
                            return (index+1) + "." + item.name +"<br>";
                        }).join("");
                        },
                name: 'core_businesses.name'
                },
                {
                data: 'classifications',
                    render: function (data) {
                        return data.map(function (item, index) {
                            return (index+1) + "." + item.name + "<br>";
                        }).join("");
                    },
                name: 'classifications.name'
                },
                { data: 'address', name: 'address' },
                // { data: 'area', name: 'area' },
                // { data: 'director', name: 'director' },
                // { data: 'phone', name: 'phone' },
                // { data: 'email', name: 'email' },
                // { data: 'capital', name: 'capital' },
                { data: 'grade', name: 'grade',
                render: function (data) {
                        if (data === '0') {
                            return 'Kecil';
                        } else if (data === '1') {
                            return 'Menengah';
                        } else if (data === '2') {
                            return 'Besar';
                        } else  {
                            return '-';
                        }
                    }
                },
                { data: 'is_blacklist', name: 'is_blacklist',
                render: function (data) {
                    if (data === '0') {
                        return '<span class="badge bg-success">Not Blacklisted</span>';
                    } else if (data === '1') {
                        return '<span class="badge bg-danger">Blacklisted</span>';
                    } else {
                        return '<span class="badge bg-secondary">-</span>';
                    }
                    }
                },
                { data: 'blacklist_at', name: 'blacklist_at' },
                {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false,
                render: function (data, type, row, meta) {
                    var source = 'data';
                return `
                    <a href="${route('vendors.show', {vendor: row.id, source:source})}" class="btn btn-sm btn-info">
                        Detail
                    </a>
                    `;
                }
            }]
        });
    });
</script>
@endsection
