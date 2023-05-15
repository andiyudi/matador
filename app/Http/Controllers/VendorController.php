<?php

namespace App\Http\Controllers;

use App\Models\CoreBusiness;
use App\Models\Classification;
use App\Models\Vendor;
use App\Models\VendorFile;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class VendorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $vendors = Vendor::where('is_blacklist', 1)
                ->with('coreBusinesses:name', 'classifications:name')
                ->get();
            return DataTables::of($vendors)->make(true);
        }

        $vendors = Vendor::where('is_blacklist', 1)->get();
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

        return redirect()->route('vendors.index')->with('success', 'Data vendor berhasil disimpan.');
    }


    /**
     * Display the specified resource.
     */
    public function show(Vendor $vendor)
    {
        return view('vendors.detail', compact('vendor'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Vendor $vendor)
    {
        $core_businesses = CoreBusiness::all();
        $classifications = Classification::all();
        return view('vendors.edit', compact('vendor', 'core_businesses', 'classifications'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Vendor $vendor)
    {
        $request->validate([
            'name' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'email' => 'required|email|unique:vendors,email,' . $vendor->id,
            'capital' => 'required|numeric',
            'core_businesses' => 'required|array',
            'classifications' => 'required|array'
        ]);

        $vendor->update([
            'name' => $request->name,
            'address' => $request->address,
            'phone' => $request->phone,
            'email' => $request->email,
            'capital' => $request->capital,
            'grade' => $request->grade,
            'is_blacklist' => $request->is_blacklist ? 1 : 0,
            'blacklist_at' => $request->is_blacklist ? now() : null,
            'status' => $request->status,
            'expired_at' => $request->status == 2 ? now() : null
        ]);

        $vendor->coreBusinesses()->sync($request->core_businesses);
        $vendor->classifications()->sync($request->classifications);

        return redirect()->route('vendors.index')->with('success', 'Vendor updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Vendor $vendor)
    {
        $vendor->delete();
        return redirect()->route('vendors.index')->with('success', 'Vendor deleted successfully');
    }

    public function blacklist(Vendor $vendor)
    {
        $vendor->is_blacklist = 2;
        $vendor->blacklist_at = now();
        $vendor->save();

        return redirect()->back()->with('success', 'Vendor has been blacklisted.');
    }

    public function upload(Request $request)
    {
        $this->validate($request, [
            'vendor_file' => 'required|mimes:xlsx,xls,pdf,doc,docx',
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
}
