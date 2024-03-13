<nav class="navbar navbar-expand-lg bg-light shadow-lg">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">
            <img src="{{ asset('assets/images/last.png') }}" class="logo img-fluid" alt="logo">
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">

            <ul class="navbar-nav ms-auto d-flex justify-content-center align-items-center">

                <!-- Search box for big screens -->
                <li class="d-none nav-item d-lg-block">
                    <form action="{{ route('companies.emptyposition.search') }}" method="GET" class="input-group">
                        <div id="search-autocomplete" class="form-outline" data-mdb-input-init>
                            <input type="search" class="form-control no-focus-outline" placeholder="city or country" name="query" aria-label="Search" aria-describedby="search-addon" require style="
                            border-radius: 0px;
                            border: 1px solid #ced4da;
                            border-right: none;
                            focus: none;
                            " />
                        </div>
                        <button type="submit" class="btn btn-info btn-sm" data-mdb-ripple-init>
                            <i class="mdi mdi-magnify"></i>
                        </button>
                    </form>
                </li>
                <!-- Search box for mobile screens -->
                <li class="nav-item d-lg-none mx-auto">
                    <form action="{{ route('companies.emptyposition.search') }}" method="GET" class="form-inline">
                        <div class="input-group">
                            <input type="text" class="form-control no-focus-outline" placeholder="search by city or country" aria-label="Search" name="query" aria-describedby="button-addon2" style="
                            border-radius: 0px;
                            border: 1px solid #ced4da;
                            border-right: none;
                            ">
                            <div class="input-group-append">
                                <button class="btn btn-info btn-sm" type="submit" id="button-addon2">
                                    <i class="mdi mdi-magnify"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('/') ? 'active' : 'inactive' }}" href="{{ route('home') }}">Home</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ Request::is('about') ? 'active' : 'inactive' }}" href="{{ route('about') }}">About</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ Request::is('service') ? 'active' : 'inactive' }}" href="{{ route('service') }}">Service</a>
                </li>

                @guest
                <li class="nav-item">
                    @if (request()->route()->getName() == 'companies.emptyposition.search.details' || request()->route()->getName() == 'companies.emptyposition.search')
                    <a class="nav-link {{ Request::is('signup') ? 'active' : '' }}" href="{{ route('signup.index',['routeName' => request()->route()->getName()]) }}">Signup</a>
                    @else
                    <a class="nav-link {{ Request::is('signup') ? 'active' : '' }}" href="{{ route('signup.index') }}">Signup</a>
                    @endif
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ Request::is('login') ? 'active' : 'inactive' }}" href="{{ route('login.index') }}">Login</a>
                </li>
                @endguest
                @auth
                @hasanyrole('admin|manager')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('companies') }}">Dashboard</a>
                </li>
                @endhasanyrole
                @hasanyrole('superadmin')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('superadmin') }}">Dashboard</a>
                </li>
                @endhasanyrole
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('logout') }}">Logout</a>
                </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>
