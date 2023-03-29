@extends('layouts.app')
  
@section('content')

<div class="content-wrapper" style="min-height: 1302.4px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Show Department</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
              <li class="breadcrumb-item active"><a href="{{ route('departments.index') }}">Department Master</a></li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <!-- /.card-header -->
              <div class="card-body p-0">
                <table class="table table-sm">
                  <tbody>
                    <tr>
                      <th>Department ID</th>
                      <td>{{ $department->id }}</td>
                    </tr>
                    <tr>
                      <th>Name</th>
                      <td>{{ $department->name }}</td>
                    </tr>
                    <tr>
                      <th>Code</th>
                      <td>{{ $department->code }}</td>
                    </tr>
                    <tr>
                      <th>Unit Name</th>
                      <td>{{ $department->unitname }}</td>
                    </tr>
                    <tr>
                      <th>HOD</th>
                      <td>{{ $department->hod }}</td>
                    </tr>
                    <tr>
                      <th>Status</th>
                        <td>@if($department->status == 1)
                            <span class="badge bg-success">Active</span>
                        @else
                            <span class="badge bg-danger">InActive</span>
                        @endif 
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>

      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
@endsection
