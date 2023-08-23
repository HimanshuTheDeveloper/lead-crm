{{-- <h1>coming soon</h1> --}}

@extends('layout.app')

@section('title')
<title>Profile</title>
@endsection

@section('extra_css')
<style>
  .fx_width {
    width: 8rem;
  }
  .field-icon {
  float: right;
  margin-left: -25px;
  margin-top: -25px;
  position: relative;
  z-index: 2;
}

.container{
  padding-top:50px;
  margin: auto;
}
</style>
@endsection

@section('content')

<div class="pcoded-main-container">
  <div class="pcoded-wrapper">
    <div class="pcoded-content">
      <div class="pcoded-inner-content">
        <!-- [ breadcrumb ] start -->
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route("user.dashboard")}}">Dashboard</a></li>
            {{-- <li class="breadcrumb-item"><a href="{{route("admin.profile")}}">Profile</a></li> --}}
            {{-- <li class="breadcrumb-item active" aria-current="page">Add Profile</li> --}}
          </ol>
        </nav>
        <!-- [ breadcrumb ] end -->
        <div class="main-body">
          <div class="page-wrapper">
   

            <form action="#" id="ProfileUpdate" method="POST" enctype="multipart/form-data">
                @csrf
            
            
                {{-- <input type="hidden" value="{{Auth::user()->id}}" name="id"> --}}
                <input type="hidden" id="name" class="form-control" name="user_id" value="{{Auth::user()->id}}">

                    <div class="row">   
            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Name*</label>
                                    <input value="{{Auth::user()->name}}" type="text" name="name" class="form-control" placeholder="Name" required autocomplete="off">
                                </div>
                            </div>                                   
            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label >Email</label >
                                        <input value="{{ Auth::user()->email}}" type="email" name="email" class="form-control">
                                 </div>
                            </div>
            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Change Password*</label>
                                    <input  id="password-field" type="password" name="password" class="form-control" placeholder="Change Password">
                                    <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                </div>
                            </div>
                        
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label >Phone Number</label>
                                        <input  value="{{Auth::user()->phone}}" class="form-control" name="phone">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label >Profile Image*</label>
                                        <input value="{{Auth::user()->profile_image}}" name="profile_image" type="file" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="status">Status</label>
                                    <select class="custom-select" value="{{Auth::user()->status}}" id="status" name="status" required>
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                    </div>
                         
                                <div class="row mb-0 float-right ">
                                    <div class="col-md-3 offset-md-1 ">
                                        <button type="submit" class="btn btn-success" style="margin-right:32px;">
                                            {{ __('Submit') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
            
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


@endsection

@section('extra_js')
<script>
    $(".toggle-password").click(function() {
    
    $(this).toggleClass("fa-eye fa-eye-slash");
    var input = $($(this).attr("toggle"));
    if (input.attr("type") == "password") {
      input.attr("type", "text");
    } else {
      input.attr("type", "password");
    }
    });    
    </script>
<script>
  $(function () {
    $('#ProfileUpdate').on('submit', function (e) {
      e.preventDefault()
      let fd = new FormData(this);
      fd.append('_token', "{{ csrf_token() }}");
      $.ajax({
        url: "{{ route('admin.update_profiles') }}",
        type: "POST",
        data: fd,
        dataType: 'json',
        processData: false,
        contentType: false,
        beforeSend: function () {
          $("#load").show();
        },
        success: function (result) {
          if (result.status) {
            toast.success(result.msg);
            setTimeout(function () {
              window.location.href = result.location;
            }, 2000);
          }
          else {
            toast.error(result.msg);
          }
        },
        complete: function () {
          $("#load").hide();
        },
        error: function (jqXHR, exception) {
        }
      });
    })
  });
</script>
@endsection