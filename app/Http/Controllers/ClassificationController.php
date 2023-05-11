<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Classification;
use App\Models\CoreBusiness;


class ClassificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $classifications = Classification::with('coreBusiness')->orderByDesc('id')->paginate(5)->fragment('cls');
        $coreBusinesses = CoreBusiness::all();
        return view('classification.index', compact('classifications', 'coreBusinesses'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'core_business_id' => 'required|exists:core_businesses,id'
        ]);

        Classification::create($validatedData);

        return redirect('/classifications')->with('success', 'Classification data has been created!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Classification $classification)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'core_business_id' => 'required|exists:core_businesses,id'
        ]);

        $classification->update($validatedData);

        return redirect()->route('classifications.index')->with('success', 'Classification data has been updated!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Classification $classification)
    {
        $classification->delete();

        return redirect()->route('classifications.index')
            ->with('success', 'Classification data has been deleted successfully.');
    }
    // method for get classifications data by core business id
    public function getByCoreBusiness(Request $request)
    {
        $core_business_ids = $request->input('core_business_ids');
        $classifications = Classification::whereIn('core_business_id', $core_business_ids)->pluck('name', 'id');
        return response()->json($classifications);
    }
}
