<!DOCTYPE html>
<html lang="en">

<head>
    <title>CRM Login</title>
    <!-- HTML5 Shim and Respond.js IE10 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 10]>
		<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->
    <!-- Meta -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="Datta Able Bootstrap admin template made using Bootstrap 4 and it has huge amount of ready made feature, UI components, pages which completely fulfills any dashboard needs." />
    <meta name="keywords" content="admin templates, bootstrap admin templates, bootstrap 4, dashboard, dashboard templets, sass admin templets, html admin templates, responsive, bootstrap admin templates free download,premium bootstrap admin templates, datta able, datta able bootstrap admin template, free admin theme, free dashboard template"/>
    <meta name="author" content="CodedThemes"/>

    <!-- Favicon icon -->
    {{-- <link rel="icon" href="{{asset("public/assets/images/favicon.ico")}}" type="image/x-icon"> --}}
    <link rel="icon" href="https://ih1.redbubble.net/image.1794537282.6594/st,small,507x507-pad,600x600,f8f8f8.jpg"type="image/x-icon">
    <!-- fontawesome icon -->
    <link rel="stylesheet" href="{{asset("public/assets/fonts/fontawesome/css/fontawesome-all.min.css")}}">
    <!-- animation css -->
    <link rel="stylesheet" href="{{asset("public/assets/plugins/animation/css/animate.min.css")}}">
    <!-- vendor css -->
    <link rel="stylesheet" href="{{asset("public/assets/css/style.css")}}">

    <link rel="stylesheet" href="{{asset('public/assets/css/toast.css')}}">
    <link rel="stylesheet" href="{{asset('public/assets/css/confirm.css')}}">

</head>

<body>
    <div class="auth-wrapper">
        <div class="auth-content">
            <div class="auth-bg">
                <span class="r"></span>
                <span class="r s"></span>
                <span class="r s"></span>
                <span class="r"></span>
            </div>
            <div class="card">
                <div class="card-body text-center">
                    <form id="form_submit">
                        <div class="mb-4">
                            <i class="feather icon-unlock auth-icon"></i>
                        </div>
                        <h3 class="mb-4">Login</h3>
                        <div class="input-group mb-3">
                            <input type="email" class="form-control" name="email" placeholder="Email">
                        </div>
                        <div class="input-group mb-4">
                            <input type="password" class="form-control" name="password"  placeholder="password">
                        </div>
                        <div class="form-group text-left">
                            <div class="checkbox checkbox-fill d-inline">
                                <input type="checkbox" name="checkbox-fill-1" name=""  id="checkbox-fill-a1" checked="">
                                <label for="checkbox-fill-a1" class="cr"> Save Details</label>
                            </div>
                        </div>
                        <button class="btn btn-primary shadow-2 mb-4" type="submit">Login</button>
                        <p class="mb-2 text-muted">Forgot password? <a href="auth-reset-password.html">Reset</a></p>
                        <p class="mb-0 text-muted">Don’t have an account? <a href="{{url('signup')}}">Signup</a></p>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Required Js -->
<script src="{{asset("public/assets/js/vendor-all.min.js")}}"></script>
<script src="{{asset("public/assets/plugins/bootstrap/js/bootstrap.min.js")}}"></script>

<script src="{{asset('public/assets/js/toast.js')}}"></script>
<script src="{{asset('public/assets/js/toastDemo.js')}}"></script>


<script>
$('#load').hide();

    var options = {
    autoClose: true,
    progressBar: true,
    enableSounds: true,
    sounds: {
        info: "{{asset('public/assets/info.mp3')}}",
// path to sound for successfull message:
        success: "{{asset('public/assets/success.mp3')}}",
// path to sound for warn message:
        warning: "{{asset('public/assets/warning.mp3')}}",
// path to sound for error message:
        error: "{{asset('public/assets/error.mp3')}}",
    },
};

var toast = new Toasty(options);
toast.configure(options);
</script>


<script>

    $(function () {
        $('#form_submit').on('submit', function(e){
            e.preventDefault();
            let fd = new FormData(this);
            fd.append('_token',"{{ csrf_token() }}");
            $.ajax({
                url: "{{ route('user.login_submit') }}",
                type:"POST",
                data: fd,
                dataType: 'json',
                processData: false,
                contentType: false,
                beforeSend: function () {
                    $("#load").show();
                },
                success:function(result){
                    console.log(result);
                    if(result.status)
                    {
                        toast.success(result.msg);
                        setTimeout(function(){
                            window.location.href = result.location;
                        }, 500);
                    }
                    else
                    {
                        toast.error(result.msg);
                    }
                },
                complete: function () {
                    $("#load").hide();
                },
                error: function(jqXHR, exception) {
                }
            });
        })
    });
</script>

</body>
</html>
