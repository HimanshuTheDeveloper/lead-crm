@extends('layout.app')

@section('title')
    <title>Annual Maintainance Charge</title>
@endsection

@section('extra_css')
<style>
    .fx_width{
      width: 8rem;
    }
    table.table-bordered.dataTable th, table.table-bordered.dataTable td {
            border-left-width: 0;
            padding: 8px;
        }
  </style>
@endsection

@section('content')

<div class="pcoded-main-container">
    <div class="pcoded-wrapper">
        <div class="pcoded-content">
            <div class="pcoded-inner-content">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item"><a href="{{route("user.dashboard")}}">Dashboard</a></li>
                      <li class="breadcrumb-item active" aria-current="page"> Expired AMC Notifications</li>
                    </ol>
                  </nav>
                <div class="main-body">
                    <div class="page-wrapper">
                        <div class="container-fluid">
                            <div class="row">
                              <div class="col-12">
                                <div class="card">
                                  <div class="card-header">
                                    <div class="d-flex justify-content-between mb-4">
                                        <h3 class="card-title">Expired Annual Maintainance Charge Notifications List</h3>
                                    </div>

                                    <ul class="nav nav-tabs">
                                        <li class="nav-item">
                                          <a class="nav-link " aria-current="page" href="{{route('admin.amc_lookup')}}">AMC  Notifications</a>
                                        </li>
                                        <li class="nav-item">
                                          
                                          <a class="nav-link active bg-warning" href="{{route('admin.expired_amc_lookup')}}">Expired AMC  Notifications</a>
                                        </li>
                                       
                                      </ul>

                                  </div>
                                  <div class="card-body">
                                    <table id="userDetails" class="table table-bordered table-hover">
                                      <thead>
                                      <tr>
                                        <th>AMC id</th>
                                        <th>Client</th>
                                        <th>Domain</th>
                                        <th>AMC start date</th>
                                        <th>AMC end date</th>
                                        <th>Currency</th>
                                        <th>Amount</th>
                                        <th>Remarks</th>
                                        <th>Created By</th>
                                        <th>Created At</th>
                                      </tr>
                                      </thead>
                                      <tbody>
                    
                                      </tbody>
                                    </table>
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


    $.fn.tableload = function() {
    $('#userDetails').dataTable({
      "scrollX": true,
    //   "processing": true,
      pageLength: 10,
      "serverSide": true,
      "bDestroy": true,
      'checkboxes': {
          'selectRow': true
      },
      "ajax": {
          url: "{{ route('admin.expired_amc_lookup_list') }}",
          "type": "POST",
          "data": function(d) {
              d._token = "{{ csrf_token() }}";
          },
          dataFilter: function(data) {
              var json = jQuery.parseJSON(data);
              json.recordsTotal = json.recordsTotal;
              json.recordsFiltered = json.recordsFiltered;
              json.data = json.data;
              return JSON.stringify(json);;
          }
      },
      "order": [
          [0, 'DESC']
      ],
      "columns": [
      
          {
              "width": "10%",
              "targets": 0,
              "name": "amc_id",
              'searchable': true,
              'orderable': true
          },
      
          {
              "width": "10%",
              "targets": 1,
              "name": "client_name",
              'searchable': true,
              'orderable': true
          },
      
          {
              "width": "10%",
              "targets": 2,
              "name": "domain_name",
              'searchable': true,
              'orderable': true
          },
      
          {
              "width": "10%",
              "targets": 3,
              "name": "amc_start_date",
              'searchable': true,
              'orderable': true
          },
      
          {
              "width": "10%",
              "targets": 4,
              "name": "amc_end_date",
              'searchable': true,
              'orderable': true
          },
          {
              "width": "10%",
              "targets": 5,
              "name": "currency",
              'searchable': true,
              'orderable': true
          },
          {
              "width": "10%",
              "targets": 6,
              "name": "amount",
              'searchable': true,
              'orderable': true
          },
          {
              "width": "10%",
              "targets": 7,
              "name": "remarks",
              'searchable': true,
              'orderable': true
          },
          {
              "width": "10%",
              "targets": 8,
              "name": "created_by",
              'searchable': true,
              'orderable': true
          },
          {
              "width": "10%",
              "targets": 8,
              "name": "created_at",
              'searchable': true,
              'orderable': true
          },
         

      ]
    });
    }
    $.fn.tableload();


    $('body').on("click", ".DeleteClient", function(e) {
                var id = $(this).data('id');
                let fd = new FormData();
                console.log(id);
                fd.append('id', id);
                fd.append('_token', '{{ csrf_token() }}');
                $.confirm({
                    title: 'Confirm!',
                    content: 'Sure you want to delete this product ?',
                    buttons: {
                        yes: function() {
                            $.ajax({
                                    url: "{{ route('admin.amc_delete') }}",
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