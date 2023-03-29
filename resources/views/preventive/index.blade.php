@extends('layouts.app')
 
@section('content')

    <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Preventive Plan Action</h1>
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

                <div class="card-tools">
                  <a class="btn btn-success" href="{{route('plan.create')}}"> Create New Plan</a>
                </div>
              </div>
                 <!-- form start -->
              <?php 
                $frequency = [12=>'Monthly',4=>'Quarterly',2=>'Half Yearly',1=>'Yearly'];
              ?>
                 <div class="card-body table-responsive">
                  <table id="tblplan" class="table table-sm table-bordered table-hover">
                    <thead>
                      <tr>
                          <th width="40px">No.</th>
                          <th>Equipment</th>
                          <th>Frequancy</th>
                          <th>Start Date</th>
                          <th>Assigned User</th>
                          <th>Ticket Status</th>
                      </tr>
                    </thead>
                    <tbody>
                   
                    @foreach ($planmasters as $plan)
                      <tr>
                        <td>{{ $loop->iteration}}</td>
                          <td>{{ $plan->equipment_name }}</td>
                          <td>{{ $frequency[$plan->frequancy] }}</td>
                          <td>{{ ShowNewDateFormat($plan->start_date) }}</td>
                          <td>{{ ucfirst($plan->first_name.' '.$plan->last_name) }}</td>
                          <td><span class="badge bg-secondary">{{$plan->ticket_status}}</span>
                          </td>
                          <!-- <td>
                            <form action="{{ route('plan.destroy',$plan->uniqueid) }}" method="POST">
                              <div class="action_btn">  
                                <a class="mr-2" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="View" href="{{ route('plan.show',$plan->uniqueid) }}"><i class="fas fa-eye fa-lg" aria-hidden="true"></i>
                                </a>                 
                                <a href="{{ route('plan.edit',$plan->uniqueid) }}" class="text-success mr-2" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Edit">
                                  <i class="fas fa-edit fa-lg"></i>
                                </a> 

                                  @csrf
                                  @method('DELETE')

                                   <button type="submit" class="btn btn-danger">Delete</button>
                                  <button type="submit" class="text-danger" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Delete"><i class="fas fa-trash fa-lg"></i></button>
                              </div>
                            </form>
                        </td> -->

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
<script>
    $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>

@endsection
