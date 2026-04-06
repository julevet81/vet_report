<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('messages.app_name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="app-shell">
        <header class="layout-top">
            <div class="layout-top-inner">
                <div>
                    <strong class="text-emerald-800">{{ __('messages.app_name') }}</strong>
                </div>
                @auth
                    <div class="flex items-center gap-2 flex-wrap">
                        <a class="btn btn-secondary" href="{{ request()->fullUrlWithQuery(['lang' => 'ar']) }}">AR</a>
                        <a class="btn btn-secondary" href="{{ request()->fullUrlWithQuery(['lang' => 'fr']) }}">FR</a>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button class="btn btn-secondary" type="submit">{{ __('messages.logout') }}</button>
                        </form>
                    </div>
                @endauth
            </div>
        </header>

        @auth
            <aside class="layout-sidebar card p-4">
                <p class="text-sm text-slate-600 mb-4">
                    {{ auth()->user()->name }}<br>
                    {{ __('messages.'.auth()->user()->role) }}
                </p>

                <nav class="space-y-2">
                    <a class="{{ request()->routeIs('dashboard') ? 'btn btn-primary w-full justify-start' : 'btn btn-secondary w-full justify-start' }}" href="{{ route('dashboard') }}">{{ __('messages.dashboard') }}</a>

                    <a class="{{ request()->routeIs('reports.index') || request()->routeIs('reports.show') ? 'btn btn-primary w-full justify-start' : 'btn btn-secondary w-full justify-start' }}" href="{{ route('reports.index') }}">{{ __('messages.reports') }}</a>

                    @if(auth()->user()->isRole('private_vet'))
                        <a class="{{ request()->routeIs('reports.create') ? 'btn btn-primary w-full justify-start' : 'btn btn-secondary w-full justify-start' }}" href="{{ route('reports.create') }}">{{ __('messages.new_report') }}</a>
                    @endif

                    @if(in_array(auth()->user()->role, ['branch_manager', 'wilaya_inspector', 'admin'], true))
                        <a class="{{ request()->routeIs('approvals.*') ? 'btn btn-primary w-full justify-start' : 'btn btn-secondary w-full justify-start' }}" href="{{ route('approvals.index') }}">{{ __('messages.approvals') }}</a>
                    @endif

                    @if(auth()->user()->isRole('admin'))
                        <a class="{{ request()->routeIs('admin.users.*') ? 'btn btn-primary w-full justify-start' : 'btn btn-secondary w-full justify-start' }}" href="{{ route('admin.users.index') }}">Users</a>
                        <a class="{{ request()->routeIs('admin.inspectorates.*') ? 'btn btn-primary w-full justify-start' : 'btn btn-secondary w-full justify-start' }}" href="{{ route('admin.inspectorates.index') }}">Inspectorates</a>
                        <a class="{{ request()->routeIs('admin.branches.*') ? 'btn btn-primary w-full justify-start' : 'btn btn-secondary w-full justify-start' }}" href="{{ route('admin.branches.index') }}">Branches</a>
                    @endif
                </nav>
            </aside>

            <main class="layout-main">
                @if(session('status'))
                    <div class="card p-3 mb-4 text-emerald-900">{{ session('status') }}</div>
                @endif

                @if ($errors->any())
                    <div class="card p-3 mb-4 text-rose-700">
                        <ul class="list-disc px-6">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </main>
        @else
            <main class="layout-main-guest">
                @if(session('status'))
                    <div class="card p-3 mb-4 text-emerald-900">{{ session('status') }}</div>
                @endif

                @if ($errors->any())
                    <div class="card p-3 mb-4 text-rose-700">
                        <ul class="list-disc px-6">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </main>
        @endauth

        <footer class="layout-footer">
            <div class="layout-footer-inner text-sm">
                <span>{{ __('messages.app_name') }}</span>
                <span>{{ now()->format('Y') }}</span>
            </div>
        </footer>
    </div>
</body>
</html>