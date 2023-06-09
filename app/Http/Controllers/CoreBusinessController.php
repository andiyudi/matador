<?php

namespace App\Http\Controllers;

use App\Models\CoreBusiness;
use Illuminate\Http\Request;
use palPalani\Toastr\Facades\Toastr;

class CoreBusinessController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $core_businesses = CoreBusiness::all();
        return view('core-business.index', compact('core_businesses'));
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
        try {
            $request->validate([
                'name' => 'required|unique:core_businesses',
            ]);

            $core_business = new CoreBusiness([
                'name' => $request->get('name'),
            ]);

            $core_business->save();

            Toastr::success('Core Business added successfully!', 'Success');
            return redirect('/core-business');
        } catch (\Illuminate\Validation\ValidationException $e) {
            Toastr::error('Failed to add Core Business: ' . $e->errors()['name'][0], 'Error');
            return redirect()->back()->withInput();
        } catch (\Exception $e) {
            Toastr::error('Failed to add Core Business: ' . $e->getMessage(), 'Error');
            return redirect()->back()->withInput();
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
    public function edit(CoreBusiness $core_business)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CoreBusiness $core_business)
    {
        $request->validate([
            'name' => 'required|max:255'
        ]);

        $core_business->update($request->all());

        return redirect()->route('core-business.index')->with('success', 'Core Business updated successfully!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CoreBusiness $core_business)
    {
        $core_business->delete();

        return redirect()->route('core-business.index')
            ->with('success', 'Core Business deleted successfully');
    }
}
