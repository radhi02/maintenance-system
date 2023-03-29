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
                    <!-- Add Tender Form -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Update Maintenance Plan</h3>
                        </div>
                        <!-- form start -->
                        <div class="card-body">
                            <table class="table table-striped table-valign-middle">
                                <input value="{{ $ReactiveMaintenancePlan->id }}" name="idd" id="idd" hidden>
                                <input value="{{ $ReactiveMaintenancePlan->ename }}" name="ename" id="ename" hidden>
                                <tbody>
                                    <tr>
                                        <th>Equipment Name</th>
                                        <td>{{ $ReactiveMaintenancePlan->ename }}</td>
                                    </tr>
                                    <tr>
                                        <th>User Name</th>
                                        <td>{{ $ReactiveMaintenancePlan->uname }}</td>
                                    </tr>
                                    <tr>
                                        <th>Problem</th>
                                        <td>{{ $ReactiveMaintenancePlan->Problem }}</td>
                                    </tr>
                                    <tr>
                                        <th>Request Date</th>
                                        <td>{{ ShowNewDateFormat($ReactiveMaintenancePlan->plan_date) }}</td>
                                    </tr>
                                    <tr>
                                        <th>criticality</th>
                                        <td>{{ $ReactiveMaintenancePlan->criticality }}</td>
                                    </tr>
                                    <tr>
                                        <th>Maintenance Type</th>
                                        <td>{{ $ReactiveMaintenancePlan->maintenance_type }}</td>
                                    </tr>
                                    <tr>
                                        <th>Loss Repair Hour</th>
                                        <td>{{ $ReactiveMaintenancePlan->loss_hrs }}</td>
                                    </tr>
                                    @if(Auth::user()->Role != 2)
                                    <tr>
                                        <th>Cost of Servies From External Vendor</th>
                                        <td>{{ $ReactiveMaintenancePlan->service_cost_external_vendor }}</td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                            @if($ReactiveMaintenancePlan->remark_by_enginner != NULL &&
                            !empty($ReactiveMaintenancePlan->remark_by_enginner))
                            <label style="margin-top: 10px;"> Enginner Action Taken :</label>
                            @php
                            $remarklist = json_decode($ReactiveMaintenancePlan->remark_by_enginner);
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
                            @if($ReactiveMaintenancePlan->remark_by_manager != NULL &&
                            !empty($ReactiveMaintenancePlan->remark_by_manager))
                            <label style="margin-top: 10px;"> Your Remark : </label>
                            @php
                            $remarkmanager = json_decode($ReactiveMaintenancePlan->remark_by_manager);
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
                                        <td>{{  ShowNewDateFormat($re->date) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                @endif
                            </table>
                            <label style="margin-top: 10px;">Remark :</label>
                            <textarea class="form-control" name="remark" id="remark" required></textarea>
                            <div style="text-align: center;">
                                <button type="button" name="enduser_status" id="enduser_status"
                                    class="btn btn-success status" value="Approved"
                                    style="margin: 10px 24px;">Approve</button>
                                <button type="button" value="Rejected" class="btn btn-danger status"
                                    name="enduser_status" id="enduser_status" style="margin: 10px 24px;">Reject</button>
                                <a href="{{ URL::previous() }}" class="btn btn-primary" style="margin: 10px 24px;">Go
                                    Back</a>
                            </div>
                        </div>
                            <!-- /.card -->
                        <div class="overlay" style="display:none">
                            <i class="fas fa-2x fa-sync-alt fa-spin"></i>
                        </div>
                </section>
            </div>

        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<script>
$(document).ready(function() {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('.status').on('click', function(e) {
        var status = $(this).val();
        var idd = $('#idd').val();
        var ename = $('#ename').val();
        var remark = $('#remark').val();
        $(".overlay").show();
        $.ajax({
            url: "{{route('changeEndstatus')}}",
            method: 'post',
            data: {
                status: status,
                idd: idd,
                remark: remark,
                ename: ename
            },
            dataType: 'json',
            success: function(res) {
                $(".overlay").hide();
                if (res.msg == 1) {
                    window.location.href = "{{route('home')}}";                
                }
            }
        });
    });
})
</script>
@endsection