@extends('layouts.app')

@section('content')
<div class="card p-5 max-w-2xl">
    <h2 class="text-xl font-bold mb-4">Add Inspectorate</h2>

    <form action="{{ route('admin.inspectorates.store') }}" method="POST" class="space-y-4">
        @csrf
        <div>
            <label class="block mb-1">Name</label>
            <input class="input" type="text" name="name" value="{{ old('name') }}" required>
        </div>
        <div>
            <label class="block mb-1">Code</label>
            <input class="input" type="text" name="code" value="{{ old('code') }}" required>
        </div>
        <div>
            <label class="block mb-1">Description</label>
            <textarea class="input min-h-24" name="description">{{ old('description') }}</textarea>
        </div>
        <div class="flex gap-2">
            <button class="btn btn-primary" type="submit">Save</button>
            <a class="btn btn-secondary" href="{{ route('admin.inspectorates.index') }}">Back</a>
        </div>
    </form>
</div>
@endsection