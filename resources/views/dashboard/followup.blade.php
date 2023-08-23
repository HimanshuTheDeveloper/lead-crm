@extends('layout.app')

@section('title')
    <title> Followup Dashboard</title>
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
                <div class="d-flex justify-content-between">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item"><a href="{{route("user.dashboard")}}">Dashboard</a></li>
                      <li class="breadcrumb-item active" aria-current="page">Leads</li>
                    </ol>
                </nav>
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
                                        <h3 class="card-title">Followup Lead List</h3>
                                    </div>
                                  </div>
                                  <!-- /.card-header -->
                                  <div class="card-body">
                                    <table id="userDetails" class="table table-bordered table-hover">
                                      <thead>
                                      <tr>
                                        <th>Lead Number</th>
                                        <th>Lead Date</th>
                                        <th>Followup Date</th>
                                        <th>Work Description</th>
                                        <th>Client Name</th>
                                        <th>Client Email</th>
                                        <th>Alt Email</th>
                                        <th>Client Mobile</th>
                                        <th>Alt Mobile</th>
                                        <th>Skype</th>
                                        <th>Followed</th>
                                        <th>Services</th>
                                        <th>Country</th>
                                        <th>State</th>
                                        <th>City</th>
                                        <th>Address</th>
                                        <th>Status</th>
                                        <th>Domain Name</th>
                                        {{-- <th>Amount</th> --}}
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

    $.fn.tableload = function(status=null , lead_from_date=null, lead_to_date=null, follow_from_date=null ,follow_to_date=null) {
        var dataArray = new Array();
        var dataArray = {
            'status': status,
            'lead_from_date': lead_from_date,
            'lead_to_date': lead_to_date,
            'follow_from_date': follow_from_date,
            'follow_to_date': follow_to_date,
        };

        console.log(dataArray);

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
          url: "{{ route('admin.followup_list') }}",
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
              return JSON.stringify(json);;
          }
      },
      "order": [
          [0, 'DESC']
      ],
      "columns": [
        {
              "width": "10%",
              "targets": 20,
              "name": "lead_number",
              'searchable': true,
              'orderable': true
          },
      
          {
              "width": "10%",
              "targets": 0,
              "name": "lead_number",
              'searchable': true,
              'orderable': true
          },
      
          {
              "width": "10%",
              "targets": 1,
              "name": "lead_date",
              'searchable': true,
              'orderable': true
          },
      
          {
              "width": "10%",
              "targets": 2,
              "name": "followup_date",
              'searchable': true,
              'orderable': true
          },
      
          {
              "width": "10%",
              "targets": 3,
              "name": "work_description",
              'searchable': true,
              'orderable': true
          },
      
          {
              "width": "10%",
              "targets": 4,
              "name": "name",
              'searchable': true,
              'orderable': true
          },
          {
              "width": "10%",
              "targets": 5,
              "name": "email",
              'searchable': true,
              'orderable': true
          },
          {
              "width": "10%",
              "targets": 6,
              "name": "alt_email",
              'searchable': true,
              'orderable': true
          },
          {
              "width": "10%",
              "targets": 7,
              "name": "mobile",
              'searchable': true,
              'orderable': true
          },
          {
              "width": "10%",
              "targets": 8,
              "name": "skype",
              'searchable': true,
              'orderable': true
          },
          {
              "width": "10%",
              "targets": 9,
              "name": "followed",
              'searchable': true,
              'orderable': true
          },
          {
              "width": "10%",
              "targets": 10,
              "name": "services",
              'searchable': true,
              'orderable': true
          },
          {
              "width": "10%",
              "targets": 11,
              "name": "country",
              'searchable': true,
              'orderable': true
          },
          {
              "width": "10%",
              "targets": 12,
              "name": "state",
              'searchable': true,
              'orderable': true
          },
          {
              "width": "10%",
              "targets": 13,
              "name": "city",
              'searchable': true,
              'orderable': true
          },
          {
              "width": "10%",
              "targets": 14,
              "name": "address",
              'searchable': true,
              'orderable': true
          },
          {
              "width": "10%",
              "targets": 15,
              "name": "status",
              'searchable': true,
              'orderable': true
          },
          {
              "width": "10%",
              "targets": 16,
              "name": "domain_name",
              'searchable': true,
              'orderable': true
          },
        //   {
        //       "width": "10%",
        //       "targets": 17,
        //       "name": "amount",
        //       'searchable': true,
        //       'orderable': true
        //   },
          {
              "width": "10%",
              "targets": 18,
              "name": "comment",
              'searchable': true,
              'orderable': true
          },
          {
              "width": "10%",
              "targets": 19,
              "name": "created_by",
              'searchable': true,
              'orderable': true
          },
          {
              "width": "10%",
              "targets": 20,
              "name": "action",
              'searchable': true,
              'orderable': true
          }

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
                                    url: "",
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
                                            window.location.reload();
                                        }, 2000);
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