@extends('layouts.app')

@section('content')
<div class="card p-5">
    <h2 class="text-xl font-bold mb-4">User Management</h2>

    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
            <tr class="text-left text-slate-500">
                <th class="py-2">Name</th>
                <th>Email</th>
                <th>Authority #</th>
                <th>Role</th>
                <th>Approval</th>
                <th>Branch</th>
                <th>Lang</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
                <tr class="border-t border-slate-100">
                    <td class="py-2">{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->veterinary_authority_number }}</td>
                    <td>
                        <form action="{{ route('admin.users.update', $user) }}" method="POST" class="flex gap-2 items-center">
                            @csrf
                            @method('PUT')
                            <select class="input" name="role">
                                <option value="admin" @selected($user->role === 'admin')>admin</option>
                                <option value="wilaya_inspector" @selected($user->role === 'wilaya_inspector')>wilaya_inspector</option>
                                <option value="branch_manager" @selected($user->role === 'branch_manager')>branch_manager</option>
                                <option value="private_vet" @selected($user->role === 'private_vet')>private_vet</option>
                            </select>
                    </td>
                    <td>{{ $user->approval_status }}</td>
                    <td>
                            <select class="input" name="branch_id">
                                <option value="">--</option>
                                @foreach($branches as $branch)
                                    <option value="{{ $branch->id }}" @selected((int) $user->branch_id === (int) $branch->id)>{{ $branch->wilaya }} - {{ $branch->name }}</option>
                                @endforeach
                            </select>
                    </td>
                    <td>
                            <select class="input" name="preferred_locale">
                                <option value="ar" @selected($user->preferred_locale === 'ar')>AR</option>
                                <option value="fr" @selected($user->preferred_locale === 'fr')>FR</option>
                            </select>
                    </td>
                    <td>
                            <button class="btn btn-primary" type="submit">Save</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $users->links() }}</div>
</div>
@endsection