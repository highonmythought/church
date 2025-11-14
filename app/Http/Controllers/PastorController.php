<?php

namespace App\Http\Controllers;

use App\Models\Pastor;
use Illuminate\Http\Request;



 
class PastorController extends Controller
{
    /**
     * Display a listing of the pastors.
     */
    public function index()
    {
        $pastors = Pastor::all();
        
        return view('pastors.index', compact('pastors', ));
    }

    /**
     * Show the form for creating a new pastor.
     */
    public function create()
    {
        return view('pastors.create');
    }

    /**
     * Store a newly created pastor in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'rank' => 'required|string|max:255',
            'email' => 'nullable|email',
            'phone' => 'nullable|string|max:20',
        ]);

        Pastor::create($request->all());

        return redirect()->route('pastors.index')->with('success', 'Pastor added successfully.');
    }

    /**
     * Display the specified pastor.
     */
    public function show($id)
    {
        $pastor = Pastor::findOrFail($id);
        return view('pastors.show', compact('pastor'));
    }

    /**
     * Show the form for editing the specified pastor.
     */
    public function edit($id)
    {
        $pastor = Pastor::findOrFail($id);
        return view('pastors.edit', compact('pastor'));
    }

    /**
     * Update the specified pastor in storage.
     */
    public function update(Request $request, $id)
    {
        $pastor = Pastor::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'rank' => 'required|string|max:255',
            'email' => 'nullable|email',
            'phone' => 'nullable|string|max:20',
        ]);

        $pastor->update($request->all());

        return redirect()->route('pastors.index')->with('success', 'Pastor updated successfully.');
    }

    /**
     * Remove the specified pastor from storage.
     */
    public function destroy($id)
    {
        $pastor = Pastor::findOrFail($id);
        $pastor->delete();

        return redirect()->back()->with('success', 'Pastor deleted successfully.');
    }



}
