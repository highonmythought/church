<?php

namespace App\Http\Controllers;

use App\Models\FinancialRecord;
use Illuminate\Support\Facades\DB;
use App\Models\Event;
use Illuminate\Http\Request;

class FinancialRecordController extends Controller
{
    public function index()
{
    $financialRecords = FinancialRecord::latest()->paginate(10);

    // Group totals by type
    $totalsByType = FinancialRecord::select('type', DB::raw('SUM(amount) as total'))
        ->groupBy('type')
        ->get();
$chartLabels = $totalsByType->pluck('type');
$chartValues = $totalsByType->pluck('total');

    // Total sum of all records
    $grandTotal = FinancialRecord::sum('amount');
    $events = Event::all();

    return view('financial_records.index', compact('financialRecords', 'totalsByType', 'events', 'grandTotal', 'chartLabels', 'chartValues'));

}
public function create()
    {
        $events = Event::all();
        return view('financial_records.create', compact('events'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'event_id' => 'nullable|exists:events,id',
            'type' => 'required|in:Tithe,Offering,Thanksgiving,Donation,Others',
            'description' => 'nullable|string|max:255',
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date',
        ]);

        FinancialRecord::create($validated);
        return redirect()->route('financial-records.index')->with('success', 'Financial record added successfully.');
    }

    public function show($id)
    {
        $events = Event::all();
        $financialRecord = FinancialRecord::with('event')->findOrFail($id);
        return view('financial_records.show', compact('financialRecord', 'events'));
    }

    public function edit($id)
    {
         $financialRecord = FinancialRecord::findOrFail($id);
        $events = Event::all();
        return view('financial_records.edit', compact('financialRecord', 'events'));
    }

    public function update(Request $request, $id)
    {
         $financialRecord = FinancialRecord::findOrFail($id);
        $validated = $request->validate([
            'event_id' => 'nullable|exists:events,id',
            'type' => 'required|in:Tithe,Offering,Thanksgiving,Donation,Others',
            'description' => 'nullable|string|max:255',
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date',
        ]);

        $financialRecord->update($validated);
        return redirect()->route('financial-records.index')->with('success', 'Financial record updated successfully.');
    }

   public function destroy($id)
{
    $financialRecord = FinancialRecord::findOrFail($id);
    $financialRecord->delete();

    return redirect()->route('financial-records.index')->with('success', 'Financial record deleted successfully.');
}





}
