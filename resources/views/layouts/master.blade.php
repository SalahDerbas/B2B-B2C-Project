<!DOCTYPE html>
<html lang="en">
<head>
    <title>@yield('title', 'Dashboard')</title>
    @include('layouts.head')
</head>
<body style="font-family: 'Cairo', sans-serif">

    <div class="content wrapper" style="font-family: 'Cairo', sans-serif">
        @include('layouts.header')
        <div class="container-fluid">
            <div class="row">

                @if(Session::get('is_admin'))
                    @include('layouts.sidebar-admin')
                @else
                    @include('layouts.sidebar-b2b')
                @endif

                <div class="content-wrapper">
                    @include('layouts.page-title')
                    @yield('content')
                    @include('layouts.footer')

                </div>
             </div>
        </div>

    @include('layouts.scripts')
</body>
</html>
