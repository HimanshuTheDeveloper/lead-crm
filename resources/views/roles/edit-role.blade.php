@extends('layout.app')

@section('title')
    <title>Roles</title>
@endsection

@section('extra_css')
<style>
    .fx_width{
      width: 8rem;
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
                      <li class="breadcrumb-item"><a href="{{route("admin.roles")}}">Roles</a></li>
                      <li class="breadcrumb-item active" aria-current="page">Edit Role</li>
                    </ol>
                  </nav>
                <!-- [ breadcrumb ] end -->
                <div class="main-body">
                    <div class="page-wrapper">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex justify-content-between">
                                    <h3 class="card-title">Edit Role</h3>
                                </div>
                              </div>
                            <div class="card-body">
                                <form id="roleAdd">
                                    <div class="row mb-3">
                                      <div class="col-md-5">
                                        <label for="name">Name *</label>
                                        <input type="hidden" id="name" class="form-control" name="id"  value="{{$role->id}}">
                                        <input type="text" id="name" class="form-control" name="name"  value="{{$role->name}}">
                                      </div>
                                    </div>
                                    <div class="row mb-3">
                                      <div class="col-md-5">
                                        <label for="slug">Slug</label>
                                        <input type="text" id="slug" class="form-control" name="slug"  value="{{$role->slug}}" >
                                      </div>
                                    </div>
                                <button type="submit" class="btn btn-primary">Save</button>
                                  </form> 
                              </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('extra_js')

<script>
    $(function () {
        $('#roleAdd').on('submit', function(e){
            e.preventDefault();
            let fd = new FormData(this);
            fd.append('_token',"{{ csrf_token() }}");
            $.ajax({
                url: "{{ route('admin.update_role')}}",
                type:"POST",
                data: fd,
                dataType: 'json',
                processData: false,
                contentType: false,
                beforeSend: function () {
                    $("#load").show();
                },
                success:function(result){
                    if(result.status)
                    {
                        toast.success(result.msg);
                        setTimeout(function(){
                            window.location.href = result.location;
                        }, 2000);
                    }
                    else
                    {
                        toast.warning(result.msg);
                        // toast.error(result.msg);
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
@endsection