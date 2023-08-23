@extends('layout.app')

@section('title')
    <title> 
        @role('bdm')     
            BDM
        @endrole
        @role('admin')     
            Admin
        @endrole
        @role('hr')     
            Hr
        @endrole
        Dashboard
    </title>
    <style>
        .font
        {
            font-size:1rem;
            color:white;
        }
        #bgcolor
        {
            background-color: #ec4611c9;
        }

        .themebackground{
            color: #7f3bff;
        }
    </style>
@endsection
@section('extra_css')
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    
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
                    <li class="breadcrumb-item active" aria-current="page">Revenue</li>
                  </ol>
                </nav>
                <!-- [ breadcrumb ] end -->
                <div class="main-body">
                    <div class="page-wrapper">
                        <div class="card">
                            <div class="card-body">
                             
                                <h2 class="text-center">Revenue</h2>
                                <form id="revenueData">
                                    <div class="row mt-3 mb-4">
                                        <div class="col">
                                            <div class="mb-3">
                                              <label for="exampleInputEmail1" class="form-label">From Date</label><br>
                                              <select name="user" class="px-2 py-1 bg-light rounded border" id="user">
                                                <option value="0">All</option>
                                                @foreach ($users as $item)
                                                  <option value="{{$item->id}}">{{$item->name}} 
                                                    {{-- &nbsp;({{$item->email}}) --}}
                                                  </option>
                                                @endforeach
                                            </select>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="mb-3">
                                              <label for="exampleInputEmail1" class="form-label">From Date</label><br>
                                              <input type="date" class="px-2 py-1 bg-light rounded border" name="from_date"  required>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="mb-3">
                                              <label for="exampleInputEmail1" class="form-label">To Date</label><br>
                                              <input type="date" class="px-2 py-1 bg-light rounded border"  name="to_date" required> 
                                            </div>
                                        </div>


                                      <div class="col">
                                          <div class="mb-3">
                                            <label for="exampleInputEmail1" class="form-label">Payment Status</label><br>
                                            <select class="px-2 py-1 bg-light rounded border" name="payment_status"  >
                                              <option value="">All</option>
                                              <option value="Paid">Paid</option>
                                              <option value="Unpaid">Unpaid</option>
                                            </select>
                                          </div>
                                      </div>




                                        <div class="col">
                                            <label for="exampleInputEmail1" class="form-label">Filter</label><br>
                                            <button type="submit" class="px-2 py-1 btn-primary w-100">Filter</button>
                                        </div>
                                    </div>
                                  </form>

                                  <div class="row ">
                                    <div class="col-md-12 ">
                                      <table class="table table-sm table-secondary">
                                        <thead class="bg-dark text-white"> 
                                          <tr>
                                            <th scope="col">Invoice Id</th>
                                            <th scope="col">Client Email</th>
                                            <th scope="col">Created By</th>
                                            <th scope="col">Amount</th>
                                            <th scope="col">Currency</th>
                                            <th scope="col">Date</th>
                                          </tr>
                                        </thead>
                                        <tbody class="append">
                                         
                                        </tbody>
                                      </table>
                                    </div>
                                  </div>

                                  <div class="row mb-5 mt-3">
                                        <div class="col-12 ">
                                            <div class="card card-stats mb-4 mb-xl-0  shadow-lg">
                                              <div class="card-body">
                                                <div class="row">
                                                  <div class="col">
                                                    <h5 class="card-title text-uppercase text-muted mb-5">Revenue Amount</h5>
                                                  </div>
                                                  <div class="col-auto">
                                                    <div class="">
                                                        <h5 class="card-title text-uppercase text-muted  mb-5">Currency</h5>
                                                    </div>
                                                  </div>
                                                </div>

                                                <div class="appendRevenue">

                                                </div>

                                              

                                              </div>
                                            </div>
                                          </div>
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
      $('#revenueData').on('submit', function(e){
          e.preventDefault();
          let fd = new FormData(this);
          fd.append('_token',"{{ csrf_token() }}");
          $.ajax({
              url: "{{route('admin.revenueData')}}",
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

                            var html = '';
                          $.each(result.data.payments,function(i,val) { 
                            html += `<tr>
                                      <td>${val.invoice_id}</td>
                                      <td>${val.email}</td>
                                      <td>${val.created_by_name}</td>
                                      <td>${val.total_amount}</td>
                                      <td>${val.currency}</td>
                                      <td>${val.payment_date}</td>
                                    </tr>`;
                          });
                          $('.append').html(html);

                          var html2 = '';
                          $.each(result.data.revenue,function(i,val) {

                            html2 += `<div class="row mb-4">
                                                        <div class="col">
                                                          <span class="h2 font-weight-bold">${val.revenueAmount}</span>
                                                        </div>
                                                        <div class="col-auto">
                                                          <div class="">
                                                              <span class="h2 font-weight-bold">${val.currency}</span>
                                                          </div>
                                                        </div>
                                                      </div> `;
                          });
                          $('.appendRevenue').html(html2)

                  }
                  else
                  {
                    $('.append').html(" ");
                    $('.appendRevenue').html(" ");
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