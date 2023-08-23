@extends('layout.app')

@section('title')
    <title>Payments</title>
@endsection

@section('extra_css')
    <style>
        .fx_width {
            width: 8rem;
        }

        table.table-bordered.dataTable th,
        table.table-bordered.dataTable td {
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
                            <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Payments</li>
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
                                                    <h3 class="card-title">Payments List</h3>
                                                    <div>
                                                        <a class="btn btn-success"
                                                            href="{{ route('admin.getPaymentData') }}">Export Payments</a>
                                                        <a href="{{ route('admin.add_payments') }}"
                                                            class="btn btn-primary">Add Payments</a>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="card-body pt-1">
                                                <form class="pb-2">
                                                    <div class="d-flex justify-content-around flex-wrap">

                                                        <div class="">
                                                            <label for="user">Created By</label><br>
                                                            <select name="user" class="padding" id="created_by">
                                                                <option value="">All</option>
                                                                @foreach ($users as $item)
                                                                    <option value="{{ $item->id }}">{{ $item->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div class="">
                                                            <label for="user">Invoice Type</label><br>
                                                            <select name="invoice_type" class="padding" id="invoice_type">
                                                                <option value="">All</option>
                                                                <option value="gst">Gst</option>
                                                                <option value="non_gst">Non Gst</option>
                                                                <option value="export">Export</option>
                                                            </select>
                                                        </div>

                                                        <div class="">
                                                            <label for="lead_from_date">Payment Status</label><br>
                                                            <select name="payment_status" class="padding"
                                                                id="payment_status">
                                                                <option value="">All</option>
                                                                <option value="Paid">Paid</option>
                                                                <option value="Unpaid">Unpaid</option>
                                                            </select>
                                                        </div>


                                                        <div class="">
                                                            <label for="invoice_from_date">Invoice From Date</label><br>
                                                            <input type="date" id="invoice_from_date" class=""  name="invoice_from_date">
                                                        </div>
                                                        <div class="">
                                                            <label for="invoice_to_date">Invoice To Date </label><br>
                                                            <input type="date" id="invoice_to_date" class=""  name="invoice_to_date">
                                                        </div>


                                                        <div class="">
                                                            <button type="button"
                                                                class="px-3 btn-primary w-100 mt-4 btn-sm clickFilter">Filter</button>
                                                        </div>
                                                    </div>
                                                </form>
                                                <table id="paymentDetails" class="table table-bordered table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>Invoice Id</th>
                                                            <th>Cilent Name</th>
                                                            <th>Job Description</th>
                                                            <th>Remarks</th>
                                                            <th>Payment Date</th>
                                                            <th>Invoice Date</th>
                                                            <th>Invoice Type</th>
                                                            <th>Currency</th>
                                                            <th>Total Amount</th>
                                                            <th>Created By</th>
                                                            <th>Payment Status</th>
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


    <!-- Modal -->
    <div class="modal fade" id="createInvoice" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Generate Invoice</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form id="generateInvoice">
                        <div class="form-group">
                            <label for="invoice_data">Invoice Type</label>
                            <input type="text" class="form-control" id="modal_invoice_type" name="invoice_type">
                            <input type="hidden" class="form-control" id="payment_id" name="payment_id">
                        </div>

                        <div class="form-group">
                            <label for="invoice_id">Invoice Id</label>
                            <input type="text" class="form-control" id="invoice_id" name="invoice_id">
                        </div>

                        <div class="form-group">
                            <label for="payment_status">Payment Status</label>
                            <select type="text" class="form-control" id="payment_status" name="payment_status">
                                <option value="Paid">Paid</option>
                                <option value="Unpaid">Unpaid</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary">Generate</button>
                    </form>

                </div>

            </div>
        </div>
    </div>
@endsection

@section('extra_js')
    <script>
        $(function() {

            $(".clickFilter").click(function() {
                var created_by = $("#created_by").val();
                var invoice_type = $("#invoice_type").val();
                var payment_status = $("#payment_status").val();
                var invoice_from_date = $("#invoice_from_date").val();
                var invoice_to_date = $("#invoice_to_date").val();
                $.fn.tableload(created_by, invoice_type, payment_status , invoice_from_date , invoice_to_date);
            });

            $.fn.tableload = function(created_by = null, invoice_type = null, payment_status = null , invoice_from_date = null , invoice_to_date = null)  {

                var dataArray = {
                    'created_by': created_by,
                    'invoice_type': invoice_type,
                    'payment_status': payment_status,
                    'invoice_from_date': invoice_from_date,
                    'invoice_to_date': invoice_to_date,
                };

                $('#paymentDetails').dataTable({
                    "scrollX": true,
                    //   "processing": true,
                    pageLength: 10,
                    "serverSide": true,
                    "bDestroy": true,
                    'checkboxes': {
                        'selectRow': true
                    },
                    "ajax": {
                        url: "{{ route('admin.payment_list') }}",
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
                        [0, 'desc']
                    ],
                    "columns": [{
                            "width": "10%",
                            "targets": 0,
                            "name": "invoice_id",
                            'searchable': true,
                            'orderable': true
                        },

                        {
                            "width": "10%",
                            "targets": 1,
                            "name": "client",
                            'searchable': true,
                            'orderable': true
                        },

                        {
                            "width": "10%",
                            "targets": 2,
                            "name": "job_description",
                            'searchable': true,
                            'orderable': true
                        },

                        {
                            "width": "10%",
                            "targets": 3,
                            "name": "remarks",
                            'searchable': true,
                            'orderable': true
                        },
                        {
                            "width": "10%",
                            "targets": 4,
                            "name": "payment_date",
                            'searchable': true,
                            'orderable': true
                        },
                        {
                            "width": "10%",
                            "targets": 5,
                            "name": "invoice_date",
                            'searchable': true,
                            'orderable': true
                        },
                        {
                            "width": "10%",
                            "targets": 6,
                            "name": "invoice_type",
                            'searchable': true,
                            'orderable': true
                        },
                        {
                            "width": "10%",
                            "targets": 7,
                            "name": "currency",
                            'searchable': true,
                            'orderable': true
                        },
                        {
                            "width": "10%",
                            "targets": 8,
                            "name": "total_amount",
                            'searchable': true,
                            'orderable': true
                        },
                        {
                            "width": "10%",
                            "targets": 9,
                            "name": "created_by_payment",
                            'searchable': true,
                            'orderable': true
                        },
                        {
                            "width": "10%",
                            "targets": 10,
                            "name": "payment_type",
                            'searchable': true,
                            'orderable': true
                        },
                        {
                            "width": "10%",
                            "targets": 11,
                            "name": "action",
                            'searchable': true,
                            'orderable': true
                        },
                    ]
                });

            }
            $.fn.tableload();

            $('body').on("click", ".DeletePayment", function(e) {
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
                                    url: "{{ route('admin.payment_delete') }}",
                                    type: 'POST',
                                    data: fd,
                                    dataType: "JSON",
                                    contentType: false,
                                    processData: false,
                                })
                                .done(function(result) {
                                    if (result.status) {
                                        toast.success(result.msg);
                                        setTimeout(function() {
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



            $('body').on("click", ".modalButton", function(e) {
                $('#createInvoice').modal('toggle');
                $('#payment_id').val($(this).data('payment_id'));
                $('#modal_invoice_type').val($(this).data('invoice_type'));
                $('#invoice_id').val($(this).data('invoice_id'));
            });

            $('#generateInvoice').on('submit', function(e) {
                e.preventDefault()
                let fd = new FormData(this);
                fd.append('_token', "{{ csrf_token() }}");
                $.ajax({
                    url: "{{ route('admin.saveInvoiceData') }}",
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
                                $('#createInvoice').modal('toggle');
                                $.fn.tableload();
                            }, 1000);
                        } else {
                            toast.warning(result.msg);
                        }
                    },
                    complete: function() {
                        $("#load").hide();
                    },
                    error: function(jqXHR, exception) {}
                });
            })



        });
    </script>
@endsection
