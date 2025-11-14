<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\User;
use App\Notifications\NewAlert;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $members = Member::with('department')->get();
        $departments = Department::all();
        return view('members.index', compact('members','departments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $departments = Department::all();
        return view('members.create', compact('departments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name'     => 'required|string|max:255',
            'last_name'      => 'required|string|max:255',
            'email'          => 'required|email|unique:members,email',
            'phone'          => 'required|string|max:20|unique:members,phone',
            'address'        => 'nullable|string|max:255',
            'gender'         => 'nullable|in:Male,Female',
            'dob'            => 'nullable|date',
            'department_id'  => 'nullable|exists:departments,id',
        ]);

        $member = new Member();
        $member->first_name    = $request->first_name;
        $member->last_name     = $request->last_name;
        $member->email         = $request->email;
        $member->phone         = $request->phone;
        $member->address       = $request->address;
        $member->gender        = $request->gender;
        $member->dob           = $request->dob;
        $member->department_id = $request->department_id;
        $member->save();

        // ✅ Send alert notification to Admin(s) — database + email
        $admins = User::role('Admin')->get();
        foreach ($admins as $admin) {
            $admin->notify(new NewAlert("A new member has been registered: {$member->first_name} {$member->last_name}."));
        }

        return redirect()->route('members.index')->with('success', 'Member added successfully!');
    }


    public function publicCreate()
{
    $departments = Department::all();
    return view('members.public-register', compact('departments'));
}

public function publicStore(Request $request)
{
    $request->validate([
        'first_name'     => 'required|string|max:255',
        'last_name'      => 'required|string|max:255',
        'email'          => 'required|email|unique:members,email',
        'phone'          => 'required|string|max:20|unique:members,phone',
        'address'        => 'nullable|string|max:255',
        'gender'         => 'nullable|in:Male,Female',
        'dob'            => 'nullable|date',
        'department_id'  => 'nullable|exists:departments,id',
    ]);

    $member = Member::create($request->all());
    

    // ✅ Notify admin of new registration
    $admins = \App\Models\User::role('Admin')->get();
    foreach ($admins as $admin) {
        $admin->notify(new \App\Notifications\NewAlert("A new member registered online: {$member->first_name} {$member->last_name}."));
    }

 // Flash success and stay on welcome page
    return redirect()->route('home')->with('success', 'You have registered successfully!');}


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $member = Member::with('department')->findOrFail($id);
        return view('members.show', compact('member'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $member = Member::findOrFail($id);
        $departments = Department::all();
        return view('members.edit', compact('member', 'departments'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $member = Member::findOrFail($id);
        $request->validate([
            'first_name'     => 'required|string|max:255',
            'last_name'      => 'required|string|max:255',
            'email'          => 'required|email|unique:members,email,' . $member->id,
            'phone'          => 'required|string|max:20|unique:members,phone,' . $member->id,
            'address'        => 'nullable|string|max:255',
            'gender'         => 'nullable|in:Male,Female',
            'dob'            => 'nullable|date',
            'department_id'  => 'nullable|exists:departments,id',
        ]);

        $member->first_name    = $request->first_name;
        $member->last_name     = $request->last_name;
        $member->email         = $request->email;
        $member->phone         = $request->phone;
        $member->address       = $request->address;
        $member->gender        = $request->gender;
        $member->dob           = $request->dob;
        $member->department_id = $request->department_id;
        $member->update();

        return redirect()->route('members.index')->with('success', 'Member updated successfully!');
    }

    public function search(Request $request)
    {
        $q = $request->input('q');

        $members = Member::when($q, function($query) use ($q) {
            $query->where('first_name', 'like', "%{$q}%")
                  ->orWhere('last_name', 'like', "%{$q}%")
                  ->orWhere('email', 'like', "%{$q}%");
        })
        ->take(50)
        ->get();

        return response()->json($members);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $member = Member::findOrFail($id);
        $member->delete();
        return redirect()->route('members.index')->with('success', 'Member deleted successfully!');
    }
}
