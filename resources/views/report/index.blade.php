@extends('layouts.templates')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h1>ISO Report</h1>
                    <ul class="nav nav-tabs nav-justified" id="reportTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="vendorTab" data-bs-toggle="tab" data-bs-target="#vendorContent" type="button" role="tab" aria-controls="vendorContent" aria-selected="true">Rekap Vendor</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="evaluationTab" data-bs-toggle="tab" data-bs-target="#evaluationContent" type="button" role="tab" aria-controls="evaluationContent" aria-selected="false">Rekap Penilaian</button>
                        </li>
                    </ul>
                    <div class="tab-content mt-3" id="reportTabsContent">
                        @include('report.vendor')
                        @include('report.evaluation')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
