@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-semibold">Edit Permission</h1>
        <a href="{{ route('permissions.index') }}" class="text-sm text-gray-600 hover:underline">Back</a>
    </div>

    @if ($errors->any())
        <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">
            <ul>
                @foreach ($errors->all() as $error) 
                    <li>{{ $error }}</li> 
                @endforeach
            </ul>
        </div>
    @endif

      <form action="{{ route('permissions.update', $permission->id) }}" method="POST" class="bg-white p-6 rounded shadow">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block font-medium text-gray-700">Permission Name</label>
            <input type="text" name="name" value="{{ old('name', $permission->name) }}" required class="mt-1 block w-full border-gray-300 rounded-md">
        </div>

        <div class="flex justify-end gap-2">
            <a href="{{ route('permissions.index') }}" class="px-4 py-2 bg-gray-100 rounded">Cancel</a>
            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded">Save</button>
        </div>
    </form>
</div>
@endsection
