<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\Pastor;
use App\Models\Department;
use App\Models\Event;
use App\Models\Attendance;

class DashboardController extends Controller
{
    public function index()
    {
        $totalMembers     = Member::count();
        $totalPastors     = Pastor::count();
        $totalDepartments = Department::count();
        $totalEvents      = Event::count();
        $totalAttendance  = Attendance::sum('total_attendance');

        // simple example chart data
        $labels = Attendance::orderBy('date')->limit(10)->pluck('date')->map(fn($d) => $d->format('M d'))->toArray();
        $data   = Attendance::orderBy('date')->limit(10)->pluck('total_attendance')->toArray();

        // change the view name to match your view file location:
        // If your blade is resources/views/dashboard.blade.php use 'dashboard'
        // If your blade is resources/views/dashboard/index.blade.php use 'dashboard.index'
        return view('dashboard', compact(
            'totalMembers',
            'totalPastors',
            'totalDepartments',
            'totalEvents',
            'totalAttendance',
            'labels',
            'data'
        ));
    }



}
