<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Vendor;
use App\Models\Division;
use App\Models\Procurement;
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
        // Mengambil path file logo
        $logoPath = public_path('assets/logo/cmnplogo.png');
        // Membaca file logo dan mengonversi menjadi base64
        $logoData = file_get_contents($logoPath);
        $logoBase64 = 'data:image/png;base64,' . base64_encode($logoData);
        // Mengambil data divisi dari table divisions
        $divisions = Division::all();
        // Inisialisasi array untuk menyimpan data jumlah form penilaian
        $jumlahPenilaian = [];
        $jumlahPenilaianBaik = [];
        $jumlahPenilaianBuruk = [];
        // Menghitung jumlah form penilaian yang diserahkan untuk setiap divisi berdasarkan periode
        foreach ($divisions as $division) {
            $jumlah = Procurement::where('division_id', $division->id)
                ->whereHas('vendors', function ($query) use ($startDate, $endDate) {
                    $query->whereNotNull('evaluation')
                        ->whereBetween('periode', [$startDate, $endDate]);
                })
                ->count();
            $jumlahBaik = Procurement::where('division_id', $division->id)
                ->whereHas('vendors', function ($query) use ($startDate, $endDate) {
                    $query->where('evaluation', '1')
                        ->whereBetween('periode', [$startDate, $endDate]);
                })
                ->count();
            $jumlahBuruk = Procurement::where('division_id', $division->id)
                ->whereHas('vendors', function ($query) use ($startDate, $endDate) {
                    $query->where('evaluation', '0')
                        ->whereBetween('periode', [$startDate, $endDate]);
                })
                ->count();
            $jumlahPenilaian[$division->id] = $jumlah;
            $jumlahPenilaianBaik[$division->id] = $jumlahBaik;
            $jumlahPenilaianBuruk[$division->id] = $jumlahBuruk;
        }
        // data pembuat dan atasan
        $nameCreator = request()->query('nameCreator');
        $positionCreator = request()->query('positionCreator');
        $nameSupervisor = request()->query('nameSupervisor');
        $positionSupervisor = request()->query('positionSupervisor');
        // Mengembalikan hasil dalam bentuk view
        return view('report.company-vendor', compact('logoBase64', 'divisions', 'jumlahPenilaian', 'jumlahPenilaianBaik', 'jumlahPenilaianBuruk', 'nameSupervisor', 'positionSupervisor', 'positionCreator', 'nameCreator'));
    }
}
