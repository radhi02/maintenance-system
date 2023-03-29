@extends('layouts.app')
 
@section('content')

    <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Preventive Plan</h1>
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
                <h3 class="card-title">Preventive Plan List</h3>
              </div>
                 <!-- form start -->
              
                 <div class="card-body table-responsive">
                  <table id="tblplan" class="table table-sm table-bordered table-hover">
                    <thead>
                      <tr>
                          <th width="40px">No.</th>
                          <th>Equipment</th>
                          <th>Plan Date</th>
                          <th>Activity</th>
                      </tr>
                    </thead>
                    <tbody>
                   
                    @foreach ($planlist as $plan)
                      <tr>
                          <td>{{ $plan->id}}</td>
                          <td>{{ $plan->equipment_name }}</td>
                          <td>{{ ShowNewDateFormat($plan->plan_date) }}</td>
                          <td>
                          <?php 
                                if($plan->tasktype == "minor")
                                {
                                  echo $plan->minor;
                                } else {
                                  echo $plan->major;
                                  echo ",";
                                  echo $plan->minor;
                                }
                                ?>
                          </td>
                      </tr>
                      @endforeach
                      
                    </tbody>
                    
                  </table>
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
<!-- boostrap Plan model -->  
<div class="modal fade" id="planedit-modal-lg" aria-hidden="true" style="display: none;">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Edit Plan</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="javascript:void(0)" id="PlanActivityForm" name="PlanActivityForm" class="form-horizontal" method="POST" enctype="multipart/form-data">          
          {{-- plan_id,plan_date,equipmetn_id,assigned_to, 
            attendded by current user, remark
            replaced_spare,spare_cost,remark --}}
            <div class="row">
              <div class="form-group col-sm-6 col-lg-4 col-xl-4">
                <label for="planid">Plan Id</label>
                <input type="text" class="form-control" name="planid" id="planid" disabled>
              </div>        
              <div class="form-group col-sm-6 col-lg-4 col-xl-4">
                <label for="plandate">Plan Date</label>
                <input type="text" class="form-control" name="plandate" id="plandate" disabled>
              </div>                                      
              <div class="form-group col-sm-6 col-lg-4 col-xl-4">
                <label for="equipementid">Equipment Id</label>
                <input type="text" class="form-control" name="equipementid" id="equipementid" disabled>
              </div>                                      
              <div class="form-group col-sm-6 col-lg-4 col-xl-4">
                <label for="equipementname">Equipment Name</label>
                <input type="text" class="form-control" name="equipementname" id="equipementname" disabled>
              </div>                                      
              <div class="form-group col-sm-6 col-lg-4 col-xl-4">
                <label>Select Start & End Date-Time range:</label>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="far fa-clock"></i></span>
                  </div>
                  <input type="text" class="form-control float-right" id="reservationtime">
                </div>
                <!-- /.input group -->
              </div>
              <div class="form-group col-sm-6 col-lg-4 col-xl-4">
                <label for="loss_repair_hur">Loss Repair Hour</label>
                <input type="number" class="form-control" name="loss_repair_hur" id="loss_repair_hur" placeholder="Loss Repair Hour">
              </div>
              <div class="form-group col-sm-6 col-lg-4 col-xl-4">
                <label for="cost_servies">Cost of Servies From External Vendor</label>
                <input type="number" class="form-control" name="cost_servies" id="cost_servies" placeholder="Cost of Servies From External Vendor">
              </div>
              <div class="form-group col-sm-6 col-lg-4 col-xl-4">
                <label for="MTBF">MTBF (Days)</label>
                <input type="text" class="form-control" name="MTBF" id="MTBF" placeholder="MTBF (Days)">
              </div>
              <div class="form-group col-sm-6 col-lg-4 col-xl-12"> 
                <label> Action Taken *</label>
                <textarea class="form-control" name="note" id="note"></textarea>
              </div>
              <div class="col-sm-2 col-lg-4 col-xl-2"> 
                <label> Major Checklist</label> 
              </div>
              <div class="col-sm-6 col-lg-4 col-xl-6"> 
                <div class="icheck-primary d-inline"> 
                  <input type="checkbox" id="checkboxPrimaryJ" name="major"  value="1" class="chkmajor"> 
                  <label for="checkboxPrimaryJ">HHHHH</label> 
                </div>
                <div class="icheck-primary d-inline"> 
                  <input type="checkbox" id="checkboxPrimaryJ" name="major"  value="1" class="chkmajor"> 
                  <label for="checkboxPrimaryJ">HHHHH</label> 
                </div>
                <div class="icheck-primary d-inline"> 
                  <input type="checkbox" id="checkboxPrimaryJ" name="major"  value="1" class="chkmajor"> 
                  <label for="checkboxPrimaryJ">HHHHH</label> 
                </div>
                <div class="icheck-primary d-inline"> 
                  <input type="checkbox" id="checkboxPrimaryJ" name="major"  value="1" class="chkmajor"> 
                  <label for="checkboxPrimaryJ">HHHHH</label> 
                </div>
                <div class="icheck-primary d-inline"> 
                  <input type="checkbox" id="checkboxPrimaryJ" name="major"  value="1" class="chkmajor"> 
                  <label for="checkboxPrimaryJ">HHHHH</label> 
                </div>
              </div>
            </div>
          <table class="table table-striped table-valign-middle">
            <thead>
            <tr>
              <th>Replaced Spare</th>
              <th>Spare's Cost</th>
              <th>Remark</th>
              <th><button type="button" class="btn btn-info add_button">Add Row</button></th>
            </tr>
            </thead>
            <tbody class="field_wrapper">
            </tbody>
          </table>
        </form>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" id="btn-save">Save changes</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- end bootstrap model -->

<script>
  $('#reservationtime').daterangepicker({
    timePicker: true,
    timePickerIncrement: 30,
    locale: {
      format: 'MM/DD/YYYY hh:mm A'
    }
  })

  $.ajaxSetup({
      headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });

  var maxField = 10; //Input fields increment limitation
  var addButton = $('.add_button'); //Add button selector
  var wrapper = $('.field_wrapper'); //Input field wrapper
  var fieldHTML = '<tr> <td> <div class="col-sm-6 col-lg-4 col-xl-12"> <input type="text" class="form-control" name="txtdetail[]"> </div> </td> <td> <div class="col-sm-6 col-lg-4 col-xl-12"> <input type="text" class="form-control" name="txtsparecost[]"> </div> </td> <td> <div class="col-sm-6 col-lg-4 col-xl-12"> <input type="text" class="form-control" name="txtspareremark[]"> </div> </td> <td> <div class="col-sm-6 col-lg-4 col-xl-12"> <button type="button" class="btn btn-danger remove_button">Remove</button> </div> </td> </tr>'; //New input field html 
  var x = 1; //Initial field counter is 1
  
  //Once add button is clicked
  $(addButton).click(function(){
      //Check maximum number of input fields
      if(x < maxField){ 
          x++; //Increment field counter
          $(wrapper).append(fieldHTML); //Add field html
      }
  });
  
  //Once remove button is clicked
  $(wrapper).on('click', '.remove_button', function(e){
      e.preventDefault();
      $(this).closest('tr').remove(); //Remove field html
      x--; //Decrement field counter
  });

  function editFunc(id){
      $('#PlanActivityForm').trigger("reset");
      $.ajax({
        type:"get",
        url: "{{ route('planactivity.edit',"+id+") }}",
        data: { id: id },
        dataType: 'json',
        success: function(res){
          console.log(res);
          $('#planid').val(res['PId']);
          $('#plandate').val(res['PDate']);
          $('#equipementid').val(res['EId']);
          $('#equipementname').val(res['Ename']);
          // $('#editplandate').val(res['plan_date']);
          // $('#editequipement').val(res['equipment_name']);
          // $('#edit_assigned_to_userid option[value='+res['assigned_to_userid']+']').attr('selected','selected');
          // if(res['major_task_id'] != null) {
          //   $('#editmajor').prop('checked', true);
          // }
          // if(res['minor_task_id'] != null) {
          //   $('#editminor').prop('checked', true);
          // }
          // $('#PlanModal').html("Edit Plan");
          $('#planedit-modal-lg').modal('show');
        }
      });
    }  
</script>

@endsection
