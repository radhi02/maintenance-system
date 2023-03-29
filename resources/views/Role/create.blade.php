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

            <form action="{{ isset($edit_role) ? route('role.update', $edit_role->id) : route('role.store') }}" method="POST" id="RoleForm" autocomplete="off">
            @csrf
            {{ isset($edit_role) ? method_field('PUT') : '' }}

             <!-- Add Tender Form -->
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">{{ isset($edit_role) ? 'Edit' : 'Add' }} Role</h3>
              </div>
              
              <!-- form start -->
              
                <div class="card-body">
                  <div class="row">
                    <div class="form-group col-sm-6 col-lg-4 col-xl-3">
                      <label for="name">Role Name <span class="required text-danger">*</span></label>
                      <input type="text" class="form-control" name="name" id="name" placeholder="Role Name" value="{{ old('name', isset($edit_role) ? $edit_role->name : '' )  }}" >
                    </div>

                    <div class="form-group col-sm-6 col-lg-4 col-xl-3">
                        <label>Status <span class="required text-danger">*</span></label>
                        <select class="form-control" name="status">
                          <option {{ old('status', isset($edit_role)&&($edit_role->status==1) ? 'selected' : '' ) }} value="Active">Active</option>
                          <option {{ old('status', isset($edit_role)&&($edit_role->status==0) ? 'selected' : '' ) }} value="In-Active">Inactive</option>
                        </select>
                    </div>

                    <div class="form-group col-sm-6 col-lg-4 col-xl-3">
                      <label for="description">Description <span class="required text-danger">*</span></label>
                      <textarea class="form-control" name="description">{{ old('description', isset($edit_role) ? $edit_role->description : '' )  }}</textarea>
                    </div>

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

    $('#RoleForm').validate({
        rules: {
            name: {
                required: true
            },
            description: {
                required: true
            },
        },
        messages: {
            name: {
                required: "Please enter a Role name "
            },
            description: {
                required: "Please enter Some About this role"
            },
   
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

</script>
@endsection
