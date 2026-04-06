@extends('layouts.app')

@section('content')
<div class="card p-5">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-xl font-bold">Branches</h2>
        <a class="btn btn-primary" href="{{ route('admin.branches.create') }}">Add Branch</a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
            <tr class="text-left text-slate-500">
                <th class="py-2">Name</th>
                <th>Code</th>
                <th>Inspectorate</th>
                <th>Wilaya</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @forelse($branches as $branch)
                <tr class="border-t border-slate-100">
                    <td class="py-2">{{ $branch->name }}</td>
                    <td>{{ $branch->code }}</td>
                    <td>{{ $branch->inspectorate?->name }}</td>
                    <td>{{ $branch->wilaya }}</td>
                    <td>
                        <div class="flex gap-2">
                            <a class="btn btn-secondary" href="{{ route('admin.branches.edit', $branch) }}">Edit</a>
                            <form action="{{ route('admin.branches.destroy', $branch) }}" method="POST" onsubmit="return confirm('Delete this branch?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-secondary" type="submit">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="py-4 text-slate-500">-</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $branches->links() }}</div>
</div>
@endsection