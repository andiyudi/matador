<div class="tab-pane fade show active" id="vendorContent" role="tabpanel" aria-labelledby="vendorTab">
    <!-- Konten untuk Rekap Vendor -->
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="vendorStatus">Status Vendor:</label>
                <select class="form-select" id="vendorStatus">
                    <option disabled selected>Pilih Status Vendor</option>
                    <option value="0">Register</option>
                    <option value="1">Active</option>
                    <option value="2">Inactive</option>
                    <option value="3">Blacklist</option>
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="period">Periode:</label>
                <div class="input-group input-daterange">
                    <input type="text" class="form-control">
                    <span class="input-group-text">to</span>
                    <input type="text" class="form-control">
                </div>
            </div>
        </div>
    </div>
    <div class="row float-end">
        <div class="col-md-12 mt-3 mb-3">
            <button class="btn btn-secondary" id="searchBtn">Cari</button>
            <button class="btn btn-primary" id="printBtn">Print</button>
        </div>
    </div>
    <iframe id="searchResults" src="" style="width: 100%; height: 500px; border: none;"></iframe>
</div>
<script>
    $(document).ready(function(){
        $('.input-daterange input').each(function() {
            var startDateInput = $(this).closest('.input-daterange').find('input:first');
            var endDateInput = $(this);

            startDateInput.datepicker({
                format: 'mm-yyyy',
                startView: 'months',
                minViewMode: 'months'
            });

            endDateInput.datepicker({
                format: 'mm-yyyy',
                startView: 'months',
                minViewMode: 'months',
                startDate: startDateInput.val()
            }).on('show', function() {
                $(this).datepicker('setStartDate', startDateInput.val());
            });
        });
        $('#searchBtn').click(function() {
            var status = $('#vendorStatus').val();
            var fromDate = $('.input-daterange input:eq(0)').val();
            var toDate = $('.input-daterange input:eq(1)').val();
            var url = "your_search_url_here?status=" + status + "&fromDate=" + fromDate + "&toDate=" + toDate;
            $('#searchResults').attr('src', url);
        });
        $('#printBtn').click(function() {
            var url = $('#searchResults').attr('src');
            if (url) {
                var printWindow = window.open(url, '_blank');
                printWindow.print();
            }
        });
    });
</script>
