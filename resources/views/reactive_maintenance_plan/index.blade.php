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
            <h1 class="m-0">Reactive Maintenance Plan  Activity</h1>
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
                <h3 class="card-title">Add Reactive Maintenance Plan  Activity</h3>
                <!-- @php   $role = Auth::user()->Role; @endphp
                @if($role == 3) -->
                <div class="card-tools">
                  <!-- <button type="button" class="btn btn-info" data-toggle="modal" data-target="#edit-modal"> -->
                  <a class="btn btn-success" href="{{ route('reactive_maintenance_plan.create') }}"> Create New Reactive Maintenance Plan  Activity</a>
                </div>
                <!-- @endif -->
              </div>
              
              <!-- form start -->
                <div class="card-body">
                  <div class="table-responsive"> 
                  <table id="tblvendor" class="table table-sm table-bordered table-hover">
                    <thead>
                      <tr>
                          <th width="40px">No.</th>
                          <th>Equipment </th>
                          <th>Request  Date</th>
                          <th>Problem</th>
                          <th>Assign  User </th>
                          <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                    @foreach ($reactive_maintenance as $reactive)
                      <tr>
                          <td>{{ $loop->iteration}}</td>
                          <td>{{ $reactive->ename }}</td>
                          <td>{{ ShowNewDateFormat($reactive->plan_date))}}</td>
                          <td>{{ $reactive->Problem }}</td>
                          <td>{{ $reactive->uname }}</td>
                          <td>
                              <form action="{{ route('reactive_maintenance_plan.destroy',$reactive->id) }}" method="POST">
                                <div class="action_btn">  
                                  <a class="mr-2" data-toggle="tooltip" data-placement="bottom" title="Show Data" data-original-title="View" href="{{ route('reactive_maintenance_plan.show',$reactive->id) }}"><i class="fas fa-eye fa-lg" aria-hidden="true"></i>
                                  </a>                 
                                  <!-- <a href="{{ route('reactive_maintenance_plan.edit',$reactive->id) }}" class="text-success mr-2" data-toggle="tooltip" data-placement="bottom" title="Update Ticket" data-original-title="Edit">
                                    <i class="fas fa-edit fa-lg"></i>
                                  </a>  -->
                                    @csrf
                                    @method('DELETE')

                                    {{-- <button type="submit" class="btn btn-danger">Delete</button> --}}
                                    <button type="submit" class="text-danger" data-toggle="tooltip" data-placement="bottom" title="Delete" data-original-title="Delete"><i class="fas fa-trash fa-lg"></i></button>
                                </div>
                              </form>
                          </td>
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
      </div>
    </div>
  </div>
</div>
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

    $('#equipment_id').on('change', function () {
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
              success: function (res) {
                  // $('#date').html('<input type="date"  name="date" id="date">');
                  $.each(res, function (key, value) {
                          $("#date").html('<label for="code">Request Date</label><input  disabled class="form-control" name="date" type="date" value="' + value.date + '">');
                          $("#Problem").html('<label>Problem</label><input disabled class="form-control" name="date" type="input" value="' +   value.Problem + '">');
                  });
              }
          });
      });
   
      $(function() {
        $('#equipment_id').change(function(){
          $('.showdate').show();
          $('.showdate' + $(this).val()).hide();
        });
      });

      $(function() {
        $('#equipment_id').change(function(){
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
      $('select[name="user_id"]').on('change', function(){
      var user_id = $(this).val();
      var id = $(this).data('id'); 
        $.ajax({
            type: "GET",
            dataType: "json",
            url: "{{route('changeUser')}}",
            data: {'user_id': user_id, 'id': id},
            success: function(data){
              location.reload();
              // console.log(data)
            }
        });
    })

    //Self Assign user 
    $('button[name="selfuser_id"]').on('click', function(){
      var selfuser_id = $(this).val();
      var id = $(this).data('id'); 
        $.ajax({
            type: "GET",
            dataType: "json",
            url: "{{route('changeUserself')}}",
            data: {'selfuser_id': selfuser_id, 'id': id},
            success: function(data){
              // console.log(data)
              location.reload();
            }
        });
    })
  </script>
  
@endsection
