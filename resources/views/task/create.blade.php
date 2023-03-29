@extends('layouts.app')

@section('content')

<script>
  var i=1;
</script>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Task Master</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active"><a href="{{ route('task.index') }}">Task Master</a></li>
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

          <form action="{{ route('task.update', $task->id) }}" method="POST"
            id="frmequipment" autocomplete="off">
            @csrf
            {{ method_field('PUT') }}

            <!-- Add Tender Form -->
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">{{ $task->equipment_name }} Task</h3>
              </div>
              <input type="hidden" name="id" value="{{$task->id}}">
              <!-- form start -->
              <div class="card-body">
                <div class="row">
                    <div class="form-group col-sm-6 col-lg-4 col-xl-12">
                      <label> Activity Check List </label>                  
                      <table class="table table-striped table-valign-middle">
                        <thead>
                          <tr>
                            <th>Activity</th>
                            <th>Major</th>
                            <th>Minor</th>
                            <th><button type="button" class="btn btn-success addother">Add </button> </th>
                          </tr>
                        </thead>
                        <tbody class="field_wrapper">
                        @php $i = 1001; $j = 2001  @endphp
                          @if (isset($task->major))
                          @php $majorlist = explode(',',$task->major); @endphp
                            @foreach($majorlist as $v)
                              <tr class="remove_{{$i}}"> 
                                <td> 
                                  <div class="col-sm-6 col-lg-4 col-xl-6"> 
                                    <input type="text" class="form-control" id="otherdetails_{{$i}}" name="otherdetails[{{$i}}]" placeholder="Add Activity " required="" value="{{$v}}">
                                  </div>
                                </td>
                                <td>
                                  <div class="icheck-primary d-inline"> 
                                    <input type="radio" id="radioPrimaryId1[{{$i}}]" name="radioPrimary[{{$i}}]" value="Major" required="" checked>
                                    <label for="radioPrimaryId1[{{$i}}]"></label>
                                  </div> 
                                </td> 
                                <td> 
                                  <div class="icheck-primary d-inline">
                                    <input type="radio" id="radioPrimaryId2[{{$i}}]" name="radioPrimary[{{$i}}]" value="Minor">
                                    <label for="radioPrimaryId2[{{$i}}]"></label>
                                  </div>
                                </td> 
                                <td>
                                  <div class="form-group col-sm-1">
                                    <a href="javascript:void(0);" data-id="{{$i}}" class="btn btn-danger removeme">
                                      <i class="fas fa-trash-alt"></i>
                                    </a>
                                  </div>
                                </td>
                            </tr>
                            @php $i++ @endphp
                          @endforeach
                        @endif
                        @if (isset($task->minor))
                          @php $minorlist = explode(',',$task->minor); @endphp
                            @foreach($minorlist as $v)
                              <tr class="remove_{{$j}}"> 
                                <td> 
                                  <div class="col-sm-6 col-lg-4 col-xl-6"> 
                                    <input type="text" class="form-control" id="otherdetails_{{$j}}" name="otherdetails[{{$j}}]" placeholder="Add Activity " required="" value="{{$v}}">
                                  </div>
                                </td>
                                <td>
                                  <div class="icheck-primary d-inline"> 
                                    <input type="radio" id="radioPrimaryId1[{{$j}}]" name="radioPrimary[{{$j}}]" value="Major" required="">
                                    <label for="radioPrimaryId1[{{$j}}]"></label>
                                  </div> 
                                </td> 
                                <td> 
                                  <div class="icheck-primary d-inline">
                                    <input type="radio" id="radioPrimaryId2[{{$j}}]" name="radioPrimary[{{$j}}]" value="Minor" checked>
                                    <label for="radioPrimaryId2[{{$j}}]"></label>
                                  </div>
                                </td> 
                                <td>
                                  <div class="form-group col-sm-1">
                                    <a href="javascript:void(0);" data-id="{{$j}}" class="btn btn-danger removeme">
                                      <i class="fas fa-trash-alt"></i>
                                    </a>
                                  </div>
                                </td>
                            </tr>
                            @php $j++ @endphp
                          @endforeach
                        @endif

<!-- 
                          <tr class="remove_1">
                            <td>
                              <div class="col-sm-6 col-lg-4 col-xl-6">
                                <div class="form-group">
                                  <input type="text" class="form-control" id="1" name="otherdetails[1]" placeholder="Add Activity " required="">
                                </div>
                              </div>
                            </td>
                            <td>
                              <div class="form-group">
                                <div class="icheck-primary d-inline">
                                  <input type="radio" id="radioPrimaryId1[1]" name="radioPrimary[1]" value="Major" required="">
                                  <label for="radioPrimaryId1[1]"></label>
                                </div>
                              </div>
                            </td>
                            <td>
                              <div class="form-group">
                                <div class="icheck-primary d-inline">
                                  <input type="radio" id="radioPrimaryId2[1]" name="radioPrimary[1]" value="Minor">
                                  <label for="radioPrimaryId2[1]"></label>
                                </div>
                              </div>
                            </td>
                            <td>
                              <div class="form-group col-sm-1  remove_1">
                                <a href="javascript:void(0);" data-id="1" class="btn btn-danger removeme remove_me1">
                                  <i class="fas fa-trash-alt"></i>
                                </a>
                              </div>
                            </td>
                          </tr> -->
                        </tbody>
                      </table>
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
        $("#frmequipment").validate({
            rules: {
                otherdetails: {
                    required: true,
                },
                equipment_id: {
                    required: true,
                },
                // problem_type: {
                //     required: true                
                // },
            },
            messages: {
              equipment_id: "Please select Equipment",
              otherdetails: "Activity is required",
              // problem_type: "Problem type is required",
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
    var i = 1;
    $(".addother").click(function(){
        var btn='';
        btn = '<tr class="remove_'+i+'"> <td> <div class="col-sm-6 col-lg-4 col-xl-6"> <div class="form-group"> <input type="text" class="form-control" name="otherdetails['+i+']" id="other'+i+'" placeholder="Add Activity " required /> </div></div> </td> <td> <div class="form-group">  <div class="icheck-primary d-inline"> <input type="radio" id="radioPrimaryId1['+i+']"  name="radioPrimary['+i+']"  value="Major" required> <label for="radioPrimaryId1['+i+']"></label> </div> </div> </td> <td> <div class="form-group"> <div class="icheck-primary d-inline"> <input type="radio" id="radioPrimaryId2['+i+']"  name="radioPrimary['+i+']"  value="Minor" > <label for="radioPrimaryId2['+i+']"></label> </div></div> </td><td><div class="form-group col-sm-1"><a href="javascript:void(0);" data-id="'+i+'" class="btn btn-danger removeme"><i class="fas fa-trash-alt"></i></a></div></td></tr>';
        $(".field_wrapper").append(btn);
        i++;
    });   
    
    $('body').on('click','.removeme',function(){
      var remove_id = $(this).attr('data-id');
      $(".remove_"+remove_id).remove();

      // var remove_id = $(this).attr('data-id');
        // var ids = $(".get_id").val();
        // // var data =$('#otherdetails'+remove_id).val();

        // var data = $(this).attr("data-other");
        // if(data != " " && ( ($("#otherdetails_"+remove_id).val()) != null) )
        // {
        //   var confirms = confirm("Are you sure you want to delete Activity " +data+" ?");
        //   if(confirms === true)
        //   {
        //     $.ajax({
        //       url:"{{route('task.DestroyOther')}}",
        //       type: 'post',
        //       dataType: "json",
        //       data: { "_token": "{{ csrf_token() }}",'data':data,"id":ids},
        //       success: function(data)
        //       {
        //           if(data.msg == 1)
        //           {
        //               $(".remove_"+remove_id).remove();
        //           }
        //       }
        //     });
        //   }
        // }
        // else
        // {
        //     $(".remove_"+remove_id).remove();
        // }
        // alert(data);
    });
</script>


@endsection