<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Classification;
use App\Models\CoreBusiness;
use palPalani\Toastr\Facades\Toastr;


class ClassificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $classifications = Classification::with('coreBusiness')->get()->all();
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
    { {
            try {
                $validatedData = $request->validate([
                    'name' => 'required',
                    'core_business_id' => 'required|exists:core_businesses,id'
                ]);

                Classification::create($validatedData);

                Toastr::success('Classification added successfully!', 'Success');
                return redirect('/classifications');
            } catch (\Illuminate\Validation\ValidationException $e) {
                Toastr::error('Failed to add Classification: ' . $e->errors()['name'][0], 'Error');
                return redirect()->back()->withInput();
            } catch (\Exception $e) {
                Toastr::error('Failed to add Classification: ' . $e->getMessage(), 'Error');
                return redirect()->back()->withInput();
            }
        }
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
