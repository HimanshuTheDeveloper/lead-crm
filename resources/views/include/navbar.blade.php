<nav class="pcoded-navbar">
    <div class="navbar-wrapper">
        <div class="navbar-brand header-logo">
            <a href="{{route("user.dashboard")}}" class="b-brand">
                <img src="https://ih1.redbubble.net/image.1794537282.6594/st,small,507x507-pad,600x600,f8f8f8.jpg" style="width:30px;">
                {{-- <div class="b-bg"> --}}
                    {{-- <i class="feather icon-trending-up"></i> --}}
                {{-- </div> --}}
                <span class="b-title">Bytelogic CRM</span>
                <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
                {{-- <span class="b-title">
                    <img src="https://www.bytelogicindia.com/wp-content/uploads/2020/09/bytelogiclogo.png" class="w-75">
                </span> --}}
            </a>
            <a class="mobile-menu" id="mobile-collapse" href="javascript:"><span></span></a>
        </div>
        <div class="navbar-content scroll-div">
            <ul class="nav pcoded-inner-navbar">
                <li class="nav-item pcoded-menu-caption">
                    <label>Navigation</label>
                </li>
                <li data-username="dashboard Default Ecommerce CRM Analytics Crypto Project" class="nav-item ">
                    <a href="{{route("user.dashboard")}}" class="nav-link "><span class="pcoded-micon"><i class="feather icon-home"></i></span><span class="pcoded-mtext">Dashboard</span></a>
                </li>

                @role('admin')
                    <li data-username="dashboard Default Ecommerce CRM Analytics Crypto Project" class="nav-item ">
                        <a href="{{route("admin.users")}}" class="nav-link "><span class="pcoded-micon"><i class="fa fa-users" aria-hidden="true"></i></span><span class="pcoded-mtext">Users</span></a>
                    </li>
                    <li data-username="dashboard Default Ecommerce CRM Analytics Crypto Project" class="nav-item ">
                        <a href="{{route("admin.roles")}}" class="nav-link "><span class="pcoded-micon"><i class="fa fa-tasks" aria-hidden="true"></i></span><span class="pcoded-mtext">Roles</span></a>
                    </li>
                @endrole
                
                <li data-username="form elements advance componant validation masking wizard picker select" class="nav-item">
                    <a href="{{route('admin.leads')}}" class="nav-link "><span class="pcoded-micon"><i class="fa fa-columns"></i></span><span class="pcoded-mtext">Leads</span></a>
                </li>

                <li data-username="form elements advance componant validation masking wizard picker select" class="nav-item">
                    <a href="{{route('admin.clients')}}" class="nav-link "><span class="pcoded-micon"><i class="fa fa-user" aria-hidden="true"></i></span><span class="pcoded-mtext">Clients</span></a>
                </li>
                @if(Auth::user()->hasRole('admin')|| Auth::user()->hasRole('bdm'))
                <li data-username="form elements advance componant validation masking wizard picker select" class="nav-item">
                    <a href="{{route('admin.payments')}}" class="nav-link "><span class="pcoded-micon"><i class="fa fa-credit-card"></i></span><span class="pcoded-mtext">Payment</span></a>
                </li>
                
                <li data-username="form elements advance componant validation masking wizard picker select" class="nav-item">
                    <a href="{{route('admin.amc')}}" class="nav-link "><span class="pcoded-micon"><i class="feather icon-file-text"></i></span><span class="pcoded-mtext">AMC</span></a>
                </li>

                <li data-username="form elements advance componant validation masking wizard picker select" class="nav-item">
                    <a href="{{route('admin.hosting')}}" class="nav-link "><span class="pcoded-micon"><i class="fab fa-github-square"></i></span><span class="pcoded-mtext">Hosting</span></a>
                </li>
                <li data-username="form elements advance componant validation masking wizard picker select" class="nav-item">
                    <a href="{{route('admin.domain')}}" class="nav-link "><span class="pcoded-micon"><i class="fas fa-server"></i></span><span class="pcoded-mtext">Domain</span></a>
                </li>
                @endif

                @role('admin')
                <li data-username="form elements advance componant validation masking wizard picker select" class="nav-item">
                    <a href="{{route('admin.expense')}}" class="nav-link "><span class="pcoded-micon"><i class="fas fa-dollar"></i></span><span class="pcoded-mtext">Expenses</span></a>
                </li>
                {{-- <li data-username="form elements advance componant validation masking wizard picker select" class="nav-item">
                    <a href="{{route('admin.invoice_view')}}" class="nav-link "><span class="pcoded-micon"><i class="fas fa-file"></i></span><span class="pcoded-mtext">Invoice</span></a>
                </li> --}}

                <li data-username="form elements advance componant validation masking wizard picker select" class="nav-item">
                    <a href="{{route("admin.revenue")}}" class="nav-link "><span class="pcoded-micon"><i class="fa fa-money"></i></span><span class="pcoded-mtext">Revenue</span></a>
                </li>

               
                @endrole

        
            </ul>
        </div>
    </div>
</nav>