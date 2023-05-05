<?php

namespace App\Http\Controllers;

use App\Models\CoreBusiness;
use Illuminate\Http\Request;

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
        $request->validate([
            'name' => 'required|unique:core_businesses',
        ]);

        $core_business = new CoreBusiness([
            'name' => $request->get('name'),
        ]);

        $core_business->save();

        return redirect('/core-business')->with('success', 'Core Business added successfully!');
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
