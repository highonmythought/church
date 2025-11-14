<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventPhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EventPhotoController extends Controller
{
    public function index()
    {
        $photos = EventPhoto::with('event')->latest()->get();
        return view('event_photos.index', compact('photos'));
    }

    public function create()
    {
        $events = Event::all();
        return view('event_photos.create', compact('events'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'event_id' => 'required|exists:events,id',
            'photos.*' => 'required|image|max:10240', // ✅ up to 10MB
        ]);

        $uploadedPhotos = [];

        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $file) {
                // Save to /storage/app/public/event_photos
                $path = $file->store('event_photos', 'public');

                $photo = EventPhoto::create([
                    'event_id' => $request->event_id,
                    'photo_path' => 'storage/' . $path, // stored as "storage/event_photos/xxx.jpg"
                ]);

                $uploadedPhotos[] = [
                    'id' => $photo->id,
                    'photo_path' => asset($photo->photo_path),
                ];
            }
        }

        if ($request->ajax()) {
            return response()->json(['success' => true, 'photos' => $uploadedPhotos]);
        }

        return back()->with('success', 'Photos uploaded successfully.');
    }

    public function show(EventPhoto $eventPhoto)
    {
        return view('event_photos.show', compact('eventPhoto'));
    }

   public function destroy($id)
{
    // ✅ Find the photo by ID
    $eventPhoto = EventPhoto::findOrFail($id);

    // ✅ Delete the physical file if it exists
    $relativePath = str_replace('storage/', '', $eventPhoto->photo_path);
    if (Storage::disk('public')->exists($relativePath)) {
        Storage::disk('public')->delete($relativePath);
    }

    // ✅ Delete from database
    $eventPhoto->delete();

    // ✅ Handle AJAX vs normal requests
    if (request()->ajax()) {
        return response()->json(['success' => true]);
    }

    return back()->with('success', 'Photo deleted successfully.');
}
}
