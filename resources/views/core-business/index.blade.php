@extends('layouts.templates')
@php
 $pretitle ='Data';
 $title ='Core Business';
@endphp
@section('content')
<h1>Data Core Business</h1>

        <table id="table-default" class="table table-responsive table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Core Business</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                    <th width="250px">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($core_businesses as $coreBusiness)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ $coreBusiness->name }}</td>
                    <td>{{ $coreBusiness->created_at }}</td>
                    <td>{{ $coreBusiness->updated_at }}</td>
                    <td>
                        <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editCoreBusinessModal" data-corebusiness-id="{{ $coreBusiness->id }}" data-corebusiness-name="{{ $coreBusiness->name }}">
                            Edit
                        </button>
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteCoreBusinessModal" data-corebusiness-id="{{ $coreBusiness->id }}">
                            Hapus
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $core_businesses->links() }}

        <!-- Modal Tambah Core Business -->
        <div class="modal fade" id="createCoreBusinessModal" tabindex="-1" aria-labelledby="createCoreBusinessModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form action="{{ route('core-business.store') }}" method="POST">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="createCoreBusinessModalLabel">Create Core Business Data</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="name">Core Business Name</label>
                                <input type="text" class="form-control" id="name" name="name" required>
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

       <!-- Modal Edit Core Business -->
<div class="modal fade" id="editCoreBusinessModal" tabindex="-1" aria-labelledby="editCoreBusinessModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editCoreBusinessModalLabel">Edit Core Business Data</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="editCoreBusinessForm" method="POST">
          <div class="modal-body">
            @csrf
            @method('PUT')
            <div class="form-group">
              <label for="editCoreBusinessName">Core Business Name</label>
              <input type="text" class="form-control" id="editCoreBusinessName" name="name" required>
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
<!-- Modal Delete Core Business -->
<div class="modal fade" id="deleteCoreBusinessModal" tabindex="-1" aria-labelledby="deleteCoreBusinessModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteCoreBusinessModalLabel">Delete Core Business</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="deleteCoreBusinessForm" method="POST">
                <div class="modal-body">
                    @csrf
                    @method('DELETE')
                    <p>Are you sure you want to delete this Core Business Data?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $('#deleteCoreBusinessModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var id = button.data('corebusiness-id')

        var modal = $(this)

        var form = $('#deleteCoreBusinessForm')
        form.attr('action', '/core-business/' + id)
    })
</script>


<script>
    $('#editCoreBusinessModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var id = button.data('corebusiness-id')
        var name = button.data('corebusiness-name')

        var modal = $(this)
        modal.find('.modal-body #editCoreBusinessName').val(name)

        var form = $('#editCoreBusinessForm')
        form.attr('action', '/core-business/' + id)
    })
</script>



@endsection
@push('page-action')
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createCoreBusinessModal">
    Add Core Business Data
</button>
@endpush
