<!DOCTYPE html>
<html lang="en">

<head>
    @yield('title')
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="Free Datta Able Admin Template come up with latest Bootstrap 4 framework with basic components, form elements and lots of pre-made layout options" />
    <meta name="keywords" content="admin templates, bootstrap admin templates, bootstrap 4, dashboard, dashboard templets, sass admin templets, html admin templates, responsive, bootstrap admin templates free download,premium bootstrap admin templates, datta able, datta able bootstrap admin template, free admin theme, free dashboard template"/>
    <meta name="author" content="CodedThemes"/>

    <!-- Favicon icon -->
    {{-- <link rel="icon" href="{{asset("public/assets/images/favicon.ico")}}"type="image/x-icon"> --}}
    <link rel="icon" href="https://ih1.redbubble.net/image.1794537282.6594/st,small,507x507-pad,600x600,f8f8f8.jpg"type="image/x-icon">
    <!-- fontawesome icon -->
    <link rel="stylesheet" href="{{asset("public/assets/fonts/fontawesome/css/fontawesome-all.min.css")}}">
    <!-- animation css -->
    <link rel="stylesheet" href="{{asset("public/assets/plugins/animation/css/animate.min.css")}}">
    <!-- vendor css -->
    <link rel="stylesheet" href="{{asset("public/assets/css/style.css")}}">

    
    <link rel="stylesheet" href="{{asset('public/assets/css/toast.css')}}">
    <link rel="stylesheet" href="{{asset('public/assets/css/confirm.css')}}">
    
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.13.1/datatables.min.css"/>

    <meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    
    @yield('extra_css')

    <style>
        body{
            color: #000 !important;





            /* background: #cfe4ff; */
            /* background: #ffc8c6; */
            /* background-image: url("https://source.unsplash.com/random/1600×900/?nature"); */
            background:linear-gradient(0deg, rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.3)), url(https://source.unsplash.com/random/1600×900/?nature);
            background-repeat:no-repeat;
            background-position: center center;
            background-size: cover;



                    
        }


        
        .card{
            background: #ffffffe6;
        }



        table.table-bordered.dataTable th, table.table-bordered.dataTable td {
            border-left-width: 0;
            padding: 8px;
        }



    </style>

</head>

<body>
  
    <!-- [ Pre-loader ] start -->


    {{-- <div class="loader-bg">
        <div class="loader-track">
            <div class="loader-fill"></div>
        </div>
    </div> --}}

    @include('include.navbar')
    @include('include.header')
    @include('include.sidebar')
    
    @yield('content')
    
    @include('include.footer')
    <script src="{{asset("public/assets/js/vendor-all.min.js")}}"></script>
	<script src="{{asset("public/assets/plugins/bootstrap/js/bootstrap.min.js")}}"></script>
    <script src="{{asset("public/assets/js/pcoded.min.js")}}"></script>

    <script src="{{ asset('public/assets/js/confirm.js') }}"></script>
    <script src="{{asset('public/assets/js/toast.js')}}"></script>
    <script src="{{asset('public/assets/js/toastDemo.js')}}"></script>

    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.13.1/datatables.min.js"></script>

    <script>
      
        $('#load').hide();
            var options = {
            autoClose: true,
            progressBar: true,
            enableSounds: true,
            sounds: {
                info: "{{asset('public/assets/info.mp3')}}",
                success: "{{asset('public/assets/success.mp3')}}",
                warning: "{{asset('public/assets/warning.mp3')}}",
                error: "{{asset('public/assets/error.mp3')}}",
            },
        };
        
        var toast = new Toasty(options);
        toast.configure(options);
        </script>
        

  @yield('extra_js')
</body>


</html>
