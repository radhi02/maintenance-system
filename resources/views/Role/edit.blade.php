@extends('layouts.app')
@section('content')

<div class="page-body clearfix">
                <!-- Basic Validation -->
               
                
                @if ($errors->any())
             
                <div class="alert alert-danger" id="errors_all_page">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
                <div class="panel panel-default">
                    <div class="panel-heading">Role Update</div>
                    <div class="panel-body">
                        <form id="RoleForm" method="post" action="{{route('role.update',$edit_role->id)}}">
                            @csrf
                            {{method_field('PUT')}}
                            <div class="row">
                                <div class="col-md-6">
                                <div class="form-group">
                                    <label>Role Name</label>
                                    <input type="text"  class="form-control" name="role_name" value="{{$edit_role->name}}" maxlength="10" minlength="3"  />

                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Status</label>
                                                <select class="form-control" name="Status" >
                                                    <option value="Active" {{($edit_role->status=='Active')?'selected':'' }}>Active</option>
                                                    <option value="Inactive"  {{($edit_role->status=='Inactive')?'selected':'' }}>Inactive</option>
                                                </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Description</label>
                                        <textarea class="form-control" name="Description"  >{{$edit_role->description}}</textarea>
                                    </div>
        
                                </div>  

                            </div>
                            <button type="submit" class=" m-w-105 btn btn-sm btn-success">Update</button>
                            <a href="{{route('role.index')}}" type="submit" class=" m-w-105 btn btn-sm btn-danger">Cancel</a>
                        </form>
                    </div>
                </div>
           
            </div>

            <!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script> -->


<script>

    
    $('#RoleForm').validate({
        rules: {
            role_name: {
                required: true
            },
            Description: {
                required: true
            },
        },
        messages: {
            role_name: {
                required: "Please enter a Role name "
            },
            Description: {
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