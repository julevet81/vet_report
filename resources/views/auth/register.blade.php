@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto card p-6">
    <h2 class="text-2xl font-bold mb-5">{{ __('messages.register') }}</h2>

    <form action="{{ route('register.store') }}" method="POST" class="grid md:grid-cols-2 gap-4">
        @csrf

        <div>
            <label class="block mb-1">{{ __('messages.full_name') }}</label>
            <input class="input" type="text" name="name" value="{{ old('name') }}" required>
        </div>

        <div>
            <label class="block mb-1">{{ __('messages.email') }}</label>
            <input class="input" type="email" name="email" value="{{ old('email') }}" required>
        </div>

        <div>
            <label class="block mb-1">{{ __('messages.authority_number') }}</label>
            <input class="input" type="text" name="veterinary_authority_number" value="{{ old('veterinary_authority_number') }}" required>
        </div>

        <div>
            <label class="block mb-1">{{ __('messages.role') }}</label>
            <select class="input" name="role" required>
                <option value="private_vet" @selected(old('role') === 'private_vet')>{{ __('messages.private_vet') }}</option>
                <option value="branch_manager" @selected(old('role') === 'branch_manager')>{{ __('messages.branch_manager') }}</option>
                <option value="wilaya_inspector" @selected(old('role') === 'wilaya_inspector')>{{ __('messages.wilaya_inspector') }}</option>
            </select>
        </div>

        <div>
            <label class="block mb-1">{{ __('messages.branch') }}</label>
            <select class="input" name="branch_id" id="branch_id" required>
                <option value="">--</option>
                @foreach($branches as $branch)
                    <option data-wilaya="{{ $branch->wilaya }}" value="{{ $branch->id }}" @selected((string) old('branch_id') === (string) $branch->id)>{{ $branch->wilaya }} - {{ $branch->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block mb-1">{{ __('messages.language') }}</label>
            <select class="input" name="preferred_locale" required>
                <option value="ar" @selected(old('preferred_locale') === 'ar')>العربية</option>
                <option value="fr" @selected(old('preferred_locale') === 'fr')>Francais</option>
            </select>
        </div>

        <div>
            <label class="block mb-1">{{ __('messages.wilaya') }}</label>
            <input class="input" type="text" id="wilaya_input" name="wilaya" value="{{ old('wilaya') }}" placeholder="تحدد تلقائيا من الفرع" readonly>
        </div>

        <div>
            <label class="block mb-1">{{ __('messages.password') }}</label>
            <input class="input" type="password" name="password" required>
        </div>

        <div>
            <label class="block mb-1">{{ __('messages.password_confirmation') }}</label>
            <input class="input" type="password" name="password_confirmation" required>
        </div>

        <div class="md:col-span-2">
            <button class="btn btn-primary w-full" type="submit">{{ __('messages.register') }}</button>
        </div>
    </form>

    <p class="mt-4 text-sm"><a class="text-emerald-700 font-bold" href="{{ route('login') }}">{{ __('messages.login') }}</a></p>
</div>
@endsection