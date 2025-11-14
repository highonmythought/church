<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Event;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    /**
     * Display a listing of attendance records.
     */
    public function index()
    {
        
    // Eager-load the related event to avoid N+1 queries
    $attendances = Attendance::with('event')->latest()->paginate(15);

    // Fetch all events for the add/edit modals
    $events = Event::all();

    return view('attendance.index', compact('attendances', 'events'));
}
    

    /**
     * Show the form for creating a new record.
     */
    public function create()
    {
        $events = Event::all();
        return view('attendance.create', compact('events'));
    }

    /**
     * Store a newly created attendance record.
     */
    public function store(Request $request)
    {
        $request->validate([
            'event_id' => 'required|exists:events,id',
            'date' => 'nullable|date',
            'total_attendance' => 'required|integer|min:0',
        ]);

        Attendance::create($request->all());
 if ($request->ajax()) {
        return response()->json(['success' => true, 'data' => $attendance]);
    }
        return redirect()->route('attendance.index')->with('success', 'Attendance record added successfully.');
    }

    public function search(Request $request)
{
    $q = $request->input('q');

    $results = Attendance::when($q, function($query) use ($q) {
        $query->where('event_id', 'like', "%{$q}%")
              ->orWhere('date', 'like', "%{$q}%");
              
    })
    ->take(50)
    ->get();

    return response()->json($results);
}


    /**
     * Show a specific record.
     */
    public function show($id)
    {
        $attendance = Attendance::with('event')->findOrFail($id);
        return view('attendance.show', compact('attendance'));
    }

    /**
     * Show the form for editing a record.
     */
    public function edit($id)
    {
        $attendance = Attendance::findOrFail($id);
        $events = Event::all();
        return view('attendance.edit', compact('attendance', 'events'));
    }

    /**
     * Update the specified attendance record.
     */
    public function update(Request $request, $id)
    {
        $attendance = Attendance::findOrFail($id);

        $request->validate([
            'event_id' => 'required|exists:events,id',
            'date' => 'nullable|date',
            'total_attendance' => 'required|integer|min:0',
        ]);

        $attendance->update($request->all());

        return redirect()->route('attendance.index')->with('success', 'Attendance updated successfully.');
    }

    /**
     * Delete a record.
     */
    public function destroy($id)
    {
        $attendance = Attendance::findOrFail($id);
        $attendance->delete();

        return redirect()->back()->with('success', 'Attendance deleted successfully.');
    }

public function chart()
{
    $attendances = \App\Models\Attendance::with('event')
        ->orderBy('date')
        ->get()
        ->groupBy(fn($a) => $a->event->event_type ?? 'Unknown');

    // Prepare data for Chart.js
    $labels = [];
    $datasets = [];

    foreach ($attendances as $eventType => $records) {
        $labels = $records->pluck('date')->map(fn($d) => $d->format('Y-m-d'))->toArray();

        $datasets[] = [
            'label' => $eventType,
            'data' => $records->pluck('total_attendance')->toArray(),
            'fill' => false,
            'borderColor' => '#' . substr(md5($eventType), 0, 6),
            'tension' => 0.3,
        ];
    }

    return view('attendance.chart', [
        'labels' => $labels,
        'datasets' => $datasets,
    ]);
}





}
