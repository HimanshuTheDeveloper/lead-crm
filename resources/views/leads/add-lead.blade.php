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
                        <li class="breadcrumb-item active" aria-current="page">Add Lead</li>
                    </ol>
                </nav>
                <!-- [ breadcrumb ] end -->
                <div class="main-body">
                    <div class="page-wrapper">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex justify-content-between">
                                    <h3 class="card-title">Add Lead</h3>
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
                                                    <input required type="text" name="lead_number" id="lead_number" value="{{$lead_number}}"
                                                        class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-sm">
                                                <div class="form-group">
                                                    <label>Lead Date <span class="required-mark">*</span></label>
                                                    <input required type="Date" name="lead_date" id="lead_date"
                                                        class="form-control">
                                                </div>
                                            </div>
                                        </div>


                                        <div class="row">
                                            <div class="col-sm">
                                                <div class="form-group">
                                                    <label>Followup Date <span class="required-mark">*</span></label>
                                                    <input required type="datetime-local" name="followup_date"
                                                        id="followup_date" class="form-control">
                                                </div>

                                            </div>
                                            <div class="col-sm">
                                                <div class="form-group">
                                                    <label>Work Description <span class="required-mark">*</span></label>
                                                    <textarea required name="work_description" id="summary-ckedito"
                                                        col-sms="30" rows="6" class="form-control"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm">
                                                <div class="form-group">
                                                    <label>Name <span class="required-mark">*</span></label>
                                                    <input required type="text" name="name" id="name"
                                                        class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-sm">
                                                <div class="form-group">
                                                    <label>Email <span class="required-mark">*</span></label>
                                                    <input required type="email" name="email" id="email"
                                                        class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm">
                                                <div class="form-group">
                                                    <label>Alt-Email</label>
                                                    <input type="text" name="alt_email" id="alt_email"
                                                        class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-sm">
                                                <div class="form-group">
                                                    <label>Mobile</label>
                                                    <input type="text" name="mobile" id="mobile" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm">
                                                <div class="form-group">
                                                    <label>Alt-Mobile</label>
                                                    <input type="text" name="alt_mobile" id="alt_mobile"
                                                        class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-sm">
                                                <div class="form-group">
                                                    <label>Skype</label>
                                                    <input type="text" name="skype" id="skype" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm">
                                                <div class="form-group">
                                                    <label>Followed</label>
                                                    <input type="text" name="followed" id="followed"
                                                        class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-sm">
                                                <div class="form-group">
                                                    <label>Services</label>
                                                    <input type="text" name="services" id="services"
                                                        class="form-control">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-sm">
                                                <div class="form-group">
                                                    <label> Country*</label>
                                                    <select class="form-control" name="country" id='ai_country'
                                                        onchange="ShowHideStateDetails()">
                                                        @foreach($countries as $country)
                                                            <option value="{{$country->Country}}"> {{$country->Country}}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm">
                                                <div class="form-group">
                                                    <label for="ai_state" id="ai_state">State</label>
                                                    <input class="form-control " placeholder="Enter State" id="other_state" name="state">
                                                    <select class="form-control " type="text" id="indian_state" name="state"
                                                        id="ai_ind_state" style="display: none;">
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
                                                    </select>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="row">
                                            <div class="col-sm">
                                                <div class="form-group">
                                                    <label>City</label>
                                                    <input type="text" name="city" id="cit" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-sm">
                                                <div class="form-group">
                                                    <label>Address</label>
                                                    <input type="text" name="address" id="address" class="form-control">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-sm">
                                                <div class="form-group">
                                                    <label>Domain Name/Company Name</label>
                                                    <input type="text" name="domain_name" id="domain_name"
                                                        class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-sm">
                                                <div class="form-group">
                                                    <label>Status</label>
                                                    <select name="status" class="form-control" id="status">
                                                        <option value="">Select Status</option>
                                                        {{-- <option value="all">All</option> --}}
                                                        <option value="started conversation" selected>Started Conversation</option>
                                                        <option value="following up">Following Up</option>
                                                        <option value="converted">Converted</option>
                                                        <option value="denied">Denied</option>
                                                        <option value="waiting response">Waiting Response</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm">
                                                <div class="form-group" id="reject_reason">
                                                    <label>Reject Reason</label>
                                                    <input type="text" name="reject_reason" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-sm">
                                                <div class="row" id="converted">
                                                <div class="col-sm">
                                                    <div class="form-group" id="currency">
                                                        <label>Currency</label>
                                                        {{-- <input type="text" name="currency" class="form-control"> --}}
                                                        <select class="form-control" id="currency" name="currency" >
                                                            <option value="USD">USD</option>
                                                            <option value="GBP">GBP</option>
                                                            <option value="INR">INR</option>
                                                            <option value="CAD">CAD</option>
                                                            <option value="EURO">EURO</option>
                                                            <option value="AED">AED</option>
                                                            <option value="SAR">SAR</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm">
                                                    <div class="form-group" id="amount">
                                                        <label>Converted Amount</label>
                                                        <input type="text" name="converted_amount" class="form-control">
                                                    </div>
                                                </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm">
                                                <div class="form-group" id="amount">
                                                    <label>Comment</label>
                                                    <textarea name="comment" class="form-control"></textarea>
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
        $('#reject_reason').hide(); 
        $('#converted').hide();
        $('#other_state').show();
        $('#indian_state').hide();
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
                url: "{{ route('admin.save_lead') }}",
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