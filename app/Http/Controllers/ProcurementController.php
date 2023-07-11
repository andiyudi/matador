<?php

namespace App\Http\Controllers;

use Dompdf\Dompdf;
use App\Models\Vendor;
use App\Models\Division;
use App\Models\Procurement;
use Illuminate\Http\Request;
use App\Models\ProcurementFile;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Storage;

class ProcurementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $procurements = Procurement::leftJoin('divisions', 'procurements.division_id', '=', 'divisions.id')
                ->with('vendors')
                ->where('procurements.status', '!=', '1')
                ->orderByDesc('procurements.id')
                ->select('procurements.*', 'divisions.name as division_name')
                ->get();

            return DataTables::of($procurements)
                ->addColumn('vendor_names', function ($procurement) {
                    return $procurement->vendors->pluck('name')->implode(', ');
                })
                ->make(true);
        }
        return view('procurement.index');
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $divisions = Division::where('status', '1')->get();
        $vendors = Vendor::where('status', '!=', '3')->get();
        return view('procurement.create', compact('divisions', 'vendors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'periode' => 'required',
            'name' => 'required',
            'number' => 'required',
            'estimation_time' => 'required',
            'division' => 'required',
            'person_in_charge' => 'required',
        ]);
        // Create a new procurement
        $procurement = new Procurement();
        $procurement->periode = $request->input('periode');
        $procurement->name = $request->input('name');
        $procurement->number = $request->input('number');
        $procurement->estimation_time = $request->input('estimation_time');
        $procurement->division_id = $request->input('division');
        $procurement->person_in_charge = $request->input('person_in_charge');
        $procurement->save();

        // Save vendor_id in procurement_vendor table
        $vendorIds = $request->input('vendor_id');
        if (!empty($vendorIds)) {
            $procurement->vendors()->attach($vendorIds);
        }

        Alert::success('Success', 'Job data has been saved.');
        return redirect()->route('procurement.index');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $procurement = Procurement::findOrFail($id);
        $divisions = Division::all();
        $vendors = $procurement->vendors;
        $source = request('source');
        $procurementFiles = ProcurementFile::where('procurement_id', $id)->get();

        return view('procurement.show', compact('procurement', 'divisions', 'vendors', 'source', 'procurementFiles'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $procurement = Procurement::find($id);
        // Mengambil data procurement berdasarkan ID
        $divisions = Division::where('status', '1')->get();
        $vendors = Vendor::where('status', '!=', '3')->get();
        // Mengambil semua data vendor untuk dropdown

        $selectedVendors = $procurement->vendors;

        return view('procurement.edit', compact('procurement', 'divisions', 'vendors', 'selectedVendors'));
        // Menampilkan view edit dengan data procurement dan vendors
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'periode' => 'required',
            'name' => 'required',
            'number' => 'required',
            'estimation_time' => 'required',
            'division' => 'required',
            'person_in_charge' => 'required',
        ]);
        // Validasi input yang diperlukan

        $procurement = Procurement::find($id);
        // Mengambil data procurement berdasarkan ID

        $procurement->periode = $request->periode;
        $procurement->name = $request->name;
        $procurement->number = $request->number;
        $procurement->estimation_time = $request->estimation_time;
        $procurement->division_id = $request->division;
        $procurement->person_in_charge = $request->person_in_charge;
        $procurement->save();
        // Memperbarui data procurement

        $procurement->vendors()->sync($request->vendor_id);
        // Memperbarui data vendor yang terkait dengan procurement
        Alert::success('Success', 'Job data updated successfully.');
        return redirect()->route('procurement.index');
        // Mengalihkan pengguna ke halaman index procurement dengan pesan sukses
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Procurement $procurement)
    {
        $procurement->delete();
        return redirect()->route('procurement.index');
    }



    public function print($id)
    {
        // Mendapatkan data procurement berdasarkan ID
        $procurement = Procurement::find($id);

        // Mendapatkan data nama pembuat, jabatan pembuat, nama atasan, dan jabatan atasan dari URL
        $creatorName = request()->query('creatorName');
        $creatorPosition = request()->query('creatorPosition');
        $supervisorName = request()->query('supervisorName');
        $supervisorPosition = request()->query('supervisorPosition');

        // Mengambil path file logo
        $logoPath = public_path('assets/logo/cmnplogo.png');

        // Membaca file logo dan mengonversi menjadi base64
        $logoData = file_get_contents($logoPath);
        $logoBase64 = 'data:image/png;base64,' . base64_encode($logoData);

        // Meneruskan data procurement, data tambahan, dan base64 logo ke view print.blade.php
        $html = view('procurement.print', compact('procurement', 'creatorName', 'creatorPosition', 'supervisorName', 'supervisorPosition', 'logoBase64'))->render();

        // Membuat objek Dompdf
        $dompdf = new Dompdf();
        // Menghasilkan file PDF dari tampilan HTML
        $dompdf->loadHtml($html);
        $dompdf->render();

        // Mengirim file PDF sebagai respons ke browser
        return $dompdf->stream('procurement.pdf');
    }


    public function cancel(Request $request, Procurement $procurement)
    {
        $procurement->status = '2';
        $procurement->save();
        // Upload file ke server dengan file_type=1
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('procurement_files', $fileName, 'public');

            // Simpan data file ke database
            $fileData = new ProcurementFile();
            $fileData->procurement_id = $procurement->id;
            $fileData->file_name = $fileName;
            $fileData->file_path = $filePath;
            $fileData->file_type = 1; // Sesuaikan dengan file_type yang diinginkan
            $fileData->save();
        }
        return redirect()->route('procurement.index');
    }

    public function repeat(Request $request, Procurement $procurement)
    {
        $procurement->status = '3';
        $procurement->save();

        // Upload file ke server dengan file_type=2
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('procurement_files', $fileName, 'public');

            // Simpan data file ke database
            $fileData = new ProcurementFile();
            $fileData->procurement_id = $procurement->id;
            $fileData->file_name = $fileName;
            $fileData->file_path = $filePath;
            $fileData->file_type = 2; // Sesuaikan dengan file_type yang diinginkan
            $fileData->save();
        }

        return redirect()->route('procurement.index');
    }

    public function updateVendorStatus(Request $request, Procurement $procurement)
    {
        $vendors = $procurement->vendors;

        foreach ($vendors as $vendor) {
            $vendor->status = '1';
            $vendor->expired_at =  date('Y') . '-12-31';
            $vendor->save();
        }

        return response()->json(['message' => 'Vendor status updated successfully']);
    }

    public function vendors($procurementId)
    {
        $procurement = Procurement::findOrFail($procurementId);
        $vendors = $procurement->vendors()->select('vendors.id', 'vendors.name')->get();

        // Mendapatkan vendor yang dipilih berdasarkan data procurement
        $selectedVendors = $procurement->vendors()->pluck('vendors.id')->toArray();

        return response()->json([
            'vendors' => $vendors,
            'selectedVendors' => $selectedVendors
        ]);
    }

    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:pdf',
            'procurementId' => 'required',
            'fileType' => 'required',
        ]);

        $file = $request->file('file');
        $procurementId = $request->input('procurementId');
        $fileType = $request->input('fileType');

        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('procurement_files', $fileName, 'public');

        $procurementFile = new ProcurementFile();
        $procurementFile->procurement_id = $procurementId;
        $procurementFile->file_name = $fileName;
        $procurementFile->file_path = $filePath;
        $procurementFile->file_type = $fileType;
        $procurementFile->save();

        return response()->json(['file' => $procurementFile]);
    }

    public function updateSelectedVendor(Request $request)
    {
        $vendorId = $request->input('vendorId');
        $procurementId = $request->input('procurementId');

        try {
            $procurement = Procurement::findOrFail($procurementId);

            // Get all the vendors associated with the procurement
            $vendors = $procurement->vendors;

            // Update the is_selected column for the selected vendor
            foreach ($vendors as $vendor) {
                if ($vendor->id == $vendorId) {
                    $vendor->pivot->is_selected = '1';
                } else {
                    $vendor->pivot->is_selected = '0';
                }
                $vendor->pivot->save();
            }

            // Update the status column of the procurement
            $procurement->status = '1';
            $procurement->save();

            // Update the status of all the vendors
            Vendor::whereIn('id', $vendors->pluck('id')->toArray())
                ->update([
                    'status' => '1',
                    'expired_at' => date('Y') . '-12-31'
                ]);

            return response()->json(['success' => 'Vendor selection updated successfully!']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function data()
    {
        if (request()->ajax()) {
            $procurements = Procurement::where('status', '1')
                ->whereHas('vendors', function ($query) {
                    $query->where('is_selected', '1');
                })
                ->with(['vendors' => function ($query) {
                    $query->where('is_selected', '1')->select('name');
                }])
                ->with('division') // Tambahkan eager loading untuk relasi division
                ->orderByDesc('updated_at')
                ->get();

            return DataTables::of($procurements)
                ->addColumn('vendor_selected', function ($procurement) {
                    return implode(", ", $procurement->vendors->pluck('name')->toArray());
                })
                ->addColumn('division_name', function ($procurement) {
                    return $procurement->division->name;
                })
                ->make(true);
        }

        return view('procurement.data');
    }

    public function view($id)
    {
        $procurement = Procurement::findOrFail($id);
        $divisions = Division::all();
        $vendors = $procurement->vendors()->wherePivot('is_selected', '0')->get();
        $vendor = $procurement->vendors()->wherePivot('is_selected', '1')->first();
        $source = request('source');
        $procurementFiles = ProcurementFile::where('procurement_id', $id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('procurement.view', compact('procurement', 'divisions', 'vendors', 'vendor', 'source', 'procurementFiles'));
    }

    public function evaluation($id)
    {
        $procurement = Procurement::findOrFail($id);
        $divisions = Division::all();
        $vendor = $procurement->vendors()->wherePivot('is_selected', '1')->first();
        $source = request('source');
        $procurementFiles = ProcurementFile::where('procurement_id', $id)
            ->orderBy('created_at', 'desc')
            ->get();

        // Menambahkan variabel untuk data procurement_id, vendor_id, dan vendor_name
        $data = [
            'procurement' => $procurement,
            'divisions' => $divisions,
            'vendor' => $vendor,
            'source' => $source,
            'procurementFiles' => $procurementFiles,
            'procurement_id' => $id,
            'vendor_id' => $vendor->id,
            'vendor_name' => $vendor->name,
        ];

        // Mengambil informasi apakah file evaluation company dan file vendor sudah ada
        $fileExistsResponse = $this->getProcurementFile($id);
        $fileCompanyExists = $fileExistsResponse->original['fileCompanyExists'];
        $fileVendorExists = $fileExistsResponse->original['fileVendorExists'];
        $data['fileCompanyExists'] = $fileCompanyExists;
        $data['fileVendorExists'] = $fileVendorExists;

        return view('procurement.evaluation', $data);
    }
    public function getProcurementFile($procurementId)
    {
        $fileCompanyExists = ProcurementFile::where('procurement_id', $procurementId)
            ->where('file_type', 3)
            ->exists();

        $fileVendorExists = ProcurementFile::where('procurement_id', $procurementId)
            ->where('file_type', 4)
            ->exists();


        return response()->json([
            'fileCompanyExists' => $fileCompanyExists,
            'fileVendorExists' => $fileVendorExists,
        ]);
    }

    public function saveEvaluationCompany(Request $request)
    {
        // Validasi input jika diperlukan
        $request->validate([
            'file_evaluation_company' => 'required|file|mimes:pdf|max:2048', // Ubah sesuai kebutuhan
            'evaluation' => 'required|in:0,1', // Ubah sesuai kebutuhan
        ]);

        // Menyimpan file ke direktori penyimpanan (storage/app/public)
        $file = $request->file('file_evaluation_company');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('procurement_files', $fileName, 'public');
        $fileType = $request->input('file_type');


        // Mendapatkan procurement_id, vendor_id, dan vendor_name
        $procurementId = $request->input('procurement_id');
        $vendorId = $request->input('vendor_id');
        $vendorName = $request->input('vendor_name');

        // Simpan data ke tabel procurement_files
        $procurementFile = new ProcurementFile();
        $procurementFile->procurement_id = $procurementId;
        $procurementFile->file_name = $fileName;
        $procurementFile->file_path = $filePath;
        $procurementFile->file_type = $fileType;
        $procurementFile->save();

        // Update kolom evaluation di tabel procurement_vendor
        $procurement = Procurement::findOrFail($procurementId);
        $vendor = $procurement->vendors()->findOrFail($vendorId);
        $vendor->pivot->evaluation = $request->input('evaluation');
        $vendor->pivot->save();

        // Berikan respons berupa data yang berhasil disimpan
        return response()->json([
            'message' => 'File evaluasi vendor berhasil disimpan.',
        ]);
    }

    public function saveEvaluationVendor(Request $request)
    {
        // Validasi input jika diperlukan
        $request->validate([
            'file_evaluation_vendor' => 'required|file|mimes:pdf|max:2048', // Ubah sesuai kebutuhan
            'value_cost' => 'required|in:0,1,2', // Ubah sesuai kebutuhan
            'contract_order' => 'required|in:0,1,2', // Ubah sesuai kebutuhan
            'work_implementation' => 'required|in:0,1,2', // Ubah sesuai kebutuhan
            'pre_handover' => 'required|in:0,1,2,3', // Ubah sesuai kebutuhan
            'final_handover' => 'required|in:0,1,2,3', // Ubah sesuai kebutuhan
            'invoice_payment' => 'required|in:0,1,2', // Ubah sesuai kebutuhan
        ]);

        // Menyimpan file ke direktori penyimpanan (storage/app/public)
        $file = $request->file('file_evaluation_vendor');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('procurement_files', $fileName, 'public');
        $fileType = $request->input('file_type');


        // Mendapatkan procurement_id, vendor_id, dan vendor_name
        $procurementId = $request->input('procurement_id');
        $vendorId = $request->input('vendor_id');
        $vendorName = $request->input('vendor_name');

        // Simpan data ke tabel procurement_files
        $procurementFile = new ProcurementFile();
        $procurementFile->procurement_id = $procurementId;
        $procurementFile->file_name = $fileName;
        $procurementFile->file_path = $filePath;
        $procurementFile->file_type = $fileType;
        $procurementFile->save();

        // Update kolom evaluation di tabel procurement_vendor
        $procurement = Procurement::findOrFail($procurementId);
        $vendor = $procurement->vendors()->findOrFail($vendorId);
        $vendor->pivot->value_cost = $request->input('value_cost');
        $vendor->pivot->contract_order = $request->input('contract_order');
        $vendor->pivot->work_implementation = $request->input('work_implementation');
        $vendor->pivot->pre_handover = $request->input('pre_handover');
        $vendor->pivot->final_handover = $request->input('final_handover');
        $vendor->pivot->invoice_payment = $request->input('invoice_payment');
        $vendor->pivot->save();

        // Berikan respons berupa data yang berhasil disimpan
        return response()->json([
            'message' => 'File evaluasi company berhasil disimpan.',
        ]);
    }
}
