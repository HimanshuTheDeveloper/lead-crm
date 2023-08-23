@extends('layout.app')

@section('title')
    <title>Hosting</title>
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
                    <div class="d-flex justify-content-between">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Hosting Lookup Notification</li>
                            </ol>
                        </nav>

                    </div>
                    <div class="main-body">
                        <div class="page-wrapper">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <div class="d-flex justify-content-between mb-4">
                                                    <h3 class="card-title">Hosting Lookup</h3>
                                                </div>

                                                <ul class="nav nav-tabs">
                                                    <li class="nav-item">
                                                      <a class="nav-link active bg-warning" aria-current="page" href="{{route('admin.hostings_lookup')}}">Hosting Lookup Notification</a>
                                                    </li>
                                                    <li class="nav-item">
                                                      
                                                      <a class="nav-link" href="{{route('admin.expired_hostings_lookup')}}">Expired Hosting Lookup Notification</a>
                                                    </li>
                                                   
                                                  </ul>
                                            </div>
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
                                                            <th>Created Date</th>
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
        $(function() {
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
                        url: "{{ route('admin.hostings_lookup_list') }}",
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
                            "targets": 5,
                            "name": "amount",
                            'searchable': true,
                            'orderable': true
                        },
                        {
                            "width": "10%",
                            "targets": 6,
                            "name": "status",
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
                            "name": "action",
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
        });
    </script>
@endsection
