@extends('layout.app')

@section('title')
    <title>Edit Domain</title>
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
                      <li class="breadcrumb-item"><a href="{{route("admin.domain")}}">Domain</a></li>
                      <li class="breadcrumb-item active" aria-current="page">Edit Domain</li>
                    </ol>
                  </nav>
                <!-- [ breadcrumb ] end -->
                <div class="main-body">
                    <div class="page-wrapper">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex justify-content-between">
                                    <h3 class="card-title">Edit Domain</h3>
                                    {{-- <a href="{{route("admin.add_users")}}" class="btn btn-primary">Add User</a> --}}
                                </div>
                              </div>
                            <div class="card-body">

                                <form id="ClientUpdate">
                                    <div class="row mb-3">
                                        <div class="col-sm">
                                          <label for="client">Client</label>
                                          <input type="hidden" name="id" value="{{$domain->id}}" >
                                          <select class="form-control" name="client" id='client' required>
                                              <option>--select client--</option>
                                              @foreach($clients as $client)
                                                  <option value="{{$client->id}}" {{$domain->client_fk_id == $client->id ? "selected" : ""}}>{{$client->name}}</option>
                                              @endforeach
                                          </select>
                                        </div>
                                      <div class="col-sm">
                                        <label for="expiry_date">Expiry Date</label>
                                        <input type="date" id="expiry_date" class="form-control" name="expiry_date" value="{{$domain->expiry_date}}" >
                                      </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm">
                                          <label for="amc_start_date">Registration Date</label>
                                          <input type="date" id="registration_date" class="form-control" name="registration_date"  value="{{$domain->registration_date}}">
                                        </div>
                                        <div class="col-sm">
                                            <label for="domain_name">Domain name *</label>
                                            <input type="text" id="domain_name" class="form-control" name="domain_name" value="{{$domain->domain_name}}" >
                                          </div>
                                    </div>
                
                                    <div class=" row mb-3">
                                        <div class="col-sm">
                                            <label for="amc_end_date">Registrar details*</label>
                                            {{-- <input type="text" id="amc_end_date" class="form-control" name="registrar_details" required> --}}
                                            <textarea  class="form-control" name="registrar_details" >{{$domain->registrar_details}}</textarea>
                                          </div>
                                    <div class="col-sm">
                                        <label for="currency">Currency </label>
                                        <select class="form-control" name="currency" id='currency'  required>
                                                <option value="USD">USD</option>
                                                <option value="GBP">GBP</option>
                                                <option value="INR" >INR</option>
                                                <option value="CAD">CAD</option>
                                                <option value="EURO">EURO</option>
                                                <option value="AED">AED</option>
                                                <option value="SAR">SAR</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-6">
                                        <label for="amount">Amount</label>
                                        <input type="number"  min="0"  step="any" id="amount" class="form-control" name="amount" value="{{$domain->amount}}" required>
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="amount">Remarks</label>
                                        <select class="form-control" name="status" id='status'  >
                                            <option>--Select Status--</option>
                                            <option value="active" {{$domain->status == 'active' ? "selected" : ""}}>Active</option>
                                            <option value="expired" {{$domain->status == 'expired' ? "selected" : ""}}>Expired</option>
                                            <option value="deleted"  {{$domain->status == 'deleted' ? "selected" : ""}}>Deleted</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    
                                    <div class="col-sm-6">
                                        <label for="amount">Remarks</label>
                                        <textarea  class="form-control" name="remarks" >{{$domain->remarks}}</textarea>
                                    </div>
                                </div>
                         
                                <button type="submit" class="btn btn-primary">Create</button>
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
        $('#ClientUpdate').on('submit', function(e){
            e.preventDefault()
            let fd = new FormData(this);
            fd.append('_token',"{{ csrf_token() }}");
            $.ajax({
                url: "{{route('admin.update_domain')}}",
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