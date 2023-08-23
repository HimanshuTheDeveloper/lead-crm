@extends('layout.app')

@section('title')
    <title>Clients</title>
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
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item"><a href="{{route("user.dashboard")}}">Dashboard</a></li>
                      <li class="breadcrumb-item active" aria-current="page">Clients</li>
                    </ol>
                  </nav>
                <!-- [ breadcrumb ] end -->
                <div class="main-body">
                    <div class="page-wrapper">
                        <div class="container-fluid">
                            <div class="row">
                              <div class="col-12">
                                <div class="card">
                                  <div class="card-header">
                                    <div class="d-flex justify-content-between">
                                        <h3 class="p">Clients List</h3>
                                        <a href="{{route("admin.add_clients")}}" class="btn btn-primary btn-sm">Add Clients</a>
                                    </div>

                                  </div>
                                  <!-- /.card-header -->
                                  <div class="card-body table-responsive  table-responsive-sm">
                                    <table id="clientDetails" class="table table-bordered table-hover text-justify">
                                      <thead>
                                      <tr>
                                        {{-- <th>Profile Image</th> --}}
                                        <th>Client Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Country</th>
                                        <th>State</th>
                                        <th>Address</th>
                                        <th>GST Number</th>
                                        <th>Created By</th>
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
    $.fn.tableload = function() {
    $('#clientDetails').dataTable({
      "scrollX": true,
    //   "processing": true,
      pageLength: 10,
      "serverSide": true,
      "bDestroy": true,
      'checkboxes': {
          'selectRow': true
      },
      "ajax": {
          url: "{{ route('admin.client_list') }}",
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
        // {
        //       "width": "5%",
        //       "targets": 1,
        //       "name": "image",
        //       'searchable': true,
        //       'orderable': true
        //   },
          {
              "width": "5%",
              "targets": 0,
              "name": "name",
              'searchable': true,
              'orderable': true
          },
      
          {
              "width": "5%",
              "targets": 0,
              "name": "email",
              'searchable': true,
              'orderable': true
          },
      
          {
              "width": "5%",
              "targets": 0,
              "name": "phone",
              'searchable': true,
              'orderable': true
          },
      
          {
              "width": "5%",
              "targets": 0,
              "name": "country",
              'searchable': true,
              'orderable': true
          },
      
          {
              "width": "5%",
              "targets": 0,
              "name": "state",
              'searchable': true,
              'orderable': true
          },
          {
              "width": "5%",
              "targets": 0,
              "name": "address",
              'searchable': true,
              'orderable': true
          },
          {
              "width": "5%",
              "targets": 0,
              "name": "gst_no",
              'searchable': true,
              'orderable': true
          },
          {
              "width": "5%",
              "targets": 0,
              "name": "created_by",
              'searchable': true,
              'orderable': true
          },
          {
              "width": "5%",
              "targets": 0,
              "name": "remarks",
              'searchable': true,
              'orderable': true
          },
        //   {
        //       "width": "5%",
        //       "targets": 0,
        //       "name": "remarks",
        //       'searchable': true,
        //       'orderable': true
        //   },
          {
              "width": "5%",
              "targets": 0,
              "name": "action",
              'searchable': true,
              'orderable': true
          },
      
      ]
    });
    }
    $.fn.tableload();
//     $('#update_category').on('submit', function(e){
//         e.preventDefault()
//         let fd = new FormData(this);
//         fd.append('_token',"{{ csrf_token() }}");
//         $.ajax({
//             url: "{{ route('admin.user_list') }}",
//             type:"POST",
//             data: fd,
//             dataType: 'json',
//             processData: false,
//             contentType: false,
//             beforeSend: function () {
//                 $("#load").show();
//             },
//             success:function(result){
//                 if(result.status)
//                 {
//                     toast.success(result.msg);
//                     $("#submit_category").trigger( "reset" );
//                     setTimeout(function(){
//                                             window.location.reload();
//                                         }, 2000);
//                 }
//                 else
//                 {
//                     toast.error(result.msg);
//                 }
//             },
//             complete: function () {
//                 $("#load").hide();
//             },
//             error: function(jqXHR, exception) {
//             }
//         });
//     })


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
                                    url: "{{ route('admin.client_delete') }}",
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