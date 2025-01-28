<div class="side-menu-fixed">
    <div class="scrollbar side-menu-bg" style="overflow: scroll">
        <ul class="nav navbar-nav side-menu" id="sidebarnav">
            <li>
                <a href="{{ route('admin.home') }}">
                    <div class="pull-left"><i class="ti-home"></i><span class="right-nav-text"> @yield('title', 'Dashboard') </span>
                    </div>
                    <div class="clearfix"></div>
                </a>
            </li>
            <li class="mt-10 mb-10 text-muted pl-4 font-medium menu-title"> Actions </li>

            {{--  Home  --}}
            <li>
                <a href="{{ route('admin.home') }}">
                    <div class="pull-left"><i class="fas fa-book"></i><span class="right-nav-text"> Home </span></div>
                    <div class="clearfix"></div>
                </a>
            </li>

            {{--  Admins  --}}
            <li>
                <a href="{{ route('admin.admins.index') }}">
                    <div class="pull-left"><i class="fas fa-book"></i><span class="right-nav-text"> Admins </span></div>
                    <div class="clearfix"></div>
                </a>
            </li>

            {{--  B2bs  --}}
            <li>
                <a href="{{ route('admin.b2bs.index') }}">
                    <div class="pull-left"><i class="fas fa-book"></i><span class="right-nav-text"> B2bs </span></div>
                    <div class="clearfix"></div>
                </a>
            </li>


            {{--  Payments  --}}
            <li>
                <a href="{{ route('admin.payments.index') }}">
                    <div class="pull-left"><i class="fas fa-book"></i><span class="right-nav-text"> Payments </span></div>
                    <div class="clearfix"></div>
                </a>
            </li>



            {{--  Sources  --}}
            <li>
                <a href="{{ route('admin.sources.index') }}">
                    <div class="pull-left"><i class="fas fa-book"></i><span class="right-nav-text"> Sources </span></div>
                    <div class="clearfix"></div>
                </a>
            </li>




            {{--  Billings  --}}
            <li>
                <a href="{{ route('admin.billings.index') }}">
                    <div class="pull-left"><i class="fas fa-book"></i><span class="right-nav-text"> Billings </span></div>
                    <div class="clearfix"></div>
                </a>
            </li>



            {{--  Categories  --}}
            <li>
                <a href="{{ route('admin.categories.index') }}">
                    <div class="pull-left"><i class="fas fa-book"></i><span class="right-nav-text"> Categories </span></div>
                    <div class="clearfix"></div>
                </a>
            </li>



            {{--  Countries  --}}
            <li>
                <a href="{{ route('admin.countries.index') }}">
                    <div class="pull-left"><i class="fas fa-book"></i><span class="right-nav-text"> Countries </span></div>
                    <div class="clearfix"></div>
                </a>
            </li>



            {{--  Items  --}}
            <li>
                <a href="{{ route('admin.items.index') }}">
                    <div class="pull-left"><i class="fas fa-book"></i><span class="right-nav-text"> Items </span></div>
                    <div class="clearfix"></div>
                </a>
            </li>



            {{--  Lookups  --}}
            <li>
                <a href="{{ route('admin.lookups.index') }}">
                    <div class="pull-left"><i class="fas fa-book"></i><span class="right-nav-text"> Lookups </span></div>
                    <div class="clearfix"></div>
                </a>
            </li>



            {{--  Orders  --}}
            <li>
                <a href="{{ route('admin.orders.index') }}">
                    <div class="pull-left"><i class="fas fa-book"></i><span class="right-nav-text"> Orders </span></div>
                    <div class="clearfix"></div>
                </a>
            </li>


            {{--  Promo Codes  --}}
            <li>
                <a href="{{ route('admin.promo_codes.index') }}">
                    <div class="pull-left"><i class="fas fa-book"></i><span class="right-nav-text"> Promo Codes </span></div>
                    <div class="clearfix"></div>
                </a>
            </li>



            {{--  User Promo Codes  --}}
            <li>
                <a href="{{ route('admin.user_promo_codes.index') }}">
                    <div class="pull-left"><i class="fas fa-book"></i><span class="right-nav-text"> User Promo Codes </span></div>
                    <div class="clearfix"></div>
                </a>
            </li>









        </ul>
    </div>
</div>
