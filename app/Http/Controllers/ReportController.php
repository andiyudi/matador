<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Vendor;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        return view('report.index');
    }

    public function vendor(Request $request)
    {
        $status = $request->input('statusVendor');
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');

        $startDate = Carbon::createFromFormat('m-Y', $startDate)->startOfMonth();
        $endDate = Carbon::createFromFormat('m-Y', $endDate)->endOfMonth();

        $vendors = Vendor::with(['coreBusinesses:name', 'classifications:name'])
            ->where('status', $status)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get();
        $vendors->transform(function ($vendor) {
            $vendor->core_businesses = $vendor->coreBusinesses->pluck('name')->map(function ($name, $index) {
                return ($index + 1) . '. ' . $name;
            })->implode(', ');

            $vendor->classifications = $vendor->classifications->pluck('name')->map(function ($name, $index) {
                return ($index + 1) . '. ' . $name;
            })->implode(', ');

            return $vendor;
        });

        // Mengambil path file logo
        $logoPath = public_path('assets/logo/cmnplogo.png');

        // Membaca file logo dan mengonversi menjadi base64
        $logoData = file_get_contents($logoPath);
        $logoBase64 = 'data:image/png;base64,' . base64_encode($logoData);
        // data pembuat dan atasan
        $creatorName = request()->query('creatorName');
        $creatorPosition = request()->query('creatorPosition');
        $supervisorName = request()->query('supervisorName');
        $supervisorPosition = request()->query('supervisorPosition');

        // Mapping nilai status
        $statusMapping = [
            0 => 'Baru',
            1 => 'Aktif',
            2 => 'Tidak Aktif',
            3 => 'Blacklist',
        ];
        // Mendapatkan nilai status yang lebih deskriptif
        $status = $statusMapping[$status];

        // Format bulan dan tahun untuk startDate dan endDate
        $formattedStartDate = Carbon::parse($startDate)->format('F Y');
        $formattedEndDate = Carbon::parse($endDate)->format('F Y');

        return view('report.vendor-result', compact('vendors', 'logoBase64', 'creatorName', 'creatorPosition', 'supervisorName', 'supervisorPosition', 'status', 'formattedStartDate', 'formattedEndDate'));
    }

    public function vendorToCompanyReport(Request $request)
    {
        // Ambil data dari request
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');

        // Proses logika atau pengambilan data yang diperlukan
        // ...

        // Mengembalikan hasil dalam bentuk view
        return view('report.vendor-company', [
            'startDate' => $startDate,
            'endDate' => $endDate,
            // data lain yang diperlukan untuk tampilan
        ]);
    }

    public function companyToVendorReport(Request $request)
    {
        // Ambil data dari request
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');

        // Proses logika atau pengambilan data yang diperlukan
        // ...

        // Mengembalikan hasil dalam bentuk view
        return view('report.company-vendor', [
            'startDate' => $startDate,
            'endDate' => $endDate,
            // data lain yang diperlukan untuk tampilan
        ]);
    }
}
