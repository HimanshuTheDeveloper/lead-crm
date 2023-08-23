@extends('layout.app')

@section('title')
    <title>Leads</title>
@endsection

@section('extra_css')

{{-- <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css'> --}}
<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/css/bootstrap-select.min.css'>
<style>


        
    .fx_width{
      width: 8rem;
    }
    table.table-bordered.dataTable th, table.table-bordered.dataTable td {
    border-left-width: 0;
    padding: 8px;
}
.padding{
    padding-top: 2px;
    padding-bottom: 2px;
}
.padding-btn{
    padding-top: 4px;
    padding-bottom: 4px;
    padding-left: 10px;
    padding-right: 10px;
}


#Demo .bootstrap-select>.dropdown-toggle.bs-placeholder{
        color: #000;
        padding: 2px;
        border: 1px solid #000;
        background: transparent;
        border-radius: 2px;
      }

        #Demo .bootstrap-select.show-tick .dropdown-menu li a span.text {
            font-weight: normal;
            display: block;
            white-space: nowrap;
            min-height: 1.2em;
            padding: 0px 2px 1px;
        } 
        #Demo .dropdown-menu{
            border-color: #000;
        }  
        #Demo .form-control:focus{
            border-color : #000!important;
            box-shadow: none!important;
        }
  </style>
@endsection

@section('content')

<div class="pcoded-main-container">
    <div class="pcoded-wrapper">
        <div class="pcoded-content">
            <div class="pcoded-inner-content">
                <!-- [ breadcrumb ] start -->
                <div class="d-flex justify-content-between" >
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item"><a href="{{route("user.dashboard")}}">Dashboard</a></li>
                      <li class="breadcrumb-item active" aria-current="page">Leads</li>
                    </ol>
                  </nav>
                  <div>
                    <a class="px-2 py-2 rounded btn-success " href="{{asset('/public/dummy/dummy.xlsx')}}"><i class="fa fa-file">&nbsp; Dummy Import file</i></a>
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
                                        <h3 class="card-title">Lead List</h3>
                                        <form action="{{ route('admin.import') }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div>
                                            <input type="file" name="file" class=" bg-light " required>
                                            <button class=" rounded btn-primary">Import Lead</button>
                                            
                                        </form>
                                        <a class=" rounded btn-success padding-btn " href="{{ route('admin.export-leads') }}">Export Lead</a>
                                        <a href="{{route("admin.addleads")}}" class=" rounded btn-primary padding-btn">Add Lead</a>
                                        </div>
                                    </div>

                                  </div>
                                  <!-- /.card-header -->
                                  <div class="card-body">

                                    <form class="mb-5">
                                        <div class="d-flex justify-content-between flex-wrap">

                                            <div class="" id="Demo">
                                                <label for="status">Status</label><br>

                                                <select class="selectpicker padding"   multiple aria-label="Default select example" data-live-search="true" name="status[]"  id="status" multiple>
                                
                                                    <option value="all">All</option>
                                                    <option value="started conversation">Started Conversation</option>
                                                    <option value="following up">Following Up</option>
                                                    <option value="converted">Converted</option>
                                                    <option value="denied">Denied</option>
                                                    <option value="waiting response">Waiting Response</option>
                                                </select>

                                            </div>
                                           
                                           
                                            @role('admin')
                                            <div class="">
                                                <label for="user">User</label><br>
                                                <select name="user" class="padding" id="user">
                                                    <option value="">Select User</option>
                                                    <option value="">All</option>
                                                    @foreach ($users as $item)
                                                    <option value="{{$item->id}}">{{$item->name}} 
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>  
                                            @endrole
                                            @role('bdm')
                                            <div class="">
                                                <label for="user">User</label><br>
                                                <select name="user" class="padding" id="user">
                                                    <option value="">Select User</option>
                                                    <option value="">All</option>
                                                    @foreach ($users as $item)
                                                    <option value="{{$item->id}}">{{$item->name}} 
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>  
                                            @endrole
                                           

                                           

                                            <div class="">
                                                <label for="lead_from_date">Lead From Date</label><br>
                                                <input type="date" id="lead_from_date" class=""  name="lead_from_date">
                                            </div>
                                            <div class="">
                                                <label for="lead_to_date">Lead To Date </label><br>
                                                <input type="date" id="lead_to_date" class=""  name="lead_to_date">
                                            </div>
                                            <div class="">
                                                <label for="follow_from_date">Follow From Date</label><br>
                                                <input type="date" id="follow_from_date" class=""  name="follow_from_date">
                                            </div>
                                            <div class="">
                                                <label for="follow_to_date">Follow To Date</label><br>
                                                <input type="date" id="follow_to_date" class=""  name="follow_to_date">
                                            </div>
                                            <div class="">
                                            <button type="button" class="  px-3 btn-primary w-100 mt-4 btn-sm clickFilter">Filter</button>
                                            </div>
                                        </div>
                                    </form>
                                    <div class="table-responsive table-responsive-sm" id="myTable_wrapper">
                                    <table id="userDetails" class="table table-bordered table-hover">
                                      <thead>
                                      <tr>
                                        <th>Lead Number</th>
                                        <th>Lead Date</th>
                                        <th>Followup Date</th>
                                        <th>Work Description</th>
                                        <th>Client Name</th>
                                        <th>Client Email</th>
                                        {{-- <th>Alt Email</th> --}}
                                        <th>Client Mobile</th>
                                        {{-- <th>Alt Mobile</th> --}}
                                        {{-- <th>Skype</th> --}}
                                        <th>Followed</th>
                                        {{-- <th>Services</th> --}}
                                        <th>Country</th>
                                        <th>State</th>
                                        {{-- <th>City</th> --}}
                                        {{-- <th>Address</th> --}}
                                        <th>Status</th>
                                        <th>Reject Reason</th>
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

     <!-- Modal -->
     {{-- <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Follow Up</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                    <div class="form-group">
                      <input type="hidden" name="id" class="form-control" id="id" >
                      <label>Client Email</label>
                      <input type="text" name="client" class="form-control" id="client_details" disabled >
                    </div>
                    <div class="form-group">
                      <label for="client_resonse">Client Resonse</label>
                      <input type="text" name="client_resonse" class="form-control" id="client_response" placeholder="client resonse" required>
                    </div>
                    <div class="form-group">
                        <label for="your_response">Your Response</label>
                        <input type="text" name="your_response" class="form-control" id="your_response" placeholder="your response" required>
                    </div>
                    <div class="form-group">
                      <label for="followup_date">Followup Date </label>
                      <input type="datetime-local" name="followup_date" class="form-control" id="followup_date" placeholder="followup date" required>
                    </div>
            </div>
            <div class="modal-footer">
              <button type="button" id="LeadUpdate" class="btn btn-primary">Submit</button>
            </div>
          </div>
        </div>
      </div> --}}
  

@endsection

@section('extra_js')

{{-- <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js'></script> --}}
<script src='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/js/bootstrap-select.min.js'></script>




<script>

    $(function () {
            $('body').on("click", ".modalClick", function(e){
                // console.log( $(this).attr('data-id'));
                $("#client_details").val($(this).attr('data-email'));
                $("#id").val($(this).attr('data-id'))
                $('#exampleModal').modal('toggle');
            });

            $('body').on("click", "#LeadUpdate", function(e){
                e.preventDefault();
                let fd = new FormData();
                fd.append('client_resonse',$("#client_response").val());
                fd.append('your_response',$("#your_response").val());
                fd.append('followup_date',$("#followup_date").val());
                fd.append('lead_fk_id',$("#id").val());
                fd.append('_token',"{{ csrf_token() }}");
                $.ajax({
                    url: "{{ route('admin.lead_modal')}}",
                    type:"POST",
                    data: fd,
                    dataType:'json',
                    processData: false,
                    contentType: false,
                    beforeSend: function () {
                        $("#load").show();
                    },
                    success:function(result){
                        if(result.status)
                        {
                            toast.success(result.msg);
                            setTimeout(function(){
                                window.location.href = result.location;
                            }, 2000);
                        }
                        else
                        {
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
<script>

    $(function () {

        // $(document).ready(function() {
        //     var tableWrapper = $('#myTable_wrapper');

        //     $(document).keydown(function(e) {
        //         var keyCode = e.keyCode || e.which;

        //         if (keyCode === 37) {
        //             // Left arrow key
        //             tableWrapper.scrollLeft(tableWrapper.scrollLeft() - 50);
        //         } else if (keyCode === 39) {
        //             // Right arrow key
        //             tableWrapper.scrollLeft(tableWrapper.scrollLeft() + 50);
        //         }
        //     });
        // });

       
        $(".clickFilter").click(function(){
            var user = $("#user").val();
            var status = $("#status").val();
            var lead_from_date = $("#lead_from_date").val();
            var lead_to_date = $("#lead_to_date").val();
            var follow_from_date = $("#follow_from_date").val();
            var follow_to_date = $("#follow_to_date").val();
            $.fn.tableload(user ,status, lead_from_date, lead_to_date, follow_from_date,follow_to_date);

        });

    $.fn.tableload = function(user= null, status=null , lead_from_date=null, lead_to_date=null, follow_from_date=null ,follow_to_date=null) {
        var dataArray = new Array();
        var dataArray = {
            'user': user,
            'status': status,
            'lead_from_date': lead_from_date,
            'lead_to_date': lead_to_date,
            'follow_from_date': follow_from_date,
            'follow_to_date': follow_to_date,
        };

        console.log(dataArray);

     $('#userDetails').dataTable({
      scrollX: true,
      "processing": true,
      pageLength: 10,
      "serverSide": true,
      "bDestroy": true,
      'checkboxes': {
          'selectRow': true
      },
      "ajax": {
          url: "{{ route('admin.lead_list') }}",
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
              "targets": 0,
              "name": "lead_number",
              'searchable': true,
              'orderable': true
          },
      
          {
              "width": "10%",
              "targets": 1,
              "name": "lead_number",
              'searchable': true,
              'orderable': true
          },
      
          {
              "width": "10%",
              "targets": 2,
              "name": "lead_date",
              'searchable': true,
              'orderable': true
          },
      
          {
              "width": "10%",
              "targets": 3,
              "name": "followup_date",
              'searchable': true,
              'orderable': true
          },
      
          {
              "width": "10%",
              "targets": 4,
              "name": "work_description",
              'searchable': true,
              'orderable': true
          },
      
          {
              "width": "10%",
              "targets": 5,
              "name": "name",
              'searchable': true,
              'orderable': true
          },
          {
              "width": "10%",
              "targets": 6,
              "name": "email",
              'searchable': true,
              'orderable': true
          },
        //   {
        //       "width": "10%",
        //       "targets": 7,
        //       "name": "alt_email",
        //       'searchable': true,
        //       'orderable': true
        //   },
        //   {
        //       "width": "10%",
        //       "targets": 8,
        //       "name": "mobile",
        //       'searchable': true,
        //       'orderable': true
        //   },
        //   {
        //       "width": "10%",
        //       "targets": 9,
        //       "name": "skype",
        //       'searchable': true,
        //       'orderable': true
        //   },
          {
              "width": "10%",
              "targets": 10,
              "name": "followed",
              'searchable': true,
              'orderable': true
          },
        //   {
        //       "width": "10%",
        //       "targets": 11,
        //       "name": "services",
        //       'searchable': true,
        //       'orderable': true
        //   },
          {
              "width": "10%",
              "targets": 12,
              "name": "country",
              'searchable': true,
              'orderable': true
          },
          {
              "width": "10%",
              "targets": 13,
              "name": "state",
              'searchable': true,
              'orderable': true
          },
        //   {
        //       "width": "10%",
        //       "targets": 14,
        //       "name": "city",
        //       'searchable': true,
        //       'orderable': true
        //   },
        //   {
        //       "width": "10%",
        //       "targets": 15,
        //       "name": "address",
        //       'searchable': true,
        //       'orderable': true
        //   },
          {
              "width": "10%",
              "targets": 16,
              "name": "status",
              'searchable': true,
              'orderable': true
          },
          {
              "width": "10%",
              "targets": 17,
              "name": "reject_reason",
              'searchable': true,
              'orderable': true
          },
        //   {
        //       "width": "10%",
        //       "targets": 18,
        //       "name": "amount",
        //       'searchable': true,
        //       'orderable': true
        //   },
          {
              "width": "10%",
              "targets": 19,
              "name": "comment",
              'searchable': true,
              'orderable': true
          },
          {
              "width": "10%",
              "targets": 20,
              "name": "created_by",
              'searchable': true,
              'orderable': true
          },
          {
              "width": "10%",
              "targets": 21,
              "name": "action",
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
                                    url: "{{ route('admin.lead_delete') }}",
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