@extends('layouts.templates')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                <h1>Edit Vendor Data</h1>
                <form action="{{ route('vendors.update', $vendor->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ $vendor->name }}">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="core_business_id" class="form-label">Core Business</label>
                            <select class="form-select basic-multiple @error('core_business_id') is-invalid @enderror" name="core_business_id[]" id="core_business" multiple>
                                <option value="" disabled>Pilih Jenis Bisnis</option>
                                @foreach($core_businesses as $core_business)
                                    <option value="{{ $core_business->id }}">{{ $core_business->name }}</option>
                                @endforeach
                            </select>
                            @error('core_business_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col mb-3">
                            <label for="classification_id" class="form-label">Classification</label>
                            <select class="form-select basic-multiple @error('classification_id') is-invalid @enderror" name="classification_id[]" id="classification" multiple>
                                <option value="" disabled>Pilih Klasifikasi</option>
                                @foreach($classifications as $classification)
                                    <option value="{{ $classification->id }}" {{ in_array($classification->id, $selectedClassifications) ? 'selected' : '' }}>
                                        {{ $classification->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('classification_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="address" class="form-label">Address</label>
                            <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" rows="4">{{ $vendor->address }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col mb-3">
                            <label for="domicility" class="form-label">Residence Address</label>
                            <textarea class="form-control @error('domicility') is-invalid @enderror" id="domicility" name="domicility" rows="4">{{ $vendor->domicility }}</textarea>
                            @error('domicility')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="area" class="form-label">Area</label>
                            <input type="text" class="form-control @error('area') is-invalid @enderror" id="area" name="area" value="{{ $vendor->area }}">
                            @error('area')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col mb-3">
                            <label for="director" class="form-label">Director</label>
                            <input type="text" class="form-control @error('director') is-invalid @enderror" id="director" name="director" value="{{ $vendor->director }}">
                            @error('director')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="phone" class="form-label">Telephone</label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ $vendor->phone }}">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ $vendor->email }}">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="join_date" class="form-label">Join Date</label>
                            <input type="date" class="form-control @error('join_date') is-invalid @enderror" id="join_date" name="join_date" value="{{ $vendor->join_date }}">
                            @error('join_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col mb-3">
                            <label for="reference" class="form-label">Reference</label>
                            <input type="reference" class="form-control @error('reference') is-invalid @enderror" id="reference" name="reference" value="{{ $vendor->reference }}">
                            @error('reference')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="capital" class="form-label">Capital</label>
                            <input type="text" class="form-control @error('capital') is-invalid @enderror" id="capital" name="capital" value="{{ $vendor->capital }}">
                            @error('capital')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col mb-3">
                            <label for="grade" class="form-label">Grade</label>
                            <div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input @error('grade') is-invalid @enderror" type="radio" name="grade" id="grade_kecil" value="0" {{ $vendor->grade == 0 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="grade_kecil">Kecil</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input @error('grade') is-invalid @enderror" type="radio" name="grade" id="grade_menengah" value="1" {{ $vendor->grade == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="grade_menengah">Menengah</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input @error('grade') is-invalid @enderror" type="radio" name="grade" id="grade_besar" value="2" {{ $vendor->grade == 2 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="grade_besar">Besar</label>
                                </div>
                            </div>
                            @error('grade')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success">Update</button>
                    @include('sweetalert::alert')
                </form>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                <h3>Existing Files:</h3>
                <button type="button" class="btn btn-primary mb-3 float-end" data-bs-toggle="modal" data-bs-target="#uploadVendorFiles">
                    Upload File
                </button>
                @if($vendor_files && $vendor_files->count() > 0)
                    <table class="table table-responsive table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>File Type</th>
                                <th>Updated At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($vendor_files as $file)
                                <tr>
                                    <td>{{ $file->file_name }}</td>
                                    <td>
                                        @if ($file->file_type == 0)
                                            Compro
                                        @elseif ($file->file_type == 1)
                                            Legalitas
                                        @elseif ($file->file_type == 2)
                                            Hasil Survey
                                        @elseif ($file->file_type == 3)
                                            File Blacklist
                                        @else
                                            Unknown
                                        @endif
                                    </td>
                                    <td>{{ $file->updated_at }}</td>
                                    <td>
                                        <a href="{{ asset('storage/'.$file->file_path) }}" class="btn btn-sm btn-info" target="_blank">View</a>
                                        <a href="#" class="btn btn-sm btn-warning" onclick="event.preventDefault(); openEditModal('{{ $file->id }}');">Edit</a>
                                        <a href="#" class="btn btn-sm btn-danger" onclick="event.preventDefault(); confirmDelete({{ $file->id }});">Delete</a>
                                        <form id="delete-form-{{ $file->id }}" action="{{ route('vendors.file-delete', $file->id) }}" method="POST" style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                <p>No files found.</p>
                @endif
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="uploadVendorFiles" aria-labelledby="uploadVendorFilesLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form method="POST" action="{{ route('vendors.upload') }}" id="uploadForm" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="uploadVendorFilesLabel">Upload Vendor Files</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="form-group">
                        <label for="existing_vendors">Vendor Name</label>
                        <div class="col">
                            <input type="hidden" class="form-control" id="id_vendor" name="id_vendor" value="{{ $vendor->id }}" readonly>
                            <input type="text" class="form-control" id="name_vendor" name="name_vendor" value="{{ $vendor->name }}" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="type_file">File Type</label>
                        <div class="row">
                            <div class="col">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="type_file" id="type_file_0" value="0">
                                    <label class="form-check-label" for="type_file_0">
                                        Compro
                                    </label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="type_file" id="type_file_1" value="1">
                                    <label class="form-check-label" for="type_file_1">
                                        Legalitas
                                    </label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="type_file" id="type_file_2" value="2">
                                    <label class="form-check-label" for="type_file_2">
                                        Hasil Survey
                                    </label>
                                </div>
                            </div>
                        </div>
                        @error('type_file')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="vendor_file">Vendor File</label>
                        <input type="file" class="form-control" id="vendor_file" name="vendor_file" accept=".xlsx,.xls,.pdf,.doc,.docx,.jpg,.jpeg,.png">
                        @error('vendor_file')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" id="uploadButton" class="btn btn-success">Upload</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="editVendorFileModal" aria-labelledby="editVendorFileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editVendorFileModalLabel">Edit Vendor File</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="edit-form" action="" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="vendor_name">Vendor Name</label>
                        <input type="hidden" class="form-control" id="id" name="id" value="" readonly>
                        <input type="hidden" class="form-control" id="vendor_id" name="vendor_id" value="" readonly>
                        <input type="text" class="form-control" id="vendor_name" name="vendor_name" value="" readonly>
                    </div>
                    <div class="form-group">
                        <label for="file_type">File Type</label>
                        <div class="row">
                            <div class="col">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="file_type" id="file_type_0" value="0">
                                    <label class="form-check-label" for="file_type_0">Compro</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="file_type" id="file_type_1" value="1">
                                    <label class="form-check-label" for="file_type_1">Legalitas</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="file_type" id="file_type_2" value="2">
                                    <label class="form-check-label" for="file_type_2">Hasil Survey</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="edit_vendor_file">Upload File</label>
                        <input type="file" class="form-control" id="edit_vendor_file" name="edit_vendor_file" accept=".xlsx,.xls,.pdf,.doc,.docx,.jpg,.jpeg,.png">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-success" onclick="editFile()">Update</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).on('click', '#uploadButton', function(e) {
        e.preventDefault();

        var vendorId = $('#id_vendor').val();
        var fileType = $('input[name="type_file"]:checked').val();
        var file = $('#vendor_file').prop('files')[0];

        // Buat objek FormData untuk mengirim file dan data lainnya ke server
        var formData = new FormData();
        formData.append('id_vendor', vendorId);
        formData.append('type_file', fileType);
        formData.append('vendor_file', file);
        formData.append('_token', "{{ csrf_token() }}");

        // Kirim data ke server menggunakan AJAX
        $.ajax({
            url: route('vendors.upload'),
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                // Tampilkan SweetAlert sukses
                Swal.fire({
                    icon: 'success',
                    title: 'Upload Success',
                    text: 'File berhasil diupload'
                }).then(function() {
                    // Reload halaman
                    location.reload();
                });
            },
            error: function(xhr, status, error) {
                // Tampilkan SweetAlert error
                Swal.fire({
                    icon: 'error',
                    title: 'Upload Failed',
                    text: 'Gagal mengunggah file'
                }).then(function() {
                    // Reload halaman
                    location.reload();
                });
            }
        });
    });
</script>
<script>
    async function fetchData(fileId) {
        let response = await fetch("{{ route('vendors.file-fetch', '') }}/" + fileId);
        let data = await response.json();

        if (data.success) {
            var file = data.file;
            // Populate the form fields with file data
            document.getElementById("id").value = file.id;
            document.getElementById("vendor_id").value = file.vendor.id;
            document.getElementById("vendor_name").value = file.vendor.name;
            document.getElementById("file_type_" + file.file_type).checked = true;
        } else {
            // Show error message using Sweet Alert
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: data.message,
            });
        }
    }

    function openEditModal(fileId) {
        var editModal = document.getElementById("editVendorFileModal");
        $(editModal).modal("show");
        fetchData(fileId);
    }

    function editFile() {

        var fileId = document.getElementById("id").value;
        var form = document.getElementById("edit-form");
        var formData = new FormData(form);
        form.action = "{{ route('vendors.file-update', '') }}/" + fileId;
        formData.append('_method', 'PUT');
        formData.append('_token', "{{ csrf_token() }}");

        fetch(form.action, {
                method: 'POST',
                body: formData
            })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: data.message,
                }).then(() => {
                    location.reload();
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: data.message,
                });
            }
        });
    }
</script>
<script>
    $(document).ready(function () {
        $('.basic-multiple').select2({
            theme: "bootstrap-5",
            selectionCssClass: "select2--small",
            dropdownCssClass: "select2--small",
        });

        // Set selected core businesses
        var selectedCoreBusiness = {!! json_encode($selectedCoreBusinesses) !!};
        $('#core_business').val(selectedCoreBusiness).trigger('change');

        $('#core_business').change(function () {
            var core_business_ids = $(this).val();
            if (core_business_ids) {
                $.ajax({
                    url: route('classifications.getByCoreBusiness'),
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        core_business_ids: core_business_ids
                    },
                    success: function (data) {
                        $('#classification').empty();
                        $('#classification').append('<option value="" disabled>Pilih Klasifikasi</option>');
                        $.each(data, function (key, value) {
                            $('#classification').append('<option value="' + key + '">' + value + '</option>');
                        });

                        // Set selected classifications
                        var selectedClassifications = {!! json_encode($selectedClassifications) !!};
                        $('#classification').val(selectedClassifications).trigger('change');
                    }
                });
            } else {
                $('#classification').empty();
                $('#classification').append('<option value="" disabled>Pilih Klasifikasi</option>');
            }
        });
    });
</script>
<script>
    function confirmDelete(fileId) {
        Swal.fire({
            title: 'Are you sure?',
            text: 'You will not be able to recover this file!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                deleteFile(fileId);
            }
        });
    }

    function deleteFile(fileId) {
        fetch("{{ route('vendors.file-delete', '') }}/" + fileId, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}",
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire('Deleted!', data.success, 'success').then(() => {
                    // Refresh the page or update the file list
                    location.reload();
                });
            } else if (data.error) {
                Swal.fire('Error', data.error, 'error');
            } else {
                throw new Error('An error occurred while deleting the file.');
            }
        })
        .catch(error => {
            Swal.fire('Error', error.message, 'error');
        });
    }
</script>
@endsection
@push('page-action')
<div class="container">
    <a href="{{ route('vendors.index') }}" class="btn btn-primary">Back</a>
</div>
@endpush
