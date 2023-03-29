@extends('layouts.app')

@section('content')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Vendor Master</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
              <li class="breadcrumb-item active"><a href="{{ route('vendors.index') }}">Vendor Master</a></li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
        @if ($errors->any())
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <i class="icon fas fa-ban"></i><strong>Whoops!</strong> There were some problems with your input.
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
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

            <form action="{{ isset($vendor) ? route('vendors.update', $vendor->id) : route('vendors.store') }}" method="POST" id="frmvendor" autocomplete="off">
            @csrf
            {{ isset($vendor) ? method_field('PUT') : '' }}

             <!-- Add Tender Form -->
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">{{ isset($vendor) ? 'Edit' : 'Add' }} Vendor</h3>
              </div>
              
              <!-- form start -->
                <div class="card-body">
                  <div class="row">

                    <div class="form-group col-sm-6 col-lg-4 col-xl-3">
                      <label>Select Company <span class="required text-danger">*</span></label>
                      <select class="form-control" name="company_id" id="company_id">
                        <option value="" disabled>-- Select Company --</option>
                        @foreach ($companies as $data)
                        <option value="{{$data->id}}" {{ old('company_id', (isset($vendor)&& $vendor->company_id == $data->id) ? 'selected' : ''   )}}>
                            {{$data->name}}
                        </option>
                        @endforeach
                      </select>
                    </div>

                    <div class="form-group col-sm-6 col-lg-4 col-xl-3">
                      <label for="vendor_name">Vendor Name <span class="required text-danger">*</span></label>
                      <input type="text" class="form-control" name="vendor_name" id="vendor_name" placeholder="Name" value="{{ old('vendor_name', isset($vendor) ? $vendor->vendor_name : '' )  }}" >
                    </div>

                    <div class="form-group col-sm-6 col-lg-4 col-xl-3">
                      <label for="vendor_name">Vendor Email <span class="required text-danger">*</span></label>
                      <input type="email" class="form-control" name="vendor_email" id="vendor_email" placeholder="Email" value="{{ old('vendor_email', isset($vendor) ? $vendor->vendor_email : '' )  }}" >
                    </div>
                
                    <div class="form-group col-sm-6 col-lg-4 col-xl-3">
                      <label for="vendor_contactperson">Contact Person Name <span class="required text-danger">*</span></label>
                      <input type="text" class="form-control" name="vendor_contactperson" id="vendor_contactperson" placeholder="Contact Person Name" value="{{ old('vendor_contactperson', isset($vendor) ? $vendor->vendor_contactperson : '' )  }}" >
                    </div>

                    <div class="form-group col-sm-6 col-lg-4 col-xl-3">
                      <label for="vendor_phone">Phone No. <span class="required text-danger">*</span></label>
                      <input type="tel" class="form-control" name="vendor_phone" id="vendor_phone" placeholder="Phone No" value="{{ old('vendor_phone', isset($vendor) ? $vendor->vendor_phone : '' )  }}" >
                    </div>

                    <div class="form-group col-sm-6 col-lg-4 col-xl-3">
                      <label for="vendor_street">Street <span class="required text-danger">*</span></label>
                      <input type="text" class="form-control" name="vendor_street" id="vendor_street" placeholder="Street" value="{{ old('vendor_street', isset($vendor) ? $vendor->vendor_contactperson : '' )  }}" >
                    </div>

                    <div class="form-group col-sm-6 col-lg-4 col-xl-3">
                      <label for="vendor_zipcode">Zipcode <span class="required text-danger">*</span></label>
                      <input type="number" class="form-control" name="vendor_zipcode" id="vendor_zipcode" placeholder="Zipcode" value="{{ old('vendor_zipcode', isset($vendor) ? $vendor->vendor_zipcode : '' )  }}" >
                    </div>

                    <div class="form-group col-sm-6 col-lg-4 col-xl-3">
                      <label>Status <span class="required text-danger">*</span></label>
                      <select class="form-control" name="vendor_status">
                        <option {{ old('company_id', (isset($vendor)&& $vendor->vendor_status == 1) ? 'selected' : ''   )}} value="1">Active</option>
                        <option {{ old('company_id', (isset($vendor)&& $vendor->vendor_status == 0) ? 'selected' : ''   )}} value="0">Inactive</option>
                      </select>
                    </div>

                    <div class="form-group col-sm-6 col-lg-4 col-xl-3">
                      <label>Country <span class="required text-danger">*</span></label>
                      <select  id="country-dd" class="form-control" name="country_id">
                        <option value="">Select Country</option>
                        @foreach ($fetchCountry as $data)
                        <option value="{{$data->id}}" {{ old('vendor_country', (isset($vendor)&& $vendor->vendor_country == $data->id) ? 'selected' : ''   )}}>
                          {{$data->name}}
                        </option>
                        @endforeach
                    </select>
                  </div>

                  <div class="form-group col-sm-6 col-lg-4 col-xl-3">
                    <label>State <span class="required text-danger">*</span></label>
                    <select id="state-dd" class="form-control" name="state_id">
                      @if(isset($state))
                        @foreach($state as $data)
                          <option value="{{$data->id}}"@if($vendor->vendor_state ==  $data->id) selected @endif>{{$data->name}}</option>
                        @endforeach
                      @endif
                    </select>
                  </div>

                  <div class="form-group col-sm-6 col-lg-4 col-xl-3">
                      <label>City <span class="required text-danger">*</span></label>
                      <select id="city-dd" class="form-control" name="city_id">
                        @if(isset($city))
                          @foreach($city as $data)
                            <option value="{{$data->id}}"@if($vendor->vendor_city ==  $data->id) selected @endif>{{$data->name}}</option>
                          @endforeach
                        @endif
                      </select>
                  </div>
                  
                  @if(isset($vendor))
                    <div class="form-group col-sm-6 col-lg-4 col-xl-3">
                      <label for="vendor_code">Vendor Code</label>
                      <input type="text" disabled class="form-control" name="vendor_code" id="vendor_code" placeholder="Vendor Code" value="{{ old('vendor_code', isset($vendor) ? $vendor->vendor_code : '' )  }}" >
                    </div>
                  @endif

                  </div>
                  
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn my_btn">Save</button>
                </div>
              

            </div>
            <!-- /.card -->

            </form>
          </section>

        </div>

      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  
  <script>
    $(document).ready(function() {
      $('#country-dd').on('change', function () {
          var idCountry = this.value;
          $("#state-dd").html('');
          $.ajax({
              url: "{{url('api/fetch-states')}}",
              type: "POST",
              data: {
                  country_id: idCountry,
                  _token: '{{csrf_token()}}'
              },
              dataType: 'json',
              success: function (result) {
                  $('#state-dd').html('<option disabled>Select State</option>');
                  $.each(result.states, function (key, value) {
                      $("#state-dd").append('<option value="' + value
                          .id + '" {{ old('vendor_state', (isset($vendor)&& $vendor->vendor_state == '+value
                          .id +') ? 'selected' : ''   )}}  >' + value.name + '</option>');
                  });
                  $('#city-dd').html('<option disabled>Select City</option>');
              }
          });
       
    });
    $('#state-dd').on('change', function () {
          var idState = this.value;
          $("#city-dd").html('');
          $.ajax({
              url: "{{url('api/fetch-cities')}}",
              type: "POST",
              data: {
                  state_id: idState,
                  _token: '{{csrf_token()}}'
              },
              dataType: 'json',
              success: function (res) {
                  $('#city-dd').html('<option disabled>Select City</option>');
                  $.each(res.cities, function (key, value) {
                      $("#city-dd").append('<option value="' + value
                          .id + '">' + value.name + '</option>');
                  });
              }
          });
    });

      $("#frmvendor").validate({
          rules: {
              vendor_name: {
                  required: true
              },
              vendor_email: {
                  required: true,
                  email: true
              },
              vendor_contactperson: {
                  required: true
              },
              vendor_phone: {
                  required: true
              },
              vendor_street: {
                  required: true
              },
              city_id: {
                  required: true,
              },
              state_id: {
                  required: true,
              },
              country_id: {
                  required: true,
              },
              vendor_zipcode: {
                  required: true,
                  digits: true
              },
              company_id: {
                  required: true
              },
              vendor_status: {
                  required: true                
              },
          },
          messages: {
            vendor_name: "Vendor Name is required",
            vendor_contactperson: "Contact Person Name is required",
            vendor_email: "Email is required",
            vendor_phone: "Phone no. is required",
            vendor_street: "Street is required",
            city_id: "City is required",
            state_id: "State is required",
            country_id: "Country is required",
            vendor_zipcode: "Zipcode is required",
            company_id: "Please select company",
            vendor_status: "Please select the status",
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
  </script>

@endsection
