@extends('layouts.app')

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Equipment Master</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active"><a href="{{ route('equipment.index') }}">Equipment Master</a>
                        </li>
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
                        action="{{ isset($equipment) ? route('equipment.update', $equipment->id) : route('equipment.store') }}"
                        method="POST" id="frmequipment" autocomplete="off" enctype="multipart/form-data">
                        @csrf
                        {{ isset($equipment) ? method_field('PUT') : '' }}

                        <!-- Add Tender Form -->
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">{{ isset($equipment) ? 'Edit' : 'Add' }} Equipment</h3>
                            </div>

                            <!-- form start -->
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-sm-6 col-lg-4 col-xl-3">
                                        <label>Select Unit <span class="required text-danger">*</span></label>
                                        <select class="form-control" name="unit_id" id="unit-dd">
                                            <option value="">Select Unit</option>
                                            @foreach ($units as $data)
                                            <option value="{{$data->id}}"
                                                {{  old('unit_id', (isset($equipment->unit_id) && $equipment->unit_id == $data->id ) ? 'selected' : '') }}>
                                                {{$data->name}}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group col-sm-6 col-lg-4 col-xl-3">
                                        <label>Select Department <span class="required text-danger">*</span></label>
                                        <select class="form-control" name="department_id" id="department_id">
                                            <option value="">Select Department</option>
                                            @if(isset($departments))
                                            @foreach($departments as $data)
                                            <option value="{{$data->id}}"
                                                {{  old('department_id', (isset($equipment->department_id) && $equipment->department_id == $data->id ) ? 'selected' : '') }}>
                                                {{$data->name}}
                                            </option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>


                                    <div class="form-group col-sm-6 col-lg-4 col-xl-3">
                                        <label for="vendor_name">Equipment Name <span
                                                class="required text-danger">*</span></label>
                                        <input type="text" class="form-control" name="equipment_name"
                                            id="equipment_name" placeholder="Name"
                                            value="{{ old('equipment_name', isset($equipment) ? $equipment->equipment_name : '' )  }}">
                                    </div>

                                    <div class="form-group col-sm-6 col-lg-4 col-xl-3">
                                        <label for="equipment_code">Asset Code <span
                                                class="required text-danger">*</span></label>
                                        <input type="text" class="form-control" name="equipment_code"
                                            id="equipment_code" placeholder="Asset Code"
                                            value="{{ old('equipment_code', isset($equipment) ? $equipment->equipment_code : '' )  }}">
                                    </div>

                                    <div class="form-group col-sm-6 col-lg-4 col-xl-3">
                                        <label for="serial_no">Serial No. <span
                                                class="required text-danger">*</span></label>
                                        <input type="text" class="form-control" name="serial_no" id="serial_no"
                                            placeholder="Serial No."
                                            value="{{ old('serial_no', isset($equipment) ? $equipment->serial_no : '' )  }}">
                                    </div>

                                    <div class="form-group col-sm-6 col-lg-4 col-xl-3">
                                        <label for="vendor_code">Equipment Make</label>
                                        <input type="text" class="form-control" name="equipment_make"
                                            id="equipment_make" placeholder="Equipment Make"
                                            value="{{ old('equipment_make', isset($equipment) ? $equipment->equipment_make : '' )  }}">
                                    </div>

                                    <div class="form-group col-sm-6 col-lg-4 col-xl-3">
                                        <label for="equipment_capacity">Equipment Capacity</label>
                                        <input type="number" class="form-control" name="equipment_capacity"
                                            id="equipment_capacity" placeholder="Equipment capacity"
                                            value="{{ old('equipment_capacity', isset($equipment) ? $equipment->equipment_capacity : '' )  }}">
                                    </div>

                                    <div class="form-group col-sm-6 col-lg-4 col-xl-3">
                                        <label>Responsible End user <span class="required text-danger">*</span></label>
                                        <select class="form-control" name="user_id" id="user_id">
                                            <option value="">-- Select Responsible user --</option>
                                            @foreach ($users as $data)
                                            <option value="{{$data->id}}"
                                                {{ old('user_id')==$data->id || isset($equipment)&&($equipment->user_id==$data->id) ? 'selected' : ''  }}>
                                                {{$data->first_name}}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-sm-6 col-lg-4 col-xl-3">
                                        <label for="location">Location</label>
                                        <input type="text" class="form-control" name="location" id="location"
                                            placeholder="Location"
                                            value="{{ old('location', isset($equipment) ? $equipment->location : '' )  }}">
                                    </div>

                                    <div class="form-group col-sm-6 col-lg-4 col-xl-3">
                                        <label for="purchase_date">Purchase Date</label>
                                        <input type="date" class="form-control" name="purchase_date" id="purchase_date"
                                            placeholder="Purchase Date"
                                            value="{{ old('purchase_date', isset($equipment) ? $equipment->purchase_date : '' )  }}">
                                    </div>

                                    <div class="form-group col-sm-6 col-lg-4 col-xl-3">
                                        <label for="purchase_cost">Purchase Cost</label>
                                        <input type="number" class="form-control" name="purchase_cost"
                                            id="purchase_cost" placeholder="Purchase Cost"
                                            value="{{ old('purchase_cost', isset($equipment) ? $equipment->purchase_cost : '' )  }}">
                                    </div>

                                    <div class="form-group col-sm-6 col-lg-4 col-xl-3">
                                        <label>Vendor Name</label>
                                        <select class="form-control" name="vendor_id" id="vendor_id">
                                            <option value="" disabled>-- Select vendor --</option>
                                            @foreach ($vendor as $data)
                                            <option value="{{$data->id}}"
                                                {{ old('vendor_id')==$data->id || isset($equipment)&&($equipment->vendor_id==$data->id) ? 'selected' : ''  }}>
                                                {{$data->vendor_name}}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group col-sm-6 col-lg-4 col-xl-3">
                                        <label>Equipment Status</label>
                                        <select class="form-control" name="equipment_status">
                                            <option
                                                {{ old('equipment_status')=='Active' || isset($equipment)&&($equipment->equipment_status=='In-Active') ? 'selected' : ''  }}
                                                value="Active">Active</option>
                                            <option
                                                {{ old('equipment_status')=='In-Active' || isset($equipment)&&($equipment->equipment_status=='In-Active') ? 'selected' : ''  }}
                                                value="In-Active">Inactive</option>
                                        </select>
                                    </div>

                                    <div class="form-group col-sm-6 col-lg-4 col-xl-3">
                                        <label>Warranty Status <span class="required text-danger">*</span></label>
                                        <select class="form-control" name="warranty_status" id="warranty_status">
                                            <option value="">-- Select Warranty --</option>
                                            <option
                                                {{ old('warranty_status') == 'Warranty' || isset($equipment)&&($equipment->warranty_status== 'Warranty') ? 'selected' : ''  }}
                                                value="Warranty">Warranty</option>
                                            <option
                                                {{ old('warranty_status') == 'AMC Contract' || isset($equipment)&&($equipment->warranty_status=='AMC Contract') ? 'selected' : ''  }}
                                                value="AMC Contract">AMC Contract</option>
                                            <option
                                                {{ old('warranty_status')=='Out of Warranty/AMC Contract' || isset($equipment)&&($equipment->warranty_status=='Out of Warranty/AMC Contract') ? 'selected' : ''  }}
                                                value="Out of Warranty/AMC Contract">Out of Warranty/AMC Contract
                                            </option>
                                        </select>
                                    </div>

                                    <div class="form-group col-sm-6 col-lg-4 col-xl-3" id="warranty_date_div"
                                        style="display:none">
                                        <label for="warranty_date">Warranty/AMC Upto(Date) <span
                                                class="required text-danger">*</span></label>
                                        <input type="Date" class="form-control" name="warranty_date" id="warranty_date"
                                            value="{{ old('warranty_date', isset($equipment) ? $equipment->warranty_date : '' )  }}">
                                    </div>

                                    <div class="form-group col-sm-6 col-lg-4 col-xl-3">
                                        <label>Invoice File </label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="invoiceFile"
                                                    name="invoiceFile">
                                                <label class="custom-file-label" for="invoiceFile">Choose file</label>
                                            </div>
                                        </div>
                                        <div id="list_file">
                                            {{ old('invoiceFile', isset($equipment) ? $equipment->invoiceFile : '' )  }}
                                        </div>

                                        @if(isset($equipment) && ($equipment->invoiceFile != NULL))<button type="button"
                                            class="btn btn-primary btn-sm" name="removeinvoicefile"
                                            value="{{ old('invoiceFile', isset($equipment) ? $equipment->invoiceFile : '' )  }}">Delete
                                            File</button>
                                        @endif
                                    </div>
                                </div>
                                <input type="hidden" name="oldfilename"
                                    value="{{ old('invoiceFile', isset($equipment) ? $equipment->invoiceFile : '' )  }}">
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
    $("#frmequipment").validate({
        rules: {
            unit_id: {
                required: true
            },
            equipment_name: {
                required: true
            },
            equipment_code: {
                required: true,
            },
            serial_no: {
                required: true,
            },
            department_id: {
                required: true,
            },
            warranty_status: {
                required: true
            },
            equipment_status: {
                required: true
            },
            user_id: {
                required: true
            },
            warranty_date: {
                required: true
            },
        },
        messages: {
            equipment_name: "Equipment Name is required",
            equipment_code: "Asset Code is required",
            serial_no: "Serial No. is required",
            user_id: "Please select responsible enduser",
            unit_id: "Please select unit",
            department_id: "Please select department",
            warranty_status: "Please select the status",
            equipment_status: "Please select the status",
            warranty_date: "Please select warranty date",
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

    checkWarranty();
    $("#warranty_status").change(function() {
        checkWarranty();
    });

    function checkWarranty() {
        if ($("#warranty_status").val() == "Warranty") {
            $("#warranty_date_div").show()
        } else {
            $("#warranty_date_div").hide()
        }
    }

    var fileInput = document.getElementById('invoiceFile');
    var listFile = document.getElementById('list_file');

    fileInput.onchange = function() {
        var files = Array.from(this.files);
        files = files.map(file => file.name);
        listFile.innerHTML = files.join('<br/>');
    }

    $('button[name="removeinvoicefile"]').on('click', function() {
        if (this.value == '') {
            var id = "<?php echo isset($equipment->id)?$equipment->id:'' ?>";
            var file = "<?php echo isset($equipment->invoiceFile)?$equipment->invoiceFile:'' ?>";
            toastr.success("File Deleted Successfully", 'Invoice File');
            $("#list_file").html("");
        } else {
            $.ajax({
                url: "{{route('deleteInvoicefile')}}",
                type: "POST",
                data: {
                    filename: file,
                    id: id,
                    _token: '{{csrf_token()}}'
                },
                dataType: 'json',
                success: function(res) {
                    if (res.msg == 1) {
                        toastr.success("File Deleted Successfully", 'Invoice File');
                        $("#list_file").html("");
                        $('button[name="removeinvoicefile"]').remove()
                    } else if (res.msg == 2) toastr.error("File Not Found", 'Invoice File');
                }
            });
        }
    });
     // get department
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