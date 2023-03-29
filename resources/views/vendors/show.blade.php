@extends('layouts.app')
  
@section('content')

<div class="content-wrapper" style="min-height: 1302.4px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Show Vendor</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
              <li class="breadcrumb-item active"><a href="{{ route('vendors.index') }}">Vendor Master</a></li>
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
                      <th>Name</th>
                      <td>{{ $vendor->vendor_name }}</td>
                    </tr>
                    <tr>
                      <th>Code</th>
                      <td>{{ $vendor->vendor_code }}</td>
                    </tr>
                    <tr>
                      <th>Contact Person Name</th>
                      <td>{{ $vendor->vendor_contactperson }}</td>
                    </tr>
                    <tr>
                      <th>Email</th>
                      <td>{{ $vendor->vendor_email }}</td>
                    </tr>
                    <tr>
                      <th>Phone No.</th>
                      <td>{{ $vendor->vendor_phone }}</td>
                    </tr>
                    <tr>
                      <th>Street</th>
                      <td>{{ $vendor->vendor_street }}</td>
                    </tr>
                    <tr>
                      <th>City</th>
                      <td>{{ $vendor->cityname }}</td>
                    </tr>
                    <tr>
                      <th>State</th>
                      <td>{{ $vendor->statename }}</td>
                    </tr>
                    <tr>
                      <th>Country</th>
                      <td>{{ $vendor->countryname }}</td>
                    </tr>
                    <tr>
                      <th>Zipcode</th>
                      <td>{{ $vendor->vendor_zipcode }}</td>
                    </tr>
                    <tr>
                      <th>Company Name</th>
                      <td>{{ $vendor->companyname }}</td>
                    </tr>
                    <tr>
                      <th>Status</th>
                        <td>@if($vendor->vendor_status == 1)
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
