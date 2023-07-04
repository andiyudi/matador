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
        // Mengambil path file logo
        $logoPath = public_path('assets/logo/cmnplogo.png');
        // Membaca file logo dan mengonversi menjadi base64
        $logoData = file_get_contents($logoPath);
        $logoBase64 = 'data:image/png;base64,' . base64_encode($logoData);
        // Periode awal dan periode akhir dalam bentuk tahun
        $periodeAwal = date('Y', strtotime($startDate));
        $periodeAkhir = date('Y', strtotime($endDate));
        // data pembuat dan atasan
        $namaPembuat = request()->query('nameCreator');
        $jabatanPembuat = request()->query('positionCreator');
        $namaAtasan = request()->query('nameSupervisor');
        $jabatanAtasan = request()->query('positionSupervisor');
        // Mengambil data dari tabel procurement_vendor dengan kondisi is_selected = 1
        $dataVendor = Vendor::whereHas('procurement', function ($query) use ($startDate, $endDate) {
            $query->where('is_selected', '1')
                ->whereBetween('periode', [$startDate, $endDate]);
        })->get();
        $vendorData = $dataVendor->map(function ($vendor) {
            $coreBusiness = $vendor->coreBusinesses->pluck('name')->toArray();
            $jumlahPenilaian = $vendor->procurement()
                ->wherePivot('is_selected', '1')
                ->count();
            // nilai pekerjaan
            $jumlahValueCost0 = $vendor->procurement()
                ->wherePivot('value_cost', '0')
                ->count();
            $jumlahValueCost1 = $vendor->procurement()
                ->wherePivot('value_cost', '1')
                ->count();
            $jumlahValueCost2 = $vendor->procurement()
                ->wherePivot('value_cost', '2')
                ->count();
            // penerbitan kontrak
            $jumlahContractOrder0 = $vendor->procurement()
                ->wherePivot('contract_order', '0')
                ->count();
            $jumlahContractOrder1 = $vendor->procurement()
                ->wherePivot('contract_order', '1')
                ->count();
            $jumlahContractOrder2 = $vendor->procurement()
                ->wherePivot('contract_order', '2')
                ->count();
            // pelaksanaan peekerjaan
            $jumlahWorkImplementation0 = $vendor->procurement()
                ->wherePivot('work_implementation', '0')
                ->count();
            $jumlahWorkImplementation1 = $vendor->procurement()
                ->wherePivot('work_implementation', '1')
                ->count();
            $jumlahWorkImplementation2 = $vendor->procurement()
                ->wherePivot('work_implementation', '2')
                ->count();
            // pengajuan PHO
            $jumlahPreHandover0 = $vendor->procurement()
                ->wherePivot('pre_handover', '0')
                ->count();
            $jumlahPreHandover1 = $vendor->procurement()
                ->wherePivot('pre_handover', '1')
                ->count();
            $jumlahPreHandover2 = $vendor->procurement()
                ->wherePivot('pre_handover', '2')
                ->count();
            // pengajuan FHO
            $jumlahFinalHandover0 = $vendor->procurement()
                ->wherePivot('final_handover', '0')
                ->count();
            $jumlahFinalHandover1 = $vendor->procurement()
                ->wherePivot('final_handover', '1')
                ->count();
            $jumlahFinalHandover2 = $vendor->procurement()
                ->wherePivot('final_handover', '2')
                ->count();
            // pengajuan invoice
            $jumlahInvoicePayment0 = $vendor->procurement()
                ->wherePivot('invoice_payment', '0')
                ->count();
            $jumlahInvoicePayment1 = $vendor->procurement()
                ->wherePivot('invoice_payment', '1')
                ->count();
            $jumlahInvoicePayment2 = $vendor->procurement()
                ->wherePivot('invoice_payment', '2')
                ->count();
            return [
                'nama_perusahaan' => $vendor->name,
                'grade' => ($vendor->grade == '0') ? 'Kecil' : (($vendor->grade == '1') ? 'Menengah' : 'Besar'),
                'core_business' => implode(', ', array_map(function ($index, $business) {
                    return ($index + 1) . '. ' . $business;
                }, array_keys($coreBusiness), $coreBusiness)),
                'jumlah_penilaian' => $jumlahPenilaian,
                'jumlahValueCost0' => $jumlahValueCost0,
                'jumlahValueCost1' => $jumlahValueCost1,
                'jumlahValueCost2' => $jumlahValueCost2,
                'jumlahContractOrder0' => $jumlahContractOrder0,
                'jumlahContractOrder1' => $jumlahContractOrder1,
                'jumlahContractOrder2' => $jumlahContractOrder2,
                'jumlahWorkImplementation0' => $jumlahWorkImplementation0,
                'jumlahWorkImplementation1' => $jumlahWorkImplementation1,
                'jumlahWorkImplementation2' => $jumlahWorkImplementation2,
                'jumlahPreHandover0' => $jumlahPreHandover0,
                'jumlahPreHandover1' => $jumlahPreHandover1,
                'jumlahPreHandover2' => $jumlahPreHandover2,
                'jumlahFinalHandover0' => $jumlahFinalHandover0,
                'jumlahFinalHandover1' => $jumlahFinalHandover1,
                'jumlahFinalHandover2' => $jumlahFinalHandover2,
                'jumlahInvoicePayment0' => $jumlahInvoicePayment0,
                'jumlahInvoicePayment1' => $jumlahInvoicePayment1,
                'jumlahInvoicePayment2' => $jumlahInvoicePayment2,
            ];
        });
        // Menghitung total dari tiap kolom
        $totalPenilaian = $vendorData->sum('jumlah_penilaian');
        $totalValueCost0 = $vendorData->sum('jumlahValueCost0');
        $totalValueCost1 = $vendorData->sum('jumlahValueCost1');
        $totalValueCost2 = $vendorData->sum('jumlahValueCost2');
        $totalContractOrder0 = $vendorData->sum('jumlahContractOrder0');
        $totalContractOrder1 = $vendorData->sum('jumlahContractOrder1');
        $totalContractOrder2 = $vendorData->sum('jumlahContractOrder2');
        $totalWorkImplementation0 = $vendorData->sum('jumlahWorkImplementation0');
        $totalWorkImplementation1 = $vendorData->sum('jumlahWorkImplementation1');
        $totalWorkImplementation2 = $vendorData->sum('jumlahWorkImplementation2');
        $totalPreHandover0 = $vendorData->sum('jumlahPreHandover0');
        $totalPreHandover1 = $vendorData->sum('jumlahPreHandover1');
        $totalPreHandover2 = $vendorData->sum('jumlahPreHandover2');
        $totalFinalHandover0 = $vendorData->sum('jumlahFinalHandover0');
        $totalFinalHandover1 = $vendorData->sum('jumlahFinalHandover1');
        $totalFinalHandover2 = $vendorData->sum('jumlahFinalHandover2');
        $totalInvoicePayment0 = $vendorData->sum('jumlahInvoicePayment0');
        $totalInvoicePayment1 = $vendorData->sum('jumlahInvoicePayment1');
        $totalInvoicePayment2 = $vendorData->sum('jumlahInvoicePayment2');
        // Mengembalikan hasil dalam bentuk view
        return view('report.vendor-company', compact('logoBase64', 'periodeAwal', 'periodeAkhir', 'vendorData', 'namaPembuat', 'jabatanPembuat', 'namaAtasan', 'jabatanAtasan', 'totalPenilaian', 'totalValueCost0', 'totalValueCost1', 'totalValueCost2', 'totalContractOrder0', 'totalContractOrder1', 'totalContractOrder2', 'totalWorkImplementation0', 'totalWorkImplementation1', 'totalWorkImplementation2', 'totalPreHandover0', 'totalPreHandover1', 'totalPreHandover2', 'totalFinalHandover0', 'totalFinalHandover1', 'totalFinalHandover2', 'totalInvoicePayment0', 'totalInvoicePayment1', 'totalInvoicePayment2'));
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
        // Periode awal dan periode akhir dalam bentuk tahun
        $periodeAwal = date('Y', strtotime($startDate));
        $periodeAkhir = date('Y', strtotime($endDate));
        // Mengembalikan hasil dalam bentuk view
        return view('report.company-vendor', compact('logoBase64', 'divisions', 'jumlahPenilaian', 'jumlahPenilaianBaik', 'jumlahPenilaianBuruk', 'nameSupervisor', 'positionSupervisor', 'positionCreator', 'nameCreator', 'periodeAwal', 'periodeAkhir'));
    }
}
