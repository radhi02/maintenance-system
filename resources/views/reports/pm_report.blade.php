@extends('layouts.app')

@section('content')

<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<!-- Content Wrapper. Contains page content -->
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
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <!-- <h1 class="m-0">Reactive Maintenance Report</h1> -->
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
            @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
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
                            <h3 class="card-title"> Preventive Maintenance Report </h3>
                            <div class="card-tools">
                                <!-- <button type="button" class="btn btn-info" data-toggle="modal" data-target="#edit-modal"> -->
                                <!-- <a class="btn btn-success" href="{{ route('reactive_maintenance_plan.create') }}"> Create New Reactive Maintenance Plan  Activity</a> -->
                            </div>
                        </div>
                        <!-- form start -->
                        <div class="card-body">
                            <!-- custom filter button -->
                            <form id="submit_Form" method="post">
                                @csrf
                                <div class="row">
                                    <div class="form-group col-sm-3">
                                        <label>Select Start & End Date-Time range: <span class="required"
                                                style="color:red;">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="far fa-clock"></i></span>
                                            </div>
                                            <input type="text" class="form-control float-right" id="daterange"
                                                name="daterange">
                                        </div>
                                        <!-- /.input group -->
                                    </div>

                                    <div class="form-group col-sm-3">
                                        <label>Select End User<span class="required"
                                                style="color:red;">&nbsp;</span></label>
                                        <select class="form-control organization_dropdown" name="end_user_id"
                                            id="end_user_id">
                                            <option>All User</option>
                                            @foreach ($Enduser as $data)
                                            <option value="{{$data->id}}">
                                                {{$data->first_name .' '.$data->last_name }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group col-sm-3">
                                        <label>Select Maintenance User<span class="required"
                                                style="color:red;">&nbsp;</span></label>
                                        <select class="form-control organization_dropdown" name="eng_user_id"
                                            id="eng_user_id">
                                            <option>All User</option>
                                            @foreach ($Enguser as $data)
                                            <option value="{{$data->id}}">
                                                {{$data->first_name .' '.$data->last_name }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group col-sm-3">
                                        <label>Select Unit</label>
                                        <select class="form-control" name="unit_id" id="unit-dd">
                                            <option value="All Unit">All Unit</option>
                                            @foreach ($units as $data)
                                            <option value="{{$data->id}}">
                                                {{$data->name}}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group col-sm-3">
                                        <label>Select Department</label>
                                        <select class="form-control" name="department_id" id="department_id">
                                            <option value="All Departments">All Departments</option>
                                            @if(isset($departments))
                                            @foreach($departments as $data)
                                            <option value="{{$data->id}}">
                                                {{$data->name}}
                                            </option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>

                                    <div class="form-group col-sm-3">
                                        <label>Select Vendor</label>
                                        <select class="form-control" name="vendor_id" id="vendor_id">
                                            <option>All Vendor</option>
                                            @foreach ($vendor as $data)
                                            <option value="{{$data->id}}">
                                                {{$data->vendor_name }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group col-sm-3">
                                        <label>Select Equipment</label>
                                        <select class="form-control" name="equipment_id" id="equipment_id">
                                            <option>All Equipment</option>
                                            @foreach ($equipment as $data)
                                            <option value="{{$data->id}}">
                                                {{$data->equipment_name}}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group col-sm-3">
                                        <label>Select Status</label>
                                        <select class="form-control" name="status" id="status">
                                            <option value="All">All</option>
                                            <option value="pending">HOD Pending</option>
                                            <option value="open">Open</option>
                                            <option value="complete">Complete (By Engineer)</option>
                                            <option value="close">Close</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-sm-3">
                                        <button type="submit" name="submit" class="btn btn-primary"
                                            style="align-self: flex-start;margin-block-start: 31px;">Search</button>
                                    </div>
                                </div>
                            </form>
                            <div id="printThis"></div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </section>
            </div>
        </div><!-- /.container-fluid -->
    </section>
</div>

<script type="text/javascript">
$('#daterange').daterangepicker({
    locale: {
        format: 'MM/DD/YYYY',
    }
});

$(document).ready(function() {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#submit_Form').validate({
        rules: {
            daterange: {
                required: true
            }
        },
        messages: {
            daterange: {
                required: "Please select date range "
            }
        },
        submitHandler: function(form) {
            $("#printThis").html('');
            var end_user_id = $('#end_user_id').val();
            var eng_user_id = $('#eng_user_id').val();
            var vendor = $('#vendor_id').val();
            var department = $('#department_id').val();
            var unit = $('#unit-dd').val();
            var daterange = $('#daterange').val();
            var equipment = $('#equipment_id').val();
            var status = $('#status').val();
            $.ajax({
                type: "POST",
                url: "{{route('getpmdata')}}",
                data: {
                    end_user_id: end_user_id,
                    eng_user_id: eng_user_id,
                    vendor: vendor,
                    department: department,
                    unit: unit,
                    daterange: daterange,
                    equipment: equipment,
                    status: status
                },
                //cache: false,
                success: function(data) {
                    $("#printThis").html(data);
                }
            });
        },
        errorElement: 'span',
        errorPlacement: function(label, element) {
            if (element.attr("name") == "exchange_rate") {
                element.parent().append(label);
            } else if (element.attr("name") == "quotation_date") {
                element.closest('.form-group').append(label);
            } else {
                label.insertAfter(element);
            }
            label.addClass('invalid-feedback');
        },
        highlight: function(element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        }
    });

});

$('#unit-dd').on('change', function() {
    var unitid = this.value;
    $("#department_id").html('');
    $.ajax({
        url: "{{url('api/fetch-department')}}",
        type: "POST",
        data: {
            unit_id: unitid,
            _token: '{{csrf_token()}}'
        },
        dataType: 'json',
        success: function(result) {
            $('#department_id').html('<option value="All Departments">All Departments</option>');
            $.each(result.departments, function(key, value) {
                $("#department_id").append('<option value="' + value.id + '">' + value
                    .name + '</option>');
            });
        }
    });

});

function exportpdf() {
    var daterange = $('#daterange').val();
    var end_user_id = $('#end_user_id').val();
    var eng_user_id = $('#eng_user_id').val();
    var vendor = $('#vendor_id').val();
    var department = $('#department_id').val();
    var unit = $('#unit-dd').val();
    var equipment = $('#equipment_id').val();
    var status = $('#status').val();
    $.ajax({
        type: "POST",
        url: "{{route('createPMPDF')}}",
        data: {
            end_user_id: end_user_id,
            eng_user_id: eng_user_id,
            daterange: daterange,
            vendor: vendor,
            unit: unit,
            department: department,
            equipment: equipment,
            status: status
        },
        success: function(response) {
            window.open(response, '_blank');
        }
    });
}
</script>
@endsection