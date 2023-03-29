@extends('layouts.app')

@section('content')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Permission List</h1>
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

          <section class="col-lg-12">

            <form method="post" action="{{route('Module.GivePermission')}}">
            <input type="hidden" name="id" value="{{$userid}}">

                @csrf
        
            <!-- Add Tender Form -->
            <div class="card">
                <div class="card-header">
                {{-- <h3 class="card-title">Add User</h3>
                <div class="card-tools">
                    <a class="btn btn-success" href="{{route('user.create')}}"> Create New User</a>
                </div> --}}
                </div>
            

                <div class="card-body table-responsive">
                    <table id="tblpermission" class="table table-sm table-bordered table-hover">
                    <thead>                 <!-- thead required -->
                        <tr>                <!-- tr required -->
                            <th>Permission List</th>    <!-- td instead of th will also work -->
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($perant as $per)
                        <tr>
                            @php     $cheked_id=   CheckPermissionExitOrNot($per['id'],$userid);     @endphp
                            <td>
                                <div class="icheck-primary d-inline">
                                    <input type="checkbox"  class="checkval_parent  customeparent{{$per['id']}}" @if(isset($cheked_id[$per['id']])) checked  @endif    data-parent="{{$per['id']}}" id="id-{{$per['Name']}}">
                                    <label for="id-{{$per['Name']}}">
                                        {{$per['Name']}}
                                    </label>
                                </div>

                                    <div style="display: flex;
                                                flex-wrap: wrap;
                                                margin-left: 50px;
                                                margin-top: 15px;">
                                            @foreach($permisson as $k => $child)
                                             
    
                                                    @if($child->moduleName  ==  $per['Name'])
    
                                                        @php $module = explode("-",$child->name);
                                                           $cheked_id= CheckPermissionExitOrNot($child->id,$userid);     // helper function 
                                                        @endphp
                                                        <div class="icheck-primary d-inline">
                                                             <input type="checkbox" name="child[]"  class="child{{$per['id']}}" id="{{$k}}" value="{{$child->name}}"  @if(isset($cheked_id[$child->id])) checked  @endif >
                                                            <label for="{{$k}}">
                                                              {{ucfirst($module[1])}}
                                                            </label>
                                                        </div>
                                                    @endif
                                         
    
                                        @endforeach 
                                    </div>
                            </td>                               
                        </tr>
                        @endforeach
                        
                    </tbody>
                    
                    </table>

                    <div class="col-md-12 form_Submit_cancel_btn" > 
                        <button type="submit"   class=" m-w-105 btn btn-sm btn-success">@if(!empty($edit_users->id)) Update @else Save @endif</button>
                        <a href="{{route('user.index')}}" type="submit" class=" m-w-105 btn btn-sm btn-danger">Cancel</a>
                    </div>   
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
  <!-- /.content-wrapper -->
  <script>
    $(".checkval_parent").click(function(){
    
        var parent =$(this).attr('data-parent');
        var checkparent =  $(".customeparent"+parent).is(':checked');
        
        if( checkparent== true)
        {   
            var child = $(".child"+parent).prop("checked", true);
        }
        else if( checkparent== false )
        {
            var child = $(".child"+parent).prop("checked", false);
        }
    
    });
    </script>
    
@endsection
