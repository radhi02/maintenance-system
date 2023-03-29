@extends('layouts.app')

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">User Master</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        {{-- <li class="breadcrumb-item active"><a href="{{ route('User.index') }}">User Master</a></li>
                        --}}
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->

            @if ($errors->any())
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <strong>Whoops!</strong> There were some problems with your input.<br><br>
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

                    <form id="UserForm" method="post"
                        action=" @if(!empty($edit_users->id)!=0)  {{route('user.update',$edit_users->id)}} @else {{route('user.store')}}@endif"
                        enctype="multipart/form-data">

                        @if(!empty($edit_users->id))
                        @method('PATCH')
                        @endif
                        @csrf

                        <!-- Add Tender Form -->
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">User Create</h3>
                            </div>

                            <!-- form start -->
                            <div class="card-body">
                                <div class="row">

                                    <div class="form-group col-sm-6 col-lg-4 col-xl-3">
                                        <label for="firstName">First Name <span
                                                class="required text-danger">*</span></label>
                                        <input type="text" class="form-control" name="firstName"
                                            value="{{ old('firstName', isset($edit_users->first_name) ?  $edit_users->first_name  : '' ) }}"
                                            placeholder="First Name">
                                    </div>

                                    <div class="form-group col-sm-6 col-lg-4 col-xl-3">
                                        <label for="lastName">Last Name <span
                                                class="required text-danger">*</span></label>
                                        <input type="text" class="form-control" name="lastName"
                                            value="{{  old('lastName', isset($edit_users->last_name) ?  $edit_users->last_name  : '' ) }}"
                                            placeholder="Last Name">
                                    </div>

                                    <div class="form-group col-sm-6 col-lg-4 col-xl-3">
                                        <label for="email">Email Address <span
                                                class="required text-danger">*</span></label>
                                        <input type="email" class="form-control" name="email"
                                            value="{{  old('email', isset($edit_users->email) ?  $edit_users->email  : '' ) }}"
                                            placeholder="Email">
                                    </div>

                                    <div class="form-group col-sm-6 col-lg-4 col-xl-3">
                                        <label for="Phone">Mobile No. <span
                                                class="required text-danger">*</span></label>
                                        <input type="tel" class="form-control" name="Phone"
                                            value="{{  old('Phone', isset($edit_users->Phone) ?  $edit_users->Phone  : '' ) }}"
                                            placeholder="Mobile No.">
                                    </div>

                                    @if(!isset($edit_users->password))
                                    <div class="form-group col-sm-6 col-lg-4 col-xl-3">
                                        <label>Password <span class="required text-danger">*</span></label>
                                        <input type="password" placeholder="Password" class="form-control"
                                            name="password" maxlength="10" minlength="3" />
                                    </div>
                                    @endif

                                    <div class="form-group col-sm-6 col-lg-4 col-xl-3">
                                        <label>Select Unit <span class="required text-danger">*</span></label>
                                        <select class="form-control" name="unit_id" id="unit-dd">
                                            <option value="">Select Unit</option>
                                            @foreach ($units as $data)
                                            <option value="{{$data->id}}" {{  old('unit_id', (isset($edit_users->unit_id) && $edit_users->unit_id == $data->id ) ? 'selected' : '') }}> {{$data->name}} </option> @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group col-sm-6 col-lg-4 col-xl-3">
                                        <label>Select Department <span class="required text-danger">*</span></label>
                                        <select class="form-control" name="department_id" id="department_id">
                                            <option value="">Select Department</option>
                                            @if(isset($departments))
                                              @foreach($departments as $data)
                                              <option value="{{$data->id}}" {{  old('department_id', (isset($edit_users->department_id) && $edit_users->department_id == $data->id ) ? 'selected' : '') }}> {{$data->name}} </option> @endforeach
                                            @endif
                                        </select>
                                    </div>

                                    <div class="form-group col-sm-6 col-lg-4 col-xl-3">
                                        <label>User Role <span class="required text-danger">*</span></label>
                                        @php $id = auth()->user()->id; @endphp
                                        <select class="form-control" name="UserType">
                                            <option value="">User Role</option>
                                            @foreach($roles as $role)
                                            <option value=" {{$role->id}}"
                                                {{  old('UserType', (isset($edit_users->email) && $edit_users->Role == $role->id ) ? 'selected' : '') }}>
                                                {{$role->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group col-sm-6 col-lg-4 col-xl-3">
                                        <label>Country <span class="required text-danger">*</span></label>
                                        <select id="country-dd" class="form-control" name="user_country">
                                            <option value="">Select Country</option>
                                            @foreach ($fetchCountry as $data)
                                            <option value="{{$data->id}}"
                                                {{  old('Country', (isset($edit_users->Country) && $edit_users->Country == $data->id ) ? 'selected' : '') }}>
                                                {{$data->name}}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group col-sm-6 col-lg-4 col-xl-3">
                                        <label>State <span class="required text-danger">*</span></label>
                                        <select id="state-dd" class="form-control" name="user_state">
                                            <option value="">Select State</option>
                                            @if(isset($state))
                                            @foreach($state as $data)
                                            <option value="{{$data->id}}" @if($edit_users->State == $data->id) selected
                                                @endif>{{$data->name}}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>

                                    <div class="form-group col-sm-6 col-lg-4 col-xl-3">
                                        <label>City <span class="required text-danger">*</span></label>
                                        <select id="city-dd" class="form-control" name="user_city">
                                            <option value="">Select City</option>
                                            @if(isset($city))
                                            @foreach($city as $data)
                                            <option value="{{$data->id}}" @if($edit_users->city == $data->id) selected
                                                @endif>{{$data->name}}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>

                                    <div class="form-group col-sm-6 col-lg-4 col-xl-3">
                                        <label for="image">Status <span class="required text-danger">*</span></label>
                                        <div class="custom-file">
                                            <select class="form-control" name="Status">
                                                <option value="Active"
                                                    {{(isset($edit_users->user_status) && $edit_users->user_status=='Active')?'selected':'' }}>
                                                    Active</option>
                                                <option value="Inactive"
                                                    {{( isset($edit_users->user_status) && $edit_users->user_status=='Inactive')?'selected':'' }}>
                                                    Inactive</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-sm-6 col-lg-4 col-xl-3">
                                        <label for="image">User Image</label>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="fileimg" name="image">
                                            <label class="custom-file-label" for="image">Choose file</label>
                                        </div>
                                        <input type="hidden" name="image_2" @if(!empty($edit_users->Image))
                                        value="{{$edit_users->Image}}" @endif>
                                    </div>

                                    @php
                                    $img="Admin/no_preview.jpg";
                                    if(isset($edit_users->Image))
                                    {
                                    $filename = public_path('Users/'. $edit_users->Image);
                                    if($edit_users->Image != '' && file_exists($filename))
                                    {
                                    $img='Users/'.$edit_users->Image;
                                    }
                                    }
                                    @endphp
                                    <img src="{{ URL::asset($img) }}" alt="" width="100" height="100" class="img"
                                        id="preview-image">
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
    $('#country-dd').on('change', function() {
        var idCountry = this.value;
        $("#state-dd").html('');
        $.ajax({
            url: "{{url('api/fetch-states')}}",
            type: "POST",
            data: {
                country_id: idCountry,
                _token: '{{csrf_token()}}'
            },
            dataType: 'json',
            success: function(result) {
                $('#state-dd').html('<option disabled>Select State</option>');
                $.each(result.states, function(key, value) {
                    $("#state-dd").append('<option value="' + value .id + '">' + value.name + '</option>'); });
                $('#city-dd').html('<option disabled>Select City</option>');
            }
        });

    });
    $('#state-dd').on('change', function() {
        var idState = this.value;
        $("#city-dd").html('');
        $.ajax({
            url: "{{url('api/fetch-cities')}}",
            type: "POST",
            data: {
                state_id: idState,
                _token: '{{csrf_token()}}'
            },
            dataType: 'json',
            success: function(res) {
                $('#city-dd').html('<option disabled>Select City</option>');
                $.each(res.cities, function(key, value) {
                    $("#city-dd").append('<option value="' + value
                        .id + '">' + value.name + '</option>');
                });
            }
        });
    });

    $('#fileimg').change(function() {
        let reader = new FileReader();
        reader.onload = (e) => {
            $('#preview-image').attr('src', e.target.result);
        }
        reader.readAsDataURL(this.files[0]);
    });

    $('#UserForm').validate({
        rules: {
            firstName: {
                required: true
            },
            lastName: {
                required: true
            },
            email: {
                required: true
            },
            Phone: {
                required: true
            },
            password: {
                required: true
            },
            UserType: {
                required: true
            },
            user_country: {
                required: true
            },
            Status: {
                required: true
            },
            user_state: {
                required: true
            },
            user_city: {
                required: true
            },
            unit_id: {
                required: true
            },
            department_id: {
                required: true
            },
        },
        messages: {
            firstName: {
                required: "Please enter First Name "
            },
            lastName: {
                required: "Please enter Last Name"
            },
            email: {
                required: "Please enter Email-Id"
            },
            Phone: {
                required: "Please enter Mobile No."
            },
            password: {
                required: "Please enter password"
            },
            UserType: {
                required: "Please Select User Role"
            },
            user_country: {
                required: "Please enter country name"
            },
            user_state: {
                required: "Please enter state name"
            },
            user_city: {
                required: "Please enter city"
            },
            unit_id: {
                required: "Please select unit"
            },
            department_id: {
                required: "Please select department"
            },
            Status: {
                required: "Please select status"
            },
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
                $('#department_id').html('<option disabled>Select Department</option>');
                $.each(result.departments, function(key, value) {
                    $("#department_id").append('<option value="' + value .id + '">' + value.name + '</option>'); });
            }
        });
    });
});
</script>

@endsection