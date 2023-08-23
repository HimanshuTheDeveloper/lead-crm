@extends('layout.app')

@section('title')
    <title>Hosting</title>
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
                <!-- [ breadcrumb ] start -->
                <div class="d-flex justify-content-between">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item"><a href="{{route("user.dashboard")}}">Dashboard</a></li>
                      <li class="breadcrumb-item active" aria-current="page">Hosting</li>
                    </ol>
                  </nav>
                  <div>
                    <a class="px-3 py-2 rounded btn-success btn-sm" href="{{asset('/public/dummy/exportHosting.xlsx')}}"><i class="fa fa-file">&nbsp; Dummy Import file</i></a>
                  </div>
                </div>
                <!-- [ breadcrumb ] end -->
                <div class="main-body">
                    <div class="page-wrapper">
                        <div class="container-fluid">
                            <div class="row">
                              <div class="col-12">
                                <div class="card">
                                  <div class="card-header">
                                    <div class="d-flex justify-content-between">
                                        <h3 class="card-title">Hosting List</h3>
                         
                                        <form action="{{route('admin.hosting-view')}}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                        <div>  
                                        <input type="file" name="file" class="px-3 py-2 bg-light">
                                        <button  type="submit" class="px-3 py-2 rounded btn-primary">Import Hosting</button>
                                    </form>
                                        <a class="px-3 py-2 rounded btn-success" href="{{ route('admin.export-hostings') }}">Export Hosting</a>
                                        <a href="{{route("admin.add_hosting")}}" class="px-3 py-2 rounded btn-primary">Add Hosting</a>
                                        </div>
                                    </div>

                                  </div>
                                  <!-- /.card-header -->
                                  <div class="card-body">
                                    
                                    <table id="userDetails" class="table table-bordered table-hover">
                                      <thead>
                                      <tr>
                                        <th>Client Name</th>
                                        <th>Expiry date</th>
                                        <th>Registration date</th>
                                        <th>Domain name</th>
                                        <th>Server</th>
                                        <th>Currency</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                        <th>Comment</th>
                                        <th>Created By</th>
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
    $.fn.tableload = function() {
    $('#userDetails').dataTable({
      "scrollX": true,
      "processing": true,
      pageLength: 10,
      "serverSide": true,
      "bDestroy": true,
      'checkboxes': {
          'selectRow': true
      },
      "ajax": {
          url: "{{ route('admin.hosting_list') }}",
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
              "name": "name",
              'searchable': true,
              'orderable': true
          },
      
          {
              "width": "10%",
              "targets": 1,
              "name": "expiry_date",
              'searchable': true,
              'orderable': true
          },
      
          {
              "width": "10%",
              "targets": 2,
              "name": "registration_date",
              'searchable': true,
              'orderable': true
          },
      
          {
              "width": "10%",
              "targets": 3,
              "name": "domain_name",
              'searchable': true,
              'orderable': true
          },
      
          {
              "width": "10%",
              "targets": 4,
              "name": "server",
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
              "name": "status",
              'searchable': true,
              'orderable': true
          },
          {
              "width": "10%",
              "targets": 8,
              "name": "remarks",
              'searchable': true,
              'orderable': true
          },
          {
              "width": "10%",
              "targets": 9,
              "name": "created_by",
              'searchable': true,
              'orderable': true
          },
          {
              "width": "10%",
              "targets": 10,
              "name": "action",
              'searchable': true,
              'orderable': true
          },

      ]
    });
    }
    $.fn.tableload();


    $('body').on("click", ".deleteHosting", function(e) {
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
                                    url: "{{ route('admin.hosting_delete') }}",
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