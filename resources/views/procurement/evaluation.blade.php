@extends('layouts.templates')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h1>Evaluation Job Vendor</h1>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Jobs Data</h5>
                                <div class="row mb-3">
                                    <label for="name" class="col-sm-4 col-form-label">Job Name</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="name" name="name" value="{{ $procurement->name }}" readonly>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="number" class="col-sm-4 col-form-label">Procurement Number</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="number" name="number" value="{{ $procurement->number }}" readonly>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="estimation_time" class="col-sm-4 col-form-label">Estimation Time</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="estimation_time" name="estimation_time" value="{{ $procurement->estimation_time }}" readonly>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="division" class="col-sm-4 col-form-label">Division</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="division" name="division" value="{{ $procurement->division->name }}" readonly>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="person_in_charge" class="col-sm-4 col-form-label">Person In Charge</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="person_in_charge" name="person_in_charge" value="{{ $procurement->person_in_charge }}" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Vendor Data</h5>
                                <div class="row mb-3">
                                    <label for="vendor" class="col-sm-4 col-form-label">Vendor Name</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="vendor" name="vendor" value="{{ $vendor->name }}" readonly>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="status" class="col-sm-4 col-form-label">Status</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="status" name="status" value="{{ $vendor->status == '1' ? 'Active' : $vendor->status }}" readonly>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="director" class="col-sm-4 col-form-label">Director</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="director" name="director" value="{{ $vendor->director }}" readonly>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="phone" class="col-sm-4 col-form-label">Phone</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="phone" name="phone" value="{{ $vendor->phone }}" readonly>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="email" class="col-sm-4 col-form-label">Email</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="email" name="email" value="{{ $vendor->email }}" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-md-6">
                            <h5 class="card-title">Procurement Files</h5>
                        </div>
                        <div class="col-md-6 btn-group">
                            <button id="evaluationCompanyButton" class="btn btn-primary mb-3 me-3" data-bs-target="#modalEvaluationCompany" data-bs-toggle="modal" @if($fileCompanyExists) disabled @endif>Give Evaluation To Vendor</button>
                            <button id="evaluationVendorButton" class="btn btn-primary mb-3" data-bs-target="#modalEvaluationVendor" data-bs-toggle="modal" @if($fileVendorExists) disabled @endif>Give Evaluation To CMNP</button>
                        </div>
                    </div>
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
                            @foreach ($procurementFiles as $file)
                            <tr>
                                <td>{{ $file->file_name }}</td>
                                <td>
                                    @if ($file->file_type == 0)
                                    File Selected Vendor
                                    @elseif ($file->file_type == 1)
                                    File Cancelled Procurement
                                    @elseif ($file->file_type == 2)
                                    File Repeat Procurement
                                    @elseif ($file->file_type == 3)
                                    File Evaluation Company
                                    @elseif ($file->file_type == 4)
                                    File Evaluation Vendor
                                    @else
                                    Unknown
                                    @endif
                                </td>
                                <td>{{ $file->updated_at }}</td>
                                <td>
                                    <a href="{{ asset('storage/'.$file->file_path) }}" class="btn btn-sm btn-info" target="_blank">View</a>
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
<div class="modal fade" id="modalEvaluationCompany" aria-hidden="true" aria-labelledby="modalEvaluationCompanyLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modalEvaluationCompanyLabel">Evaluation CMNP To Vendor</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="evaluationCompanyForm" action="{{ route('procurement.evaluation-company') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="vendor_name">Vendor Name</label>
                        <input type="hidden" class="form-control" name="file_type" id="file_type" value="3" readonly>
                        <input type="hidden" class="form-control" name="procurement_id" id="procurement_id" value="{{ $procurement_id }}" readonly>
                        <input type="hidden" class="form-control" name="vendor_id" id="vendor_id" value="{{ $vendor_id }}" readonly>
                        <input type="text" class="form-control" name="vendor_name" id="vendor_name" value="{{ $vendor_name }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="type_file">Evaluation</label>
                        <div class="row">
                            <div class="col">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="evaluation" id="evaluation_0" value="0">
                                    <label class="form-check-label" for="evaluation_0">
                                        <h4>Buruk (Tidak Layak: &le; -60)</h4>
                                    </label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="evaluation" id="evaluation_1" value="1">
                                    <label class="form-check-label" for="evaluation_1">
                                        <h4>Baik (Dipertahankan: 61-100)</h4>
                                    </label>
                                </div>
                            </div>
                        </div>
                        @error('evaluation')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="file_evaluation_company">File Evaluation Company</label>
                        <input type="file" class="form-control" id="file_evaluation_company" name="file_evaluation_company" accept=".pdf">
                        @error('file_evaluation_company')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="evaluationCompanyBtn" name="evaluationCompanyBtn" class="btn btn-success">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="modalEvaluationVendor" aria-hidden="true" aria-labelledby="modalEvaluationVendorLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modalEvaluationVendorLabel">Evaluation Vendor To CMNP</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="evaluationVendorForm" action="{{ route('procurement.evaluation-vendor') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="vendor_name">Vendor Name</label>
                        <input type="hidden" class="form-control" name="file_type" id="file_type" value="4" readonly>
                        <input type="hidden" class="form-control" name="procurement_id" id="procurement_id" value="{{ $procurement_id }}" readonly>
                        <input type="hidden" class="form-control" name="vendor_id" id="vendor_id" value="{{ $vendor_id }}" readonly>
                        <input type="text" class="form-control" name="vendor_name" id="vendor_name" value="{{ $vendor_name }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="value_cost">Nilai Pekerjaan</label>
                        <div class="row">
                            <div class="col md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="value_cost" id="value_cost_0" value="0">
                                    <label class="form-check-label" for="value_cost_0">
                                        <h4>0 s.d &lt; 100Jt</h4>
                                    </label>
                                </div>
                            </div>
                            <div class="col md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="value_cost" id="value_cost_1" value="1">
                                    <label class="form-check-label" for="value_cost_1">
                                        <h4>&ge; 100Jt s.d &lt; 1 Miliar</h4>
                                    </label>
                                </div>
                            </div>
                            <div class="col md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="value_cost" id="value_cost_2" value="2">
                                    <label class="form-check-label" for="value_cost_2">
                                        <h4>&ge; 1 Miliar</h4>
                                    </label>
                                </div>
                            </div>
                        </div>
                        @error('value_cost')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="contract_order">Penerbitan Kontrak &#47; PO</label>
                        <div class="row">
                            <div class="col md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="contract_order" id="contract_order_0" value="0">
                                    <label class="form-check-label" for="contract_order_0">
                                        <h4>Cepat</h4>
                                    </label>
                                </div>
                            </div>
                            <div class="col md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="contract_order" id="contract_order_1" value="1">
                                    <label class="form-check-label" for="contract_order_1">
                                        <h4>Lama</h4>
                                    </label>
                                </div>
                            </div>
                            <div class="col md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="contract_order" id="contract_order_2" value="2">
                                    <label class="form-check-label" for="contract_order_2">
                                        <h4>Sangat Lama</h4>
                                    </label>
                                </div>
                            </div>
                        </div>
                        @error('contract_order')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="work_implementation">Pelaksanaan Pekerjaan &#40; Koordinasi &#41;</label>
                        <div class="row">
                            <div class="col md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="work_implementation" id="work_implementation_0" value="0">
                                    <label class="form-check-label" for="work_implementation_0">
                                        <h4>Mudah</h4>
                                    </label>
                                </div>
                            </div>
                            <div class="col md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="work_implementation" id="work_implementation_1" value="1">
                                    <label class="form-check-label" for="work_implementation_1">
                                        <h4>Sulit</h4>
                                    </label>
                                </div>
                            </div>
                            <div class="col md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="work_implementation" id="work_implementation_2" value="2">
                                    <label class="form-check-label" for="work_implementation_2">
                                        <h4>Sangat Sulit</h4>
                                    </label>
                                </div>
                            </div>
                        </div>
                        @error('work_implementation')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="pre_handover">Pengajuan &#38; Pelaksanaan PHO</label>
                        <div class="row">
                            <div class="col md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="pre_handover" id="pre_handover_0" value="0">
                                    <label class="form-check-label" for="pre_handover_0">
                                        <h4>Cepat</h4>
                                    </label>
                                </div>
                            </div>
                            <div class="col md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="pre_handover" id="pre_handover_1" value="1">
                                    <label class="form-check-label" for="pre_handover_1">
                                        <h4>Lama</h4>
                                    </label>
                                </div>
                            </div>
                            <div class="col md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="pre_handover" id="pre_handover_2" value="2">
                                    <label class="form-check-label" for="pre_handover_2">
                                        <h4>Sangat Lama</h4>
                                    </label>
                                </div>
                            </div>
                        </div>
                        @error('pre_handover')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="final_handover">Pengajuan &#38; Pelaksanaan FHO</label>
                        <div class="row">
                            <div class="col md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="final_handover" id="final_handover_0" value="0">
                                    <label class="form-check-label" for="final_handover_0">
                                        <h4>Cepat</h4>
                                    </label>
                                </div>
                            </div>
                            <div class="col md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="final_handover" id="final_handover_1" value="1">
                                    <label class="form-check-label" for="final_handover_1">
                                        <h4>Lama</h4>
                                    </label>
                                </div>
                            </div>
                            <div class="col md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="final_handover" id="final_handover_2" value="2">
                                    <label class="form-check-label" for="final_handover_2">
                                        <h4>Sangat Lama</h4>
                                    </label>
                                </div>
                            </div>
                        </div>
                        @error('final_handover')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="invoice_payment">Pengajuan Invoice &#38; Real Pembayaran</label>
                        <div class="row">
                            <div class="col md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="invoice_payment" id="invoice_payment_0" value="0">
                                    <label class="form-check-label" for="invoice_payment_0">
                                        <h4>Cepat</h4>
                                    </label>
                                </div>
                            </div>
                            <div class="col md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="invoice_payment" id="invoice_payment_1" value="1">
                                    <label class="form-check-label" for="invoice_payment_1">
                                        <h4>Lama</h4>
                                    </label>
                                </div>
                            </div>
                            <div class="col md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="invoice_payment" id="invoice_payment_2" value="2">
                                    <label class="form-check-label" for="invoice_payment_2">
                                        <h4>Sangat Lama</h4>
                                    </label>
                                </div>
                            </div>
                        </div>
                        @error('invoice_payment')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="file_evaluation_vendor">File Evaluation Vendor</label>
                        <input type="file" class="form-control" id="file_evaluation_vendor" name="file_evaluation_vendor" accept=".pdf">
                        @error('file_evaluation_vendor')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="evaluationVendorBtn" name="evaluationVendorBtn" class="btn btn-success">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        // Memeriksa apakah procurement_id sudah memiliki file_type=3
        var procurementId = "{{ $procurement_id }}";
        checkProcurementFile(procurementId);

        $('#evaluationCompanyForm').on('submit', function(event) {
            event.preventDefault();

            var formData = new FormData($(this)[0]);

            $.ajax({
                url: $(this).attr('action'),
                type: $(this).attr('method'),
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    // Tangani respons berhasil
                    console.log(response);
                    Swal.fire({
                        title: "Success",
                        text: response.message,
                        icon: "success",
                        button: "OK",
                    }).then(function() {
                        // Contoh tindakan lain yang dapat Anda lakukan setelah menyimpan data
                        var fileId = response.fileId;
                        var vendorName = response.vendorName;
                        $('#fileIdInput').val(fileId);
                        $('#vendorNameInput').val(vendorName);
                        // ...

                        // Tutup modal atau lakukan tindakan lain yang sesuai
                        $('#modalEvaluationCompany').modal('hide');
                        // Nonaktifkan tombol "Give Evaluation" setelah evaluasi berhasil diberikan
                        $('#evaluationButton').attr('disabled', true);
                        location.reload();
                    });
                },
                error: function(xhr, status, error) {
                    // Tangani respons error
                    console.log(xhr.responseText);
                    swal("Error", "Terjadi kesalahan: " + xhr.responseText, "error");
                }
            });
        });

        // Fungsi untuk memeriksa apakah procurement_id sudah memiliki file_type=3
        function checkProcurementFile(procurementId) {
            $.ajax({
                url: "{{ route('procurement.get-file', ':procurementId') }}".replace(':procurementId', procurementId),
                type: 'GET',
                success: function(response) {
                    if (response.fileExists) {
                        // Nonaktifkan tombol "Give Evaluation" jika procurement_id sudah memiliki file_type=3
                        $('#evaluationButton').attr('disabled', true);
                    }
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                    swal("Error", "Terjadi kesalahan: " + xhr.responseText, "error");
                }
            });
        }
    });
</script>
<script>
    $(document).ready(function() {
        // Memeriksa apakah procurement_id sudah memiliki file_type=3
        var procurementId = "{{ $procurement_id }}";
        checkProcurementFile(procurementId);

        $('#evaluationVendorForm').on('submit', function(event) {
            event.preventDefault();

            var formData = new FormData($(this)[0]);

            $.ajax({
                url: $(this).attr('action'),
                type: $(this).attr('method'),
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    // Tangani respons berhasil
                    console.log(response);
                    Swal.fire({
                        title: "Success",
                        text: response.message,
                        icon: "success",
                        button: "OK",
                    }).then(function() {
                        // Contoh tindakan lain yang dapat Anda lakukan setelah menyimpan data
                        var fileId = response.fileId;
                        var vendorName = response.vendorName;
                        $('#fileIdInput').val(fileId);
                        $('#vendorNameInput').val(vendorName);
                        // ...

                        // Tutup modal atau lakukan tindakan lain yang sesuai
                        $('#modalEvaluationVendors').modal('hide');
                        // Nonaktifkan tombol "Give Evaluation" setelah evaluasi berhasil diberikan
                        $('#evaluationButton').attr('disabled', true);
                        location.reload();
                    });
                },
                error: function(xhr, status, error) {
                    // Tangani respons error
                    console.log(xhr.responseText);
                    swal("Error", "Terjadi kesalahan: " + xhr.responseText, "error");
                }
            });
        });

        // Fungsi untuk memeriksa apakah procurement_id sudah memiliki file_type=3
        function checkProcurementFile(procurementId) {
            $.ajax({
                url: "{{ route('procurement.get-file', ':procurementId') }}".replace(':procurementId', procurementId),
                type: 'GET',
                success: function(response) {
                    if (response.fileExists) {
                        // Nonaktifkan tombol "Give Evaluation" jika procurement_id sudah memiliki file_type=3
                        $('#evaluationButton').attr('disabled', true);
                    }
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                    swal("Error", "Terjadi kesalahan: " + xhr.responseText, "error");
                }
            });
        }
    });
</script>
@endsection
@push('page-action')
<div class="container">
    @if ($source === 'index')
        <a href="{{ route('procurement.index') }}" class="btn btn-primary">Back</a>
    @elseif ($source === 'data')
        <a href="{{ route('procurement.data') }}" class="btn btn-primary">Back</a>
    @else
        <!-- Default fallback action -->
        <a href="{{ route('procurement.index') }}" class="btn btn-primary">Back</a>
    @endif
</div>
@endpush
