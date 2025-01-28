<div class="side-menu-fixed">
    <div class="scrollbar side-menu-bg" style="overflow: scroll">
        <ul class="nav navbar-nav side-menu" id="sidebarnav">
            <li>
                <a href="{{ route('b2b.home') }}">
                    <div class="pull-left"><i class="ti-home"></i><span class="right-nav-text"> @yield('title', 'Dashboard') </span>
                    </div>
                    <div class="clearfix"></div>
                </a>
            </li>
            <li class="mt-10 mb-10 text-muted pl-4 font-medium menu-title"> Actions </li>

            {{--  Home  --}}
            <li>
                <a href="{{ route('b2b.home') }}">
                    <div class="pull-left"><i class="fas fa-book"></i><span class="right-nav-text"> Home </span></div>
                    <div class="clearfix"></div>
                </a>
            </li>


            {{--  eSIM  --}}
            <li>
                <a href="{{ route('b2b.manage_esims.index') }}">
                    <div class="pull-left"><i class="fas fa-book"></i><span class="right-nav-text">eSIM</span></div>
                    <div class="clearfix"></div>
                </a>
            </li>


            {{--  API Integration  --}}
            <li>
                <a href="{{ route('b2b.api_integration.index') }}">
                    <div class="pull-left"><i class="fas fa-book"></i><span class="right-nav-text">API
                            Integration</span></div>
                    <div class="clearfix"></div>
                </a>
            </li>


            {{--  API Order  --}}
            <li>
                <a href="{{ route('b2b.api_orders.index') }}">
                    <div class="pull-left"><i class="fas fa-book"></i><span class="right-nav-text">API Order</span>
                    </div>
                    <div class="clearfix"></div>
                </a>
            </li>


            {{--  Credits  --}}
            <li>
                <a href="{{ route('b2b.credits.index') }}">
                    <div class="pull-left"><i class="fas fa-book"></i><span class="right-nav-text">Credits</span></div>
                    <div class="clearfix"></div>
                </a>
            </li>


            {{--  Billing  --}}
            <li>
                <a href="{{ route('b2b.billing.index') }}">
                    <div class="pull-left"><i class="fas fa-book"></i><span class="right-nav-text">Billing</span></div>
                    <div class="clearfix"></div>
                </a>
            </li>


            {{--  Analytics  --}}
            <li>
                <a href="{{ route('b2b.analytics.index') }}">
                    <div class="pull-left"><i class="fas fa-book"></i><span class="right-nav-text">Analytics</span>
                    </div>
                    <div class="clearfix"></div>
                </a>
            </li>


            {{--  Run Postman  --}}
            <li>
                <a href="{{ route('b2b.run_postman.index') }}">
                    <div class="pull-left"><i class="fas fa-book"></i><span class="right-nav-text">Run Postman</span>
                    </div>
                    <div class="clearfix"></div>
                </a>
            </li>

            {{--  API Documentation  --}}
            <li>
                <a href="{{ route('b2b.api_documents.index') }}">
                    <div class="pull-left"><i class="fas fa-book"></i><span class="right-nav-text">API
                            Documentation</span></div>
                    <div class="clearfix"></div>
                </a>
            </li>

            {{--  Profile  --}}
            <li>
                <a href="{{ route('b2b.user.index') }}">
                    <div class="pull-left"><i class="fas fa-book"></i><span class="right-nav-text">Profile</span></div>
                    <div class="clearfix"></div>
                </a>
            </li>

            {{--  Help  --}}
            <li>
                <a href="{{ route('b2b.faq.index') }}">
                    <div class="pull-left"><i class="fas fa-book"></i><span class="right-nav-text">FAQ</span></div>
                    <div class="clearfix"></div>
                </a>
            </li>



            {{--  Logout  --}}
            <li>
                <a href="{{ route('auth.logout') }}">
                    <div class="pull-left"><i class="fas fa-book"></i><span class="right-nav-text">Logout</span></div>
                    <div class="clearfix"></div>
                </a>
            </li>

        </ul>
    </div>
</div>
