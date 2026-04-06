@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto card p-6">
    <h2 class="text-2xl font-bold mb-5">{{ __('messages.login') }}</h2>

    <form action="{{ route('login.store') }}" method="POST" class="space-y-4">
        @csrf
        <div>
            <label class="block mb-1">{{ __('messages.email') }}</label>
            <input class="input" type="email" name="email" value="{{ old('email') }}" required>
        </div>
        <div>
            <label class="block mb-1">{{ __('messages.password') }}</label>
            <input class="input" type="password" name="password" required>
        </div>
        <button class="btn btn-primary w-full" type="submit">{{ __('messages.login') }}</button>
    </form>

    <p class="mt-4 text-sm">
        <a class="text-emerald-700 font-bold" href="{{ route('register') }}">{{ __('messages.register') }}</a>
    </p>
</div>
@endsection
