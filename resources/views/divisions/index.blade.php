@extends('layouts.templates')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h1>Data Division</h1>
                    <table id="table-divisions" class="table table-responsive table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Division Name</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($divisions as $index => $division)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $division->name }}</td>
                                <td>
                                    @if ($division->status == '1')
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-danger">InActive</span>
                                    @endif
                                </td>
                                <td>
                                    <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editDivisionModal" data-division-id="{{ $division->id }}" data-division-name="{{ $division->name }}" data-division-status="{{ $division->status }}">
                                        Edit
                                    </button>
                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteDivisionModal" data-division-id="{{ $division->id }}">
                                        Delete
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal Tambah Division -->
<div class="modal fade" id="createDivisionModal" tabindex="-1" aria-labelledby="createDivisionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('divisions.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="createDivisionModalLabel">Create Division Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label for="name">Division Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Input Division Name" required>
                    </div>
                    <div class="form-group mb-3">
                        <div class="form-label">Status</div>
                        <label class="form-check form-switch">
                            <input class="form-check-input" name="status" id="status" type="checkbox" value="1" checked>
                            <span class="form-check-label">Active</span>
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Division -->
<div class="modal fade" id="editDivisionModal" tabindex="-1" aria-labelledby="editDivisionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editDivisionModalLabel">Edit Division Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editDivisionForm" method="POST">
                <div class="modal-body">
                    @csrf
                    @method('PUT')
                    <div class="form-group mb-3">
                        <label for="editDivisionName">Division Name</label>
                        <input type="text" class="form-control" id="editDivisionName" name="name" required>
                    </div>
                    <div class="form-group mb-3">
                        <div class="form-label">Status</div>
                        <label class="form-check form-switch">
                            <input class="form-check-input" name="status" id="editStatus" type="checkbox">
                            <span class="form-check-label">Active</span>
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Modal Delete Division -->
<div class="modal fade" id="deleteDivisionModal" tabindex="-1" aria-labelledby="deleteDivisionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteDivisionModalLabel">Delete Division</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="deleteDivisionForm" method="POST">
                <div class="modal-body">
                    @csrf
                    @method('DELETE')
                    <p>Are you sure you want to delete this Division Data?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>
{!! Toastr::render() !!}
<script>
   $(document).ready(function () {
        $('#table-divisions').DataTable({
            lengthMenu: [5, 10, 25, 50] // Pilihan jumlah data per halaman
        });
    });
</script>
<script>
    @if (session('success'))
        toastr.success('{{ session('success') }}', 'Success');
    @endif

    @if (session('error'))
        toastr.error('{{ session('error') }}', 'Error');
    @endif
 </script>
<script>
    $('#deleteDivisionModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var id = button.data('division-id')

        var modal = $(this)

        var form = $('#deleteDivisionForm')
        form.attr('action', route('divisions.destroy', {division: id}))
    })
</script>
<script>
    $('#editDivisionModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var id = button.data('division-id');
        var name = button.data('division-name');
        var status = button.data('division-status');

        var modal = $(this);
        modal.find('.modal-body #editDivisionName').val(name);

        var form = $('#editDivisionForm');
        form.attr('action', route('divisions.update', { division: id })); // Perbaikan pada parameter division

        // Perbaikan pada pengecekan status dan set nilai toggle
        if (status == '1') {
            modal.find('.modal-body #editStatus').prop('checked', true);
        } else {
            modal.find('.modal-body #editStatus').prop('checked', false);
        }
    });
</script>

@endsection
@push('page-action')
<div class="container">
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createDivisionModal">
        Add Division Data
    </button>
</div>
@endpush
