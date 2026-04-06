@extends('layouts.app')

@section('content')
<div class="card p-5">
    <h2 class="text-xl font-bold mb-4">{{ __('messages.approvals') }}</h2>

    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="text-slate-500 text-left">
                    <th class="py-2">{{ __('messages.full_name') }}</th>
                    <th>{{ __('messages.email') }}</th>
                    <th>{{ __('messages.role') }}</th>
                    <th>{{ __('messages.wilaya') }}</th>
                    <th>{{ __('messages.branch') }}</th>
                    <th>{{ __('messages.actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pendingUsers as $pendingUser)
                    <tr class="border-t border-slate-100">
                        <td class="py-2">{{ $pendingUser->name }}</td>
                        <td>{{ $pendingUser->email }}</td>
                        <td>{{ __('messages.'.$pendingUser->role) }}</td>
                        <td>{{ $pendingUser->wilaya }}</td>
                        <td>{{ $pendingUser->branch?->name }}</td>
                        <td>
                            <div class="flex gap-2">
                                <form action="{{ route('approvals.approve', $pendingUser) }}" method="POST">
                                    @csrf
                                    <button class="btn btn-primary" type="submit">{{ __('messages.approve') }}</button>
                                </form>
                                <form action="{{ route('approvals.reject', $pendingUser) }}" method="POST">
                                    @csrf
                                    <button class="btn btn-secondary" type="submit">{{ __('messages.reject') }}</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="py-4 text-slate-500">-</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection