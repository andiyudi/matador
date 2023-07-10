<div class="tab-pane fade" id="evaluationContent" role="tabpanel" aria-labelledby="evaluationTab">
    <div class="row">
        <div class="col-md-6">
            <div class="form-check">
                <input class="form-check-input" type="radio" name="evaluationType" id="evaluationCompanyToVendor" value="companyToVendor">
                <label class="form-check-label" for="evaluationCompanyToVendor">
                    CMNP To Vendor
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="evaluationType" id="evaluationVendorToCompany" value="vendorToCompany">
                <label class="form-check-label" for="evaluationVendorToCompany">
                    Vendor To CMNP
                </label>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="evaluationStartDate">Periode:</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="evaluationStartDate" name="evaluationStartDate" placeholder="Start Year">
                    <span class="input-group-text">to</span>
                    <input type="text" class="form-control" id="evaluationEndDate" name="evaluationEndDate" placeholder="End Year">
                </div>
            </div>
        </div>
    </div>
    <div class="row float-end">
        <div class="col-md-12 mt-3 mb-3">
            <button class="btn btn-secondary" id="btnSearch">Cari</button>
            <button class="btn btn-primary" id="btnPrint" data-toggle="modal" data-target="#modalPrint">Print</button>
        </div>
    </div>
    <iframe id="resultSearch" src="" style="width: 100%; height: 500px; border: none;"></iframe>
</div>

<!-- Modal untuk mengisi data pembuat dan atasan -->
<div class="modal fade" id="modalPrint" tabindex="-1" role="dialog" aria-labelledby="modalPrintLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalPrintLabel">Data Pembuat dan Atasan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formPrint">
                    <div class="form-group">
                        <label for="nameCreator">Nama Pembuat:</label>
                        <input type="text" class="form-control" id="nameCreator" name="nameCreator">
                    </div>
                    <div class="form-group">
                        <label for="positionCreator">Jabatan Pembuat:</label>
                        <input type="text" class="form-control" id="positionCreator" name="positionCreator">
                    </div>
                    <div class="form-group">
                        <label for="nameSupervisor">Nama Atasan:</label>
                        <input type="text" class="form-control" id="nameSupervisor" name="nameSupervisor">
                    </div>
                    <div class="form-group">
                        <label for="positionSupervisor">Jabatan Atasan:</label>
                        <input type="text" class="form-control" id="positionSupervisor" name="positionSupervisor">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="confirmBtnPrint">Cetak</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        var startDateInput = $("#evaluationStartDate");
        var endDateInput = $("#evaluationEndDate");
        var searchResultsIframe = $("#resultSearch");

        startDateInput.datepicker({
            format: "yyyy",
            viewMode: "years",
            minViewMode: "years",
            autoclose: true
        }).on('changeDate', function(selected) {
            var selectedStartDate = new Date(selected.date.valueOf());
            endDateInput.datepicker('setStartDate', selectedStartDate);
            if (endDateInput.val() !== '') {
                var selectedEndDate = new Date(endDateInput.val());
                if (selectedEndDate < selectedStartDate) {
                    endDateInput.val(startDateInput.val());
                }
            }
        });

        endDateInput.datepicker({
            format: "yyyy",
            viewMode: "years",
            minViewMode: "years",
            autoclose: true
        }).on('changeDate', function(selected) {
            var selectedEndDate = new Date(selected.date.valueOf());
            startDateInput.datepicker('setEndDate', selectedEndDate);
            if (startDateInput.val() !== '') {
                var selectedStartDate = new Date(startDateInput.val());
                if (selectedStartDate > selectedEndDate) {
                    startDateInput.val(endDateInput.val());
                }
            }
        });

        var companyToVendorRoute = "{{ route('report.company-to-vendor') }}";
        var vendorToCompanyRoute = "{{ route('report.vendor-to-company') }}";

        $("#btnSearch").click(function() {
            var evaluationType = $("input[name='evaluationType']:checked").val();
            var startDate = startDateInput.val();
            var endDate = endDateInput.val();

            if (evaluationType && startDate && endDate) {
                var url_evaluation;
                if (evaluationType === "companyToVendor") {
                    url_evaluation = companyToVendorRoute;
                } else if (evaluationType === "vendorToCompany") {
                    url_evaluation = vendorToCompanyRoute;
                }

                url_evaluation += "?startDate=" + encodeURIComponent(startDate);
                url_evaluation += "&endDate=" + encodeURIComponent(endDate);

                searchResultsIframe.attr("src", url_evaluation);
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Failed',
                    text: 'Please complete all fields',
                });
            }
        });

        $('#btnPrint').click(function() {
            $('#modalPrint').modal('show');
        });

        $('#confirmBtnPrint').click(function() {
            var nameCreator = $('#nameCreator').val();
            var positionCreator = $('#positionCreator').val();
            var nameSupervisor = $('#nameSupervisor').val();
            var positionSupervisor = $('#positionSupervisor').val();
            var url_evaluation = $('#resultSearch').attr('src');

            // Validasi form
            if (nameCreator === '' || positionCreator === '' || nameSupervisor === '' || positionSupervisor === '') {
                Swal.fire({
                    icon: 'error',
                    title: 'Failed',
                    text: 'Please complete all fields',
                });
                return false;
            }

            if (url_evaluation) {
                url_evaluation += '&nameCreator=' + encodeURIComponent(nameCreator);
                url_evaluation += '&positionCreator=' + encodeURIComponent(positionCreator);
                url_evaluation += '&nameSupervisor=' + encodeURIComponent(nameSupervisor);
                url_evaluation += '&positionSupervisor=' + encodeURIComponent(positionSupervisor);

                Swal.fire({
                    title: 'Print Confirmation',
                    text: 'Are you sure you want to print?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Print',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        var windowPrint = window.open(url_evaluation, '_blank');
                        windowPrint.print();
                        $('#modalPrint').modal('hide');
                        $('#formPrint')[0].reset();
                    }
                });
            }
        });
    });
</script>
