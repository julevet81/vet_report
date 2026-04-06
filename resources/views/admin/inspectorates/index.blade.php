@extends('layouts.app')

@section('content')
<div class="card p-5">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-xl font-bold">Wilaya Inspectorates</h2>
        <a class="btn btn-primary" href="{{ route('admin.inspectorates.create') }}">Add Inspectorate</a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
            <tr class="text-left text-slate-500">
                <th class="py-2">Name</th>
                <th>Code</th>
                <th>Branches</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @forelse($inspectorates as $inspectorate)
                <tr class="border-t border-slate-100">
                    <td class="py-2">{{ $inspectorate->name }}</td>
                    <td>{{ $inspectorate->code }}</td>
                    <td>{{ $inspectorate->branches_count }}</td>
                    <td>
                        <div class="flex gap-2">
                            <a class="btn btn-secondary" href="{{ route('admin.inspectorates.edit', $inspectorate) }}">Edit</a>
                            <form action="{{ route('admin.inspectorates.destroy', $inspectorate) }}" method="POST" onsubmit="return confirm('Delete this inspectorate?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-secondary" type="submit">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" class="py-4 text-slate-500">-</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $inspectorates->links() }}</div>
</div>
@endsection