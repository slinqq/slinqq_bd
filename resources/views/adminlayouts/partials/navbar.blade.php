<nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
    <div class="navbar-brand-wrapper d-flex justify-content-center">
        <div class="navbar-brand-inner-wrapper d-flex justify-content-between align-items-center w-100">
            <a class="navbar-brand brand-logo" href="{{ route('home') }}"><img src="{{ asset('assets/images/Slinqq.png') }}" alt="logo" /></a>
            <a class="navbar-brand brand-logo-mini" href="{{ route('home') }}"><img src="{{ asset('assets/images/Slinqq.png') }}" alt="logo" /></a>
            <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
                <span class="mdi mdi-sort-variant"></span>
            </button>
        </div>
    </div>
    <div class="navbar-menu-wrapper d-flex align-items-center @if (Route::currentRouteName() == 'company.manage') justify-content-between @else justify-content-end @endif"> <!-- <ul class="navbar-nav mr-lg-4 w-100">
            <li class="nav-item nav-search d-lg-block d-md-block d-sm-block w-100">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="search">
                            <i class="mdi mdi-magnify"></i>
                        </span>
                    </div>
                    <input type="text" class="form-control" placeholder="Search specific member" aria-label="search" aria-describedby="search">
                </div>
            </li>
        </ul> -->
        @if (Route::currentRouteName() == 'company.manage')
        <ul class="navbar-nav mr-lg-4 w-50">
            <li class="nav-item nav-search d-none d-lg-block d-md-block w-75">
                <form method="POST" action="{{ route('company.manage',['companyId' => request('companyId')]) }}" class="d-flex">
                    @csrf
                    @method('GET')

                    <input name="search" type="text" class="form-control w-100" placeholder="Search by flat id" aria-label="search" aria-describedby="search">
                    <div class="input-group-prepend">
                        <button class="input-group-text bg-secondary" id="search" style="cursor:pointer;" type="submit">
                            <i class="mdi mdi-magnify text-white"></i>
                        </button>
                    </div>
                </form>
            </li>
        </ul>
        @endif

        <div>
            <ul class="navbar-nav navbar-nav-right">
                <li class="nav-item dropdown me-4">
                    <a class="nav-link count-indicator dropdown-toggle d-flex align-items-center justify-content-center notification-dropdown" id="notificationDropdown" href="#" data-bs-toggle="dropdown">
                        <i class="fa-solid fa-circle-chevron-down mx-0 text-secondary"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="notificationDropdown">
                        <a class="dropdown-item" href="{{ route('notification.companies.all') }}">
                            <div class="item-thumbnail">
                                <div class="item-icon bg-success">
                                    <i class="mdi mdi-bell mx-0"></i>
                                </div>
                            </div>
                            <div class="item-content">
                                <h6 class="font-weight-normal">Notice all of members</h6>
                            </div>
                        </a>

                        @if (Route::currentRouteName() == 'company.manage')
                        <a class="dropdown-item" href="{{ route('notification.company.all',['companyId'=>request('companyId')]) }}">
                            <div class="item-thumbnail">
                                <div class="item-icon bg-danger">
                                    <i class="mdi mdi-bell mx-0"></i>
                                </div>
                            </div>
                            <div class="item-content">
                                <h6 class="font-weight-normal">Notice to all under this building</h6>
                            </div>
                        </a>
                        @endif
                        @if(Route::currentRouteName() == 'member.edit')
                        <a class="dropdown-item" href="{{ route('notification.specific.member.form', ['companyId' => $company->id,'sectionId' => $section->id, 'memberId' => $member->id]) }}">
                            <div class="item-thumbnail">
                                <div class="item-icon bg-warning">
                                    <i class="mdi mdi-bell mx-0"></i>
                                </div>
                            </div>
                            <div class="item-content">
                                <h6 class="font-weight-normal">Notice for specific member</h6>
                            </div>
                        </a>
                        @endif

                        <a href="{{ route('companies.payment.collection') }}" class="dropdown-item">
                            <div class="item-thumbnail">
                                <div class="item-icon bg-info">
                                    <i class="mdi mdi-currency-usd mx-0"></i>
                                </div>
                            </div>
                            <div class="item-content">
                                <h6 class="font-weight-normal">Chek payment collection</h6>
                            </div>
                        </a>

                        @if (Route::currentRouteName() == 'company.manage')

                        <a class="dropdown-item" href="{{ route('company.manage',['companyId' => request('companyId'), 'payment' => 'paid']) }}">
                            <div class="item-thumbnail">
                                <div class="item-icon bg-secondary">
                                    <i class="mdi mdi-alpha-p-circle mx-0"></i>
                                </div>
                            </div>
                            <div class="item-content">
                                <h6 class="font-weight-normal">Check who completed payment</h6>
                            </div>
                        </a>

                        <a class="dropdown-item" href="{{ route('company.manage',['companyId' => request('companyId'), 'payment' => 'unpaid']) }}">
                            <div class="item-thumbnail">
                                <div class="item-icon bg-dark">
                                    <i class="mdi mdi-alert-circle mx-0"></i>
                                </div>
                            </div>
                            <div class="item-content">
                                <h6 class="font-weight-normal">Chek who didn't completed payment</h6>
                            </div>
                        </a>

                        <a class="dropdown-item" href="{{ route('company.manage',['companyId' => request('companyId'), 'member' => 'empty']) }}">
                            <div class="item-thumbnail">
                                <div class="item-icon bg-info">
                                    <i class="mdi mdi-account-box mx-0"></i>
                                </div>
                            </div>
                            <div class="item-content">
                                <h6 class="font-weight-normal">Chek who's member place is empty</h6>
                            </div>
                        </a>

                        @endif

                        <!-- <a class="dropdown-item" href="">
                            <div class="item-thumbnail">
                                <div class="item-icon bg-primary">
                                    <i class="mdi mdi-magnify mx-0"></i>
                                </div>
                            </div>
                            <div class="item-content">
                                <h6 class="font-weight-normal">Search Mmeber</h6>
                            </div>
                        </a> -->
                    </div>
                </li>
            </ul>
        </div>


        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
            <span class="mdi mdi-menu"></span>
        </button>
    </div>
</nav>
