@extends('layouts.app')

@section('content')

<?php
$done_task_list = [];
$a = 5000; $b = 6000; $c = 7000;
if($plandata->done_task_list != NULL) $done_task_list = explode(",",$plandata->done_task_list);
$minor = explode(",",$plandata->minor);
$major = explode(",",$plandata->major);

$minor = array_diff($minor,$done_task_list);
$major = array_diff($major,$done_task_list);

$taskjson = NULL;
if($plandata->task_json != NULL) $taskjson = json_decode($plandata->task_json);

$total = 0;
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Maintenance Plan</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active"><a href="{{ route('planactivity.index') }}">Maintenance
                                Plan</a></li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
            @if ($errors->any())
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <i class="icon fas fa-ban"></i><strong>Whoops!</strong> There were some problems with your input.
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            @if ($message = Session::get('success'))
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-check"></i> Success!</h4>
                {{ $message }}
            </div>
            @endif
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <section class="col-lg-12 connectedSortable">
                    <form action="{{ route('planactivity.update', $plandata->id) }}" method="POST" id="frmplan"
                        autocomplete="off">
                        @csrf
                        <!-- {{ route('planactivity.update', $plandata->id) }} -->
                        {{ method_field('PUT') }}

                        <!-- {{$plandata->EId}} -->
                        <!-- {{$plandata->id}} -->
                        <!-- Add Tender Form -->
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Update Maintenance Plan</h3>
                            </div>
                            <!-- form start -->
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-sm-6 col-lg-4 col-xl-4">
                                        <label for="plandate">Plan Date</label>
                                        <input type="text" class="form-control" name="plandate" id="plandate"
                                            value="{{ShowNewDateFormat($plandata->plan_date)}}" disabled>
                                    </div>
                                    <div class="form-group col-sm-6 col-lg-4 col-xl-4">
                                        <label for="equipementname">Equipment Name</label>
                                        <input type="text" class="form-control" name="equipementname"
                                            id="equipementname" value="{{$plandata->Ename}}" disabled>
                                    </div>
                                    @if($plandata->actual_start_date != NULL)
                                        @if($plandata->remark_by_enginner != NULL && !empty($plandata->remark_by_enginner))
                                        <div class="form-group col-sm-12">
                                            <label> Previous Action Taken</label>
                                            @php
                                            $remarklist = json_decode($plandata->remark_by_enginner);
                                            @endphp
                                            <table class="table table-striped table-valign-middle">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Note</th>
                                                        <th>Date</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($remarklist as $re)
                                                    <tr>
                                                        <td>{{ $loop->iteration}}</td>
                                                        <td>{{ $re->note }}</td>
                                                        <td>{{ ShowNewDateFormat($re->date) }}</td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        @endif
                                        @if($plandata->remark_by_manager != NULL && !empty($plandata->remark_by_manager))
                                        <div class="form-group col-sm-12">
                                            <label>Enduser Remark</label>
                                            @php
                                            $remarklisth = json_decode($plandata->remark_by_manager);
                                            @endphp
                                            <table class="table table-striped table-valign-middle">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Note</th>
                                                        <th>Date</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($remarklisth as $reh)
                                                    <tr>
                                                        <td>{{ $loop->iteration}}</td>
                                                        <td>{{ $reh->note }}</td>
                                                        <td>{{ ShowNewDateFormat($reh->date) }}</td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        @endif
                                        <div class="form-group col-sm-12">
                                            <label> Action Taken</label>
                                            <textarea class="form-control" name="note" id="note"></textarea>
                                        </div>

                                        @if($taskjson != NULL)
                                        <div class="form-group col-sm-12">
                                            <label> Activity Completed</label>
                                            <table class="table table-striped table-valign-middle">
                                                <thead>
                                                    <tr>
                                                        <th>Activity</th>
                                                        <th>Detail</th>
                                                        <th>Remark</th>
                                                        <th>Date</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($taskjson as $tt)
                                                    <tr>
                                                        <td>
                                                            <div class="col-sm-6 col-lg-4 col-xl-12">
                                                                <p>{{$tt->activity}}</p>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="col-sm-6 col-lg-4 col-xl-12">
                                                                <p>{{$tt->detail}}</p>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="col-sm-6 col-lg-4 col-xl-12">
                                                                <p>{{$tt->remark}}</p>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="col-sm-6 col-lg-4 col-xl-12">
                                                                <p>{{ShowNewDateFormat($tt->date)}}</p>
                                                            </div>
                                                        </td>
                                                        <td></td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        @endif
                                        @if($plandata->worknote != NULL)
                                        <div class="form-group col-sm-6 col-lg-4 col-xl-12">
                                            <label>Work Note</label>
                                            <p>{{$plandata->worknote}}</p>
                                        </div>
                                        @endif
                                        @if( ($plandata->tasktype == "minor" && sizeof($minor) > 0) || ($plandata->tasktype == "major" && sizeof($major) > 0 ))
                                        <div class="form-group col-sm-12">
                                            <label>Activity Checklist</label>
                                            <table class="table table-striped table-valign-middle">
                                                <thead>
                                                    <tr>
                                                        <th>Activity</th>
                                                        <th>Detail</th>
                                                        <th>Remark</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if($plandata->tasktype == "minor")
                                                    @foreach($minor as $k=>$n)
                                                    <tr>
                                                        <td>
                                                            <div class="col-sm-6 col-lg-4 col-xl-12">
                                                                <div class="icheck-primary d-inline">
                                                                    <input type="checkbox" id="checkboxPrimaryJ{{$k}}"
                                                                        name="chkactivity[{{$a}}]" value="{{$n}}"
                                                                        class="chkactivity">
                                                                    <label for="checkboxPrimaryJ{{$k}}">{{$n}}</label>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="col-sm-6 col-lg-4 col-xl-12">
                                                                <input type="text" class="form-control"
                                                                    name="txtactivitydetail[{{$a}}]">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="col-sm-6 col-lg-4 col-xl-12">
                                                                <input type="text" class="form-control"
                                                                    name="txtactivityremark[{{$a}}]">
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    @php $a++; @endphp
                                                    @endforeach
                                                    @elseif($plandata->tasktype == "major")
                                                    @foreach($major as $k=>$m)
                                                    <tr>
                                                        <td>
                                                            <div class="col-sm-6 col-lg-4 col-xl-12">
                                                                <div class="icheck-primary d-inline">
                                                                    <input type="checkbox" id="checkboxPrimaryI{{$k}}"
                                                                        name="chkactivity[{{$b}}]" value="{{$m}}"
                                                                        class="chkactivity">
                                                                    <label for="checkboxPrimaryI{{$k}}">{{$m}}</label>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="col-sm-6 col-lg-4 col-xl-12">
                                                                <input type="text" class="form-control"
                                                                    name="txtactivitydetail[{{$b}}]">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="col-sm-6 col-lg-4 col-xl-12">
                                                                <input type="text" class="form-control"
                                                                    name="txtactivityremark[{{$b}}]">
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    @php $b++; @endphp
                                                    @endforeach
                                                    @foreach($minor as $k=>$n)
                                                    <tr>
                                                        <td>
                                                            <div class="col-sm-6 col-lg-4 col-xl-12">
                                                                <div class="icheck-primary d-inline">
                                                                    <input type="checkbox" id="checkboxPrimaryJ{{$k}}"
                                                                        name="chkactivity[{{$c}}]" value="{{$n}}"
                                                                        class="chkactivity">
                                                                    <label for="checkboxPrimaryJ{{$k}}">{{$n}}</label>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="col-sm-6 col-lg-4 col-xl-12">
                                                                <input type="text" class="form-control"
                                                                    name="txtactivitydetail[{{$c}}]">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="col-sm-6 col-lg-4 col-xl-12">
                                                                <input type="text" class="form-control"
                                                                    name="txtactivityremark[{{$c}}]">
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    @php $c++; @endphp
                                                    @endforeach
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                        @endif
                                        <div class="form-group col-sm-12 table-responsive">
                                            <label>Cost Details</label>
                                            <table class="table table-striped table-valign-middle" id="tblcost">
                                                <thead>
                                                    <tr>
                                                        <th>Detail</th>
                                                        <th>Type</th>
                                                        <th>Cost</th>
                                                        <th>Remark</th>
                                                        <th><button type="button" class="btn btn-info add_button">Add
                                                                Row</button></th>
                                                    </tr>
                                                </thead>
                                                <tbody class="field_wrapper">
                                                    @if(!empty($plancost))
                                                    @foreach($plancost as $p) <?php $total = $total + $p->cost; ?>
                                                    <tr>
                                                        <td>
                                                            <div class="col-sm-6 col-lg-4 col-xl-12">
                                                                <p>{{$p->detail}}</p>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="col-sm-6 col-lg-4 col-xl-12">
                                                                <p>{{$p->type}}</p>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="col-sm-6 col-lg-4 col-xl-12">
                                                                <p>{{$p->cost}}</p>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="col-sm-6 col-lg-4 col-xl-12">
                                                                <p>{{$p->remark}}</p>
                                                            </div>
                                                        </td>
                                                        <!-- <td>
                                                            <div class="col-sm-6 col-lg-4 col-xl-12">
                                                                <p>{{ShowNewDateFormat($p->created_at)}}</p>
                                                            </div>
                                                        </td> -->
                                                        <td>
                                                            <div class="col-sm-6 col-lg-4 col-xl-12"> 
                                                                <button type="button" class="btn btn-danger deleteRecord" data-id="{{ $p->id }}">Remove</button> 
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                    @endif
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th colspan="2">Total Cost: </th>
                                                        <th colspan="3"><span id="txttotal"> {{$total}} </span>
                                                        <input type="hidden" name="cost_servies" id="cost_servies" value="{{$total}}">
                                                        </th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            @if($plandata->actual_start_date != NULL)
                            <div class="card-footer text-center">
                                <button type="submit" class="btn my_btn" name="saveDraft" value="0">Save Draft</button>
                                <button type="submit" class="btn btn-success" name="finishActivity" value="1"><i class="fas fa-clock"></i>Finish Activity</button>
                            </div>
                            @elseif($plandata->actual_start_date == NULL)
                            <div class="card-footer text-center">
                                <a class="btn btn-danger" title="Start Activity" href="{{ route('startPMActivity', $plandata->id) }}"><i class="fas fa-clock"></i> Start Activity </a>
                            </div>
                            @endif
                        </div>
                    </form>
                </section>
            </div>

        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<script>
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
var finalCost = <?php echo $total ?>;

$(document).ready(function() {
    $("#frmplan").validate({
        rules: {
            chkactivity: {
                required: true,
            },
            note: {
                required: true
            },
        },
        messages: {
            chkactivity: "Please check at least one activity",
            note: "Please enter remark",
        },
        errorElement: 'span',
        errorPlacement: function(error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
        highlight: function(element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        }
    });
    var maxField = 10; //Input fields increment limitation
    var addButton = $('.add_button'); //Add button selector
    var wrapper = $('.field_wrapper'); //Input field wrapper
    var fieldHTML = '<tr> <td> <div class="col-sm-6 col-lg-4 col-xl-12"> <input type="text" class="form-control" name="txtdetail[]" required> </div> </td> <td> <div class="col-sm-6 col-lg-4 col-xl-12"> <select class="form-control" name="txttype[]" required> <option value="spare">Spare</option> <option value="labour">Labour</option> </select> </div> </td> <td> <div class="col-sm-6 col-lg-4 col-xl-12"> <input type="number" min="0" oninput="this.value = !!this.value && Math.abs(this.value) >= 0 ? Math.abs(this.value) : null" class="form-control txtsparecost" name="txtsparecost[]" required> </div> </td> <td> <div class="col-sm-6 col-lg-4 col-xl-12"> <input type="text" class="form-control" name="txtspareremark[]" required> </div> </td> <td> <div class="col-sm-6 col-lg-4 col-xl-12"> <button type="button" class="btn btn-danger remove_button">Remove</button> </div> </td> </tr>'; 
    var x = 1; //Initial field counter is 1

    //Once add button is clicked
    $(addButton).click(function() {
        //Check maximum number of input fields
        if (x < maxField) {
            x++; //Increment field counter
            $(wrapper).append(fieldHTML); //Add field html
        }
    });

    //Once remove button is clicked
    $(wrapper).on('click', '.deleteRecord', function(e) {
        e.preventDefault();
        $(this).closest('tr').remove();
        var id = $(this).data("id");    
        $.ajax(
        {
            url: "{{route('deleteplancost.all')}}",
            type: 'POST',
            data: {
                "id": id,
                "plan_id": <?php echo $plandata->id ?>,
                "_token": '{{csrf_token()}}'
            },
            success: function(response){
                $("#txttotal").html(response.cost);
                $("#cost_servies").val(response.cost);
                finalCost = response.cost;
            }
        });
    });

    //Once remove button is clicked
    $(wrapper).on('click', '.remove_button', function(e) {
        e.preventDefault();
        $(this).closest('tr').remove();
        x--;
        var tt = finalCost;
        sumCalculate(tt);
    });

    $("#tblcost").on('input', '.txtsparecost', function() {
        var tb = finalCost;
        sumCalculate(tb);
    });

    function sumCalculate(cost){
        $(".txtsparecost").each(function() {
            if($(this).val() != "") {
                cost = parseFloat(cost) + parseFloat($(this).val());
            }
        });
        $("#txttotal").html(cost);
        $("#cost_servies").val(cost);
    }

});
</script>


@endsection