@extends('layouts.templates')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h1>Data Classifications</h1>
                    <table class="table" id="table-classification">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Core Business Name</th>
                                <th>Classification Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($classifications as $classification)
                                <tr>
                                    <td>{{ $classification->id }}</td>
                                    <td>{{ $classification->coreBusiness->name }}</td>
                                    <td>{{ $classification->name }}</td>
                                    <td>
                                        <button class="btn btn-warning edit-btn" data-bs-toggle="modal" data-bs-target="#editClassificationModal"
                                            data-id="{{ $classification->id }}"
                                            data-name="{{ $classification->name }}"
                                            data-corebusiness-id="{{ $classification->core_business_id }}"
                                            data-corebusiness-name="{{ $classification->coreBusiness->name }}"
                                        >
                                            Edit
                                        </button>
                                        <button class="btn btn-danger delete-btn" data-bs-toggle="modal" data-bs-target="#deleteClassificationModal"
                                        data-id="{{ $classification->id }}"
                                        data-name="{{ $classification->name }}"
                                        data-route="{{ route('classifications.destroy', $classification->id) }}"
                                    >
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
<!-- Create Classification Modal -->
<div class="modal fade" id="classificationModal" tabindex="-1" aria-labelledby="classificationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="createClassificationForm" method="POST" action="{{ route('classifications.store') }}">
                <div class="modal-header">
                    <h5 class="modal-title" id="classificationModalLabel">Add Classification Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @csrf
                    <div class="form-group">
                        <label for="core_business_id">Core Business</label>
                        <select class="form-control" id="core_business_id" name="core_business_id" required>
                            <option value="" selected disabled>-- Select Core Business --</option>
                            @foreach($coreBusinesses as $coreBusiness)
                            <option value="{{ $coreBusiness->id }}">{{ $coreBusiness->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="name">Classification Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Input Classification Name" required>
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
<!-- Edit Classification Modal -->
<div class="modal fade" id="editClassificationModal" tabindex="-1" aria-labelledby="editClassificationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editClassificationModalLabel">Edit Classification Data</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="editClassificationForm" method="POST" action="">
          @csrf
          @method('PUT')
          <div class="modal-body">
            <div class="mb-3">
              <label for="editClassificationCoreBusiness" class="form-label">Core Business</label>
              <select class="form-select" aria-label="Select Core Business" id="editClassificationCoreBusiness" name="core_business_id">
                @foreach($coreBusinesses as $coreBusiness)
                  <option value="{{ $coreBusiness->id }}">{{ $coreBusiness->name }}</option>
                @endforeach
              </select>
            </div>
            <div class="mb-3">
                <label for="editClassificationName" class="form-label">Name</label>
                <input type="text" class="form-control" id="editClassificationName" name="name" required>
              </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-success">Update</button>
          </div>
        </form>
      </div>
    </div>
  </div>
<!-- Modal Delete Classification -->
<div class="modal fade" id="deleteClassificationModal" tabindex="-1" aria-labelledby="deleteClassificationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="" method="POST" id="deleteClassificationForm">
                @csrf
                @method('DELETE')
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteClassificationModalLabel">Delete Classification Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this classification data?</p>
                    <p id="deleteClassificationName"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger" id="confirmDeleteBtn">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>

{!! Toastr::render() !!}
<script>
    $(document).ready(function () {
    $('#table-classification').DataTable();
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

    $('#editClassificationModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var id = button.data('id')
        var name = button.data('name')
        var coreBusinessId = button.data('corebusiness-id')

        var modal = $(this)
        modal.find('.modal-body #editClassificationName').val(name)
        modal.find('.modal-body #editClassificationCoreBusiness').val(coreBusinessId)

        var form = $('#editClassificationForm')
        form.attr('action', route('classifications.update', {classification: id}))
    })
// Event Delegation for Edit and Delete Buttons
$(document).ready(function () {
    $('.delete-btn').click(function () {
        var id = $(this).data('id');
        var name = $(this).data('name');

        $('#deleteClassificationModal #deleteClassificationName').text(name);
        $('#deleteClassificationForm').attr('action', route('classifications.destroy', id));
    });

    $('#confirmDeleteBtn').click(function () {
        $('#deleteClassificationForm').submit();
    });
});


</script>
@endsection
@push('page-action')
<div class="container">
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#classificationModal" data-bs-action="create">
        Add Classification Data
    </button>
</div>
@endpush
