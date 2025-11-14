<?php

namespace App\Http\Controllers;

use App\Models\Pledge;
use Illuminate\Http\Request;

class PledgeController extends Controller
{
    /**
     * Display a listing of the pledges.
     */
    public function index()
    {
        $pledges = Pledge::orderBy('created_at', 'desc')->get();
        return view('pledges.index', compact('pledges'));
    }

    /**
     * Show the form for creating a new pledge.
     */
    public function create()
    {
        return view('pledges.create');
    }

    /**
     * Store a newly created pledge in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'amount' => 'required|numeric|min:0',
            'expected_payment_date' => 'nullable|date',
            'notes' => 'nullable|string',
            'is_paid' => 'boolean',
        'amount_paid' => 'nullable|numeric|min:0',
        'payment_date' => 'nullable|date',
        ]);

         // 👇 Automatically set name if blank
    $validated['name'] = $validated['name'] ?? 'Anonymous';

        Pledge::create($validated);
        return redirect()->route('pledges.index')->with('success', 'Pledge added successfully.');
    }

   public function show($id)
    {
        $pledge = Pledge::findOrFail($id);
        return view('pledges.show', compact('pledge'));
    }

    public function edit($id)
    {
        $pledge =Pledge::findOrFail($id);
        return view('pledges.edit', compact('pledge'));
    }


    /**
     * Update the specified pledge in storage.
     */
    public function update(Request $request, $id)
    {
        $pledge =Pledge::findOrFail($id);

        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'amount' => 'required|numeric|min:0',
            'expected_payment_date' => 'nullable|date',
            'notes' => 'nullable|string',
            'is_paid' => 'boolean',
        'amount_paid' => 'nullable|numeric|min:0',
        'payment_date' => 'nullable|date',
        ]);
       
          // 👇 Automatically set name if blank
    $validated['name'] = $validated['name'] ?? 'Anonymous';


        $pledge->update($validated);
        return redirect()->route('pledges.index')->with('success', 'Pledge updated successfully.');
    }

    /**
     * Remove the specified pledge from storage.
     */
     public function destroy($id)
    {
        $pledge = Pledge::findOrFail($id);
        $pledge->delete();

        return redirect()->back()->with('success', 'Pledge deleted successfully.');
    }


}
