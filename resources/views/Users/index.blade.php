@extends('layouts.app')
 
@section('content')

    <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">User Master</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->

        @if ($message = Session::get('success'))
          <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-check"></i> Success!</h4>
            {{ $message }}
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
            <form>
             <!-- Add Tender Form -->
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">User List</h3>

                <div class="card-tools">
                  <a class="btn btn-success" href="{{route('user.create')}}"> Create New User</a>
                </div>
              </div>
              
              <!-- form start -->
              
                <div class="card-body table-responsive">
                  <table id="tbluser" class="table table-sm table-bordered table-hover">
                    <thead>
                      <tr>
                        {{-- <th style="width: 1%"><input type='checkbox' id='checkAll'></th> --}}
                        <th>Sr No.</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Department</th>
                        <th>Status</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $k=>$values)
                        <tr id="id_rmv{{$values->id}}">
                            {{-- <td><input type="checkbox" class="checkbox"  data-id="{{$values->id}}" name="checks[]" ></td> --}}
                            <td>{{$loop->iteration}}</td>
                            <td>{{$values->first_name}}  {{$values->last_name}}</td>
                            <td>{{$values->email}}</td>
                            <td>{{$values->rolename}}</td>
                            <td>{{$values->deptname}}</td>
                            <td  id="status{{$values->id}}"><p  class="badge {{($values->user_status == 'Active')? 'bg-success' :'bg-danger'}}  btn-sm">{{$values->user_status}}</p></td>
                            <td>
                              <form action="{{ route('user.destroy',$values->id) }}" method="POST">
                                <div class="action_btn">  
                                  <a class="mr-2" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="View" href="{{route('user.show',$values->id)}}"><i class="fas fa-eye fa-lg" aria-hidden="true"></i>
                                  </a>                 
                                  <a href="{{route('user.edit',$values->id)}}" class="text-success mr-2" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Edit">
                                    <i class="fas fa-edit fa-lg"></i>
                                  </a>                   
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-danger" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Delete"><i class="fas fa-trash fa-lg"></i></button>
                                </div>
                              </form>
                            </td>    
                        </tr>
                        @endforeach
                      
                    </tbody>
                    
                  </table>
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



<script>
$("#Updaste").removeClass('alert-success');
$.ajaxSetup({
            headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
 });
$(".Delete").click(function(){
    id= $(this).data('id');
    roleName= $(this).attr('data-roleName');
    var confirms  =confirm("Are You Sure  you Want to delete this "+roleName);
    if(confirms === true)
    {
        $.ajax({
            type: "POST",
            url: "{{url('user_destroy')}}",
            data: {
                // "_token": "{{ csrf_token() }}",
                id: id
            },
            dataType: 'json',
            success: function(res) 
            {
                $("#update").addClass('alert-success');
                $("#update").html(res.success);
                $("#id_rmv"+id).remove();
            }
        });
    }
});


/// Status ///

function status(flag)
{
    var idsArr = [];
    $(".checkbox:checked").each(function() {
        
        idsArr.push($(this).attr('data-id'));
    });
    if (idsArr.length <= 0) {
        alert("Please select atleast one record to status change.");
    }
    else 
    {
        $.ajax({
            type: "POST",
            url: "{{ route('User.status') }}",
            data: {
                id: idsArr,
                value: flag
            },
            dataType: 'json',
            success: function(res) {
            
                $("#update").addClass("alert-success")
                if(res.msg == 1)
                {
                    $("#update").html("User Status Actived  Successfully ")
                    $.each(idsArr,function(index,value){
                        if(flag ==='Active')
                        {
                            var Classes="badge bg-success";
                        }
                        else
                        {
                            var Classes="badge bg-danger";
                        }
                        $("#status"+value).html('<p class="'+Classes+ '" status">'+flag+'</p>')
                    });
                }
                else
                {
                    $("#update").html("Status In-actived  Successfully ")
                }
            }
        });
    }
}
</script>
@endsection