{{-- <h1>coming soon</h1> --}}

@extends('layout.app')

@section('title')
    <title>Payments</title>
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
                            <li class="breadcrumb-item"><a href="{{ route('admin.payments') }}">Payment</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Add Payments</li>
                        </ol>
                    </nav>
                    <!-- [ breadcrumb ] end -->
                    <div class="main-body">
                        <div class="page-wrapper">
                            <form id="PaymentUpdate" autocomplete="off">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="d-flex justify-content-between">
                                            <h3 class="card-title">Add Payments</h3>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row mb-3">
                                            <div class="col-md-2 offset-md-3">
                                                <div class="form-check">
                                                    <input class="form-check-input invoice_type" type="radio"
                                                        name="invoice_type" id="invoice_type" value="gst" checked>
                                                    <label class="form-check-label" for="invoice_type">
                                                        GST
                                                    </label>

                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-check">
                                                    <input class="form-check-input invoice_type" type="radio"
                                                        name="invoice_type" id="invoice_type" value="export">
                                                    <label class="form-check-label" for="invoice_type">
                                                        Export
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-check">
                                                    <input class="form-check-input invoice_type" type="radio"
                                                        name="invoice_type" id="invoice_type" value="non_gst">
                                                    <label class="form-check-label" for="invoice_type">
                                                        NON GST
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            {{-- <div class="col-md-6">
                      <label for="firstName">Invoice Id*</label>
                      <input type="text" id="invoice_id" class="form-control" value="{{$invoice_id}}" name="invoice_id" required>
                    </div> --}}
                                            <div class="col">
                                                <label for="client">Client</label>
                                                <select class="form-control" name="client" id='client' required>
                                                    <option>--select client--</option>
                                                    @foreach ($clients as $client)
                                                        <option value="{{ $client->id }}">{{ $client->name }} &nbsp;
                                                            ({{ $client->email }})</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="job_description">Job Description</label>
                                                <input type="text" id="job_description" class="form-control"
                                                    name="job_description" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card">
                                    <div class="card-body">
                                        <div class="row mb-3 htmldata">
                                            <div class="col-md-11">
                                                <div class="row mb-3">
                                                    <div class="col-md-3">
                                                        <label for="email">Service Name*</label>
                                                        <input type="text" id="service_name" class="form-control"
                                                            name="service_name[]" required>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label for="currency">Currency*</label>
                                                        <select class="form-control parentCurrency" id="currency"
                                                            name="currency[]" required>
                                                            <option value="USD">USD</option>
                                                            <option value="GBP">GBP</option>
                                                            <option value="INR" selected>INR</option>
                                                            <option value="CAD">CAD</option>
                                                            <option value="EURO">EURO</option>
                                                            <option value="AED">AED</option>
                                                            <option value="SAR">SAR</option>
                                                            <option value="AUD">AUD</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label for="amount">Amount*</label>
                                                        <input type="number" min="0" value="0" step="any"
                                                            id="amount" class="form-control" name="amount[]" required>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label for="remarks">Remarks </label>
                                                        <textarea id="service_remarks" class="form-control" name="service_remarks[]"></textarea>
                                                    </div>

                                                </div>
                                            </div>

                                            <div class="col-md-1">
                                                <div class="d-flex flex-row justify-content-center mt-4">
                                                    <button type="button" class="btn btn-success btn-sm addBtn"><i
                                                            class="fa fa-plus" aria-hidden="true"></i></button>
                                                    {{-- <button type="button"  class="btn btn-danger btn-sm removeBtn">-</button> --}}
                                                </div>
                                            </div>

                                        </div>
                                        <div class="add-more">
                                        </div>
                                    </div>
                                </div>


                                <div class="card">

                                    <div class="card-body">

                                        <div class="row mb-3">

                                            <div class="col-md-6">
                                                <label for="payment_date">Payment Date*</label>
                                                <input type="date" id="payment_date" class="form-control"
                                                    name="payment_date" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="remarks">Remarks </label>
                                                <textarea id="remarks" class="form-control" name="remarks"></textarea>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="invoice_date">Invoice Date*</label>
                                                <input type="date" id="invoice_date" class="form-control"
                                                    name="invoice_date" required>
                                            </div>

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
        $(document).ready(function() {
            
            var html = `<div class="row mb-3  htmldata">
                    <div class="col-md-11">
                      <div class="row mb-3">
                        <div class="col-md-3">
                          <label for="email">Service Name*</label>
                          <input type="text" id="service_name" class="form-control" name="service_name[]" required>
                        </div>
                    
                        <div class="col-md-3">
                          <label for="currency">Currency*</label>
                          <input type="text" class="form-control childCurrency" id="currency" name="currency[]" disabled required>
                        </div>
                        <div class="col-md-3">
                          <label for="amount">Amount*</label>
                          <input type="number"  min="0" value="0" step="any" id="amount" class="form-control" name="amount[]" required>
                        </div>
                        <div class="col-md-3">
                          <label for="remarks">Remarks </label>
                          <textarea id="service_remarks" class="form-control" name="service_remarks[]"></textarea>
                        </div>
                      </div>
                    </div>

                    <div class="col-md-1">
                      <div class="d-flex flex-row justify-content-center mt-4">
                        <button type="button"  class="btn btn-danger btn-sm removeBtn"><i class="fa fa-minus" aria-hidden="true"></i></button>
                      </div>
                    </div>

                  </div>

                  `;


            $(".addBtn").click(function() {
                $(".add-more").after(html);
                $('.childCurrency').val($('.parentCurrency').val());
            });

            $("body").on("click", ".removeBtn", function() {
                $(this).parents(".htmldata").remove();
            });

            $('#currency').on('change', function(e) {
                e.preventDefault();
                $('.childCurrency').val($('.parentCurrency').val());
            })
        });
    </script>

    <script>
        $(function() {

            $('#PaymentUpdate').on('submit', function(e) {
                e.preventDefault();
                let fd = new FormData(this);
                fd.append('_token', "{{ csrf_token() }}");
                $.ajax({
                    url: "{{ route('admin.save_payments') }}",
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

            $('input[type=radio][name=invoice_type]').on('change', function(e) {
                e.preventDefault();
                var value = $(this).val();
                let fd = new FormData();
                fd.append('invoice_type', value);
                fd.append('_token', "{{ csrf_token() }}");
                $.ajax({
                    url: "{{ route('admin.getInvoiceCode') }}",
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
                            $('#invoice_id').val(result.invoice_id);
                        } else {
                            toast.error(result.msg);
                        }

                    },
                    complete: function() {
                        $("#load").hide();
                    },
                    error: function(jqXHR, exception) {}
                });
            });

        });
    </script>
@endsection
