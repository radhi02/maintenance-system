@extends('layouts.app')
  
@section('content')

<div class="content-wrapper" style="min-height: 1302.4px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>User Show</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
              <li class="breadcrumb-item active"><a href="{{ route('user.index') }}">User Master</a></li>
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
                      <th>First Name</th>
                      <td>{{$edit_users->first_name}}</td>
                    </tr>
                    <tr>
                        <th>Last Name</th>
                        <td>{{$edit_users->last_name}}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{$edit_users->email}}</td>
                    </tr>
                    <tr>
                        <th>Mobile No.</th>
                        <td>{{$edit_users->Phone}}</td>
                    </tr>
                    <tr>
                        <th>Unit Name</th>
                        <td>{{$Unit->name}}</td>
                    </tr>
                    <tr>
                        <th>Department Name</th>
                        <td>{{$Department->name}}</td>
                    </tr>
                    <tr>
                        <th>User Type </th>
                        <td>{{checkRole($edit_users->Role) }}</td>
                    </tr>
                    <tr>
                        <th>Country </th>
                        <td>{{$Countries->name}}</td>
                    </tr>
                    <tr>
                        <th>State</th>
                        <td>{{$States->name}}</td>
                    </tr>
                    <tr>
                        <th>City</th>
                        <td>{{$Cities->name}}</td>
                    </tr>
                    <tr>
                      <th>Image</th>
                      <td>
                          @php
                          if(isset($edit_users->Image))
                          {
                            $filename =  public_path('Users/'. $edit_users->Image);
                            if($edit_users->Image != '')
                            {
                              $img='Users/'.$edit_users->Image;
                            }
                          }
                          else { $img="Admin/no_preview.jpg"; }
                          @endphp
                          <img src="{{ URL::asset($img) }}" alt="{{$edit_users->first_name}}" width="150" height="150" class="img">
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
