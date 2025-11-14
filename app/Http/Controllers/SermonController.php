<?php

namespace App\Http\Controllers;

use App\Models\Sermon;
use App\Models\Pastor;
use App\Models\Event;
use Illuminate\Http\Request;

class SermonController extends Controller
{
    public function index()
    {
        $sermons = Sermon::with(['pastor', 'event'])->orderBy('date', 'desc')->get();
        $events = Event::all();
        $pastors = Pastor::all();
        return view('sermons.index', compact('sermons', 'events','pastors'));
    }

    public function create()
    {
        $pastors = Pastor::all();
        $events = Event::all();
        return view('sermons.create', compact('pastors', 'events'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'pastor_id' => 'nullable|exists:pastors,id',
            'event_id' => 'nullable|exists:events,id',
            'guest_preacher' => 'nullable|string|max:255',
            'bible_text' => 'nullable|string|max:255',
            'summary' => 'nullable|string',
            'date' => 'required|date',
        ]);

        Sermon::create($validated);

        return redirect()->route('sermons.index')->with('success', 'Sermon added successfully.');
    }

    public function show(Sermon $sermon)
    {
        return view('sermons.show', compact('sermon'));
    }

    public function edit($id)
    {
        $sermon = Sermon::findOrFail($id);
        $pastors = Pastor::all();
        $events = Event::all();
        return view('sermons.edit', compact('sermon', 'pastors', 'events'));
    }

    public function update(Request $request, $id)
    {
        $sermon = Sermon::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'pastor_id' => 'nullable|exists:pastors,id',
            'event_id' => 'nullable|exists:events,id',
            'guest_preacher' => 'nullable|string|max:255',
            'bible_text' => 'nullable|string|max:255',
            'summary' => 'nullable|string',
            'date' => 'required|date',
        ]);

        $sermon->update($validated);

        return redirect()->route('sermons.index')->with('success', 'Sermon updated successfully.');
    }

    public function destroy($id)
    {
        $sermon = Sermon::findOrFail($id);
        $sermon->delete();
        return redirect()->route('sermons.index')->with('success', 'Sermon deleted successfully.');
    }



}
