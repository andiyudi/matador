<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use App\Models\Procurement;
use Illuminate\Http\Request;
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
            $procurements = Procurement::with('vendors')->get();
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
}
