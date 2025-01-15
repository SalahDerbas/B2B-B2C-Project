<div id="pre-loader">
    <img src="{{ URL::asset('Web/Dashboard/assets/images/Logo-SD.png') }}" alt="">
</div>
<nav class="admin-header navbar navbar-default col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
    <div class="text-left navbar-brand-wrapper">
        <img src="{{ URL::asset('Web/Dashboard/assets/images/Logo-SD.png') }}" alt="logo"><span style="margin-left: 10%;">@yield('title', 'Dashboard')</span>
    </div>
    <ul class="nav navbar-nav mr-auto">
        <li class="nav-item">
            <a id="button-toggle" class="button-toggle-nav inline-block ml-20 pull-left"
                href="javascript:void(0);"><i class="zmdi zmdi-menu ti-align-right"></i></a>
        </li>

    </ul>
    <ul class="nav navbar-nav ml-auto">

        <li class="nav-item fullscreen">
            <a id="btnFullscreen" href="#" class="nav-link"><i class="ti-fullscreen"></i></a>
        </li>
        <li class="nav-item dropdown mr-30">
            <a class="nav-link nav-pill user-avatar" data-toggle="dropdown" href="#" role="button"
                aria-haspopup="true" aria-expanded="false">
                <img src="{{ URL::asset('Web/Dashboard/assets/images/user_icon.png') }}" alt="avatar">


            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <div class="dropdown-header">
                    <div class="media">
                        <div class="media-body">
                            <h5 class="mt-0 mb-0">{{ Auth::user()->name }}</h5>
                            <span>{{ Auth::user()->email }}</span>
                        </div>
                    </div>
                </div>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="{{ route('auth.logout') }}"><i class="text-danger ti-unlock"></i> Logout </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="{{ route('b2b.user.index') }}"><i class="bi bi-currency-dollar"></i> <span> B2b Balance : <strong> {{Auth::user()->b2b_balance}}$ </strong> </span></a>
            </div>
        </li>
    </ul>
</nav>
