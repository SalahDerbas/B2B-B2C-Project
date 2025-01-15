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
                @include('layouts.sidebar')
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
