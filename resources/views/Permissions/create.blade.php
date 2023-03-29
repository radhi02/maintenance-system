@extends('layouts.app')

@section('content')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Module  Create</h1>
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

            <form method="post" action="{{route('Module.store')}}" id="permission">
            @csrf

             <!-- Add Tender Form -->
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">{{ isset($edit_role) ? 'Edit' : 'Add' }} Role</h3>
              </div>
              
              <!-- form start -->
              
                <div class="card-body">
                  <div class="row">
                                                    
                    <!-- <div class="form-group col-sm-6 col-lg-4 col-xl-3">
                        <label>Select Module Type</label>
                        <select class="form-control" name="ModuleType" id="ModuleType" >
                            <option value="" disabled>--Select Module-- </option>
                            <option value="Master" Selected>Master </option>
                            <option value="Sub-Master">Sub-Master</option>
                        </select>
                    </div> -->

                    <div class="form-group col-sm-6 col-lg-4 col-xl-3">
                        <label> Master </label>
                        <input type="text"  class="form-control master " name="master" maxlength="30" minlength="3"  />
                    </div>
                    <!-- <div class="form-group col-sm-6 col-lg-4 col-xl-3">
                        <label>Sub Master </label>
                        <input type="text"  class="form-control sub_master" name="sub_master" maxlength="30" minlength="3"  />
                    </div> -->
                    <!-- <div class="form-group col-sm-6 col-lg-4 col-xl-3">
                        <label>Route Type</label>
                        <select class="form-control" name="RouteType" id="RouteTypeId" >
                            <option value="" disabled>--Select Route Type -- </option>
                            <option value="resource" Selected>Resource</option>
                            <option value="custome">Custom</option>
                        </select>
                    </div> -->
                    <div class="form-group col-sm-6 col-lg-4 col-xl-3">
                        <label>Module  Name</label>
                        <input type="text"  class="form-control" name="ModuleName" maxlength="30" minlength="3"  />
                    </div>
                    <div class="form-group col-sm-6 col-lg-4 col-xl-3">
                        <label>Status</label>
                        <select class="form-control" name="Status" id="StatusID" >
                            <option value="Active" Selected>Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
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
    // $(".sub_master").hide(); 
    // $(".master").hide(); 
    
    //   $('#ModuleType').on('change',function(){
    //      var  type =  $('#ModuleType').val();
    //       if(type == "Sub-Master") 
    //       {
    //            $(".sub_master").show();
    //            $(".master").hide(); 
    //            $(".master").val('');  
    //       }
    //       else{ 
    //           $(".sub_master").val('');  
    //             $(".sub_master").hide();
    //            $(".master").show(); 
    //       }
    //       });
  
  </script>
@endsection
