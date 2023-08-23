@extends('layout.app')

@section('title')
    <title>Edit Expenses</title>
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
                      <li class="breadcrumb-item"><a href="{{route("admin.expense")}}">Expenses</a></li>
                      <li class="breadcrumb-item active" aria-current="page">Edit Expense</li>
                    </ol>
                </nav>
                <!-- [ breadcrumb ] end -->
                <div class="main-body">
                    <div class="page-wrapper">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex justify-content-between">
                                    <h3 class="card-title">Edit Expense</h3>
                                </div>
                              </div>
                            <div class="card-body">
                                <form id="ExpenseSubmit">
                                    <input type="hidden" name="id" value="{{$data->id}}">
                                    <div class="row mb-3">
                                        <div class="col-sm-6">
                                            <label for="type">Type</label>
                                            <select class="form-control" id="type" name="type" >
                                                <option value="Employee's Payout" {{$data->type == "Employee's Payout" ? "selected" : "" }}>Employee's Payout</option>
                                                <option value="Office Rent" {{$data->type == "Office Rent" ? "selected" : "" }}>Office Rent</option>
                                                <option value="Incentive" {{$data->type == "Incentive" ? "selected" : "" }}>Incentive</option>
                                                <option value="Server" {{$data->type == "Server" ? "selected" : "" }}>Server</option>
                                                <option value="Domain"  {{$data->type == "Office Rent" ? "selected" : "" }}>Domain</option>
                                                <option value="Content" {{$data->type == "Content" ? "selected" : "" }}>Content</option>
                                                <option value="Graphic" {{$data->type == "Graphic" ? "selected" : "" }}>Graphic</option>
                                                <option value="Outsourced work" {{$data->type == "Outsourced work" ? "selected" : "" }}>Outsourced work</option>
                                                <option value="Ads Expense" {{$data->type == "Ads Expense" ? "selected" : "" }}>Ads Expense</option>
                                                <option value="SEO Expense" {{$data->type == "SEO Expense" ? "selected" : "" }}>SEO Expense</option>
                                                <option value="Tea\coffee\water" {{$data->type == "Tea\coffee\water" ? "selected" : "" }}>Tea\coffee\water</option>
                                                <option value="Other Office" {{$data->type == "Other Office" ? "selected" : "" }}>Other Office</option>
                                                <option value="Misc" {{$data->type == "Misc" ? "selected" : "" }}>Misc</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="date">Date</label>
                                            <input type="date" id="date" class="form-control" name="date" value="{{$data->date}}" required>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="currency">Currency</label>
                                            <select class="form-control" id="currency" name="currency" >
                                                <option value="INR"  {{$data->currency == "INR" ? "selected" : "" }}>INR</option>
                                                <option value="USD"  {{$data->currency   == "USD" ? "selected" : "" }}>USD</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="amount">Amount</label>
                                            <input type="text" id="amount" class="form-control" name="amount" value="{{$data->amount}}" required>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="remarks">Remarks</label>
                                            <textarea id="remarks" class="form-control" name="remarks"  >{{$data->remarks}}</textarea>
                                        </div>
                                    </div>
                                   
                                    <button type="submit" class="btn btn-primary">Update</button>
                                  </form> 
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
        $('#ExpenseSubmit').on('submit', function(e){
            e.preventDefault()
            let fd = new FormData(this);
            fd.append('_token',"{{ csrf_token() }}");
            $.ajax({
                url: "{{route('admin.updateExpense')}}",
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

@endsection