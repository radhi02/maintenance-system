@extends('layouts.app')
  
@section('content')

<div class="content-wrapper" style="min-height: 1302.4px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Show Equipment</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
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
                      <th>Equipment Name</th>
                      <td>{{ $equipment->equipment_name }}</td>
                    </tr>
                    <tr>
                      <th>Equipment Code</th>
                      <td>{{ $equipment->equipment_code }}</td>
                    </tr>
                    <tr>
                      <th>Equipment Make</th>
                      <td>{{ $equipment->equipment_make }}</td>
                    </tr>
                    <tr>
                      <th>Equipment Capacity</th>
                      <td>{{ $equipment->equipment_capacity }}</td>
                    </tr>
                    <tr>
                      <th>Location</th>
                      <td>{{ $equipment->location }}</td>
                    </tr>
                    <tr>
                      <th>Purchase Date</th>
                      <td>{{ $equipment->purchase_date }}</td>
                    </tr>
                    <tr>
                      <th>Purchase Cost</th>
                      <td>{{ $equipment->purchase_cost }}</td>
                    </tr>
                    <tr>
                      <th>Equipment Status</th>
                      <td>{{ $equipment->equipment_status }}</td>
                    </tr>
                       <tr>
                       <th>Warranty/AMC Upto(Date)</th>
                      <td>{{ $equipment->warranty_date }}</td>
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
