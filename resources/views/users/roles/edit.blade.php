@extends('layouts.app')

@section('title', 'Edit User Roles')

@section('content')
<div class="container mx-auto py-6 max-w-3xl">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-semibold">Edit Roles — {{ $user->name ?? $user->email }}</h1>
        <a href="{{ route('users.roles.index') }}" class="text-sm text-gray-600 hover:underline">Back to users</a>
    </div>

    <form action="{{ route('users.roles.update', $user) }}" method="POST" class="bg-white p-6 rounded shadow-sm">
        @csrf

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-2">Assign Roles</label>
            <div class="grid grid-cols-2 gap-3">
                @foreach($roles as $role)
                    <label class="inline-flex items-center space-x-2">
                        <input type="checkbox" name="roles[]" value="{{ $role->name }}" {{ $user->hasRole($role->name) ? 'checked' : '' }} class="form-checkbox h-4 w-4 text-indigo-600">
                        <span class="text-sm text-gray-700">{{ $role->name }}</span>
                    </label>
                @endforeach
            </div>
        </div>

        <div class="flex justify-end">
            <a href="{{ route('users.roles.index') }}" class="mr-2 px-4 py-2 bg-gray-100 rounded">Cancel</a>
            <button class="px-4 py-2 bg-indigo-600 text-white rounded">Save Roles</button>
        </div>
    </form>
</div>
@endsection
