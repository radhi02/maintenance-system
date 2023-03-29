@extends('layouts.app')

@section('content')
<style>
@media screen {
    #printSection {
        display: none;
    }
}

@media print {
    body * {
        visibility: hidden;
    }

    #printSection,
    #printSection * {
        visibility: visible;
    }

    #printSection {
        position: absolute;
        left: 0;
        top: 0;
    }
}
</style>
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
                    <div class="card" id="printThis">
                        <div class="card-header">
                            <h3 class="card-title">Show Maintenance Plan</h3><a href="javascript:void(0)"
                                class="btn btn-success" id="Print"><i class="fa fa-print" aria-hidden="true"></i>
                                Print</a>
                        </div>
                        <!-- form start -->
                        <div class="card-body">
                            <table width="100%" class="table table-sm">
                                <input value="{{ $ReactiveMaintenancePlan->id }}" name="idd" id="idd" hidden>
                                <input value="{{ $ReactiveMaintenancePlan->ename }}" name="ename" id="ename" hidden>

                                <tbody>
                                    <tr>
                                        <th>Equipment Name</th>
                                        <td>{{ $ReactiveMaintenancePlan->ename }}</td>
                                    </tr>
                                    <tr>
                                        <th>Engineer Name</th>
                                        <td>{{ $ReactiveMaintenancePlan->uname }}</td>
                                    </tr>
                                    <tr>
                                        <th>End-User Name</th>
                                        <td>{{ $ReactiveMaintenancePlan->endname }}</td>
                                    </tr>
                                    @if($ReactiveMaintenancePlan->maintenance_type == "Reactive")
                                    <tr>
                                        <th>Problem</th>
                                        <td>{{ $ReactiveMaintenancePlan->Problem }}</td>
                                    </tr>
                                    @endif
                                    <tr>
                                        <th>Request Date</th>
                                        <td>{{ ShowNewDateFormat($ReactiveMaintenancePlan->plan_date) }}</td>
                                    </tr>
                                    @if($ReactiveMaintenancePlan->maintenance_type == "Reactive")
                                    <tr>
                                        <th>criticality</th>
                                        <td>{{ $ReactiveMaintenancePlan->criticality }}</td>
                                    </tr>
                                    @endif
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
                            </br>
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
                            @if($ReactiveMaintenancePlan->maintenance_type == "Preventive")

                            @if($taskjson != NULL)
                            <div class="form-group col-sm-12">
                                <label> Activity Completed</label>
                                <table width="100%" class="table table-bordered table-sm">
                                    <thead>
                                        <tr>
                                            <th>#</th>
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
                                                {{ $loop->iteration}}
                                            </td>
                                            <td>
                                                {{$tt->activity}}
                                            </td>
                                            <td>
                                                {{$tt->detail}}
                                            </td>
                                            <td>
                                                {{$tt->remark}}
                                            </td>
                                            <td>
                                                {{ShowNewDateFormat($tt->date)}}
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @endif
                            @endif

                            </br>
                            @if(Auth::user()->Role != 2)
                            <div class="form-group col-sm-12">
                                <label>Cost Details</label>
                                <table width="100%" class="table table-bordered table-sm" id="tblcost">
                                    <thead>
                                        <tr>
                                            <th>Detail</th>
                                            <th>Type</th>
                                            <th>Cost</th>
                                            <th>Remark</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody class="field_wrapper">
                                        @if(!empty($plancost))
                                        @foreach($plancost as $p) <?php $total = $total + $p->cost; ?>
                                        <tr>
                                            <td>
                                                {{$p->detail}}
                                            </td>
                                            <td>
                                                {{$p->type}}
                                            </td>
                                            <td>
                                                {{$p->cost}}
                                            </td>
                                            <td>
                                                {{$p->remark}}
                                            </td>
                                            <td>
                                                {{ShowNewDateFormat($p->created_at)}}
                                            </td>
                                        </tr>
                                        @endforeach
                                        @endif
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="2">Total Cost: </th>
                                            <th colspan="3"><span id="txttotal"> {{$total}} </span></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            @endif
                            @if($ReactiveMaintenancePlan->remark_by_enginner != NULL && !empty($ReactiveMaintenancePlan->remark_by_enginner))
                            <div class="form-group col-sm-12">
                                <label> Enginner Action Taken :</label>
                                @php
                                $remarklist = json_decode($ReactiveMaintenancePlan->remark_by_enginner);
                                @endphp
                                <table width="100%" class="table table-bordered table-sm">
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
                            </div>
                            @if($ReactiveMaintenancePlan->remark_by_manager != NULL && !empty($ReactiveMaintenancePlan->remark_by_manager))
                            <div class="form-group col-sm-12">
                                <label> End-user Action Taken : </label>
                                @php
                                $remarkmanager = json_decode($ReactiveMaintenancePlan->remark_by_manager);
                                @endphp
                                <table width="100%" class="table table-bordered table-sm">
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

                            </div>
                            <!-- /.card -->
                        </div>
                </section>
            </div>

        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<script>
function printElement(elem) {
    var domClone = elem.cloneNode(true);
    var $printSection = document.getElementById("printSection");
    if (!$printSection) {
        var $printSection = document.createElement("div");
        $printSection.id = "printSection";
        document.body.appendChild($printSection);
    }
    $printSection.innerHTML = "";
    $printSection.appendChild(domClone);
    window.print();
}
$(document).ready(function() {


    document.getElementById("Print").onclick = function() {
        printElement(document.getElementById("printThis"));
    };

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
        $.ajax({
            url: "{{route('changeEndstatus')}}",
            method: 'post',
            data: {
                status: status,
                idd: idd,
                remark: remark,
                ename: ename
            }
        }).then(function() {});
        window.location.href = "{{route('home')}}";
    });
})
</script>
@endsection