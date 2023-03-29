@extends('layouts.app')

@section('content')

<script> var i=1;</script>
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
              <li class="breadcrumb-item active"><a href="{{ route('reactive_maintenance.index') }}">Reactive Maintenance</a></li>
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

            <form action="{{ isset($ReactiveMaintenance) ? route('reactive_maintenance.update', $ReactiveMaintenance->id) : route('reactive_maintenance.store') }}" method="POST" id="frmequipment" autocomplete="off">
            @csrf
            {{ isset($ReactiveMaintenance) ? method_field('PUT') : '' }}

             <!-- Add Tender Form -->
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">{{ isset($ReactiveMaintenance) ? 'Edit' : 'Add' }} Reactive Maintenance</h3>
              </div>
              <!-- form start -->
                <div class="card-body">
                  <div class="row">
                    <div class="form-group col-sm-6 col-lg-4 col-xl-12">
                      <label>Select equipment</label>
                      <select class="form-control" name="equipment_id" id="equipment_id">
                        <option value="" >-- Select equipment --</option>
                        @foreach ($equipment as $data)
                        <option value="{{$data->id}}" {{ old('equipment_id', (isset($ReactiveMaintenance)&& $ReactiveMaintenance->equipment_id == $data->id) ? 'selected' : ''   )}}>
                            {{$data->equipment_name}}
                        </option>
                        @endforeach  
                      </select>
                    </div>
                   <div class="form-group col-sm-6 col-lg-4 col-xl-6" style="display:none ;">
                      <label for="code">Request Date</label>
                      <input type="date" class="form-control" name="plan_date" id="date" placeholder="Request  Date" value="{{ old('date', isset($ReactiveMaintenance) ? ShowNewDateFormat($ReactiveMaintenance->date) : '' )  }}" >
                    </div>
                    <div class="form-group col-sm-6 col-lg-4 col-xl-12">
                      <label>Problem</label>
                      <textarea class="form-control" name="Problem" id="Problem"  >{{ old('Problem', isset($ReactiveMaintenance) ? $ReactiveMaintenance->Problem : '' )  }}</textarea>
                    </div>
                    <input type="text" value="Reactive" name="maintenance_type" hidden>

                  <!-- <div class="form-group col-sm-6 col-lg-4 col-xl-6">
                      <label>Assign  User</label>
                      <select class="form-control" name="user_id" id="user_id">
                        <option value="" disabled>-- Select User --</option>
                        @foreach ($users as $data)
                        <option value="{{$data->id}}" {{ old('user_id', (isset($ReactiveMaintenance)&& $ReactiveMaintenance->user_id == $data->id) ? 'selected' : ''   )}}>
                            {{$data->first_name }}
                        </option>
                        @endforeach
                      </select>
                    </div> -->
                    <!-- <div class="form-group col-sm-6 col-lg-4 col-xl-6"> 
                      <label> Remark</label>
                      <textarea class="form-control" name="note" id="note">{{ old('note', isset($ReactiveMaintenance) ? $ReactiveMaintenance->note : '' )  }}</textarea>
                    </div> -->
                    <div class="form-group col-sm-6 col-lg-4 col-xl-6">
                      <label> Criticality</label>
                      <select class="form-control" name="criticality">
                        <option {{ old('Non-Critical', isset($ReactiveMaintenance)&&($ReactiveMaintenance->status=='Non-Critical') ? 'selected' : '' ) }} value="Non-Critical" selected>Non-Critical</option>
                        <option {{ old('Critical', isset($ReactiveMaintenance)&&($ReactiveMaintenance->status=='Critical') ? 'selected' : '' ) }} value="Critical">Critical</option>
                      </select>
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
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script>
    $('#date').val(new Date().toJSON().slice(0,10));
</script>
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
                status: {
                    required: true                
                },
                
                
            },
            messages: {
              equipment_id: "Please select Equipment",
              status: "Please select status",
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
   
  </script>
  

@endsection
