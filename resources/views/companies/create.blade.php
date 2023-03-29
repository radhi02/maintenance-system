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
              <li class="breadcrumb-item active"><a href="{{ route('companies.index') }}">Company Master</a></li>
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

            <form action="{{ isset($company) ? route('companies.update', $company->id) : route('companies.store') }}" method="POST" id="frmcompany" autocomplete="off">
              @csrf
              {{ isset($company) ? method_field('PUT') : '' }}
  
               <!-- Add Tender Form -->
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">{{ isset($company) ? 'Edit' : 'Add' }} Company</h3>
                </div>
              
              <!-- form start -->
              
                <div class="card-body">
                  <div class="row">
                    <div class="form-group col-sm-6 col-lg-4 col-xl-3">
                      <label for="name">Name <span class="required text-danger">*</span></label>
                      <input type="text" class="form-control" name="name" value="{{ old('name', isset($company) ? $company->name : '' )  }}" id="name" placeholder="Name">
                    </div>

                    <div class="form-group col-sm-6 col-lg-4 col-xl-3">
                      <label for="email">Email <span class="required text-danger">*</span></label>
                      <input type="text" class="form-control" name="email" value="{{ old('email', isset($company) ? $company->email : '' )  }}" id="email" placeholder="Email">
                    </div>

                    <div class="form-group col-sm-12 col-lg-8 col-xl-6">
                      <label for="name">Street <span class="required text-danger">*</span></label>
                      <input type="text" class="form-control" name="street" value="{{ old('street', isset($company) ? $company->street : '' )  }}" id="street" placeholder="Street">
                    </div>

                    <div class="form-group col-sm-6 col-lg-4 col-xl-3">
                      <label>Country <span class="required text-danger">*</span></label>
                      <select  id="country-dd" class="form-control" name="country">
                        <option value="">Select Country</option>
                        @foreach ($fetchCountry as $data)
                        <option value="{{$data->id}}" {{ old('country', (isset($company)&& $company->country == $data->id) ? 'selected' : ''   )}}>
                          {{$data->name}}
                        </option>
                        @endforeach
                    </select>
                  </div>

                  <div class="form-group col-sm-6 col-lg-4 col-xl-3">
                    <label>State <span class="required text-danger">*</span></label>
                    <select id="state-dd" class="form-control" name="state">
                      @if(isset($state))
                        @foreach($state as $data)
                          <option value="{{$data->id}}" @if($company->state ==  $data->id) selected @endif>{{$data->name}}</option>
                        @endforeach
                      @endif
                    </select>
                  </div>

                  <div class="form-group col-sm-6 col-lg-4 col-xl-3">
                      <label>City <span class="required text-danger">*</span></label>
                      <select id="city-dd" class="form-control" name="city">
                        @if(isset($city))
                          @foreach($city as $data)
                            <option value="{{$data->id}}" @if($company->city ==  $data->id) selected @endif>{{$data->name}}</option>
                          @endforeach
                        @endif
                      </select>
                  </div>

                    <div class="form-group col-sm-6 col-lg-4 col-xl-3">
                      <label for="zipcode">Zipcode <span class="required text-danger">*</span></label>
                      <input type="text" class="form-control" name="zipcode" id="zipcode" value="{{ old('zipcode', isset($company) ? $company->zipcode : '' )  }}" placeholder="Zipcode">
                    </div>

                    <div class="form-group col-sm-6 col-lg-4 col-xl-3">
                      <label>Status <span class="required text-danger">*</span></label>
                      <select class="form-control" name="status">
                        <option {{ old('status', isset($company)&&($company->status==1) ? 'selected' : '' ) }} value="1">Active</option>
                        <option {{ old('status', isset($company)&&($company->status==0) ? 'selected' : '' ) }} value="0">Inactive</option>
                      </select>
                    </div>

                    @if(isset($company))
                    <div class="form-group col-sm-6 col-lg-4 col-xl-3">
                      <label for="code">Company Code <span class="required text-danger">*</span></label>
                      <input type="text" disabled class="form-control" name="code" id="code" placeholder="Company Code" value="{{ old('code', isset($company) ? $company->code : '' )  }}" >
                    </div>
                  @endif

                  </div>
                  
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
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
      // get states 
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

    // get cities 
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

        $("#frmcompany").validate({
            rules: {
                name: {
                    required: true
                },
                email: {
                    required: true,
                    email: true
                },
                street: {
                    required: true
                },
                city: {
                    required: true
                },
                state: {
                    required: true
                },
                country: {
                    required: true
                },
                zipcode: {
                    required: true,
                    digits: true
                },
                status: {
                    required: true                
                },
            },
            messages: {
                name :"Name is required",
                email: "Email is required",
                street: "Street is required",
                city: "City is required",
                state: "State is required",
                country: "Country is required",
                zipcode: "Zipcode is required",
                status: "Please select the status",
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
