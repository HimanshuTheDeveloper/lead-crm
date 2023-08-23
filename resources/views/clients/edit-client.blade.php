@extends('layout.app')

@section('title')
    <title>Clients</title>
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
                      {{-- <li class="breadcrumb-item"><a href="{{route("client.dashboard")}}">Dashboard</a></li> --}}
                      <li class="breadcrumb-item"><a href="{{route("admin.clients")}}">Clients</a></li>
                      <li class="breadcrumb-item active" aria-current="page">Edit Client</li>
                    </ol>
                  </nav>
                <!-- [ breadcrumb ] end -->
                <div class="main-body">
                    <div class="page-wrapper">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex justify-content-between">
                                    <h3 class="card-title">Edit Client</h3>
                                    {{-- <a href="{{route("admin.add_users")}}" class="btn btn-primary">Add User</a> --}}
                                </div>
                              </div>
                            <div class="card-body">

                                <form id="ClientUpdate" autocomplete="off">
                                    <div class="row mb-3">
                                      <div class="col">
                                        <label for="firstName">Name *</label>
                                        <input type="hidden" id="name" class="form-control" name="clients_id" value="{{$client->id}}">
                                        <input type="text" id="name" class="form-control" name="name" value="{{$client->name}}" >
                                      </div>
                                      <div class="col">
                                        <label for="email">Email *</label>
                                        <input type="email" id="email" class="form-control" value="{{$client->email}}"  name="email" required>
                                      </div>
                                    </div>
                                    <div class="row mb-3">
                                          <div class="col">
                                            <label for="phone">Phone</label>
                                            <input type="text" id="phone" class="form-control" name="phone" value="{{$client->phone}}">
                                          </div>
                                          <div class="col">
                                            <div class="form-group">
                                                <label> Country *</label>
                                                <select class="form-control" name="country" id='ai_country' required>
                                                    @foreach($countries as $country)
                                                    <option value="{{$country->Country}}" {{$country->Country == $client->country ? 'selected' : '' }}> {{$country->Country}} </option>
                                                     @endforeach
                                                </select>
                                            </div>
                                          </div>
                                    </div>
    
                                    <div class="row mb-3"> 
                                        <div class="col">
                                            <div class="form-group appendState">
                                            </div>
                                            </div>
                                            
                                        <div class="col">
                                            <label for="address">Address </label>
                                            <input type="text" id="address" value="{{$client->address}}" class="form-control" name="address" >
                                          </div>
                                      </div>
                
                             
                                      <div class=" row mb-3">
                                        <div class="col">
                                            <label for="gst_no">Gst Number </label>
                                            <input type="text" id="gst_no" class="form-control" value="{{$client->gst_no}}" name="gst_no" >
                                            </div>
                                        <div class="col">
                                                <label for="remarks">Remarks</label>
                                                <input type="text" id="remarks" value="{{$client->remarks}}" class="form-control" name="remarks">
                            
                                            {{-- <label for="created_by">Created By </label>
                                            <input type="text" id="created_by" value="{{$client->created_by}}" class="form-control" name="created_by"> --}}
                                        </div>
                                    </div>
                                    {{-- <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="remarks">Remarks</label>
                                            <input type="text" id="remarks" value="{{$client->remarks}}" class="form-control" name="remarks">
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

        var indianStateHtml = `<label for="ai_state">State</label> 
                                                        <select class="form-control" type="text"  name="state" id="ai_ind_state" >                                                    
                                                        <option value="Andhra Pradesh"  {{$client->state == "Andhra Pradesh" ? 'selected' : "" }}>Andhra Pradesh</option>                                                          
                                                        <option value="Arunachal Pradesh"  {{$client->state == "Arunachal Pradesh" ? 'selected' : "" }}>Arunachal Pradesh</option>                                                            
                                                        <option value="Assam" {{$client->state == "Assam" ? 'selected' : "" }}>Assam</option>
                                                        <option value="Bihar" {{$client->state == "Bihar" ? 'selected' : "" }}>Bihar</option>
                                                        <option value="Chandigarh" {{$client->state == "Chandigarh" ? 'selected' : "" }}>Chandigarh</option>
                                                        <option value="Chhattisgarh" {{$client->state == "Chhattisgarh" ? 'selected' : "" }}>Chhattisgarh</option>
                                                        <option value="Dadra and Nagar Haveli" {{$client->state == "Dadra and Nagar Haveli" ? 'selected' : "" }}>Dadra and Nagar Haveli</option>
                                                        <option value="Daman and Diu" {{$client->state == "Daman and Diu" ? 'selected' : "" }}>Daman and Diu</option>
                                                        <option value="Delhi" {{$client->state == "Delhi" ? 'selected' : "" }}>Delhi</option>
                                                        <option value="Goa" {{$client->state == "Goa" ? 'selected' : "" }}>Goa</option>
                                                        <option value="Gujarat" {{$client->state == "Gujarat" ? 'selected' : "" }}>Gujarat</option>
                                                        <option value="West Bengal" {{$client->state == "West Bengal" ? 'selected' : "" }}>West Bengal</option>
                                                        <option value="Haryana" {{$client->state == "Haryana" ? 'selected' : "" }}>Haryana</option>
                                                        <option value="Himachal Pradesh" {{$client->state == "Himachal Pradesh" ? 'selected' : "" }}>Himachal Pradesh</option>
                                                        <option value="Jharkhand" {{$client->state == "Jharkhand" ? 'selected' : "" }}>Jharkhand</option>
                                                        <option value="Karnataka" {{$client->state == "Karnataka" ? 'selected' : "" }}>Karnataka</option>
                                                        <option value="Kerala" {{$client->state == "Kerala" ? 'selected' : "" }}>Kerala</option>
                                                        <option value="Madhya Pradesh" {{$client->state == "Madhya Pradesh" ? 'selected' : "" }}>Madhya Pradesh</option>
                                                        <option value="Maharashtra" {{$client->state == "Maharashtra" ? 'selected' : "" }}>Maharashtra</option>
                                                        <option value="Manipur" {{$client->state == "Manipur" ? 'selected' : "" }}>Manipur</option>
                                                        <option value="Meghalaya" {{$client->state == "Meghalaya" ? 'selected' : "" }}>Meghalaya</option>
                                                        <option value="Mizoram" {{$client->state == "Mizoram" ? 'selected' : "" }}>Mizoram</option>
                                                        <option value="Nagaland" {{$client->state == "Nagaland" ? 'selected' : "" }}>Nagaland</option>
                                                        <option value="Odisha" {{$client->state == "Odisha" ? 'selected' : "" }}>Odisha</option>
                                                        <option value="Punjab" {{$client->state == "Punjab" ? 'selected' : "" }}>Punjab</option>
                                                        <option value="Rajasthan" {{$client->state == "Rajasthan" ? 'selected' : "" }}>Rajasthan</option>
                                                        <option value="Sikkim" {{$client->state == "Sikkim" ? 'selected' : "" }}>Sikkim</option>
                                                        <option value="Tamil Nadu" {{$client->state == "Tamil Nadu" ? 'selected' : "" }}>Tamil Nadu</option>
                                                        <option value="Telangana" {{$client->state == "Telangana" ? 'selected' : "" }}>Telangana</option>
                                                        <option value="Tripura"  {{$client->state == "Tripura" ? 'selected' : "" }}>Tripura</option>
                                                        <option value="Uttar Pradesh" {{$client->state == "Uttar Pradesh" ? 'selected' : "" }}>Uttar Pradesh</option>
                                                        <option value="Uttarakhand" {{$client->state == "Uttarakhand" ? 'selected' : "" }}>Uttarakhand</option>
                                                        <option value="Ladakh" {{$client->state == "Ladakh" ? 'selected' : "" }}>Ladakh</option>
                                                        <option value="Jammu & Kashmir" {{$client->state == "Jammu & Kashmir" ? 'selected' : "" }}>Jammu & Kashmir</option>
                                                        <option value="Puducherry" {{$client->state == "Puducherry" ? 'selected' : "" }}>Puducherry</option>
                                                        <option value="Lakshadweep" {{$client->state == "Lakshadweep" ? 'selected' : "" }}>Lakshadweep</option>
                                                        <option value="Andaman and Nicobar Islands" {{$client->state == "Andaman and Nicobar Islands" ? 'selected' : "" }}>Andaman and Nicobar Islands</option>
                                                      </select>`; 

        var otherState = `<label for="">State</label><input class="form-control"placeholder="Enter State" value="{{$client->state}}" name="state" >`;

        if($('#ai_country').val() == 'India')
        {   
            $('.appendState').html(indianStateHtml);
        }else{
            $('.appendState').html(otherState);
        }



        $('#ClientUpdate').on('submit', function(e){
            e.preventDefault()
            let fd = new FormData(this);
            fd.append('_token',"{{ csrf_token() }}");
            $.ajax({
                url: "{{ route('admin.update_clients') }}",
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

    $('#ai_country').on('change', function(e){
        e.preventDefault();
        var indianStateHtml = `<label for="ai_state">State</label> 
        <select class="form-control" type="text"  name="state" id="ai_ind_state" style="">
                                                        <option>Select State</option>                                                    
                                                        <option value="Andhra Pradesh">Andhra Pradesh</option>                                                          
                                                        <option value="Arunachal Pradesh">Arunachal Pradesh</option>                                                            
                                                        <option value="Assam">Assam</option>
                                                        <option value="Bihar">Bihar</option>
                                                        <option value="Chandigarh">Chandigarh</option>
                                                        <option value="Chhattisgarh">Chhattisgarh</option>
                                                        <option value="Dadra and Nagar Haveli">Dadra and Nagar Haveli</option>
                                                        <option value="Daman and Diu">Daman and Diu</option>
                                                        <option value="Delhi">Delhi</option>
                                                        <option value="Goa">Goa</option>
                                                        <option value="Gujarat">Gujarat</option>
                                                        <option value="West Bengal">West Bengal</option>
                                                        <option value="Haryana">Haryana</option>
                                                        <option value="Himachal Pradesh">Himachal Pradesh</option>
                                                        <option value="Jharkhand">Jharkhand</option>
                                                        <option value="Karnataka">Karnataka</option>
                                                        <option value="Kerala">Kerala</option>
                                                        <option value="Madhya Pradesh">Madhya Pradesh</option>
                                                        <option value="Maharashtra">Maharashtra</option>
                                                        <option value="Manipur">Manipur</option>
                                                        <option value="Meghalaya">Meghalaya</option>
                                                        <option value="Mizoram">Mizoram</option>
                                                        <option value="Nagaland">Nagaland</option>
                                                        <option value="Odisha">Odisha</option>
                                                        <option value="Punjab">Punjab</option>
                                                        <option value="Rajasthan">Rajasthan</option>
                                                        <option value="Sikkim">Sikkim</option>
                                                        <option value="Tamil Nadu">Tamil Nadu</option>
                                                        <option value="Telangana">Telangana</option>
                                                        <option value="Tripura">Tripura</option>
                                                        <option value="Uttar Pradesh">Uttar Pradesh</option>
                                                        <option value="Uttarakhand">Uttarakhand</option>
                                                        <option value="Ladakh">Ladakh</option>
                                                        <option value="Jammu & Kashmir">Jammu & Kashmir</option>
                                                        <option value="Puducherry">Puducherry</option>
                                                        <option value="Lakshadweep">Lakshadweep</option>
                                                        <option value="Andaman and Nicobar Islands">Andaman and Nicobar Islands</option>
                                                      </select>`; 

        var otherState = `<label for="">State</label><input class="form-control"placeholder="Enter State" value="" name="state" >`;

        if($(this).val() == 'India')
        {   
            $('.appendState').html(indianStateHtml);
        }else{
            $('.appendState').html(otherState);
        }
    });
  </script>
@endsection