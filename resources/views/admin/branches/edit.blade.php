@extends('layouts.app')

@section('content')
<div class="card p-5 max-w-2xl">
    <h2 class="text-xl font-bold mb-4">Edit Branch</h2>

    <form action="{{ route('admin.branches.update', $branch) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')
        <div>
            <label class="block mb-1">Name</label>
            <input class="input" type="text" name="name" value="{{ old('name', $branch->name) }}" required>
        </div>
        <div>
            <label class="block mb-1">Code</label>
            <input class="input" type="text" name="code" value="{{ old('code', $branch->code) }}" required>
        </div>
        <div>
            <label class="block mb-1">Inspectorate</label>
            <select class="input" name="wilaya_inspectorate_id" required>
                <option value="">--</option>
                @foreach($inspectorates as $inspectorate)
                    <option value="{{ $inspectorate->id }}" @selected((string) old('wilaya_inspectorate_id', $branch->wilaya_inspectorate_id) === (string) $inspectorate->id)>{{ $inspectorate->name }} ({{ $inspectorate->code }})</option>
                @endforeach
            </select>
        </div>
        <div class="flex gap-2">
            <button class="btn btn-primary" type="submit">Update</button>
            <a class="btn btn-secondary" href="{{ route('admin.branches.index') }}">Back</a>
        </div>
    </form>
</div>
@endsection