
@extends('layout.app')

@section('title')
    <title>Expense</title>
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
                      <li class="breadcrumb-item active" aria-current="page">Expense</li>
                    </ol>
                  </nav>
                <!-- [ breadcrumb ] end -->
                <div class="main-body">
                    <div class="page-wrapper">
                        <div class="container-fluid">
                            <div class="row">
                              <div class="col-12">
                                <div class="card">
                                  <div class="card-header pb-0">
                                    <div class="d-flex justify-content-between">
                                        <h3 class="card-title">Expense List</h3>
                                         <div>
                                            <span class="px-5 py-3 rounded border btn-info h5">Total Expenses : <b><span id="total">0</span></b></span>
                                        </div>
                                        <div>
                                            <a href="{{route("admin.expenseExport")}}" class="px-3 py-2 rounded border btn-danger">Expense Export</a>
                                            <a href="{{route("admin.addExpense")}}" class="px-3 py-2 rounded border btn-primary">Add Expense</a>
                                        </div>
                                    </div>
                                  </div>

                                  <!-- /.card-header -->
                                  <div class="card-body pt-1">
                                        <div class="row">
                                            <div class="col-sm-3 offset-2">
                                                <div class="mb-3">
                                                  <label for="from_date" class="form-label">From Date</label><br>
                                                  <input type="date" name="from_date" class="px-3 py-2 rounded bg-light border" id="from_date">
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="mb-3">
                                                  <label for="to_date" class="form-label">To Date</label><br>
                                                  <input type="date" name="to_date" class="px-3 py-2 rounded bg-light border" id="to_date"> 
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <label for="exampleInputEmail1" class="form-label">Filter</label><br>
                                                <button type="submit" class="px-3 py-2 rounded border btn-primary w-100 clickFilter">Filter</button>
                                            </div>
                                        </div>
                                      
                                      <table id="paymentDetails" class="table table-bordered table-hover w-100">
                                        <thead>
                                        <tr>
                                          <th>Type</th>
                                          <th>Date</th>
                                          <th>Currency</th>
                                          <th>Amount</th>
                                          <th>Remarks</th>
                                          <th>Action</th>
                                        </tr>
                                        </thead>
                                      <tbody>
                                      </tbody>
                                    </table>
                                  </div>
                                  <!-- /.card-body -->
                                </div>
                                <!-- /.card -->
                    
                               
                                <!-- /.card -->
                              </div>
                              <!-- /.col -->
                            </div>
                            <!-- /.row -->
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
  
   $(".clickFilter").click(function(){
       var from_date = $("#from_date").val();
       var to_date = $("#to_date").val();
  
       $.fn.tableload(from_date,to_date);
   });
  
  $.fn.tableload = function( from_date =null,to_date=null) {
   var dataArray = new Array();
   var dataArray = {
       'from_date': from_date,
       'to_date': to_date,
   };
  
   console.log(dataArray);
  
  $('#paymentDetails').dataTable({
  "scrollX": true,
  "processing": true,
  pageLength: 10,
  "serverSide": true,
  "bDestroy": true,
  'checkboxes': {
     'selectRow': true
  },
  "ajax": {
     url: "{{ route('admin.expenseList') }}",
     "type": "POST",
     "data": function(d) {
         d._token = "{{ csrf_token() }}";
         d.data = dataArray;
     },
     dataFilter: function(data) {
         var json = jQuery.parseJSON(data);
         json.recordsTotal = json.recordsTotal;
         json.recordsFiltered = json.recordsFiltered;
         json.data = json.data;
         $('#total').html(json.total_amount);
         return JSON.stringify(json);;
     }
  },
  "order": [
     [0, 'desc']
  ],
  "columns": [
      {
                "width": "20%",
                "targets": 0,
                "name": "type",
                'searchable': true,
                'orderable': true
            },
        
            {
                "width": "20%",
                "targets": 0,
                "name": "date",
                'searchable': true,
                'orderable': true
            },
        
            {
                "width": "20%",
                "targets": 0,
                "name": "currency",
                'searchable': true,
                'orderable': true
            },
        
            {
                "width": "20%",
                "targets": 0,
                "name": "amount",
                'searchable': true,
                'orderable': true
            },
            {
                "width": "20%",
                "targets": 0,
                "name": "remarks",
                'searchable': true,
                'orderable': true
            },
            {
                "width": "20%",
                "targets": 0,
                "name": "action",
                'searchable': true,
                'orderable': true
            },   
  ]
  });
  }
  $.fn.tableload();
  $('body').on("click", ".deleteExpense", function(e) {
                  var id = $(this).data('id');
                  let fd = new FormData();
                  console.log(id);
                  fd.append('id', id);
                  fd.append('_token','{{ csrf_token() }}');
                  $.confirm({
                      title: 'Confirm!',
                      content: 'Sure you want to delete this product ?',
                      buttons: {
                          yes: function() {
                              $.ajax({
                                      url: "{{ route('admin.delete_expense') }}",
                                      type: 'POST',
                                      data: fd,
                                      dataType: "JSON",
                                      contentType: false,
                                      processData: false,
                                  })
                                  .done(function(result) {
                                      if (result.status) {
                                          toast.success(result.msg);
                                          setTimeout(function(){
                                            $.fn.tableload();
                                        }, 1000);
                                      } else {
                                          toast.error(result.msg);
                                      }
                                  })
                                  .fail(function(jqXHR, exception) {
                                      console.log(jqXHR.responseText);
                                  })
                          },
                          no: function() {},
                      }
                  })
              });
  
  });
  </script>
@endsection