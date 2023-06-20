<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CoreBusiness;
use App\Models\Classification;
use App\Models\Vendor;
use App\Models\VendorFile;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Yajra\DataTables\Facades\DataTables;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Storage;

class VendorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $vendors = Vendor::where('status', '!=', '3')
                ->with('coreBusinesses:name', 'classifications:name')
                ->get();
            return DataTables::of($vendors)->make(true);
        }

        $vendors = Vendor::where('status', '!=', '3')->get();

        return view('vendors.index', compact('vendors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $core_businesses = CoreBusiness::all();
        $classifications = Classification::all();

        return view('vendors.create')
            ->with('core_businesses', $core_businesses)
            ->with('classifications', $classifications);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validasi input
        $validatedData = $request->validate([
            'name' => 'required',
            'address' => 'required',
            'domicility' => 'required',
            'area' => 'required',
            'director' => 'required',
            'phone' => 'required',
            'email' => 'required|email|unique:vendors',
            'capital' => 'required',
            'grade' => 'required',
            'join_date' => 'required',
            'reference' => 'required',
            'core_business_id' => 'required|array',
            'classification_id' => 'required|array'
        ]);

        // simpan data vendor
        $vendor = new Vendor;
        $vendor->name = $request->name;
        $vendor->address = $request->address;
        $vendor->domicility = $request->domicility;
        $vendor->area = $request->area;
        $vendor->director = $request->director;
        $vendor->phone = $request->phone;
        $vendor->email = $request->email;
        $vendor->capital = $request->capital;
        $vendor->grade = $request->grade;
        $vendor->join_date = $request->join_date;
        $vendor->reference = $request->reference;
        $vendor->save();

        // hubungkan vendor dengan core business yang dipilih
        $vendor->coreBusinesses()->attach($request->core_business_id);

        // hubungkan vendor dengan classification yang dipilih
        $vendor->classifications()->attach($request->classification_id);

        Alert::success('Success', 'Vendor data successfully stored');

        // return redirect()->route('vendors.index');
        // Alihkan ke halaman edit dengan ID vendor yang baru saja dibuat
        return redirect()->route('vendors.edit', $vendor->id);
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $core_businesses = CoreBusiness::all();
        $classifications = Classification::all();
        $source = request('source');
        // Mengambil data vendor yang akan diedit
        $vendor = Vendor::findOrFail($id);

        // Mengambil klasifikasi yang dipilih untuk vendor
        $selectedCoreBusinesses = $vendor->coreBusinesses->pluck('id')->toArray();
        $selectedClassifications = $vendor->classifications->pluck('id')->toArray();

        $vendor_files = $vendor->vendorFiles;

        // Mengirimkan $selectedClassifications ke view
        return view('vendors.show', compact('vendor', 'core_businesses', 'classifications', 'selectedCoreBusinesses', 'selectedClassifications', 'vendor_files', 'source'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $core_businesses = CoreBusiness::all();
        $classifications = Classification::all();
        // Mengambil data vendor yang akan diedit
        $vendor = Vendor::findOrFail($id);

        // Mengambil klasifikasi yang dipilih untuk vendor
        $selectedCoreBusinesses = $vendor->coreBusinesses->pluck('id')->toArray();
        $selectedClassifications = $vendor->classifications->pluck('id')->toArray();

        $vendor_files = $vendor->vendorFiles;

        // Mengirimkan $selectedClassifications ke view
        return view('vendors.edit', compact('vendor', 'core_businesses', 'classifications', 'selectedCoreBusinesses', 'selectedClassifications', 'vendor_files', 'id'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // validasi input
        $validatedData = $request->validate([
            'name' => 'required',
            'address' => 'required',
            'domicility' => 'required',
            'area' => 'required',
            'director' => 'required',
            'phone' => 'required',
            'email' => 'required|email|unique:vendors,email,' . $id,
            'capital' => 'required',
            'grade' => 'required',
            'reference' => 'required',
            'join_date' => 'required',
            'core_business_id' => 'required|array',
            'classification_id' => 'required|array'
        ]);

        // perbarui data vendor
        $vendor = Vendor::findOrFail($id);
        $vendor->name = $request->name;
        $vendor->address = $request->address;
        $vendor->domicility = $request->domicility;
        $vendor->area = $request->area;
        $vendor->director = $request->director;
        $vendor->phone = $request->phone;
        $vendor->email = $request->email;
        $vendor->capital = $request->capital;
        $vendor->grade = $request->grade;
        $vendor->join_date = $request->join_date;
        $vendor->reference = $request->reference;
        $vendor->save();

        // hubungkan vendor dengan core business yang dipilih
        $vendor->coreBusinesses()->sync($request->core_business_id);

        // hubungkan vendor dengan classification yang dipilih
        $vendor->classifications()->sync($request->classification_id);

        Alert::success('Success', 'Vendor data successfully updated');

        return redirect()->route('vendors.index');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Vendor $vendor)
    {
        $vendor->delete();
        return redirect()->route('vendors.index');
    }

    public function blacklist(Vendor $vendor)
    {
        $vendor->status = '3'; // Ubah status vendor menjadi 3 (blacklisted)
        $vendor->save();

        return response()->json(['success' => 'Vendor blacklisted successfully!']);
    }


    public function upload(Request $request)
    {
        // dd($request->all());
        try {
            $this->validate($request, [
                'vendor_file' => 'required|mimes:xlsx,xls,pdf,doc,docx,jpg,jpeg,png',
                'id_vendor' => 'required',
                'type_file' => 'required|in:0,1,2,3',
            ]);

            $existingVendor = Vendor::findOrFail($request->id_vendor);

            if ($request->hasFile('vendor_file')) {
                $file = $request->file('vendor_file');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('vendor_files', $fileName, 'public');

                $vendorFile = new VendorFile();
                $vendorFile->vendor_id = $existingVendor->id;
                $vendorFile->file_type = $request->type_file;
                $vendorFile->file_name = $fileName;
                $vendorFile->file_path = $filePath;
                $vendorFile->save();

                return response()->json(['success' => 'Vendor file uploaded successfully!']);
            } else {
                throw new \Exception('No file uploaded.');
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function fileDelete($fileId)
    {
        $vendorFile = VendorFile::findOrFail($fileId);

        // Delete the file from storage
        Storage::disk('public')->delete($vendorFile->file_path);

        // Delete the file record from the database
        $vendorFile->delete();

        return response()->json(['success' => 'File deleted successfully']);
    }


    public function data()
    {
        if (request()->ajax()) {
            $vendors = Vendor::where('status', '3')
                ->with('coreBusinesses:name', 'classifications:name')
                ->orderByDesc('updated_at')
                ->get();
            return DataTables::of($vendors)->make(true);
        }

        $vendors = Vendor::where('status', '3')->get();

        return view('vendors.data', compact('vendors'));
    }

    public function fetchData($fileId): JsonResponse
    {
        try {
            $file = VendorFile::with('vendor')->findOrFail($fileId);

            // Buat data response yang akan dikirim sebagai JSON
            $responseData = [
                'success' => true,
                'file' => $file,
            ];

            return response()->json($responseData);
        } catch (\Exception $e) {
            // Jika terjadi error, kirim response dengan status error
            $responseData = [
                'success' => false,
                'message' => 'Failed to fetch file data.',
            ];

            return response()->json($responseData, 500);
        }
    }


    public function fileUpdate(Request $request, $fileId)
    {
        // Validate the form data
        $validatedData = $request->validate([
            'file_type' => 'required|in:0,1,2',
            'edit_vendor_file' => 'nullable|file|mimes:xlsx,xls,pdf,doc,docx,jpg,jpeg,png',
        ]);

        try {
            // Find the file
            $file = VendorFile::where('id', $fileId)
                ->where('vendor_id', $request->vendor_id)
                ->firstOrFail();

            // Check if a new file is uploaded
            if ($request->hasFile('edit_vendor_file')) {

                // Delete the existing file
                if ($file->file_path) {
                    Storage::disk('public')->delete($file->file_path);
                }

                // Upload the new file
                $newFile = $request->file('edit_vendor_file');
                $newFileName = time() . '_' . $newFile->getClientOriginalName();
                $newFilePath = $newFile->storeAs('vendor_files', $newFileName, 'public');

                // Update the file path and name
                $file->file_path = $newFilePath;
                $file->file_name = $newFileName;
            }

            // Update the file type
            $file->file_type = $validatedData['file_type'];

            // Save the changes
            $file->save();

            // Return success response as JSON
            $responseData = [
                'success' => true,
                'message' => 'File vendor data updated successfully.',
            ];
            return response()->json($responseData);
        } catch (\Exception $e) {
            // Return error response as JSON
            $responseData = [
                'success' => false,
                'message' => 'Failed to update file.',
            ];
            // return response()->json($responseData, 500);
            return response()->json(["Error" => $e->getMessage() . " Line : " . $e->getLine()]);
        }
    }
}
