@extends('layouts.templates')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h1>Data Core Business</h1>
                    <table id="table-core-business" class="table table-responsive table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Core Business Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($core_businesses as $index => $coreBusiness)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $coreBusiness->name }}</td>
                                <td>
                                    <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editCoreBusinessModal" data-corebusiness-id="{{ $coreBusiness->id }}" data-corebusiness-name="{{ $coreBusiness->name }}">
                                        Edit
                                    </button>
                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteCoreBusinessModal" data-corebusiness-id="{{ $coreBusiness->id }}">
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
                                <input type="text" class="form-control" id="name" name="name" placeholder="Input Core Business Name" required>
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
{!! Toastr::render() !!}
<script>
   $(document).ready(function () {
        $('#table-core-business').DataTable({
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
    $('#deleteCoreBusinessModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var id = button.data('corebusiness-id')

        var modal = $(this)

        var form = $('#deleteCoreBusinessForm')
        form.attr('action', route('core-business.destroy', {core_business: id}))
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
        form.attr('action', route('core-business.update', {core_business: id}))
    })
</script>



@endsection
@push('page-action')
<div class="container">
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createCoreBusinessModal">
        Add Core Business Data
    </button>
</div>
@endpush
