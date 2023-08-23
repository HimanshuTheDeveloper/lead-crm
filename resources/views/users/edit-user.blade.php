@extends('layout.app')

@section('title')
    <title>Users</title>
@endsection

@section('extra_css')
<style>
    /* .fx_width{
      width: 8rem;
    } */

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
                      <li class="breadcrumb-item"><a href="{{route("admin.users")}}">Users</a></li>
                      <li class="breadcrumb-item active" aria-current="page">Edit User</li>
                    </ol>
                  </nav>
                <!-- [ breadcrumb ] end -->
                <div class="main-body">
                    <div class="page-wrapper">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex justify-content-between">
                                    <h3 class="card-title">Edit User</h3>
                                    {{-- <a href="{{route("admin.add_users")}}" class="btn btn-primary">Add User</a> --}}
                                </div>
                              </div>
                            <div class="card-body">

                                <form id="UserUpdate">
                                    <div class="row mb-3">
                                      <div class="col">
                                        <label for="firstName">Name *</label>
                                        <input type="hidden" id="name" class="form-control" name="user_id" value="{{$user->id}}">
                                        <input type="text" id="name" class="form-control" name="name" value="{{$user->name}}">
                                      </div>
                                      <div class="col">
                                        <label for="role">Role *</label>
                                        <select class="custom-select" id="role" name="role" required>
                                            {{-- <option value="">--select role--</option> --}}
                                            @foreach ($roles as $role)
                                              <option value="{{$role->id}}" {{$role->id == $user->role->id ?  "selected" : ""}}>{{$role->name}}</option>
                                            @endforeach
                                          </select>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                      <div class="col">
                                        <label for="email">Email *</label>
                                        <input type="email" id="email" class="form-control" value="{{$user->email}}"  name="email" required>
                                      </div>
                                      <div class="col">
                                        <label for="phone">Phone</label>
                                        <input type="text" id="phone" class="form-control" name="phone" value="{{$user->phone}}" >
                                      </div>
                                  
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col">
                                        
                                        </div>
                                      </div>
                
                                    <div class=" row mb-3">
                                    <div class="col-6">
                                        <label for="status">Status</label>
                                        <select class="custom-select" id="status" name="status" required>
                                            <option value="ACTIVE" {{$user->status == "ACTIVE" ? "selected" : ''}}>Active</option>
                                            <option value="INACTIVE" {{$user->status == "INACTIVE" ? "selected" : ''}}>Inactive</option>
                                        </select>
                                        </div>
                                    <div class="col-5">
                                        <label for="image">Profile Image</label>
                                        <input type="file" id="image" class="form-control" name="profile_image" >
                                    </div>
                                    <div class="col-1">
                                        <img class="card-img-top rounded mt-3" style="height:70px; width:70px;" src="{{asset('/public/images/users/' . $user->profile_image)}}" alt="Image Not Found">
                                    </div>
    
                                </div>
                                <div class="row">
                                  <div class="col-sm-6">
                                    <label for="password">Password</label>
                                    <input type="password" id="password" class="form-control"  name="password">
                                  </div>
                                </div>
                                {{-- <div class=" row mb-3">
                                    <div class="col-sm-3">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="customCheckDisabled" >
                                            <label class="custom-control-label" for="customCheckDisabled">Check this custom checkbox</label>
                                          </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="customCheckDisabled" >
                                            <label class="custom-control-label" for="customCheckDisabled">Check this custom checkbox</label>
                                          </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="customCheckDisabled" >
                                            <label class="custom-control-label" for="customCheckDisabled">Check this custom checkbox</label>
                                          </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="customCheckDisabled" >
                                            <label class="custom-control-label" for="customCheckDisabled">Check this custom checkbox</label>
                                          </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="customCheckDisabled" >
                                            <label class="custom-control-label" for="customCheckDisabled">Check this custom checkbox</label>
                                          </div>
                                    </div>
                                </div> --}}
                              
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
        $('#UserUpdate').on('submit', function(e){
            e.preventDefault()
            let fd = new FormData(this);
            fd.append('_token',"{{ csrf_token() }}");
            $.ajax({
                url: "{{ route('admin.update_users') }}",
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
                        // setTimeout(function(){
                        //     window.location.href = result.location;
                        // }, 2000);
                    }
                    else
                    {
                      toast.warning(result.msg);
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