@extends('layouts.app')
@section('content')
<?php $countI = $countJ = $countK = 1 ?>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            @if ($message = Session::get('success'))
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-check"></i> Success!</h4>
                {{ $message }}
            </div>
            @endif
        </div><!-- /.container-fluid -->
    </div>
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}" >Home</a></li>
                        <!-- <li class="breadcrumb-item active">Dashboard v1</li> -->
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid" id="userData">
        </div>
    </section>
</div>
<script type="text/javascript">
$(document).ready(function() {
    fetchMYData();
    var minutes = 1, the_interval = minutes * 60 * 1000;
    setInterval(fetchMYData,50000);
});

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

function fetchMYData(){
    $.ajax({
        url: "{{ route('fetchdashboarddata') }}",
        type: 'get',
        success: function(data){
            $("#userData").html(data);
            // $('#tblplan,#homeTblFirst,#homeTblSec,#homeTblThird,#homeTblFourth,#homeTblFifth,#homeTblSixth,#homeTblSeventh,#homeTblEight,#homeTblNine,#homeTblTen').DataTable({
            //     "pageLength": 5,
            //     "lengthMenu": [5, 10, 20, 50, 100, 200, 500],
            // });
            // $('#calendar').fullCalendar('refetchEvents');
        }
    });
}

</script>
@endsection