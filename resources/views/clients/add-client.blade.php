@extends('layout.app')
@section('title')
    <title>Clients</title>
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
                            <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.clients') }}">Clients</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Add Clients</li>
                        </ol>
                    </nav>
                    <!-- [ breadcrumb ] end -->
                    <div class="main-body">
                        <div class="page-wrapper">
                            <div class="card">
                                <div class="card-header">
                                    <div class="d-flex justify-content-between">
                                        <h3 class="card-title">Add Clients</h3>
                                        {{-- <a href="{{route("admin.add_users")}}" class="btn btn-primary">Add User</a> --}}
                                    </div>
                                </div>
                                <div class="card-body">

                                    <form id="ClientUpdate" autocomplete="off">
                                        <div class="row mb-3">
                                            <div class="col">
                                                <label for="firstName">Name *</label>
                                                <input type="text" id="name" class="form-control" name="name"
                                                    required>
                                            </div>
                                            <div class="col">
                                                <label for="email">Email *</label>
                                                <input type="email" id="email" class="form-control" name="email"
                                                    required>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col">
                                                <label for="phone">Phone</label>
                                                <input type="text" id="phone" class="form-control" name="phone">
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <label> Country *</label>
                                                    <select class="form-control" name="country" id='ai_country'
                                                        onchange="ShowHideStateDetails()" required>
                                                        @foreach ($countries as $country)
                                                            <option value="{{ $country->Country }}"> {{ $country->Country }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="ai_state">State</label>
                                                    <input class="form-control"placeholder="" id="ai_other_state">
                                                    <select class="form-control" type="text" name="state"
                                                        id="ai_ind_state" style="display: none;">
                                                        <option>Select State</option>
                                                        <option value="Andhra Pradesh">Andhra Pradesh</option>
                                                        <option value="Arunachal Pradesh">Arunachal Pradesh</option>
                                                        <option value="Assam">Assam</option>
                                                        <option value="Bihar">Bihar</option>
                                                        <option value="Chandigarh">Chandigarh</option>
                                                        <option value="Chhattisgarh">Chhattisgarh</option>
                                                        <option value="Dadra and Nagar Haveli">Dadra and Nagar Haveli
                                                        </option>
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
                                                        <option value="Andaman and Nicobar Islands">Andaman and Nicobar
                                                            Islands</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <label for="address">Address</label>
                                                <input type="text" id="address" class="form-control" name="address">
                                            </div>
                                        </div>

                                        <div class=" row mb-3">
                                            <div class="col">
                                                <label for="gst_no">Gst Number </label>
                                                <input type="text" id="gst_no" class="form-control"
                                                    name="gst_no">
                                            </div>


                                            <div class="col-md-6">
                                                <label for="remarks">Remarks</label>
                                                <input type="text" id="remarks" class="form-control"
                                                    name="remarks">
                                            </div>
                                        </div>
                                        <div class=" row mb-3">
                                            @role('admin')

                                              <div class="col-md-6">
                                                  <label for="created_by">Created By*</label>
                                                      <select class="form-control " id="created_by"
                                                      name="created_by" required >
                                                      <option value="none">None</option>
                                                      @foreach ($users as $item)
                                                        <option value="{{$item->id}}">{{$item->name}}</option>
                                                      @endforeach
                                                      <option value="USD">USD</option>
                                                  </select>
                                              </div>

                                            @endrole
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
        $(function() {
            $('#ClientUpdate').on('submit', function(e) {
                e.preventDefault();
                let fd = new FormData(this);
                fd.append('_token', "{{ csrf_token() }}");
                $.ajax({
                    url: "{{ route('admin.save_clients') }}",
                    type: "POST",
                    data: fd,
                    dataType: 'json',
                    processData: false,
                    contentType: false,
                    beforeSend: function() {
                        $("#load").show();
                    },
                    success: function(result) {
                        if (result.status) {
                            toast.success(result.msg);
                            setTimeout(function() {
                                window.location.href = result.location;
                            }, 2000);
                        } else {
                            toast.error(result.msg);
                        }
                    },
                    complete: function() {
                        $("#load").hide();
                    },
                    error: function(jqXHR, exception) {}
                });
            })
        });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>

    <script>
        function ShowHideStateDetails() {
            if (document.getElementById("ai_country").value == 'India') {
                document.getElementById("ai_other_state").style.display = 'none';
                document.getElementById("ai_ind_state").style.display = '';
            } else {
                document.getElementById("ai_ind_state").style.display = 'none';
                document.getElementById("ai_other_state").style.display = '';
            }
        }
    </script>
@endsection
