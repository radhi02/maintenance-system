@extends('layouts.app')
 
@section('content')

    <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Task Master</h1>
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
                <h3 class="card-title">Add Task</h3>
              </div>
              
              <!-- form start -->
              
                <div class="card-body table-responsive">
                  <table id="tbltask" class="table table-sm table-bordered table-hover">
                    <thead>
                      <tr>
                          <th width="40px">No.</th>
                          <th>Equipment Name</th>
                          <th>Major</th>
                          <th>Minor</th>
                          <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                   
                    @foreach ($task as $t)
                      <tr>
                      <td>{{ $loop->iteration}}</td>
                        <td>{{ $t->equipment_name }}</td>
                        <td>
                          <?php 
                          if($t->major != null) {
                            $major = explode(',',$t->major);
                            echo '<ul>';
                            foreach($major as $m) {
                              echo '<li>'.$m.'</li>';                            
                            }
                            echo '</ul>';
                          } else echo '-'; ?>
                        </td>
                        <td>                          
                          <?php 
                          if($t->minor != null) {
                            $major = explode(',',$t->minor);
                            echo '<ul>';
                            foreach($major as $m) {
                              echo '<li>'.$m.'</li>';                            
                            }
                            echo '</ul>';
                          } else echo '-'; ?>
                        </td>
                        <td>
                          <div class="action_btn">
                            <a href="{{ route('task.edit',$t->id) }}" class="text-success mr-2" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Edit">
                              <i class="fas fa-edit fa-lg"></i>
                            </a> 
                          </div>
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

@endsection
