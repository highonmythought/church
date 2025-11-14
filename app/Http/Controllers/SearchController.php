<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\Event;
use App\Models\Expense;
use App\Models\Department;
use App\Models\FinancialRecord;
use App\Models\Pledge;
use App\Models\Sermon;
use App\Models\Pastor;
use App\Models\Equipment;

class SearchController extends Controller
{
    public function global(Request $request)
    {
        $query = $request->input('q');

        // Return empty arrays if query is empty
        if (!$query) {
            $emptyResult = collect([]);
            return response()->json([
                'members' => $emptyResult,
                'events' => $emptyResult,
                'expenses' => $emptyResult,
                'departments' => $emptyResult,
                'financialRecords' => $emptyResult,
                'pledges' => $emptyResult,
                'sermons' => $emptyResult,
                'pastors' => $emptyResult,
                'equipments' => $emptyResult,
            ]);
        }

        // Build JSON results with route URLs
        $members = Member::where('first_name', 'like', "%{$query}%")
            ->orWhere('email', 'like', "%{$query}%")
            ->take(5)
            ->get()
            ->map(fn($m) => [
                'id' => $m->id,
                'title' => $m->first_name ?? $m->name ?? 'Unnamed',
                'description' => $m->email ?? '',
                'url' => route('members.show', $m->id),
            ]);

        $events = Event::where('event_type', 'like', "%{$query}%")
            ->orWhere('description', 'like', "%{$query}%")
            ->take(5)
            ->get()
            ->map(fn($e) => [
                'id' => $e->id,
                'title' => $e->event_type,
                'description' => $e->description,
                'url' => route('events.show', $e->id),
            ]);

        $expenses = Expense::where('title', 'like', "%{$query}%")
            ->orWhere('description', 'like', "%{$query}%")
            ->take(5)
            ->get()
            ->map(fn($e) => [
                'id' => $e->id,
                'title' => $e->title,
                'description' => $e->description,
                'url' => route('expenses.show', $e->id),
            ]);

        $departments = Department::where('name', 'like', "%{$query}%")
            ->orWhere('description', 'like', "%{$query}%")
            ->take(5)
            ->get()
            ->map(fn($d) => [
                'id' => $d->id,
                'title' => $d->name,
                'description' => $d->description,
                'url' => route('departments.show', $d->id),
            ]);

        $financialRecords = FinancialRecord::where('type', 'like', "%{$query}%")
            ->orWhere('description', 'like', "%{$query}%")
            ->take(5)
            ->get()
            ->map(fn($f) => [
                'id' => $f->id,
                'title' => $f->type,
                'description' => $f->description,
                'url' => route('financial-records.show', $f->id),
            ]);

        $pledges = Pledge::where('name', 'like', "%{$query}%")
            ->orWhere('notes', 'like', "%{$query}%")
            ->take(5)
            ->get()
            ->map(fn($p) => [
                'id' => $p->id,
                'title' => $p->name,
                'description' => $p->notes,
                'url' => route('pledges.show', $p->id),
            ]);

        $sermons = Sermon::where('title', 'like', "%{$query}%")
            ->orWhere('summary', 'like', "%{$query}%")
            ->take(5)
            ->get()
            ->map(fn($s) => [
                'id' => $s->id,
                'title' => $s->title,
                'description' => $s->summary,
                'url' => route('sermons.show', $s->id),
            ]);

        $pastors = Pastor::where('name', 'like', "%{$query}%")
            ->orWhere('rank', 'like', "%{$query}%")
            ->take(5)
            ->get()
            ->map(fn($p) => [
                'id' => $p->id,
                'title' => $p->name,
                'description' => $p->rank,
                'url' => route('pastors.show', $p->id),
            ]);

        $equipments = Equipment::where('name', 'like', "%{$query}%")
            ->orWhere('description', 'like', "%{$query}%")
            ->take(5)
            ->get()
            ->map(fn($e) => [
                'id' => $e->id,
                'title' => $e->name,
                'description' => $e->description,
                'url' => route('equipments.show', $e->id),
            ]);

        return response()->json([
            'members' => $members,
            'events' => $events,
            'expenses' => $expenses,
            'departments' => $departments,
            'financialRecords' => $financialRecords,
            'pledges' => $pledges,
            'sermons' => $sermons,
            'pastors' => $pastors,
            'equipments' => $equipments,
        ]);
    }
}
