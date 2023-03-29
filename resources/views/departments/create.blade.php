@extends('layouts.app')

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Department Master</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active"><a href="{{ route('departments.index') }}">Department
                                Master</a></li>
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

                    <form
                        action="{{ isset($department) ? route('departments.update', $department->id) : route('departments.store') }}"
                        method="POST" id="frmdepartment" autocomplete="off">
                        @csrf
                        {{ isset($department) ? method_field('PUT') : '' }}

                        <!-- Add Tender Form -->
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">{{ isset($department) ? 'Edit' : 'Add' }} Department</h3>
                            </div>

                            <!-- form start -->

                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-sm-6 col-lg-4 col-xl-3">
                                        <label for="name">Name <span class="required text-danger">*</span></label>
                                        <input type="text" class="form-control" name="name" id="name" placeholder="Name"
                                            value="{{ old('name', isset($department) ? $department->name : '' )  }}">
                                    </div>

                                    <div class="form-group col-sm-6 col-lg-4 col-xl-3">
                                        <label>Select Unit <span class="required text-danger">*</span></label>
                                        <select class="form-control" name="unit_id" id="unit_id">
                                            <option value="" disabled>-- Select Unit --</option>
                                            @foreach ($units as $data)
                                            <option value="{{$data->id}}"
                                                {{ old('unit_id', (isset($department)&& $department->unit_id == $data->id) ? 'selected' : ''   )}}>
                                                {{$data->name}}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group col-sm-6 col-lg-4 col-xl-3">
                                        <label>Status <span class="required text-danger">*</span></label>
                                        <select class="form-control" name="status">
                                            <option
                                                {{ old('status', isset($department)&&($department->status==1) ? 'selected' : '' ) }}
                                                value="1">Active</option>
                                            <option
                                                {{ old('status', isset($department)&&($department->status==0) ? 'selected' : '' ) }}
                                                value="0">Inactive</option>
                                        </select>
                                    </div>

                                    @if(isset($department))
                                    <div class="form-group col-sm-6 col-lg-4 col-xl-3">
                                        <label for="code">Department Code</label>
                                        <input type="text" disabled class="form-control" name="code" id="code"
                                            placeholder="Department Code"
                                            value="{{ old('code', isset($department) ? $department->code : '' )  }}">
                                    </div>
                                    @endif

                                </div>

                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn my_btn">Save</button>
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
$(document).ready(function() {
    $("#frmdepartment").validate({
        rules: {
            name: {
                required: true
            },
            unit_id: {
                required: true
            },
            status: {
                required: true
            },
        },
        messages: {
            name: "Name is required",
            unit_id: "Unit is required",
            status: "Please select the status",
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