@extends('layouts.app')
 
@section('content')

    <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Company Master</h1>
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
                <h3 class="card-title">Company List</h3>

                <div class="card-tools">
                  {{-- <div class="btn-group">
                    <button type="button" class="btn btn-success">Action</button>
                    <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
                      <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <div class="dropdown-menu" role="menu">
                      <a class="dropdown-item" href="#">Active</a>
                      <a class="dropdown-item" href="#">InActive</a>
                    </div>
                  </div> --}}
                  <a class="btn btn-success" href="{{ route('companies.create') }}"> Create New Company</a>
                </div>
              </div>
              
              <!-- form start -->
              
                <div class="card-body table-responsive">
                  <table id="tblcompany" class="table table-sm table-bordered table-hover ">
                    <thead>
                      <tr>
                          <th >No.</th>
                          <th>Name</th>
                          <th>Email</th>
                          <th>Company Code</th>
                          <th>City</th>
                          <th>Status</th>
                          <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($companies as $company)
                      <tr>
                          <td>{{ $loop->iteration}}</td>
                          <td>{{ $company->name }}</td>
                          <td>{{ $company->email }}</td>
                          <td>{{ $company->code }}</td>
                          <td>{{ $company->city }}</td>
                          <td>  @if($company->status == 1)
                                  <span class="badge bg-success">Active</span>
                                @else
                                  <span class="badge bg-danger">InActive</span>
                                @endif   
                          </td>
                          <td>
                              <form action="{{ route('companies.destroy',$company->id) }}" method="POST">
                                <div class="action_btn">  
                                  <a class="mr-2" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="View" href="{{ route('companies.show',$company->id) }}"><i class="fas fa-eye fa-lg" aria-hidden="true"></i>
                                  </a>                 
                                  <a href="{{ route('companies.edit',$company->id) }}" class="text-success mr-2" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Edit">
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
