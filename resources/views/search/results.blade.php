@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3 class="mb-4">Search Results for: <strong>{{ $query }}</strong></h3>

    @php
        $hasResults = 
            ($members ?? collect())->count() +
            ($events ?? collect())->count() +
            ($expenses ?? collect())->count() +
            ($departments ?? collect())->count() +
            ($financialRecords ?? collect())->count() +
            ($pledges ?? collect())->count() +
            ($sermons ?? collect())->count() +
            ($pastors ?? collect())->count() +
            ($equipments ?? collect())->count();
    @endphp

    @if ($hasResults === 0)
        <div class="alert alert-warning">No results found.</div>
    @else
        <div class="row">
            @foreach ([
                'Members' => $members ?? [],
                'Events' => $events ?? [],
                'Expenses' => $expenses ?? [],
                'Departments' => $departments ?? [],
                'Financial Records' => $financialRecords ?? [],
                'Pledges' => $pledges ?? [],
                'Sermons' => $sermons ?? [],
                'Pastors' => $pastors ?? [],
                'Equipment' => $equipments ?? []
            ] as $title => $collection)
                @if (count($collection))
                    <div class="col-md-6 mb-4">
                        <div class="card shadow-sm">
                            <div class="card-header bg-success text-white">
                                {{ $title }}
                            </div>
                            <div class="card-body">
                                <ul class="list-group">
                                    @foreach ($collection as $item)
                                        <li class="list-group-item">
                                            {{ $item->title ?? $item->name ?? $item->first_name ?? 'Unnamed' }}
                                            <small class="text-muted d-block">
                                                {{ $item->description ?? $item->email ?? '' }}
                                            </small>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    @endif
</div>
@endsection
