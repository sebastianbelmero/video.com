<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav me-auto">
                    
                </ul>
                
                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ms-auto">
                    <!-- Authentication Links -->
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ Auth::user()->name }}
                    </a>
                    
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>
                                
                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                class="d-none">
                                @csrf
                            </form>
                        </div>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        
        <div class="d-flex justify-content-between py-5 px-5 mx-auto gap-3">
            <div class="col-2">
                <aside>
                    <div class="card">
                        <ul class="list-group list-group-flush">
                            <a href="{{ route('admin.dashboard') }}" class="list-group-item nav-link {{ request()->is('admin') ? 'active' : '' }}">Dashboard</a>
                            <a href="#" class="list-group-item nav-link">Users</a>
                            <a href="{{ route('admin.categories.index') }}" class="list-group-item nav-link {{ request()->is('admin/categories') ? 'active' : '' }}">Categories</a>
                            <a href="{{ route('admin.videos.index') }}" class="list-group-item nav-link {{ request()->is('admin/videos') ? 'active' : '' }}">Videos</a>
                            <a href="#" class="list-group-item nav-link">Comments</a>
                        </ul>
                    </div>
                </aside>
            </div>
            <div class="col-10">
                <div class="card"">
                    <div class=" card-header">
                        @yield('title')
                    </div>
                    <div class="card-body">
                        @yield('content')
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Scripts -->
<script src="{{ asset('js/app.js') }}" defer></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@stack('custom-scripts')
</body>

</html>
