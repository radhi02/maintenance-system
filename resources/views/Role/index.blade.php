@extends('layouts.app')
 
@section('content')

    <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Role Master</h1>
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
                <h3 class="card-title">Add Role</h3>

                <div class="card-tools">
                  <a class="btn btn-success" href="{{ route('role.create') }}"> Create New Role</a>
                </div>
              </div>
              
              <!-- form start -->
              
                <div class="card-body table-responsive">
                  <table id="tblrole" class="table table-sm table-bordered table-hover">
                    <thead>
                      <tr>
                          <th width="40px">No.</th>
                          <th>Name</th>
                          <th>Permission</th>
                          <th>Status</th>
                          <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach($roles as $values)
                        <tr>
                          <td>{{ $loop->iteration}}</td>
                          <td>{{ $values->name }}</td>
                          <td> <a href="{{route('Module.permission',$values->id)}}"  class="badge bg-success" >Permission</a></td>
                          <td>  @if($values->status == "Active")
                                  <span class="badge bg-success">Active</span>
                                @else
                                  <span class="badge bg-danger">InActive</span>
                                @endif   
                          </td>
                          <td>
                              <form action="{{ route('role.destroy',$values->id) }}" method="POST">
                                <div class="action_btn">  
                                  <a class="mr-2" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="View" href="{{ route('role.show',$values->id) }}"><i class="fas fa-eye fa-lg" aria-hidden="true"></i>
                                  </a>                 
                                  <a href="{{ route('role.edit',$values->id) }}" class="text-success mr-2" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Edit">
                                    <i class="fas fa-edit fa-lg"></i>
                                  </a> 
                  
                                    @csrf
                                    @method('DELETE')

                                    {{-- <button type="submit" class="btn btn-danger">Delete</button> --}}
                                    <button type="submit" class="text-danger" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Delete"><i class="fas fa-trash fa-lg"></i></button>
                                </div>
                              </form>
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
