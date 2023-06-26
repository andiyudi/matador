<div class="tab-pane fade" id="evaluationContent" role="tabpanel" aria-labelledby="evaluationTab">
    <div class="row">
        <div class="col-md-6">
            <div class="form-check">
                <input class="form-check-input" type="radio" name="evaluationType" id="evaluationCompanyToVendor" value="companyToVendor">
                <label class="form-check-label" for="evaluationCompanyToVendor">
                    Evaluation Company to Vendor
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="evaluationType" id="evaluationVendorToCompany" value="vendorToCompany">
                <label class="form-check-label" for="evaluationVendorToCompany">
                    Evaluation Vendor to Company
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
            <button class="btn btn-secondary" id="searchBtn">Cari</button>
            <button class="btn btn-primary" id="printBtn" data-toggle="modal" data-target="#printModal">Print</button>
        </div>
    </div>
    <iframe id="searchResults" src="" style="width: 100%; height: 500px; border: none;"></iframe>
</div>
<script>
    $(document).ready(function(){
        var startDateInput = $("#evaluationStartDate");
        var endDateInput = $("#evaluationEndDate");
        var searchResultsIframe = $("#searchResults");

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

        $("#searchBtn").click(function() {
            var evaluationType = $("input[name='evaluationType']:checked").val();
            var startDate = startDateInput.val();
            var endDate = endDateInput.val();

            if (evaluationType && startDate && endDate) {
                var url;
                if (evaluationType === "companyToVendor") {
                    url = "{{ route('report.company-to-vendor') }}";
                } else if (evaluationType === "vendorToCompany") {
                    url = "{{ route('report.vendor-to-company') }}";
                }

                url += "?startDate=" + encodeURIComponent(startDate);
                url += "&endDate=" + encodeURIComponent(endDate);

                searchResultsIframe.attr("src", url);
            } else {
                alert("Harap lengkapi semua field");
            }
        });
    });
</script>
