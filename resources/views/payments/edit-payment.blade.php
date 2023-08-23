{{-- <h1>coming soon</h1> --}}

@extends('layout.app')

@section('title')
<title>Edit Payments</title>
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
            {{-- <li class="breadcrumb-item"><a href="{{route("user.dashboard")}}">Dashboard</a></li> --}}
            <li class="breadcrumb-item"><a href="{{route("admin.payments")}}">Payment</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit Payments</li>
          </ol>
        </nav>
        <!-- [ breadcrumb ] end -->
        <div class="main-body">
          <div class="page-wrapper">
            <form id="PaymentUpdate">
              <input type="hidden" class="form-control" name="payments_id" value="{{$payment->id}}">
              {{-- <input type="hidden" class="form-control" name="" value="{{$services->id}}"> --}}
              <div class="card">
                <div class="card-header">
                  <div class="d-flex justify-content-between">
                    <h3 class="card-title">Edit Payments</h3>
                  </div>
                </div>
                <div class="card-body">

                  <div class="row mb-3">
                    <div class="col-md-2 offset-md-3">
                      <div class="form-check">
                        <input class="form-check-input invoice_type" type="radio" name="invoice_type" id="invoice_type" value="gst" {{$payment->invoice_type == 'gst'? 'checked' : ''}} disabled>
                        <label class="form-check-label" for="invoice_type">
                          GST
                        </label>
                       
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-check">
                        <input class="form-check-input invoice_type" type="radio" name="invoice_type" id="invoice_type" value="export"  {{$payment->invoice_type == 'export'? 'checked' : ''}} disabled>
                        <label class="form-check-label" for="invoice_type">
                          Export
                        </label>
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-check">
                        <input class="form-check-input invoice_type"  type="radio" name="invoice_type" id="invoice_type" value="non_gst" {{$payment->invoice_type == 'non_gst'? 'checked' : ''}} disabled>
                        <label class="form-check-label" for="invoice_type">
                          NON GST
                        </label>
                      </div>
                    </div>
                  </div>

                  <div class="row mb-3">
                    {{-- <div class="col-md-6">
                      <label for="firstName">Invoice Id*</label>
                      <input type="text" id="invoice_id" class="form-control" value="{{$payment->invoice_id}}" name="invoice_id" disabled
                        required>
                    </div> --}}
                    <div class="col">
                      <label for="client">Client Name</label>
                      <select class="form-control" name="client" id='client'  required>
                          <option>--select client--</option>
                          @foreach($clients as $client)
                              <option value="{{$client->id}}" {{$client->id == $payment->client ? 'selected' : ''}}>{{$client->name}} &nbsp; ({{$client->email}})</option>
                          @endforeach
                      </select>
                    </div>




                  </div>
                  <div class="row mb-3">
                    <div class="col-md-6">
                      <label for="job_description">Job Description</label>
                      <input type="text" id="job_description" value="{{$payment->job_description}}" class="form-control" name="job_description" required>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card">
                <div class="card-body">
                  @foreach ($services as $key=>$service)
                  <div class="row mb-3 htmldata">
                    <div class="col-md-11">
                      <div class="row mb-3">
                        <div class="col-md-3">
                          <label for="email">Service Name</label>
                          <input type="text" id="service_name"  class="form-control"  name="service_name[]" value="{{$service->service_name}}" >
                        </div>
                        <div class="col-md-3">
                          <label for="currency">Currency</label>
                          <select class="form-control" id="currency" name="currency[]" >
                            <option value="USD" {{$service->currency == "USD" ? "selected" : ""}}>USD</option>
                            <option value="GBP" {{$service->currency =="GBP" ? "selected" : ""}}>GBP</option>
                            <option value="INR" {{$service->currency =="INR" ? "selected" : ""}}>INR</option>
                            <option value="CAD" {{$service->currency =="CAD" ? "selected" : ""}}>CAD</option>
                            <option value="EURO" {{$service->currency =="EURO" ? "selected" : ""}}>EURO</option>
                            <option value="AED" {{$service->currency =="AED"  ? "selected" : ""}}>AED</option>
                            <option value="SAR" {{$service->currency =="SAR" ? "selected" : ""}}>SAR</option>
                            <option value="AUD" {{$service->currency =="AUD" ? "selected" : ""}}>AUD</option>
                          </select>
                        </div>
                        <div class="col-md-3">
                          <label for="amount">Amount</label>
                          <input type="text" id="amount" class="form-control" name="amount[]"  value="{{$service->amount}}" >
                        </div>
                        <div class="col-md-3">
                          <label for="remarks">Remarks</label>
                          <textarea id="service_remarks" class="form-control" name="service_remarks[]"> {{$service->service_remarks}} </textarea>
                        </div>
                      </div>
                    </div>

                    <div class="col-md-1">
                      <div class="d-flex flex-row justify-content-center mt-4">

                        @if ($key < 1)
                          <button type="button" class="btn btn-success btn-sm addBtn">+</button>
                        @else
                          <button type="button"  class="btn btn-danger btn-sm removeBtn">-</button>  
                        @endif

                      </div>
                    </div>

                  </div>
                      
                  @endforeach
                  <div class="add-more">

                  </div>
                </div>
              </div>
              <div class="card">
                <div class="card-body">
                  <div class="row mb-3">
                    <div class="col-md-6">
                      <label for="payment_date">Payment Date*</label>
                      <input type="date" id="payment_date"  value="{{$payment->payment_date}}" class="form-control" name="payment_date">
                    </div>
                    <div class="col-md-6">
                      <label for="remarks">Remarks*</label>
                      <textarea id="remarks" name="remarks" class="form-control">{{$payment->remarks}}</textarea>
                    </div>
                  </div>

                  <div class="row mb-3">
                    <div class="col-md-12">
                      <div class="alert alert-danger alert-sm" role="alert">
                        Please make sure your Invoice date month and year (DD-<span class="text-dark"><b><i>MM</i></b></span>-YY<span class="text-dark"><b><i>YY</i></b></span>) is same for Invoice Id (B-<span class="text-dark"><b><i>YY</i></b></span>-<span class="text-dark"><b><i>MM</i></b></span>-PK) .
                      </div>
                    </div>
                    <div class="col-md-6">
                      <label for="invoice_date">Invoice Date*</label>
                      <input type="date" id="invoice_date" class="form-control" value="{{$payment->invoice_date}}" name="invoice_date">
                    </div>
                    <div class="col-md-6">
                      <label for="invoice_id">Invoice Id</label>
                      <input type="text" id="invoice_id" class="form-control" value="{{$payment->invoice_id}}" name="invoice_id">
                    </div>
                  </div>

                  <div class="row mb-3">


                    <div class="col-md-6">
                      <label for="payment_status">Payment Status</label>
                      <select type="text" class="form-control" id="payment_status" name="payment_status">
                        <option value="Paid" {{$payment->payment_status === "Paid" ? "selected": ""}}>Paid</option>
                        <option value="Unpaid"  {{$payment->payment_status === "Unpaid" ? "selected": ""}}>Unpaid</option>
                      </select>
                    </div>

                 
                  </div>



                  <button type="submit" class="btn btn-primary">Save</button>

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
  
</script>



<script>
      $(document).ready(function() {

        var html = ` <div class="row mb-3  htmldata">
                    <div class="col-md-11">
                      <div class="row mb-3">
                        <div class="col-md-3">
                          <label for="email">Service Name</label>
                          <input type="text" id="service_name" class="form-control" name="service_name[]">
                        </div>
                        <div class="col-md-3">
                          <label for="currency">Currency</label>
                          <select class="form-control" id="currency" name="currency[]">
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
                          <label for="amount">Amount</label>
                          <input type="text" id="amount" class="form-control" name="amount[]">
                        </div>
                        <div class="col-md-3">
                          <label for="remarks">Remarks</label>
                          <textarea id="service_remarks" class="form-control" name="service_remarks[]"></textarea>
                          </div>
                      </div>
                    </div>

                    <div class="col-md-1">
                      <div class="d-flex flex-row justify-content-center mt-4">
                        <button type="button"  class="btn btn-danger btn-sm removeBtn">-</button>
                      </div>
                    </div>

                  </div>
`;


  $(".addBtn").click(function(){ 
      $(".add-more").after(html);
  });

  $("body").on("click",".removeBtn",function(){ 
      $(this).parents(".htmldata").remove();
  });
  });




</script>

<script>
  $(function () {
    $('#PaymentUpdate').on('submit', function (e) {
      e.preventDefault()
      let fd = new FormData(this);
      fd.append('_token', "{{ csrf_token() }}");
      $.ajax({
        url: "{{ route('admin.update_payments') }}",
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
            toast.error(result.msg);
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