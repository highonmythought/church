@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-semibold mb-4">Create Role</h1>

    <form action="{{ route('roles.store') }}" method="POST" class="bg-white p-6 rounded shadow">
        @csrf

        <div class="mb-4">
            <label class="block font-medium text-gray-700">Role Name</label>
            <input type="text" name="name" value="{{ old('name') }}" required class="mt-1 block w-full border-gray-300 rounded-md">
        </div>

        <div class="mb-4">
            <label class="block font-medium text-gray-700 mb-2">Permissions</label>
            <div class="grid grid-cols-2 gap-2">
                @foreach($permissions as $permission)
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="permissions[]" value="{{ $permission->id }}"
                               class="form-checkbox" 
                               @if(is_array(old('permissions')) && in_array($permission->id, old('permissions'))) checked @endif>
                        <span class="ml-2">{{ $permission->name }}</span>
                    </label>
                @endforeach
            </div>
        </div>

        <div class="flex justify-end gap-2">
            <a href="{{ route('roles.index') }}" class="px-4 py-2 bg-gray-100 rounded">Cancel</a>
            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded">Save</button>
        </div>
    </form>
</div>
@endsection
