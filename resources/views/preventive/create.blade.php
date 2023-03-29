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
              <li class="breadcrumb-item active"><a href="{{ route('plan.index') }}">Maintenance Plan</a></li>
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
              <form action="{{ isset($MaintenancePlan) ? route('plan.update', $MaintenancePlan->uniqueid) : route('plan.store') }}" method="POST" id="frmplan" autocomplete="off">
              @csrf
              {{ isset($MaintenancePlan) ? method_field('PUT') : '' }}
              <!-- Add Tender Form -->
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">{{ isset($MaintenancePlan) ? 'Edit' : 'Add' }} Maintenance Plan</h3>
                </div>
                <!-- form start -->
                  <div class="card-body">
                    <div class="row">
                      <div class="form-group col-sm-6 col-lg-4 col-xl-6">
                        <label>Select Equipment</label>
                        <select class="form-control" name="equipment_id" id="equipment_id">
                          <option value="" disabled>-- Select Equipment --</option>
                          @foreach ($equipement as $data)
                          <option value="{{$data->id}}" {{ old('equipment_id', (isset($MaintenancePlan)&& $MaintenancePlan->equipment_id == $data->id) ? 'selected' : ''   )}}>
                              {{$data->equipment_name}}
                          </option>
                          @endforeach  
                        </select>
                      </div>
                      <div class="form-group col-sm-6 col-lg-4 col-xl-6">
                        <label for="code">Start Date</label>
                        <input type="date" class="form-control" value="{{ old('date', isset($MaintenancePlan) ? $MaintenancePlan->start_date :date('Y-m-d')) }}" name="date" id="startdate" min="<?php echo date("Y-m-d"); ?>"/>
                      </div>

                      <div class="form-group col-sm-6 col-lg-4 col-xl-6">
                        <label>Assign To Maintenance User</label>
                        <select class="form-control" name="assigned_to_userid" id="assigned_to_userid">
                          <option value="" disabled>-- Select User --</option>
                          @foreach ($users as $data)
                          <option value="{{$data->id}}" {{ old('hod_id', (isset($MaintenancePlan)&& $MaintenancePlan->assigned_to_userid == $data->id) ? 'selected' : ''   )}}>
                            {{$data->first_name.' '.$data->last_name}}
                          </option>
                          @endforeach
                        </select>
                      </div>

                      <div class="form-group col-sm-6 col-lg-4 col-xl-6">
                        <label>Frequancy Type</label>
                        <select class="form-control" name="frequancy" id="frequency" required>
                        <option value="" >Select Frequancy Type</option>
                        <option  value="12" {{ old('frequancy', (isset($MaintenancePlan)&& $MaintenancePlan->frequancy == 12) ? 'selected' : ''   )}}>Monthly</option>
                        <option  value="4" {{ old('frequancy', (isset($MaintenancePlan)&& $MaintenancePlan->frequancy == 4) ? 'selected' : ''   )}}>Quarterly</option>
                        <option value="2" {{ old('frequancy', (isset($MaintenancePlan)&& $MaintenancePlan->frequancy == 2) ? 'selected' : ''   )}}> Half Yearly</option>
                        <option  value="1" {{ old('frequancy', (isset($MaintenancePlan)&& $MaintenancePlan->frequancy == 1) ? 'selected' : ''   )}}>Yearly</option>
                        </select>
                      </div>

                  <!-- /.card-body -->
                    </div>

                    <table class="table table-striped table-valign-middle">
                      <thead>
                      <tr>
                        <th>Date</th>
                        <th>Major</th>
                        <th>Minor</th>
                      </tr>
                      </thead>
                      <tbody class="field_wrapper">
                        @if (isset($scheduledata))
                          @foreach($scheduledata as $k => $v)
                          <tr> 
                              <td> 
                                <div class="col-sm-6 col-lg-4 col-xl-6"> 
                                  <input type="date" class="form-control" value="{{ $v->plan_date }}" name="datelist['{{$k}}']" id="datelist['{{$k}}']"/>
                                </div>
                              </td>
                              <td>
                                <div class="icheck-primary d-inline"> 
                                  <input type="radio" id="radioPrimaryId1['{{$k}}']" name="radioPrimary['{{$k}}']"  value="major"  {{($v->tasktype=='major')?'checked':''}}> <label for="radioPrimaryId1['{{$k}}']"> </label> 
                                </div> 
                              </td> 
                              <td> 
                                <div class="icheck-primary d-inline"> 
                                  <input type="radio" id="radioPrimaryId2['{{$k}}']" name="radioPrimary['{{$k}}']"  value="minor"  {{($v->tasktype=='minor')?'checked':''}}> 
                                  <label for="radioPrimaryId2['{{$k}}']"> </label> 
                                </div> 
                              </td> 
                          </tr>
                          @endforeach
                        @endif
                      </tbody>
                    </table>
                  </div>
                  <div class="card-footer">
                    <button type="submit" class="btn my_btn">Create Schedule</button>
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
      $("#frmplan").validate({
        rules: {
            equipment_id: {
                required: true,
            },
            frequency: {
                required: true
            },
            date: {
                required: true                
            },
            assigned_to_userid: {
                required: true                
            },
            minor: {
                required: true                
            },
        },
        messages: {
          equipment_id: "Please select Equipment",
          frequency: "Please select Frequancy",
          date: "Please select Scheduled  date",
          assigned_to_userid: "Please select Assigne To Maintenance User",
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
    var wrapper = $('.field_wrapper'); //Input field wrapper
    var fieldHTML = '';
    // check();
    function check()
    {
      wrapper.html('');
      //Check maximum number of input fields

      maxField = $('#frequency').val();
      var datelist = [];
      var startDate = $("#startdate").val();
      var newDate = moment(startDate, "YYYY-MM-DD").add(1, 'year').format('YYYY-MM-DD');
      var divide = {12:1,4:4,2:6,1:12};
        
      for(var i=1; i<=maxField; i++) 
      {
        var ma,mj = null;
        var dd = moment(startDate, "YYYY-MM-DD").add(divide[maxField], 'month').format('YYYY-MM-DD');

        if(i==1) {
          var dd = moment(startDate).format('YYYY-MM-DD');
        }
        startDate = dd;
        fieldHTML = '<tr> <td> <div class="col-sm-6 col-lg-4 col-xl-6"> <input type="date" class="form-control" name="datelist['+i+']" id="datelist['+i+']" value='+dd+'> </div></td> <td> <div class="icheck-primary d-inline"> <input type="radio" id="radioPrimaryId1['+i+']"  name="radioPrimary['+i+']"  value="major" > <label for="radioPrimaryId1['+i+']"></label> </div> </td> <td> <div class="icheck-primary d-inline"> <input type="radio" id="radioPrimaryId2['+i+']"  name="radioPrimary['+i+']"  value="minor" > <label for="radioPrimaryId2['+i+']"></label> </div> </td></tr>';
        $(wrapper).append(fieldHTML);
      }
      $(".mydatepicker").datepicker();

    }
    $('#frequency').on('change', function () {
      check();
    });
    
    $('#startdate').change(function() {
      if($('#frequency').val() != "") check();
    });

    //Once remove button is clicked
    $(wrapper).on('click', '.remove_button', function(e){
        e.preventDefault();
        $(this).closest('div').remove(); //Remove field html
    });
  });  
</script>
  

@endsection
  