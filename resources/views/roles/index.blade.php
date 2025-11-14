@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-semibold">Roles</h1>
        <a href="{{ route('roles.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded">Add Role</a>
    </div>

    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
    @endif

    <table class="w-full table-auto border-collapse border border-gray-300">
        <thead>
            <tr class="bg-gray-100">
                <th class="px-4 py-2 border">#</th>
                <th class="px-4 py-2 border">Name</th>
                <th class="px-4 py-2 border">Permissions</th>
                <th class="px-4 py-2 border">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($roles as $role)
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-2 border">{{ $loop->iteration }}</td>
                <td class="px-4 py-2 border">{{ $role->name }}</td>
                <td class="px-4 py-2 border">
                    @if($role->permissions->isNotEmpty())
                        {{ $role->permissions->pluck('name')->join(', ') }}
                    @else
                        <span class="text-gray-400">No permissions</span>
                    @endif
                </td>
                <td class="px-4 py-2 border flex gap-2">
                    <a href="{{ route('roles.edit', $role->id) }}" class="text-blue-500">Edit</a>
                    <form action="{{ route('roles.destroy', $role->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-500">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
