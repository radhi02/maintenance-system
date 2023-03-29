@extends('layouts.app')

@section('content')

<script>
var i = 1;
</script>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Reactive Maintenance Plan Activity</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active"><a
                                href="{{ route('reactive_maintenance_plan.index') }}">Reactive Maintenance Plan
                                Activity</a></li>
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

                    <form action="{{ route('reactive_maintenance_plan.update', $reactive_maintenances_id) }}"
                        method="POST" id="frmequipment" autocomplete="off">
                        @csrf
                        {{ method_field('PUT') }}

                        <!-- Add Tender Form -->
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">{{ isset($ReactiveMaintenancePlan) ? 'Edit' : '' }} Reactive
                                    Maintenance Plan Activity</h3>
                            </div>
                            <!-- form start -->
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-sm-6 col-lg-4 col-xl-6" >
                                        <label for="code">Equipment</label>
                                        <input type="text" class="form-control" 
                                            value="{{ old('Ename', isset($reactive_maintenance) ? $reactive_maintenance->Ename : '' )  }}" readonly>
                                    </div>

                                    <div class="form-group col-sm-6 col-lg-4 col-xl-6" >
                                        <label for="code">Problem</label>
                                        <input type="text" class="form-control" 
                                            value="{{ old('Problem', isset($reactive_maintenance) ? $reactive_maintenance->Problem : '' )  }}" readonly>
                                    </div>
                                    <div class="form-group col-sm-6 col-lg-4 col-xl-6" >
                                        <label for="code">Criticality</label>
                                        <input type="text" class="form-control" 
                                            value="{{ old('criticality', isset($reactive_maintenance) ? $reactive_maintenance->criticality : '' )  }}" readonly>
                                    </div>

                                    @if($reactive_maintenance->remark_by_enginner != NULL && !empty($reactive_maintenance->remark_by_enginner))
                                    <div class="form-group col-sm-12">
                                        <label> Previous Action Taken</label>
                                        @php
                                        $remarklist = json_decode($reactive_maintenance->remark_by_enginner);
                                        @endphp
                                        <table class="table table-striped table-valign-middle">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Note</th>
                                                    <th>Date</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($remarklist as $re)
                                                <tr>
                                                    <td>{{ $loop->iteration}}</td>
                                                    <td>{{ $re->note }}</td>
                                                    <td>{{ $re->date }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        @endif
                                        @if($reactive_maintenance->remark_by_manager != NULL && !empty($reactive_maintenance->remark_by_manager))
                                        <div class="form-group col-sm-12">
                                            <label> Previous Remark By END-User :</label>
                                            @php
                                            $remarklist = json_decode($reactive_maintenance->remark_by_manager);
                                            @endphp
                                            <table class="table table-striped table-valign-middle">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Note</th>
                                                        <th>Date</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($remarklist as $re)
                                                    <tr>
                                                        <td>{{ $loop->iteration}}</td>
                                                        <td>{{ $re->note }}</td>
                                                        <td>{{ $re->date }}</td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            @endif

                                            <div class="form-group col-sm-6 col-lg-4 col-xl-12">
                                                <label> Action Taken</label>
                                                <textarea class="form-control" name="note" id="note"></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group col-sm-12 table-responsive">
                                            <label>Cost Details</label>
                                            <table class="table table-striped table-valign-middle" id="tblcost">
                                                <thead>
                                                    <tr>
                                                        <th>Detail</th>
                                                        <th>Type</th>
                                                        <th>Cost</th>
                                                        <th>Remark</th>
                                                        <th><button type="button" class="btn btn-info add_button">Add
                                                                Row</button></th>
                                                    </tr>
                                                </thead>
                                                <?php  $total = 0; ?>
                                                <tbody class="field_wrapper">
                                                    @if(!empty($plancost))
                                                    @foreach($plancost as $p) <?php $total = $total + $p->cost; ?>
                                                    <tr>
                                                        <td>
                                                            <div class="col-sm-6 col-lg-4 col-xl-12">
                                                                <p>{{$p->detail}}</p>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="col-sm-6 col-lg-4 col-xl-12">
                                                                <p>{{$p->type}}</p>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="col-sm-6 col-lg-4 col-xl-12">
                                                                <p>{{$p->cost}}</p>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="col-sm-6 col-lg-4 col-xl-12">
                                                                <p>{{$p->remark}}</p>
                                                            </div>
                                                        </td>
                                                        <!-- <td>
                                                            <div class="col-sm-6 col-lg-4 col-xl-12">
                                                                <p>{{ShowNewDateFormat($p->created_at)}}</p>
                                                            </div>
                                                        </td> -->
                                                        <td>
                                                            <div class="col-sm-6 col-lg-4 col-xl-12"> 
                                                                <button type="button" class="btn btn-danger deleteRecord" data-id="{{ $p->id }}">Remove</button> 
                                                            </div>
                                                        </td>
                                                        
                                                    </tr>
                                                    @endforeach
                                                    @endif
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th colspan="2">Total Cost: </th>
                                                        <th colspan="3"><span id="txttotal"> {{$total}} </span></th>
                                                        <input type="hidden" name="service_cost_external_vendor"
                                                            id="service_cost_external_vendor" value="{{$total}}">
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
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
$.ajaxSetup({
    headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
var finalCost = <?php echo $total ?>;

$(document).ready(function() {

    var maxField = 10; //Input fields increment limitation
    var addButton = $('.add_button'); //Add button selector
    var wrapper = $('.field_wrapper'); //Input field wrapper
    var fieldHTML =
        '<tr> <td> <div class="col-sm-6 col-lg-4 col-xl-12"> <input type="text" class="form-control" name="txtdetail[]" required> </div> </td> <td> <div class="col-sm-6 col-lg-4 col-xl-12"> <select class="form-control" name="txttype[]" required> <option value="spare">Spare</option> <option value="labour">Labour</option> </select> </div> </td> <td> <div class="col-sm-6 col-lg-4 col-xl-12"> <input type="number" min="0" oninput="this.value = !!this.value && Math.abs(this.value) >= 0 ? Math.abs(this.value) : null" class="form-control txtsparecost" name="txtsparecost[]" required> </div> </td> <td> <div class="col-sm-6 col-lg-4 col-xl-12"> <input type="text" class="form-control" name="txtspareremark[]" required> </div> </td> <td> <div class="col-sm-6 col-lg-4 col-xl-12"> <button type="button" class="btn btn-danger remove_button">Remove</button> </div> </td> </tr>'; var x = 1; //Initial field counter is 1

    //Once add button is clicked
    $(addButton).click(function() {
        //Check maximum number of input fields
        if (x < maxField) {
            x++; //Increment field counter
            $(wrapper).append(fieldHTML); //Add field html
        }
    });

    //Once remove button is clicked
    $(wrapper).on('click', '.deleteRecord', function(e) {
        e.preventDefault();
        $(this).closest('tr').remove();
        var id = $(this).data("id");    
        $.ajax(
        {
            url: "{{route('deleteplancost.all')}}",
            type: 'POST',
            data: {
                "id": id,
                "plan_id": <?php echo $reactive_maintenance->id ?>,
                "_token": '{{csrf_token()}}'
            },
            success: function(response){
                $("#txttotal").html(response.cost);
                $("#service_cost_external_vendor").val(response.cost);
                finalCost = response.cost;
            }
        });
    });

    //Once remove button is clicked
    $(wrapper).on('click', '.remove_button', function(e) {
        e.preventDefault();
        $(this).closest('tr').remove();
        x--;
        var tt = finalCost;
        sumCalculate(tt);
    });

    $("#tblcost").on('input', '.txtsparecost', function() {
        var tb = finalCost;
        sumCalculate(tb);
    });

    function sumCalculate(cost){
        $(".txtsparecost").each(function() {
            if($(this).val() != "") {
                cost = parseFloat(cost) + parseFloat($(this).val());
            }
        });
        $("#txttotal").html(cost);
        $("#service_cost_external_vendor").val(cost);
    }
});
</script>

@endsection