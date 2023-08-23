@extends('layout.app')

@section('title')
    <title> 
        @role('bdm')     
            BDM
        @endrole
        @role('admin')     
            Admin
        @endrole
        @role('hr')     
            Hr
        @endrole
        Dashboard
    </title>
    <style>
        .font
        {
            font-size:1rem;
            color:white;
        }
        #bgcolor
        {
            background-color: #ec4611c9;
        }
        #bg1color
        {
            background-color: #9655ff;
        }
        #bg2color
        {
            background-color: #e734ab;
        }

        .themebackground{
            color: #7f3bff;
        }
    </style>
@endsection
@section('extra_css')
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    
@endsection

@section('content')
<div class="pcoded-main-container">
    <div class="pcoded-wrapper">
        <div class="pcoded-content">
            <div class="pcoded-inner-content">
                <!-- [ breadcrumb ] start -->

                <!-- [ breadcrumb ] end -->
                <div class="main-body">
                    <div class="page-wrapper">
                        <!-- [ Main Content ] start -->
                        <h2 class="text-white text-center mb-4 themebackground"> 

                            @role('bdm')     
                                BDM
                            @endrole

                            @role('admin')     
                                ADMIN
                            @endrole

                            @role('hr')     
                                HR
                            @endrole

                            @role('bde')     
                                BDE
                            @endrole

                            DASHBOARD

                        </h2>

                        <div class="row">
                            <div class="col-md-6 col-xl-4">
                                <div class="card daily-sales bg-primary">
                                    <div class="card-block">
                                        <h6 class="mb-3 font">Hot Leads</h6>
                                        <div class="row d-flex align-items-center">
                                            <div class="col-9">
                                                <h3 class="f-w-300 d-flex align-items-center m-b-0"><i class="fa fa-columns text-white f-30 m-r-10"></i></h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-center text-white">
                                       <a href="{{route('admin.hotLeads')}}" class=" text-white"><h6 class=" text-white"> <i class="fa fa-link" aria-hidden="true"></i> More Info</h6></a>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 col-xl-4">
                                <div class="card daily-sales bg-danger">
                                    <div class="card-block">
                                        <h6 class="mb-3 font">Followups Leads</h6>
                                        <div class="row d-flex align-items-center">
                                            <div class="col-9">
                                                <h3 class="f-w-300 d-flex align-items-center m-b-0"><i class="fas fa-comment text-white f-30 m-r-10"></i></h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-center text-white">
                                        <a href="{{route('admin.followupDashboard')}}" class=" text-white"><h6 class=" text-white"> <i class="fa fa-link" aria-hidden="true"></i> More Info</h6></a>
                                     </div>
                                </div>
                            </div>

                            <div class="col-md-6 col-xl-4">
                                <div class="card daily-sales" id="bgcolor">
                                    <div class="card-block">
                                        <h6 class="mb-3 font">Missed Leads</h6>
                                        <div class="row d-flex align-items-center">
                                            <div class="col-9">
                                                <h3 class="f-w-300 d-flex align-items-center m-b-0"><i class="fa fa-times text-white f-30 m-r-10"></i></h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-center text-white">
                                        <a href="{{route('admin.missingup')}}" class=" text-white"><h6 class=" text-white"> <i class="fa fa-link" aria-hidden="true"></i> More Info</h6></a>
                                     </div>
                                </div>
                            </div>


                            <div class="col-md-6 col-xl-4">
                                <div class="card daily-sales" id="bg1color">
                                    <div class="card-block">
                                        <h6 class="mb-3 font">Hosting Lookup Notification</h6>
                                        <div class="row d-flex align-items-center">
                                            <div class="col-9">
                                                <h3 class="f-w-300 d-flex align-items-center m-b-0"><i class="fab fa-github-square text-white f-30 m-r-10"></i></h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-center text-white">
                                        <a href="{{route('admin.hostings_lookup')}}" class=" text-white"><h6 class=" text-white"> <i class="fa fa-link" aria-hidden="true"></i> More Info</h6></a>
                                     </div>
                                </div>
                            </div>

                            @if(Auth::user()->hasRole('admin'))
                             
                            @endif


                           

                            @if(Auth::user()->hasRole('admin')|| Auth::user()->hasRole('bdm'))
                            
                            <div class="col-md-6 col-xl-4">
                                <div class="card daily-sales" id="bg2color">
                                    <div class="card-block">
                                        <h6 class="mb-3 font">AMC Expired Notification</h6>
                                        <div class="row d-flex align-items-center">
                                            <div class="col-9">
                                                <h3 class="f-w-300 d-flex align-items-center m-b-0"><i class="fa fa-book text-white f-30 m-r-10"></i></h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-center text-white">
                                        <a href="{{route('admin.amc_lookup')}}" class=" text-white"><h6 class=" text-white"> <i class="fa fa-link" aria-hidden="true"></i> More Info</h6></a>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 col-xl-4">
                                <div class="card daily-sales bg-success">
                                    <div class="card-block">
                                        <h6 class="mb-3 font">Hosting</h6>
                                        <div class="row d-flex align-items-center">
                                            <div class="col-9">
                                                <h3 class="f-w-300 d-flex align-items-center m-b-0"><i class="fab fa-github-square text-white f-30 m-r-10"></i></h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-center text-white">
                                        <a href="{{route('admin.hosting')}}" class=" text-white"><h6 class=" text-white"> <i class="fa fa-link" aria-hidden="true"></i> More Info</h6></a>
                                     </div>
                                </div>
                            </div>

                            <div class="col-md-6 col-xl-4">
                                <div class="card daily-sales bg-warning">
                                    <div class="card-block">
                                        <h6 class="mb-3 font">Domain</h6>
                                        <div class="row d-flex align-items-center">
                                            <div class="col-9">
                                                <h3 class="f-w-300 d-flex align-items-center m-b-0"><i class="fas fa-server text-white f-30 m-r-10"></i></h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-center text-white">
                                        <a href="{{route('admin.domain')}}" class=" text-white"><h6 class=" text-white"> <i class="fa fa-link" aria-hidden="true"></i> More Info</h6></a>
                                     </div>
                                </div>
                            </div>

                            <div class="col-md-6 col-xl-4">
                                <div class="card daily-sales bg-secondary">
                                    <div class="card-block">
                                        <h6 class="mb-3 font">Payment</h6>
                                        <div class="row d-flex align-items-center">
                                            <div class="col-9">
                                                <h3 class="f-w-300 d-flex align-items-center m-b-0"><i class="fa fa-credit-card text-white f-30 m-r-10"></i></h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-center text-white">
                                        <a href="{{route('admin.payments')}}" class=" text-white"><h6 class=" text-white"> <i class="fa fa-link" aria-hidden="true"></i> More Info</h6></a>
                                     </div>
                                </div>
                            </div>

                            <div class="col-md-6 col-xl-4">
                                <div class="card daily-sales bg-info">
                                    <div class="card-block">
                                        <h6 class="mb-3 font">Expenses</h6>
                                        <div class="row d-flex align-items-center">
                                            <div class="col-9">
                                                <h3 class="f-w-300 d-flex align-items-center m-b-0"><i class="fas fa-landmark text-white f-30 m-r-10"></i></h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-center text-white">
                                        <a href="{{route("admin.expense")}}" class=" text-white"><h6 class=" text-white"> <i class="fa fa-link" aria-hidden="true"></i> More Info</h6></a>
                                     </div>
                                </div>
                            </div>

                            <div class="col-md-6 col-xl-4">
                                <div class="card daily-sales bg-dark">
                                    <div class="card-block">
                                        <h6 class="mb-3 font">Revenue</h6>
                                        <div class="row d-flex align-items-center">
                                            <div class="col-9">
                                                <h3 class="f-w-300 d-flex align-items-center m-b-0"><i class="fas fa-rupee text-white f-30 m-r-10"></i></h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-center text-white">
                                        <a href="{{route("admin.revenue")}}" class=" text-white"><h6 class=" text-white"> <i class="fa fa-link" aria-hidden="true"></i> More Info</h6></a>
                                     </div>
                                </div>
                            </div>




                            @endif
                        </div>
                        
                        <!-- [ Main Content ] end -->
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('extra_js')
    
@endsection