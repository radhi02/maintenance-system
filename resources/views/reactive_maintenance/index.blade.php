@extends('layouts.app')

@section('content')

<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Reactive Maintenance</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->

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
                    <form>
                        <!-- Add Tender Form -->
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Add Reactive Maintenance</h3>

                                <div class="card-tools">
                                    <!-- <button type="button" class="btn btn-info" data-toggle="modal" data-target="#edit-modal">Create New Reactive Maintenance </button> -->
                                    @if(Auth::user()->Role == 2 )<a class="btn btn-success"
                                        href="{{ route('reactive_maintenance.create') }}"> Create New Reactive
                                        Maintenance</a>
                                    @endif
                                </div>
                            </div>

                            <!-- form start -->

                            <div class="card-body table-responsive">
                                <div class="">
                                    <table class="table table-sm table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th width="40px">No.</th>
                                                <th>Equipment </th>
                                                <th>Problem</th>
                                                <th>Criticality</th>
                                                <th>Ticket Status</th>
                                                @if(Auth::user()->Role == 2 ) <th>Action</th>@endif
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($ReactiveMaintenance as $reactive)
                                            <tr>
                                                <td>{{ $loop->iteration}}</td>
                                                <td>{{ $reactive->ename }}</td>
                                                <td>{{ $reactive->Problem }}</td>
                                                <td> @if($reactive->criticality == "Critical")
                                                    <span class="badge bg-success">Critical</span>
                                                    @else
                                                    <span class="badge bg-danger">Non-Critical</span>
                                                    @endif
                                                </td>
                                                <td><span class="badge bg-success">{{$reactive->ticket_status}}</span>
                                                </td>
                                                @if(Auth::user()->Role == 2 )
                                                <td>
                                                    <a href="{{ route('reactive_maintenance.edit',$reactive->id) }}"
                                                        class="text-success mr-2" data-toggle="tooltip"
                                                        data-placement="bottom" title="" data-original-title="Edit">
                                                        <i class="fas fa-edit fa-lg"></i>
                                                    </a>
                                                    <a href="{{route('reactive_maintenance.destroy',$reactive->id) }}"
                                                        class="text-danger" data-toggle="tooltip"
                                                        data-placement="bottom" title="" data-original-title="Delete"
                                                        onclick="event.preventDefault(); document.getElementById('delete_me_form').submit();"><i
                                                            class="fas fa-trash fa-lg"></i></a>
                                                    <form id="delete_me_form"
                                                        action="{{route('reactive_maintenance.destroy',$reactive->id) }}"
                                                        method="post" class="d-none">

                                                        @csrf

                                                        {{ method_field('DELETE') }}
                                                    </form>
                                                </td>
                                                @endif
                                            </tr>
                                            @endforeach

                                        </tbody>

                                    </table>
                                </div>
                            </div>
                            <!-- /.card-body -->


                        </div>
                        <!-- /.card -->

                    </form>
                </section>

            </div>

        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<script>
$(document).ready(function() {
    $("#frmequipment").validate({
        rules: {
            equipment_id: {
                required: true,
            },
            Problem: {
                required: true
            },
            date: {
                required: true
            },


        },
        messages: {
            equipment_id: "Please select Equipment",
            date: "Please select Request date",
            Problem: " Problem is required",
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

$('#equipment_id').on('change', function() {
    var idState = this.value;
    $("#date").html('');
    $("#Problem").html('');
    $.ajax({
        url: "{{route('get_date')}}",
        type: "POST",
        data: {
            equipment_id: idState,
            _token: '{{csrf_token()}}'
        },
        dataType: 'json',
        success: function(res) {
            // $('#date').html('<input type="date"  name="date" id="date">');
            $.each(res, function(key, value) {
                $("#date").html(
                    '<label for="code">Request Date</label><input  disabled class="form-control" name="date" type="date" value="' +
                    value.date + '">');
                $("#Problem").html(
                    '<label>Problem</label><input disabled class="form-control" name="date" type="input" value="' +
                    value.Problem + '">');
            });
        }
    });
});

$(function() {
    $('#equipment_id').change(function() {
        $('.showdate').show();
        $('.showdate' + $(this).val()).hide();
    });
});

$(function() {
    $('#equipment_id').change(function() {
        $('.showproblem').show();
        $('.showproblem' + $(this).val()).hide();
    });
});
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

// Assign User  
$('select[name="user_id"]').on('change', function() {
    var user_id = $(this).val();
    var id = $(this).data('id');
    $.ajax({
        type: "GET",
        dataType: "json",
        url: "{{route('changeUser')}}",
        data: {
            'user_id': user_id,
            'id': id
        },
        success: function(data) {
            location.reload();
            // console.log(data)
        }
    });
})

//Self Assign user 
$('button[name="selfuser_id"]').on('click', function() {
    var selfuser_id = $(this).val();
    var id = $(this).data('id');
    $.ajax({
        type: "GET",
        dataType: "json",
        url: "{{route('changeUserself')}}",
        data: {
            'selfuser_id': selfuser_id,
            'id': id
        },
        success: function(data) {
            // console.log(data)
            location.reload();

        }
    });
})
</script>

@endsection