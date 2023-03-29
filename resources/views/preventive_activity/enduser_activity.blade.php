@extends('layouts.app')

@section('content')
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
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <section class="col-lg-12 connectedSortable">
                    <form action="{{ route('statusByEndUser', $plandata->id) }}" method="POST" id="frmplan"
                        autocomplete="off">
                        @csrf
                        {{ method_field('PUT') }}
                        <!-- Add Tender Form -->
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Update Maintenance Plan</h3>
                            </div>
                            <!-- form start -->
                            <div class="card-body">
                                <table class="table table-striped table-valign-middle">
                                    <tbody>
                                        <tr>
                                            <td><label>Plan Id :</label></td>
                                            <td><label>{{$plandata->id}}</label></td>
                                        </tr>
                                        <tr>
                                            <td><label>Plan Date :</label></td>
                                            <td><label>{{ShowNewDateFormat($plandata->plan_date)}}</label></td>
                                        </tr>
                                        <tr>
                                            <td><label>Assigned User :</label></td>
                                            <td><label>{{$plandata->assigned_user}}</label></td>
                                        </tr>
                                        <tr>
                                            <td><label>Actual Work By :</label></td>
                                            <td><label>{{$plandata->worked_by}}</label></td>
                                        </tr>
                                        <tr>
                                            <td><label>Equipment Id :</label></td>
                                            <td><label>{{$plandata->EId}}</label></td>
                                        </tr>
                                        <tr>
                                            <td><label>Equipment Name :</label></td>
                                            <td><label>{{$plandata->Ename}}</label></td>
                                        </tr>
                                        <tr>
                                            <td><label>Loss Repair Hour :</label></td>
                                            <td><label>{{$plandata->loss_hrs}}</label></td>
                                        </tr>
                                        <tr>
                                            <td><label>Cost of Servies From External Vendor :</label></td>
                                            <td><label>&#8377; {{$plandata->service_cost_external_vendor}}</label></td>
                                        </tr>
                                        <tr>
                                            <td><label> Activity Checklist : </label> </td>
                                            <td><label>
                                                    <?php 
                                                  if($plandata->tasktype == "minor") {
                                                    echo $plandata->minor;
                                                  } else {
                                                    echo $plandata->major;
                                                    echo ",";
                                                    echo $plandata->minor;
                                                  }
                                                  ?>
                                                </label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><label> Done Task List :</label></td>
                                            <td><label>{{$plandata->done_task_list}}</label></td>
                                        </tr>
                                    </tbody>
                                </table>

                                <label style="margin-top: 10px;"> Enginner Action Taken : </label>
                                @if($plandata->remark_by_enginner != NULL && !empty($plandata->remark_by_enginner))
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
                                @endif
                                @if($plandata->remark_by_manager != NULL && !empty($plandata->remark_by_manager))
                                <label style="margin-top: 10px;">Your Remark : </label>
                                @php
                                $remarkmanager = json_decode($plandata->remark_by_manager);
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
                                        @foreach($remarkmanager as $re)
                                        <tr>
                                            <td>{{ $loop->iteration}}</td>
                                            <td>{{ $re->note }}</td>
                                            <td>{{ ShowNewDateFormat($re->date) }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                @endif
                                <label style="margin-top: 10px;">Remark :</label>
                                <textarea class="form-control" name="remark" id="remark"></textarea>

                                <div style="text-align: center;">
                                    <button type="submit" name="btnstatus" class="btn btn-success" value="Approved"
                                        style="margin: 10px 24px;">Approve</button>
                                    <button type="submit" value="Rejected" class="btn btn-danger" name="btnstatus"
                                        style="margin: 10px 24px;">Reject</button>
                                    <a href="{{ URL::previous() }}" class="btn btn-primary"
                                        style="margin: 10px 24px;">Go Back</a>

                                </div>
                            </div>

                        </div>
                        <!-- /.card -->
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
$(document).ready(function() {
    $("#frmplan").validate({
        rules: {
            remark: {
                required: true,
            },
        },
        messages: {
            remark: "Please enter remark",
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

});
</script>


@endsection