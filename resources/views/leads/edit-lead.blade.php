@extends('layout.app')

@section('title')
<title>Add Lead</title>
@endsection

@section('extra_css')
<style>
    .fx_width {
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
                        <li class="breadcrumb-item"><a href="{{route("admin.leads")}}">Leads</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Lead</li>
                    </ol>
                </nav>
                <!-- [ breadcrumb ] end -->
                <div class="main-body">
                    <div class="page-wrapper">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex justify-content-between">
                                    <h3 class="card-title">Edit Lead</h3>
                                    {{-- <a href="{{route(" admin.add_users")}}" class="btn btn-primary">Add User</a>
                                    --}}
                                </div>
                            </div>
                            <div class="card-body">
                                <form id="leadSubmit" enctype="multipart/form-data">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm">
                                                <div class="form-group">
                                                    <label>Lead Number <span class="required-mark">*</span></label>
                                                    <input  type="hidden" name="id" id="" value="{{$lead->id}}">
                                                    <input  type="text" name="lead_number" id="lead_number" value="{{$lead->lead_number}}"
                                                        class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-sm">
                                                <div class="form-group">
                                                    <label>Lead Date <span class="required-mark">*</span></label>
                                                    <input  type="date" name="lead_date" id="lead_date" value="{{date("Y-m-d", strtotime($lead->lead_date))}}"
                                                        class="form-control">
                                                </div>
                                            </div>
                                        </div>


                                        <div class="row">
                                            <div class="col-sm">
                                                <div class="form-group">
                                                    <label>Followup Date <span class="required-mark">*</span></label>
                                                    <input  type="datetime-local" name="followup_date" value="{{$lead->followup_date}}"
                                                        id="followup_date" class="form-control">
                                                </div>

                                            </div>
                                            <div class="col-sm">
                                                <div class="form-group">
                                                    <label>Work Description <span class="required-mark">*</span></label>
                                                    <textarea  name="work_description" id="summary-ckedito"
col-sms="30" rows="6" class="form-control">{{$lead->work_description}}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm">
                                                <div class="form-group">
                                                    <label>Name <span class="required-mark">*</span></label>
                                                    <input  type="text" name="name" id="name" value="{{$lead->name}}"
                                                        class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-sm">
                                                <div class="form-group">
                                                    <label>Email <span class="required-mark">*</span></label>
                                                    <input  type="email" name="email" id="email" value="{{$lead->email}}"
                                                        class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm">
                                                <div class="form-group">
                                                    <label>Alt-Email</label>
                                                    <input type="text" name="alt_email" id="alt_email" value="{{$lead->alt_email}}"
                                                        class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-sm">
                                                <div class="form-group">
                                                    <label>Mobile</label>
                                                    <input type="text" name="mobile" id="mobile" class="form-control" value="{{$lead->mobile}}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm">
                                                <div class="form-group">
                                                    <label>Alt-Mobile</label>
                                                    <input type="text" name="alt_mobile" id="alt_mobile"  value="{{$lead->alt_mobile}}"
                                                        class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-sm">
                                                <div class="form-group">
                                                    <label>Skype</label>
                                                    <input type="text" name="skype" id="skype" class="form-control" value="{{$lead->skype}}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm">
                                                <div class="form-group">
                                                    <label>Followed</label>
                                                    <input type="text" name="followed" id="followed" value="{{$lead->followed}}"
                                                        class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-sm">
                                                <div class="form-group">
                                                    <label>Services</label>
                                                    <input type="text" name="services" id="services" value="{{$lead->services}}"
                                                        class="form-control">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-sm">
                                                <div class="form-group">
                                                    <label> Country*</label>
                                                    <select class="form-control" name="country" id='ai_country'>
                                                        @foreach($countries as $country)
                                                        <option value="{{$country->Country}}"  {{$country->Country === $lead->country ? 'selected' : ''}}> {{$country->Country}}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm">
                                                <div class="form-group">
                                                    <label for="ai_state" id="ai_state">State</label>
                                                    @if ($lead->country != 'India')
                                                        <input class="form-control " placeholder="Enter State" id="other_state" name="state">
                                                    @else
                                                        <select class="form-control " type="text" id="indian_state" name="state" id="ai_ind_state">
                                                            <option>Select State</option>
                                                            <option value="Andhra Pradesh"  {{$lead->state == "Andhra Pradesh"  ? 'selected' : ''}}>Andhra Pradesh</option>
                                                            <option value="Arunachal Pradesh" {{$lead->state == "Arunachal Pradesh"  ? 'selected' : ''}}>Arunachal Pradesh</option>
                                                            <option value="Assam" {{$lead->state == "Assam" ? 'selected' : ''}}>Assam</option>
                                                            <option value="Bihar" {{$lead->state == "Bihar" ? 'selected' : ''}}>Bihar</option>
                                                            <option value="Chandigarh"  {{$lead->state == "Chandigarh" ? 'selected' : ''}}>Chandigarh</option>
                                                            <option value="Chhattisgarh"   {{$lead->state == "Chhattisgarh" ? 'selected' : ''}}>Chhattisgarh</option>
                                                            <option value="Dadra and Nagar Haveli"   {{$lead->state == "Dadra and Nagar Haveli" ? 'selected' : ''}}>Dadra and Nagar Haveli</option>
                                                            <option value="Daman and Diu"   {{$lead->state == "Daman and Diu" ? 'selected' : ''}}>Daman and Diu</option>
                                                            <option value="Delhi"   {{$lead->state == "Delhi" ? 'selected' : ''}}>Delhi</option>
                                                            <option value="Goa"   {{$lead->state == "Goa" ? 'selected' : ''}}>Goa</option>
                                                            <option value="Gujarat"   {{$lead->state == "Gujarat" ? 'selected' : ''}}>Gujarat</option>
                                                            <option value="West Bengal"   {{$lead->state == "West Bengal" ? 'selected' : ''}}>West Bengal</option>
                                                            <option value="Haryana"   {{$lead->state == "Haryana" ? 'selected' : ''}}>Haryana</option>
                                                            <option value="Himachal Pradesh"   {{$lead->state == "Himachal Pradesh" ? 'selected' : ''}}>Himachal Pradesh</option>
                                                            <option value="Jharkhand"   {{$lead->state == "Jharkhand" ? 'selected' : ''}}>Jharkhand</option>
                                                            <option value="Karnataka"   {{$lead->state == "Karnataka" ? 'selected' : ''}}>Karnataka</option>
                                                            <option value="Kerala"   {{$lead->state == "Kerala" ? 'selected' : ''}}>Kerala</option>
                                                            <option value="Madhya Pradesh"   {{$lead->state == "Madhya Pradesh" ? 'selected' : ''}}>Madhya Pradesh</option>
                                                            <option value="Maharashtra"   {{$lead->state == "Maharashtra" ? 'selected' : ''}}>Maharashtra</option>
                                                            <option value="Manipur"   {{$lead->state == "Manipur" ? 'selected' : ''}}>Manipur</option>
                                                            <option value="Meghalaya"   {{$lead->state == "Meghalaya" ? 'selected' : ''}}>Meghalaya</option>
                                                            <option value="Mizoram"   {{$lead->state == "Mizoram" ? 'selected' : ''}}>Mizoram</option>
                                                            <option value="Nagaland"   {{$lead->state == "Nagaland" ? 'selected' : ''}}>Nagaland</option>
                                                            <option value="Odisha"   {{$lead->state == "Odisha" ? 'selected' : ''}}>Odisha</option>
                                                            <option value="Punjab"   {{$lead->state == "Punjab" ? 'selected' : ''}}>Punjab</option>
                                                            <option value="Rajasthan"   {{$lead->state == "Rajasthan" ? 'selected' : ''}}>Rajasthan</option>
                                                            <option value="Sikkim"   {{$lead->state == "Sikkim" ? 'selected' : ''}}>Sikkim</option>
                                                            <option value="Tamil Nadu" {{$lead->state == "Tamil Nadu" ? 'selected' : ''}}>Tamil Nadu</option>
                                                            <option value="Telangana" {{$lead->state == "Telangana" ? 'selected' : ''}}>Telangana</option>
                                                            <option value="Tripura" {{$lead->state == "Tripura" ? 'selected' : ''}}>Tripura</option>
                                                            <option value="Uttar Pradesh" {{$lead->state == "Uttar Pradesh" ? 'selected' : ''}}>Uttar Pradesh</option>
                                                            <option value="Uttarakhand" {{$lead->state == "Uttarakhand" ? 'selected' : ''}}>Uttarakhand</option>
                                                            <option value="Ladakh" {{$lead->state == "Ladakh" ? 'selected' : ''}}>Ladakh</option>
                                                            <option value="Jammu & Kashmir" {{$lead->state == "Jammu & Kashmir" ? 'selected' : ''}}>Jammu & Kashmir</option>
                                                            <option value="Puducherry" {{$lead->state == "Puducherry" ? 'selected' : ''}}>Puducherry</option>
                                                            <option value="Lakshadweep" {{$lead->state == "Lakshadweep" ? 'selected' : ''}}>Lakshadweep</option>
                                                            <option value="Andaman and Nicobar Islands"  {{$lead->state == "Andaman and Nicobar IslandsAndaman and Nicobar Islands" ? 'selected' : ''}}>Andaman and Nicobar Islands</option>
                                                        </select>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>


                                        <div class="row">
                                            <div class="col-sm">
                                                <div class="form-group">
                                                    <label>City</label>
                                                    <input type="text" name="city" id="cit" class="form-control" value="{{$lead->city}}">
                                                </div>
                                            </div>
                                            <div class="col-sm">
                                                <div class="form-group">
                                                    <label>Address</label>
                                                    <input type="text" name="address" id="address" class="form-control" value="{{$lead->address}}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-sm">
                                                <div class="form-group">
                                                    <label>Domain Name/Company Name</label>
                                                   
                                                    <input type="text" name="domain_name" id="domain_name"  value="{{$lead->domain_name}}"
                                                        class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-sm">
                                                <div class="form-group">
                                                    <label>Status</label>
                                                    <select name="status" class="form-control" id="status">
                                                        <option value="">Select Status</option>
                                                        {{-- <option value="all" {{$lead->status == 'all' ? 'selected' : ""}}>All</option> --}}
                                                        <option value="started conversation" {{$lead->status == 'started conversation' ? 'selected' : "" }}>Started Conversation</option>
                                                        <option value="following up" {{$lead->status == 'following up' ? 'selected' : "" }}>Following Up</option>
                                                        <option value="converted" {{$lead->status == 'converted' ? 'selected' : "" }}>Converted</option>
                                                        <option value="denied" {{$lead->status == 'denied' ? 'selected' : "" }}>Denied</option>
                                                        <option value="waiting response" {{$lead->status == 'waiting response' ? 'selected' : "" }}>Waiting Response</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group" id="reject_reason">
                                                    <label>Reject Reason</label>
                                                    <input type="text" name="reject_reason" class="form-control" {{$lead->reject_reason}}>
                                                </div>
                                            </div>
                                            <div class="col-sm">
                                                <div class="row" id="converted">
                                                <div class="col-sm">
                                                    <div class="form-group" id="currency">
                                                        <label>Currency</label>
                                                        <select class="form-control" id="currency" name="currency" >
                                                            <option value="USD" {{$lead->currency == "USD" ? "selected" : ""}}>USD</option>
                                                            <option value="GBP" {{$lead->currency == "GBP" ? "selected" : ""}}>GBP</option>
                                                            <option value="INR" {{$lead->currency == "INR" ? "selected" : ""}}>INR</option>
                                                            <option value="CAD" {{$lead->currency == "CAD" ? "selected" : ""}}>CAD</option>
                                                            <option value="EURO" {{$lead->currency == "EURO" ? "selected" : ""}}>EURO</option>
                                                            <option value="AED" {{$lead->currency == "AED" ? "selected" : ""}}>AED</option>
                                                            <option value="SAR" {{$lead->currency == "SAR" ? "selected" : ""}}>SAR</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm">
                                                    <div class="form-group" id="amount">
                                                        <label>Converted Amount</label>
                                                        <input type="text" name="converted_amount" class="form-control" value="{{$lead->converted_amount}}">
                                                    </div>
                                                </div>
                                                </div>
                                            </div>
                                            {{-- <div class="col-3">
                                                <div class="form-group" id="amount">
                                                    <label>Converted Amount</label>
                                                    <input type="text" name="amount" class="form-control" {{$lead->amount}}>
                                                </div>

                                            </div>
                                            <div class="col-3">
                                                <div class="form-group" id="amount">
                                                    <label>Converted Amount</label>
                                                    <input type="text" name="amount" class="form-control" {{$lead->amount}}>
                                                </div>

                                            </div> --}}
                                        </div>
                                        <div class="row">
                                            <div class="col-sm">
                                                <div class="form-group" id="amount">
                                                    <label>Comment</label>
                                                    <textarea name="comment" class="form-control">{{$lead->comment}}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit"  class="btn btn-success">Save</button>
                                    </div>
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
        // $('#reject_reason').hide(); 
        // $('#converted').hide();
        $('#other_state').show();
        // $('#indian_state').hide();
        $('#ai_country').on('change' , function(e){
            e.preventDefault();
            if($(this).val() == 'India')
            {
                $('#ai_state').html("State *");
                $('#other_state').hide();
                $('#indian_state').show();
            }else{
                $('#ai_state').html("State");
                $('#other_state').show();
                $('#indian_state').hide();
            }

        });
        $('#status').on('change' , function(e){
            e.preventDefault();
            if($(this).val() == 'converted')
            {
                $('#converted').show(); 
            }else{
                $('#converted').hide(); 
            }
            if($(this).val() == 'denied')
            {
                $('#reject_reason').show(); 
            }else{
                $('#reject_reason').hide(); 
            }
        });
        $('#leadSubmit').on('submit', function (e) {
            e.preventDefault()
            let fd = new FormData(this);
            fd.append('_token', "{{ csrf_token() }}");
            $.ajax({
                url: "{{ route('admin.update_lead') }}",
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
                        toast.warning(result.msg);
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