<?php

namespace App\Http\Controllers;

use App\Models\CoreBusiness;
use App\Models\Classification;
use App\Models\Vendor;
use App\Models\VendorFile;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use RealRashid\SweetAlert\Facades\Alert;

class VendorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $vendors = Vendor::where('is_blacklist', '0')
                ->with('coreBusinesses:name', 'classifications:name')
                ->get();
            return DataTables::of($vendors)->make(true);
        }

        $vendors = Vendor::where('is_blacklist', '0')->get();
        // $core_businesses = CoreBusiness::all();
        // $classifications = Classification::all();

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
            'area' => 'required',
            'director' => 'required',
            'phone' => 'required',
            'email' => 'required|email|unique:vendors',
            'capital' => 'required',
            'grade' => 'required',
            'core_business_id' => 'required|array',
            'classification_id' => 'required|array'
        ]);

        // simpan data vendor
        $vendor = new Vendor;
        $vendor->name = $request->name;
        $vendor->address = $request->address;
        $vendor->area = $request->area;
        $vendor->director = $request->director;
        $vendor->phone = $request->phone;
        $vendor->email = $request->email;
        $vendor->capital = $request->capital;
        $vendor->grade = $request->grade;
        $vendor->save();

        // hubungkan vendor dengan core business yang dipilih
        $vendor->coreBusinesses()->attach($request->core_business_id);

        // hubungkan vendor dengan classification yang dipilih
        $vendor->classifications()->attach($request->classification_id);

        Alert::success('Success', 'Vendor data successfully stored');

        return redirect()->route('vendors.index');
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $core_businesses = CoreBusiness::all();
        $classifications = Classification::all();
        // return view('vendors.edit', compact('vendor', 'core_businesses', 'classifications'));
        // Mengambil data vendor yang akan diedit
        $vendor = Vendor::findOrFail($id);

        // Mengambil klasifikasi yang dipilih untuk vendor
        $selectedCoreBusinesses = $vendor->coreBusinesses->pluck('id')->toArray();
        $selectedClassifications = $vendor->classifications->pluck('id')->toArray();

        $vendor_files = $vendor->vendorFiles;

        // Mengirimkan $selectedClassifications ke view
        return view('vendors.show', compact('vendor', 'core_businesses', 'classifications', 'selectedCoreBusinesses', 'selectedClassifications', 'vendor_files'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $core_businesses = CoreBusiness::all();
        $classifications = Classification::all();
        // return view('vendors.edit', compact('vendor', 'core_businesses', 'classifications'));
        // Mengambil data vendor yang akan diedit
        $vendor = Vendor::findOrFail($id);

        // Mengambil klasifikasi yang dipilih untuk vendor
        $selectedCoreBusinesses = $vendor->coreBusinesses->pluck('id')->toArray();
        $selectedClassifications = $vendor->classifications->pluck('id')->toArray();

        $vendor_files = $vendor->vendorFiles;

        // Mengirimkan $selectedClassifications ke view
        return view('vendors.edit', compact('vendor', 'core_businesses', 'classifications', 'selectedCoreBusinesses', 'selectedClassifications', 'vendor_files'));
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
            'area' => 'required',
            'director' => 'required',
            'phone' => 'required',
            'email' => 'required|email|unique:vendors,email,' . $id,
            'capital' => 'required',
            'grade' => 'required',
            'core_business_id' => 'required|array',
            'classification_id' => 'required|array'
        ]);

        // perbarui data vendor
        $vendor = Vendor::findOrFail($id);
        $vendor->name = $request->name;
        $vendor->address = $request->address;
        $vendor->area = $request->area;
        $vendor->director = $request->director;
        $vendor->phone = $request->phone;
        $vendor->email = $request->email;
        $vendor->capital = $request->capital;
        $vendor->grade = $request->grade;
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
        $vendor->is_blacklist = '1';
        $vendor->blacklist_at = now();
        $vendor->save();

        return redirect()->route('vendors.index');
    }

    public function upload(Request $request)
    {
        $this->validate($request, [
            'vendor_file' => 'required|mimes:xlsx,xls,pdf,doc,docx,jpg,jpeg,png',
            'existing_vendors' => 'required',
            'file_type' => 'required|in:0,1,2',
        ]);

        $existingVendor = Vendor::findOrFail($request->existing_vendors);

        $file = $request->file('vendor_file');
        $fileName = time() . '_' . $file->getClientOriginalName();

        $filePath = $file->storeAs('vendor_files', $fileName, 'public');

        $vendorFile = new VendorFile();
        $vendorFile->vendor_id = $existingVendor->id;
        $vendorFile->file_type = $request->file_type;
        $vendorFile->file_name = $fileName;
        $vendorFile->file_path = $filePath;

        $vendorFile->save();

        return redirect()->back()->with('success', 'Vendor file uploaded successfully!');
    }

    public function data()
    {
        if (request()->ajax()) {
            $vendors = Vendor::where('is_blacklist', '1')
                ->with('coreBusinesses:name', 'classifications:name')
                ->get();
            return DataTables::of($vendors)->make(true);
        }

        $vendors = Vendor::where('is_blacklist', '1')->get();
        // $core_businesses = CoreBusiness::all();
        // $classifications = Classification::all();

        return view('vendors.data', compact('vendors'));
    }
}
