<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use App\Models\Procurement;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ProcurementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $procurement = Procurement::all();
            return DataTables::of($procurement)->make(true);
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
        // Save vendor_id in procurement_vendor table
        $vendorIds = $request->input('vendor_id');
        if (!empty($vendorIds)) {
            $procurement->vendors()->attach($vendorIds);
            // Update vendor status and activated_at
            Vendor::whereIn('id', $vendorIds)->update([
                'status' => '1', // Set status to 1 (active)
                'activated_at' => today(), // Set activated_at to current timestamp
            ]);
        }


        return redirect()->route('procurement.index')->with('success', 'Procurement data has been saved.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Procurement $procurement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Procurement $procurement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Procurement $procurement)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Procurement $procurement)
    {
        //
    }
}
