@extends('layouts.app')
  
@section('content')
@php $MaintenancePlan = $scheduledata[0]; @endphp
<div class="content-wrapper" style="min-height: 1302.4px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Show Plan</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
              <li class="breadcrumb-item active"><a href="{{ route('plan.index') }}">Plan Master</a></li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <?php 
    $frequency = [12=>'Monthly',4=>'Quarterly',2=>'Half Yearly',1=>'Yearly'];
  ?>
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <!-- /.card-header -->
              <div class="card-body p-0">
                <table class="table table-bordered">
                  <tbody>
                    <tr>
                        <td><b>Equipment Name</b></td>
                        <td>{{$MaintenancePlan->equipment_name}}</td>
                    </tr>
                    <tr>
                        <td><b>Start Date</b></td>
                        <td>{{ShowNewDateFormat($MaintenancePlan->start_date)}}</td>
                    </tr>
                    <tr>
                        <td><b>Maintenance User</b></td>
                        <td>{{$MaintenancePlan->first_name.' '.$MaintenancePlan->last_name}}</td>
                    </tr>
                    <tr>
                        <td><b>Frequancy Type </b></td>
                        <td>{{$frequency[$MaintenancePlan->frequancy]}}</td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div><!-- /.container-fluid -->
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <!-- /.card-header -->
              <div class="card-body p-0">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th>Date : </th>
                      <th>Task : </th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach($scheduledata as $k => $v)
                        <tr> 
                        <td>{{ ShowNewDateFormat($v->plan_date) }}</td>
                        <td>
                            @if(!empty($v->major))  <b> Major : </b>{{ $v->major }} <br/> @endif
                            @if(!empty($v->minor))  <b> Minor : </b>{{ $v->minor }} @endif
                        </td> 
                    </tr>
                    @endforeach
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
