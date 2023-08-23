@extends('layout.app')

@section('title')
    <title>Edit Hosting</title>
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
                      <li class="breadcrumb-item"><a href="{{route("admin.hosting")}}">Hosting</a></li>
                      <li class="breadcrumb-item active" aria-current="page">Edit Hosting</li>
                    </ol>
                  </nav>
                <!-- [ breadcrumb ] end -->
                <div class="main-body">
                    <div class="page-wrapper">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex justify-content-between">
                                    <h3 class="card-title">Edit Hosting</h3>
                                    {{-- <a href="{{route("admin.add_users")}}" class="btn btn-primary">Add User</a> --}}
                                </div>
                              </div>
                            <div class="card-body">
                                <form id="ClientUpdate">
                                    <div class="row mb-3">
                                        <div class="col-sm">
                                            <label for="expiry_date">Expiry Date</label>
                                            <input type="hidden"  name="id" value="{{$hosting->id}}" >
                                            <input type="date" id="expiry_date" class="form-control" name="expiry_date" value="{{$hosting->expiry_date}}" >
                                        </div>
                                        <div class="col-sm">
                                            <label for="amc_start_date">Registration Date</label>
                                            <input type="date" id="registration_date" class="form-control" name="registration_date"  value="{{$hosting->registration_date}}" >
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm">
                                            <label for="domain">Domain</label>
                                            <input type="text" id="domain" class="form-control" name="domain" value="{{$hosting->domain_fk_id}}">
                                            {{-- <select class="form-control" name="domain" id='domain'>
                                                <option>--select domain--</option>
                                                @foreach($domains as $domain)
                                                    <option value="{{$domain->id}}"  {{$domain->id == $hosting->domain_fk_id ? "selected" : ""}}>{{$domain->domain_name}}</option>
                                                @endforeach
                                            </select> --}}
                                          </div>
                                        <div class="col-sm">
                                            <label for="server_data">Server</label>
                                            <input type="text" id="server_data" class="form-control" name="server_data" value="{{$hosting->server_data}}">
                                          </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm">
                                            <label for="client">Client</label>
                                            <select class="form-control" name="client" id='client'>
                                                <option>--select client--</option>
                                                @foreach($clients as $client)
                                                    <option value="{{$client->id}}"  {{$client->id == $hosting->client_fk_id ? "selected" : ""}}>{{$client->name }}&nbsp;({{$client->email}})</option>
                                                @endforeach
                                            </select>
                                          </div>

                                          <div class="col-sm-3">
                                            <label for="amount">Currency</label>
                                            <select class="form-control" id="currency" name="currency" >
                                                <option value="USD" {{$hosting->currency == "USD" ? "selected" : ""}}>USD</option>
                                                <option value="GBP" {{$hosting->currency == "GBP" ? "selected" : ""}}>GBP</option>
                                                <option value="INR" {{$hosting->currency == "INR" ? "selected" : ""}}>INR</option>
                                                <option value="CAD" {{$hosting->currency == "CAD" ? "selected" : ""}}>CAD</option>
                                                <option value="EURO" {{$hosting->currency == "EURO" ? "selected" : ""}}>EURO</option>
                                                <option value="AED" {{$hosting->currency == "AED" ? "selected" : ""}}>AED</option>
                                                <option value="SAR" {{$hosting->currency == "SAR" ? "selected" : ""}}>SAR</option>
                                            </select>
                                        </div>
                                        
                                          <div class="col-sm-3">
                                            <label for="amount">Amount</label>
                                            <input type="number"  min="0"  step="any" id="amount" class="form-control" name="amount" value="{{$hosting->amount}}" >
                                        </div>

                                    </div>
                
                                    <div class=" row mb-3">
                                        <div class="col-sm-6">
                                            <label for="amount">Status</label>
                                            <select class="form-control" name="status" id='status' required>
                                                <option>--select status--</option>
                                                <option value="active"  {{$hosting->status =='active'? "selected" : ""}} >Active</option>
                                                <option value="expired" {{$hosting->status =='expired'? "selected" : ""}}>Expired</option>
                                                <option value="deleted" {{$hosting->status =='deleted'? "selected" : ""}}>Deleted</option>
                                            </select>
                                        </div>
                                        <div class="col-sm">
                                            <label for="comment">Comment</label>
                                            <textarea name="comment"  class="form-control">{{$hosting->comment}}</textarea>
                                          </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Update</button>
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
                url: "{{route('admin.update_hosting')}}",
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