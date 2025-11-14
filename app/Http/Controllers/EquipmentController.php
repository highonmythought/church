<?php


namespace App\Http\Controllers;

use App\Models\Equipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EquipmentController extends Controller
{
    public function index()
    {
        $equipments = Equipment::orderBy('created_at', 'desc')->get();
        return view('equipments.index', compact('equipments'));
    }

    public function create()
    {
        return view('equipments.create');
    }

public function store(Request $request)
{
    // Validate input
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'photo_path' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        'acquired_date' => 'nullable|date',
    ]);

    $equipment = new Equipment();

    // Handle image upload
    if ($request->hasFile('photo_path')) {
        $file = $request->file('photo_path');
        $filename = time() . '_' . $file->getClientOriginalName(); // unique filename
        $file->move(public_path('uploads/equipment'), $filename);

        $equipment->photo_path = 'uploads/equipment/' . $filename;
    }

    // Assign values
    $equipment->name = $validated['name'];
    $equipment->description = $validated['description'] ?? null;
    $equipment->acquired_date = $validated['acquired_date'] ?? null;

    $equipment->save();

    return redirect()
        ->route('equipments.index')
        ->with('success', 'Equipment added successfully.');
}


    public function show($id)
    {
         $equipment= Equipment::find($id);
        return view('equipments.show', compact('equipment'));
    }

      public function edit($id)
{
    $equipment = Equipment::findOrFail($id);
    return view('equipments.edit', compact('equipment'));
}

   public function update(Request $request, $id)
    {
        $equipment = Equipment::find($id);

    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'photo_path' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        'acquired_date' => 'nullable|date',
    ]);

    // Update basic fields
    $equipment->name = $validated['name'];
    $equipment->description = $validated['description'] ?? $equipment->description;
    $equipment->acquired_date = $validated['acquired_date'] ?? $equipment->acquired_date;

    // Handle new photo upload
    if ($request->hasFile('photo_path')) {
                // Delete the old image if it exists
        if ($equipment->photo_path && file_exists(public_path($equipment->photo_path))) {
            unlink(public_path($equipment->photo_path));
        }
          // Upload new image
        $file = $request->file('photo_path');
        $filename = time() . '_' . $file->getClientOriginalName();
        $destination = public_path('uploads/equipment');

        // Make sure folder exists
        if (!file_exists($destination)) {
            mkdir($destination, 0775, true);
        }

        $file->move($destination, $filename);
        $equipment->photo_path = 'uploads/equipment/' . $filename;
    }

    $equipment->save();

    return redirect()->route('equipments.index')->with('success', 'Equipment updated successfully.');
}

    public function search(Request $request)
{
    $q = $request->input('q');

    $results = Equipment::when($q, function($query) use ($q) {
        $query->where('name', 'like', "%{$q}%")
              ->orWhere('description', 'like', "%{$q}%");
    })
    ->take(50)
    ->get();

    return response()->json($results);
}


    public function destroy($id)
{
    $equipment = Equipment::findOrFail($id);

    if ($equipment->photo_path) {
        Storage::disk('public')->delete($equipment->photo_path);
    }

    $equipment->delete();

    return redirect()->route('equipments.index')->with('success', 'Equipment deleted successfully.');
}



}
