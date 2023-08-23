@extends('layout.app')

@section('title')
    <title>Add Hosting</title>
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
                      <li class="breadcrumb-item active" aria-current="page">Add Expense</li>
                    </ol>
                  </nav>
                <!-- [ breadcrumb ] end -->
                <div class="main-body">
                    <div class="page-wrapper">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex justify-content-between">
                                    <h3 class="card-title">Add Expense</h3>
                                </div>
                              </div>
                            <div class="card-body">
                                <form id="ExpenseSubmit">
                                    <div class="row mb-3">
                                        <div class="col-sm-6">
                                            <label for="amount">Type</label>
                                            <select class="form-control" id="type" name="type" >
                                                <option value="Employee's Payout">Employee's Payout</option>
                                                <option value="Office Rent">Office Rent</option>
                                                <option value="Incentive">Incentive</option>
                                                <option value="Server">Server</option>
                                                <option value="Domain">Domain</option>
                                                <option value="Content">Content</option>
                                                <option value="Graphic">Graphic</option>
                                                <option value="Outsourced work">Outsourced work</option>
                                                <option value="Ads Expense">Ads Expense</option>
                                                <option value="SEO Expense">SEO Expense</option>
                                                <option value="Tea\coffee\water">Tea\coffee\water</option>
                                                <option value="Other Office">Other Office</option>
                                                <option value="Graphic">Graphic</option>
                                                <option value="Database">Database</option>
                                                <option value="Internet/Mobile">Internet/Mobile</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="date">Date</label>
                                            <input type="date" id="date" class="form-control" name="date" required>
                                        </div>


                                        <div class="col-sm-6">
                                            <label for="currency">Currency</label>
                                            <select class="form-control" id="currency" name="currency" >
                                                <option value="INR">INR</option>
                                                <option value="USD">USD</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="amount">Amount</label>
                                            <input type="text" id="amount" class="form-control" name="amount" required>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="remarks">Remarks</label>
                                            <textarea id="remarks" class="form-control" name="remarks"  ></textarea>
                                        </div>
                                    </div>
                                   
                                    <button type="submit" class="btn btn-primary">Create</button>
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
                url: "{{route('admin.saveExpense')}}",
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