@extends('layout.app')
@section('title')
    <title>Add AMC</title>
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
                      <li class="breadcrumb-item"><a href="{{route("admin.amc")}}">AMC</a></li>
                      <li class="breadcrumb-item active" aria-current="page">Edit AMC</li>
                    </ol>
                  </nav>
                <!-- [ breadcrumb ] end -->
                <div class="main-body">
                    <div class="page-wrapper">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex justify-content-between">
                                    <h3 class="card-title">Edit AMC</h3>
                                    {{-- <a href="{{route("admin.add_users")}}" class="btn btn-primary">Add User</a> --}}
                                </div>
                              </div>
                            <div class="card-body">

                                <form id="ClientUpdate" autocomplete="off">
                                    <div class="row mb-3">
                                      <div class="col">
                                        <label for="amc_id">AMC ID *</label>
                                        <input type="hidden" id="id" class="form-control" name="id" value="{{$amc->id}}" >
                                        <input type="text" id="amc_id" class="form-control" name="amc_id" value="{{$amc->amc_id}}" >
                                      </div>
                                      <div class="col">
                                        <label for="client">Client</label>
                                        <select class="form-control" name="client" id='client'  required>
                                            <option>--select client--</option>
                                            @foreach($clients as $client)
                                                <option value="{{$client->id}}" {{$client->id == $amc->client_fk_id ? 'selected' : ''}}>{{$client->name}} &nbsp; ({{$client->email}})</option>
                                            @endforeach
                                        </select>
                                      </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col">
                                            <label for="domain_name">Domain name *</label>
                                            <input type="text" id="domain_name" class="form-control" name="domain_name" value="{{$amc->domain_name}}" >
                                          </div>
                                          <div class="col">
                                            <label for="amc_start_date">AMC Start Date*</label>
                                            <input type="date" id="amc_start_date" class="form-control" name="amc_start_date"    value="{{$amc->amc_start_date}}" >
                                          </div>
                                    </div>
                
                                    <div class=" row mb-3">
                                        <div class="col">
                                            <label for="amc_end_date">AMC End Date*</label>
                                            <input type="date" id="amc_end_date" class="form-control" name="amc_end_date"  value="{{$amc->amc_end_date}}" >
                                          </div>
                                    <div class="col">
                                        <label for="currency">Currency </label>
                                        <select class="form-control" name="currency" id='currency'  required>
                                            {{-- <option>--select currency--</option> --}}
                                            @foreach($currencies as $currency)
                                                <option value="{{$currency->id}}" {{$currency->id == $amc->currency ? 'selected' : ''}} >{{$currency->Currency}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                    <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="amount">Amount</label>
                                        <input type="number"  min="0" value="0" step="any" id="amount" class="form-control" name="amount" value="{{$amc->amount}}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="remarks">Remarks</label>
                                        <textarea name="remarks" class="form-control">{{$amc->remarks}}</textarea>
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
        $('#ClientUpdate').on('submit', function(e){
            e.preventDefault()
            let fd = new FormData(this);
            fd.append('_token',"{{ csrf_token() }}");
            $.ajax({
                url: "{{ route('admin.update_amc') }}",
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