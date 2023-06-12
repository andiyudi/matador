<?php

namespace App\Http\Controllers;

use Dompdf\Dompdf;
use App\Models\Vendor;
use App\Models\Procurement;
use Illuminate\Http\Request;
use App\Models\ProcurementFile;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class ProcurementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $procurements = Procurement::with('vendors')->orderByDesc('id')->get();
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
        $vendors = Vendor::where('is_blacklist', '0')->get();
        return view('procurement.create', compact('vendors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'number' => 'required',
            'estimation_time' => 'required',
            'division' => 'required',
            'person_in_charge' => 'required',
        ]);
        // dd(request()->all());
        // Create a new procurement
        $procurement = new Procurement();
        $procurement->name = $request->input('name');
        $procurement->number = $request->input('number');
        $procurement->estimation_time = $request->input('estimation_time');
        $procurement->division = $request->input('division');
        $procurement->person_in_charge = $request->input('person_in_charge');
        $procurement->save();

        // Save vendor_id in procurement_vendor table
        $vendorIds = $request->input('vendor_id');
        if (!empty($vendorIds)) {
            $procurement->vendors()->attach($vendorIds);
            // Update vendor status and activated_at
            // Vendor::whereIn('id', $vendorIds)->update([
            //     'status' => '1', // Set status to 1 (active)
            //     'activated_at' => today(), // Set activated_at to current timestamp
            //     'expired_at' => (date('Y') . '-12-31'),
            // ]);
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
        $vendors = $procurement->vendors;

        return view('procurement.show', compact('procurement', 'vendors'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $procurement = Procurement::find($id);
        // Mengambil data procurement berdasarkan ID

        $vendors = Vendor::where('is_blacklist', '0')->get();
        // Mengambil semua data vendor untuk dropdown

        $selectedVendors = $procurement->vendors;

        return view('procurement.edit', compact('procurement', 'vendors', 'selectedVendors'));
        // Menampilkan view edit dengan data procurement dan vendors
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'number' => 'required',
            'estimation_time' => 'required',
            'division' => 'required',
            'person_in_charge' => 'required',
        ]);
        // Validasi input yang diperlukan

        $procurement = Procurement::find($id);
        // Mengambil data procurement berdasarkan ID

        $procurement->name = $request->name;
        $procurement->number = $request->number;
        $procurement->estimation_time = $request->estimation_time;
        $procurement->division = $request->division;
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


    public function cancel(Procurement $procurement)
    {
        $procurement->status = '2';
        $procurement->save();

        return redirect()->route('procurement.index');
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
            Vendor::whereIn('id', $vendors->pluck('id')->toArray())->update(['status' => '1']);

            return response()->json(['success' => 'Vendor selection updated successfully!']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function evaluation()
    {
        if (request()->ajax()) {
            $procurements = Procurement::where('status', '1')
                ->whereHas('vendors', function ($query) {
                    $query->where('is_selected', '1');
                })
                ->with(['vendors' => function ($query) {
                    $query->where('is_selected', '1')->select('name');
                }])
                ->orderByDesc('id')
                ->get();

            return DataTables::of($procurements)
                ->addColumn('vendor_selected', function ($procurement) {
                    return implode(", ", $procurement->vendors->pluck('name')->toArray());
                })
                ->make(true);
        }

        return view('procurement.evaluation');
    }
}
