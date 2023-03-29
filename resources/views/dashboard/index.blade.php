<?php $countI = $countJ = $countK = 1 ?>

<div class="row">
    @if(Auth::user()->Role == 1 || Auth::user()->Role == 4 || Auth::user()->Role == 5)
    <div class="col-12 col-sm-6 col-md-3">
        <a href="{{ route('user.index') }}">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">User</span>
                    <span class="info-box-number">{{$usercount}}</span>
                </div>
            </div>
        </a>
    </div>
    <div class="col-12 col-sm-6 col-md-3">
        <a href="{{ route('departments.index') }}">
            <div class="info-box">
                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-building"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Department</span>
                    <span class="info-box-number">{{$departmentscount}}</span>
                </div>
            </div>
        </a>
    </div>
    <div class="col-12 col-sm-6 col-md-3">
        <a href="{{ route('equipment.index') }}">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-tools"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Equipment </span>
                    <span class="info-box-number">{{$equipmentcount}}</span>
                </div>
            </div>
        </a>
    </div>
    <div class="col-12 col-sm-6 col-md-3">
        <a href="{{ route('vendors.index') }}">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-success elevation-1"><i class="fas fa-store"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Vendor</span>
                    <span class="info-box-number">{{$vendorscount}}</span>
                </div>
            </div>
        </a>
    </div>
    @endif
    @if(Auth::user()->Role == 1 || Auth::user()->Role == 2 || Auth::user()->Role == 3)
    <div class="col-12 col-sm-6 col-md-3">
        <a href="javascript:void(0)" onClick="scrollParagraph1('scroll-open-ticket')">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-gradient-danger elevation-1"><i
                        class="fas fa-ticket-alt"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Open  Ticket</span>
                    <span class="info-box-number">{{ $myopencount??0 }}</span>
                </div>
            </div>
        </a>
    </div>
    <div class="col-12 col-sm-6 col-md-3">
        <a href="javascript:void(0)" onClick="scrollParagraph1('scroll-close-ticket')">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-gradient-success elevation-1"><i
                        class="fas fa-ticket-alt"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Close  Ticket</span>
                    <span class="info-box-number">{{$myclosecount??0}}</span>
                </div>
            </div>
        </a>
    </div>
    <div class="col-12 col-sm-6 col-md-3">
        <a href="javascript:void(0)" onClick="scrollParagraph1('scroll-unassign-ticket')">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-gradient-warning elevation-1"><i
                        class="fas fa-ticket-alt"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Unassign  Ticket</span>
                    <span class="info-box-number">{{$myunassign??0}}</span>
                </div>
            </div>
        </a>
    </div>
    @endif
    <div class="col-12 col-sm-6 col-md-3">
        <a href="javascript:void(0)" id="tagCalender">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-gradient-dark elevation-1"><i
                        class="fa fa-calendar"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Plan Calendar</span>
                </div>
            </div>
        </a>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <!-- Maintenance User -->
        @if(Auth::user()->Role == 3)
            @if(count($openTicketEng) > 0 || count($TodayEngPMPlan) > 0)
            <div class="card" id="scroll-open-ticket">
                <div class="card-header">
                    <h5 class="card-title">Open Ticket</h5>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-hover" id="homeTblFirst">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Equipment </th>
                                <th>Request/Plan Date</th>
                                <th>Problem/Activity</th>
                                <th>End-User Name</th>
                                <th>Type</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($openTicketEng) > 0)
                            @foreach ($openTicketEng as $v1)
                            <tr>
                                <td>{{ $countI }}</td>
                                <td><a style="color:#007bff;" title="Update"
                                        href="{{ route('reactive_maintenance_plan.edit', $v1->id) }}">{{ $v1->equipment_name }}
                                    </a></td>
                                <!-- <td>{{ ShowNewDateFormat($v1->plan_date) }}</td> -->
                                @if($v1->actual_start_date < date('Y-m-d') )
                                    <td><span class="p-1 mb-2 bg-danger text-white">{{ ShowNewDateFormat($v1->actual_start_date) }}</span> </td>
                                @else
                                    <td>{{ ShowNewDateFormat($v1->actual_start_date) }}</td>
                                @endif
                                <td>
                                    <ul class="expandible" style="padding-inline-start: 20px;">
                                        <li>{{ $v1->Problem }}</li>
                                    </ul>
                                </td>
                                <td>{{ ucfirst($v1->endname) }}</td>
                                <td><span class="badge bg-warning">Reactive</span></td>
                            </tr>
                            <?php $countI++ ?>
                            @endforeach
                            @endif
                            @if(count($TodayEngPMPlan) > 0)
                            @foreach ($TodayEngPMPlan as $v2)
                            <tr>
                                <td>{{ $countI }}</td>
                                <td><a href="{{ route('planactivity.edit',$v2->id) }}"
                                        class="text-primary mr-2" data-toggle="tooltip"
                                        data-placement="bottom" title="" data-original-title="Edit">
                                        {{ $v2->equipment_name }}
                                    </a>
                                </td>
                                @if($v2->plan_date < date('Y-m-d') )
                                    <td><span class="p-1 mb-2 bg-danger text-white">{{ ShowNewDateFormat($v2->plan_date) }}</span> </td>
                                @else
                                    <td>{{ ShowNewDateFormat($v2->plan_date) }}</td>
                                @endif                                                    
                                <td>
                                    <?php 
                                        if($v2->tasktype == "major") {
                                            $tt = $v2->major .','. $v2->minor;
                                        }else if($v2->tasktype == "minor") {
                                            $tt = $v2->minor;
                                        }
                                        $tt = explode(',',$tt);
                                        echo '<ul class="expandible" style="padding-inline-start: 20px;">';
                                        foreach($tt as $m) {
                                            echo '<li>'.$m.'</li>';
                                        }
                                        echo '</ul>';
                                    ?>
                                </td>
                                <td>{{ ucfirst($v2->endname) }}</td>
                                <td><span class="badge bg-success">Preventive</span></td>
                            </tr>
                            <?php $countI++ ?>
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
            
            @if(count($reactiveUnassignTicket) > 0)
            <div class="card" id="scroll-unassign-ticket">
                <div class="card-header">
                    <h5 class="card-title">Unassign Ticket</h5>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-hover" id="homeTblSec">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Equipment </th>
                                <th>Request/Plan Date</th>
                                <th>Problem</th>
                                <th>End-User Name</th>
                                <th>Self Assign </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($reactiveUnassignTicket as $v3)
                            <tr>
                                <td>{{ $loop->iteration}}</td>
                                <td>{{ $v3->equipment_name }}</td>
                                @if($v3->actual_start_date < date('Y-m-d') )
                                <td><span class="p-1 mb-2 bg-danger text-white">{{ ShowNewDateFormat($v3->actual_start_date) }}</span> </td>
                                @else
                                <td>{{ ShowNewDateFormat($v3->actual_start_date) }}</td>
                                @endif
                                <td>
                                    <ul class="expandible" style="padding-inline-start: 20px;">
                                        <li>{{ $v3->Problem }}</li>
                                    </ul>
                                </td>
                                <td>{{ ucfirst($v3->endname) }}</td>
                                <td>
                                    <button title="Self Assign" data-id="{{$v3->id}}" value="{{ $log }}"
                                        class="btn btn-info" name="selfuser_id" id="selfuser_id"
                                        class="selfuser_id">
                                        {{ $log2 }}
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif

            @if(count($eng_close) > 0)
            <div class="card" id="scroll-close-ticket">
                <div class="card-header">
                    <h5 class="card-title">Close Ticket</h5>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-hover" id="homeTblThird">
                        <thead>
                            <tr>
                                <th>S.No </th>
                                <th>Equipment </th>
                                <th>Request/Plan Date</th>
                                <th>Problem/Activity</th>
                                <th>Maintenance Type</th>
                                <th>End-User Name</th>
                                <th>View</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($eng_close as $reactive)
                            <tr>
                                <td>{{ $reactive->id }}</td>
                                <td>{{ $reactive->equipment_name }} </td>
                                @if($reactive->maintenance_type == "Reactive")
                                    @if($reactive->actual_start_date < date('Y-m-d') )
                                        <td><span class="p-1 mb-2 bg-danger text-white">{{ ShowNewDateFormat($reactive->actual_start_date) }}</span> </td>
                                    @else
                                        <td>{{ ShowNewDateFormat($reactive->actual_start_date) }}</td>
                                    @endif
                                    <td> 
                                        <ul class="expandible" style="padding-inline-start: 20px;">
                                            <li>{{ $reactive->Problem }}</li>
                                        </ul>
                                    </td>
                                    <td><span class="badge bg-warning">Reactive</span></td>
                                @else
                                    @if($reactive->plan_date < date('Y-m-d') )
                                        <td><span class="p-1 mb-2 bg-danger text-white">{{ ShowNewDateFormat($reactive->plan_date) }}</span> </td>
                                    @else
                                        <td>{{ ShowNewDateFormat($reactive->plan_date) }}</td>
                                    @endif
                                    <td>
                                        <?php 
                                            if($reactive->tasktype == "major") {
                                                $tt = $reactive->major .','. $reactive->minor;
                                            }else if($reactive->tasktype == "minor") {
                                                $tt = $reactive->minor;
                                            }
                                            $tt = explode(',',$tt);
                                            echo '<ul class="expandible" style="padding-inline-start: 20px;">';
                                            foreach($tt as $m) {
                                                echo '<li>'.$m.'</li>';
                                            }
                                            echo '</ul>';
                                        ?>
                                    </td>
                                    <td><span class="badge bg-success">Preventive</span></td>
                                @endif
                                <td>{{ ucfirst($reactive->endname) }}</td>
                                <td>
                                    <a class="mr-2" data-toggle="tooltip" data-placement="bottom"
                                        title="" data-original-title="View"
                                        href="{{ route('showdetail',$reactive->id) }}"><i
                                            class="fas fa-eye fa-lg" aria-hidden="true"></i>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
        @endif
        <!-- End User -->
        @if(Auth::user()->Role == 2)
            @if(count($openTicketEnduser) > 0 || count($CompletedPreventivePlan) > 0)
            <div class="card" id="scroll-open-ticket">
                <div class="card-header">
                    <h5 class="card-title">Open Ticket</h5>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-hover" id="homeTblFourth">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Equipment </th>
                                <th>Request/Plan Date</th>
                                <th>Problem/Activity</th>
                                <th>Maintenance Type</th>
                                <th>Engineer Name</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($openTicketEnduser) > 0)
                            @foreach ($openTicketEnduser as $u1)
                            <tr>
                                <td>{{$countJ}}</td>
                                <td>
                                    <a style="color:#007bff;" title="Update"
                                        href="{{ route('reactive_maintenance_plan.show', $u1->id) }}">{{ $u1->equipment_name }}
                                    </a>
                                </td>
                                @if($u1->actual_start_date < date('Y-m-d') )
                                <td><span class="p-1 mb-2 bg-danger text-white">{{ ShowNewDateFormat($u1->actual_start_date) }}</span> </td>
                                @else
                                <td>{{ ShowNewDateFormat($u1->actual_start_date) }}</td>
                                @endif
                                <td>
                                    <ul class="expandible" style="padding-inline-start: 20px;">
                                        <li>{{ $u1->Problem }}</li>
                                    </ul>
                                </td>
                                <td><span class="badge bg-warning">Reactive</span></td>
                                <td>{{ ucfirst($u1->uname) }}</td>

                            </tr>
                            <?php $countJ++ ?>
                            @endforeach
                            @endif

                            @if(count($CompletedPreventivePlan) > 0)
                            @foreach ($CompletedPreventivePlan as $u2)
                            <tr>
                                <td>{{$countJ}}</td>
                                <td><a style="color:#007bff;" title="Update"
                                        href="{{ route('updateByEndUser', $u2->id) }}">{{ $u2->equipment_name }}
                                    </a></td>
                                @if($u2->plan_date < date('Y-m-d') )
                                    <td><span class="p-1 mb-2 bg-danger text-white">{{ ShowNewDateFormat($u2->plan_date) }}</span> </td>
                                @else
                                    <td>{{ ShowNewDateFormat($u2->plan_date) }}</td>
                                @endif
                                <td>
                                    <?php 
                                        if($u2->tasktype == "major") {
                                            $tt = $u2->major .','. $u2->minor;
                                        }else if($u2->tasktype == "minor") {
                                            $tt = $u2->minor;
                                        }
                                        $tt = explode(',',$tt);
                                        echo '<ul class="expandible" style="padding-inline-start: 20px;">';
                                        foreach($tt as $m) {
                                            echo '<li>'.$m.'</li>';
                                        }
                                        echo '</ul>';
                                    ?>
                                </td>
                                <td><span class="badge bg-success">Preventive</span></td>
                                <td>{{ ucfirst($u2->uname) }}</td>

                            </tr>
                            <?php $countJ++ ?>
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
            @endif

            @if(count($reactiveUnassignTicket) > 0)
            <div class="card" id="scroll-unassign-ticket">
                <div class="card-header">
                    <h5 class="card-title">Unassign Ticket</h5>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-hover" id="homeTblFifth">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Equipment </th>
                                <th>Request/Plan Date</th>
                                <th>Problem</th>
                                <th>Maintenance Type</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($reactiveUnassignTicket as $u3)
                            <tr>
                                <td>{{ $loop->iteration}}</td>
                                <td>{{ $u3->equipment_name }}</td>
                                @if($u3->actual_start_date < date('Y-m-d') )
                                <td><span class="p-1 mb-2 bg-danger text-white">{{ ShowNewDateFormat($u3->actual_start_date) }}</span> </td>
                                @else
                                <td>{{ ShowNewDateFormat($u3->actual_start_date) }}</td>
                                @endif
                                <td>
                                    <ul class="expandible" style="padding-inline-start: 20px;">
                                        <li>{{ $u3->Problem }}</li>
                                    </ul>
                                </td>
                                <td><span class="badge bg-warning">Reactive</span></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif

            @if(count($eng_close) > 0)
            <div class="card"  id="scroll-close-ticket">
                <div class="card-header">
                    <h5 class="card-title">Close Ticket</h5>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-hover" id="homeTblSixth">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Equipment </th>
                                <th>Request/Plan Date</th>
                                <th>Problem/Activity</th>
                                <th>Maintenance Type</th>
                                <th>Engineer Name</th>
                                <th>View</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($eng_close as $u2)
                            <tr>
                                <td>{{ $loop->iteration}}</td>
                                <td>{{ $u2->equipment_name }} </td>
                                @if($u2->maintenance_type == "Reactive")
                                    @if($u2->actual_start_date < date('Y-m-d') )
                                        <td><span class="p-1 mb-2 bg-danger text-white">{{ ShowNewDateFormat($u2->actual_start_date) }}</span> </td>
                                    @else
                                        <td>{{ ShowNewDateFormat($u2->actual_start_date) }}</td>
                                    @endif
                                    <td> 
                                        <ul class="expandible" style="padding-inline-start: 20px;">
                                            <li>{{ $u2->Problem }}</li>
                                        </ul>
                                    </td>
                                    <td><span class="badge bg-warning">Reactive</span></td>
                                @else
                                    @if($u2->plan_date < date('Y-m-d') )
                                        <td><span class="p-1 mb-2 bg-danger text-white">{{ ShowNewDateFormat($u2->plan_date) }}</span> </td>
                                    @else
                                        <td>{{ ShowNewDateFormat($u2->plan_date) }}</td>
                                    @endif
                                    <td>
                                        <?php 
                                            if($u2->tasktype == "major") {
                                                $tt = $u2->major .','. $u2->minor;
                                            }else if($u2->tasktype == "minor") {
                                                $tt = $u2->minor;
                                            }
                                            $tt = explode(',',$tt);
                                            echo '<ul class="expandible" style="padding-inline-start: 20px;">';
                                            foreach($tt as $m) {
                                                echo '<li>'.$m.'</li>';
                                            }
                                            echo '</ul>';
                                        ?>
                                    </td>
                                    <td><span class="badge bg-success">Preventive</span></td>
                                @endif
                                <td>{{ ucfirst($u2->uname) }}</td>
                                <td>
                                    <a class="mr-2" data-toggle="tooltip" data-placement="bottom"
                                        title="" data-original-title="View"
                                        href="{{ route('showdetail',$u2->id) }}"><i
                                            class="fas fa-eye fa-lg" aria-hidden="true"></i>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
        @endif

        <!-- Maintenance HOD -->
        @if(Auth::user()->Role == 1)
            @if(count($pmplanlist) > 0)
            <?php $frequency = [12=>'Monthly',4=>'Quarterly',2=>'Half Yearly',1=>'Yearly'];?>
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Approve/Modify Plan Ticket</h5>
                </div>
                <div class="card-body table-responsive">
                    <div class="row custom_filter">
                        <div class="form-group">
                            <select class="form-control" id="planaction" name="planaction">
                                <option value="0">Select Status</option>
                                <option value="Approved">Approve</option>
                                <!-- <option value="Rejected">Reject</option> -->
                            </select>
                            <label class="error" id="select_plan_status_error"
                                style="color:#FC2727;display:none">
                                <b> Please select any one.</b>
                            </label>
                        </div>
                        <button type="button" class="btn btn-default btn_approve_plan">Apply</button>
                    </div>
                    <div>
                        <label class="error" id="select_plan_checkbox"
                            style="color:#FC2727;display:none">
                            <b> Please select atleast one record to status change</b>
                        </label>
                    </div>
                    <table class="table table-bordered table-hover" id="tblplan">
                        <thead>
                            <tr>
                                <th class="no-sort">
                                    <input type="checkbox" id="chkAll" />
                                </th>
                                <th>Equipment</th>
                                <th>Frequancy</th>
                                <th>Start Date</th>
                                <th>End-User Name</th>
                                <th>Assigned User</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pmplanlist as $plan)
                            <tr>
                                <td><input class="checkbox" type="checkbox"
                                        data-id="{{ $plan->uniqueid }}" name="checks[]" /></td>
                                <td><a href="{{ route('plan.edit',$plan->uniqueid) }}"
                                        class="text-primary mr-2" data-toggle="tooltip"
                                        data-placement="bottom" title="" data-original-title="Edit">
                                        {{ $plan->equipment_name }}
                                    </a></td>
                                <td>{{ $frequency[$plan->frequancy]}}</td>
                                <td>{{ $plan->start_date }}</td>
                                <td>{{ ucfirst($plan->endname) }}</td>
                                <td>{{ ucfirst($plan->first_name.' '.$plan->last_name) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif

            @if(count($reactiveUnassignTicket) > 0)
            <div class="card" id="scroll-unassign-ticket">
                <div class="card-header">
                    <h5 class="card-title">Unassign Ticket</h5>
                </div>
                <div class="card-body table-responsive">
                    <div class="row custom_filter">
                        <div class="form-group">
                        <select  class="form-control" name="user_id"
                                        id="user_id" class="user_id">
                                        <option value="">Select User </option>
                                        @foreach ($usersAssign as $data)
                                        <option value="{{$data->id}}">
                                            {{ ucfirst($data->first_name) }}
                                        </option>
                                        @endforeach
                        </select>
                        <label class="error" id="select_status_error"
                            style="color:#FC2727;display:none">
                            <b> Please select any one.</b>
                        </label> </div>
                    <button type="button" class="btn btn-default btn_approve_assign">Apply</button>
                    <div>
                        <label class="error" id="select_checkbox"
                            style="color:#FC2727;display:none">
                            <b> Please select atleast one record to status change</b>
                        </label>
                    </div>
                    </div>
                    <table class="table table-bordered table-hover" id="homeTblSeventh">
                        <thead>
                            <tr>
                                <th class="no-sort">
                                    <input type="checkbox" id="chkAll" />
                                </th>
                                <th>Equipment </th>
                                <th>Request/Plan Date</th>
                                <th>Problem</th>
                                <th>End- User Name</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($reactiveUnassignTicket as $w3)
                            <tr>
                            <td><input class="checkbox" type="checkbox"
                                            data-id="{{ $w3->id }}" name="checks[]" /></td>
                                
                                <td>{{ $w3->equipment_name }}</td>
                                @if($w3->actual_start_date < date('Y-m-d') )
                                    <td><span class="p-1 mb-2 bg-danger text-white">{{ ShowNewDateFormat($w3->actual_start_date) }}</span> </td>
                                @else
                                    <td>{{ ShowNewDateFormat($w3->actual_start_date) }}</td>
                                @endif
                                <td>
                                    <ul class="expandible" style="padding-inline-start: 20px;">
                                        <li>{{ $w3->Problem }}</li>
                                    </ul>
                                </td>
                                <td>{{ ucfirst($w3->endname) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif

            @if(count($allOpenTicket) > 0)
            <div class="card" id="scroll-open-ticket">
                <div class="card-header">
                    <h5 class="card-title">Open Ticket</h5>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-hover" id="homeTblEight">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Equipment </th>
                                <th>Request/Plan Date</th>
                                <th>Problem/Activity</th>
                                <th>Maintenance Type</th>
                                <!-- <th>End-User Name</th> -->
                                <th>Engineer Name</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($allOpenTicket as $w1)
                            <tr>
                                <td>{{ $loop->iteration}}</td>
                                <td>{{ $w1->equipment_name }} </td>
                                @if($w1->maintenance_type == "Reactive")
                                    @if($w1->actual_start_date < date('Y-m-d') )
                                        <td><span class="p-1 mb-2 bg-danger text-white">{{ ShowNewDateFormat($w1->actual_start_date) }}</span> </td>
                                    @else
                                        <td>{{ ShowNewDateFormat($w1->actual_start_date) }}</td>
                                    @endif
                                    <td> 
                                        <ul class="expandible" style="padding-inline-start: 20px;">
                                            <li>{{ $w1->Problem }}</li>
                                        </ul>
                                    </td>
                                    <td><span class="badge bg-warning">Reactive</span></td>
                                @else
                                    @if($w1->plan_date < date('Y-m-d') )
                                        <td><span class="p-1 mb-2 bg-danger text-white">{{ ShowNewDateFormat($w1->plan_date) }}</span> </td>
                                    @else
                                        <td>{{ ShowNewDateFormat($w1->plan_date) }}</td>
                                    @endif
                                    <td>
                                        <?php 
                                            if($w1->tasktype == "major") {
                                                $tt = $w1->major .','. $w1->minor;
                                            }else if($w1->tasktype == "minor") {
                                                $tt = $w1->minor;
                                            }
                                            $tt = explode(',',$tt);
                                            echo '<ul class="expandible" style="padding-inline-start: 20px;">';
                                            foreach($tt as $m) {
                                                echo '<li>'.$m.'</li>';
                                            }
                                            echo '</ul>';
                                        ?>
                                    </td>
                                    <td><span class="badge bg-success">Preventive</span></td>
                                @endif
                                <!-- <td>{{ ucfirst($w1->endname)}}</td> -->
                                <td>{{ ucfirst($w1->uname)}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif

            @if(count($allCloseTicket) > 0)
            <div class="card" id="scroll-close-ticket">
                <div class="card-header">
                    <h5 class="card-title">Close Ticket</h5>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-hover" id="homeTblNine">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Equipment </th>
                                <th>Request/Plan Date</th>
                                <th>Problem/Activity</th>
                                <th>Maintenance Type</th>
                                <th>Engineer Name</th>
                                <th>End-User Name</th>
                                <th>View</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($allCloseTicket as $w2)
                            <tr>
                                <td>{{ $loop->iteration}}</td>
                                <td>{{ $w2->equipment_name }} </td>
                                @if($w2->maintenance_type == "Reactive")
                                    <td>{{ ShowNewDateFormat($w2->actual_start_date) }}</td>
                                    <td>
                                        <ul class="expandible" style="padding-inline-start: 20px;">
                                            <li>{{ $w2->Problem }}</li>
                                        </ul>
                                    </td>
                                    <td>
                                        <span class="badge bg-warning">Reactive</span>
                                    </td>                                                    
                                @else
                                    <td>{{ ShowNewDateFormat($w2->plan_date) }}</td>
                                    <td>
                                        <?php 
                                        if($w2->tasktype == "major") {
                                            $tt = $w2->major .','. $w2->minor;
                                        }else if($w2->tasktype == "minor") {
                                            $tt = $w2->minor;
                                        }
                                        $tt = explode(',',$tt);
                                        echo '<ul class="expandible" style="padding-inline-start: 20px;">';
                                        foreach($tt as $m) {
                                            echo '<li>'.$m.'</li>';
                                        }
                                        echo '</ul>'; 
                                        ?>
                                    </td>
                                    <td><span class="badge bg-success">Preventive</span></td>
                                @endif
                                <td>{{ ucfirst($w2->uname) }}</td>
                                <td>{{ ucfirst($w2->endname) }}</td>
                                <td>
                                    <a class="mr-2" data-toggle="tooltip" data-placement="bottom"
                                        title="" data-original-title="View"
                                        href="{{ route('showdetail',$w2->id) }}"><i
                                            class="fas fa-eye fa-lg" aria-hidden="true"></i>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
            @endif

            <!-- End User & Maintenance User -->
            @if(Auth::user()->Role == 2 || Auth::user()->Role == 3)
            @if(count($addNotetoTicket) > 0)
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Add Note For Upcoming PM Plan</h5>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-hover" id="homeTblTen">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Equipment </th>
                                <th>Request/Plan Date</th>
                                <th>Problem/Activity</th>
                                <th>Type</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($addNotetoTicket) > 0)
                            @foreach ($addNotetoTicket as $v7)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <a style="color:#007bff;" href="javascript:void(0)" class="addNote"
                                        class="text-primary mr-2" data-toggle="tooltip"
                                        data-placement="bottom" title="" data-original-title="AddNote"
                                        data-id="{{$v7->id}}"> {{ $v7->equipment_name }}</a>
                                </td>
                                <td>{{ ShowNewDateFormat($v7->plan_date) }}</td>
                                <td>
                                    <?php 
                                    if($v7->tasktype == "major") {
                                        $tt = $v7->major .','. $v7->minor;
                                    }else if($v7->tasktype == "minor") {
                                        $tt = $v7->minor;
                                    }
                                    $tt = explode(',',$tt);
                                    echo '<ul class="expandible" style="padding-inline-start: 20px;">';
                                    foreach($tt as $m) {
                                        echo '<li>'.$m.'</li>';
                                    }
                                    echo '</ul>';
                                ?>
                                </td>
                                <td><span class="badge bg-success">Preventive</span></td>
                            </tr>
                            <?php $countI++ ?>
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
            @endif
        </div>
    </div>
</div>

<div id="calendershow" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Plan Calender</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div id="calendar"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="calenderplan">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Plan Data</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>One fine body&hellip;</p>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="ajaxModel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add Work Note</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="planForm" name="planForm" class="form-horizontal">
                    <input type="hidden" name="plan_id" id="plan_id">
                    <div class="form-group col-sm-6 col-lg-4 col-xl-12">
                        <label> Note </label>
                        <textarea class="form-control" name="note" id="note"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Save
                    changes</button>
            </div>
        </div>
    </div>
</div>
<div id="calendershow" class="modal fade" role="dialog">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Plan Calender</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <div id="calendar"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="calenderplan">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Plan Data</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>One fine body&hellip;</p>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="ajaxModel">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Add Work Note</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="planForm" name="planForm" class="form-horizontal">
                                <input type="hidden" name="plan_id" id="plan_id">
                                <div class="form-group col-sm-6 col-lg-4 col-xl-12">
                                    <label> Note </label>
                                    <textarea class="form-control" name="note" id="note"></textarea>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Save
                                changes</button>
                        </div>
                    </div>
                </div>
            </div>
<script type="text/javascript">

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#tblplan,#homeTblFirst,#homeTblSec,#homeTblThird,#homeTblFourth,#homeTblFifth,#homeTblSixth,#homeTblSeventh,#homeTblEight,#homeTblNine,#homeTblTen').DataTable({
        "pageLength": 5,
        "lengthMenu": [5, 10, 20, 50, 100, 200, 500],
    });

    $('#chkAll').click(function() {
        var isChecked = $(this).prop("checked");
        $('#tblplan tr:has(td)').find('input[type="checkbox"]').prop('checked', isChecked);
    });
     // Note add
    $('.addNote').click(function() {
        $('#plan_id').val($(this).data('id'));
        $.ajax({
            data: {
                plan_id: $(this).data('id')
            },
            url: "{{ route('getNoteData') }}",
            type: "POST",
            dataType: 'json',
            success: function(data) {
                $('#note').html(data.worknote);
                $('#planForm').trigger("reset");
                $('#ajaxModel').modal('show');
            }
        });
    });

    $('#saveBtn').click(function(e) {
        e.preventDefault();
        $.ajax({
            data: $('#planForm').serialize(),
            url: "{{ route('addNoteData') }}",
            type: "POST",
            dataType: 'json',
            success: function(response) {
                $('#planForm').trigger("reset");
                $('#ajaxModel').modal('hide');
                if (response.msg == 1) {
                    toastr.success("Note saved successfully", 'Plan');
                }
            }
        });
    });
 // checkbox- click all record
    $('#tblplan tr:has(td)').find('input[type="checkbox"]').click(function() {
        var isChecked = $(this).prop("checked");
        var isHeaderChecked = $("#chkAll").prop("checked");
        if (isChecked == false && isHeaderChecked)
            $("#chkAll").prop('checked', isChecked);
        else {
            $('#tblplan tr:has(td)').find('input[type="checkbox"]').each(function() {
                if ($(this).prop("checked") == false)
                    isChecked = false;
            });
            $("#chkAll").prop('checked', isChecked);
        }
    });
   // get  calendar
    var SITEURL = "{{ url('/') }}";
    var calendar = $('#calendar').fullCalendar({
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
        },
        // editable: true,
        // editable: true,
        events: SITEURL + "/getEvent",
        displayEventTime: false,
        // timeFormat: 'hh:mm a',
        eventRender: function(event, element, view) {
            if (event.allDay === 'true') {
                event.allDay = true;
            } else {
                event.allDay = false;
            }
        },
        selectable: true,
        selectHelper: true,
        eventClick: function(event) {
            var id = event.id;
            $.ajax({
                url: "{{ route('showcalender') }}",
                type: "POST",
                data: {
                    id: id,
                    _token: '{{csrf_token()}}'
                },
                success: function(res) {
                    var html =
                        "<p><strong>Plan Id:</strong> <span>" + res
                        .id + "</span></p>";
                    html += "<p><strong>Equipement Name:</strong> <span>" + res
                        .equipment_name + "</span></p>";
                    if (res.first_name != null) {                        
                        html += "<p><strong>Assigned User:</strong> <span>" +
                            res.first_name + " " + res.last_name + "</span></p>";
                    }
                    html += "<p><strong>Plan Date:</strong> <span>" + res
                        .plan_date +
                        "</span></p>";
                    if(res.maintenance_type == "Preventive") {
                        html += "<p><strong>Activity Type:</strong> <span>" +
                            res.tasktype +
                            "</span></p>";
                        html += "<p><strong>Activity List:</strong> <span>";
                        if (res.tasktype == "major") html += res.major + ", " +
                            res.minor;
                        if (res.tasktype == "minor") html += res.minor;
                        html += "</span></p>"
                    } else {
                        html += "<p><strong>Activity List:</strong> <span>";
                        html += res.Problem;
                    }
                    $("#calenderplan").modal("show");
                    $("#calenderplan .modal-body").html(html);
                }
            })
        },
        eventDrop: function(event, delta) {
            var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD");
            $.ajax({
                url: SITEURL + '/fullcalenderAjax',
                data: {
                    start: start,
                    id: event.id,
                    type: 'update'
                },
                type: "POST",
                success: function(response) {
                    if (response.msg == 1) {
                        toastr.success("Plan date changed Successfully",
                            'Plan');
                    }
                }
            });
        },
    });

     // approve plan Rejected plan
    $(".btn_approve_plan").click(function() {
        var idsArr = [];
        $(".checkbox:checked").each(function() {
            idsArr.push($(this).attr('data-id'));
        });
        if (idsArr.length <= 0) {
            $("label#select_plan_checkbox").show();
            return false;
        }
        $('.error').hide();
        if ($("select[name=planaction]").val() == 0) {
            $("label#select_plan_status_error").show();
            $("select#planaction").focus();
            return false;
        }
        $("label#select_plan_checkbox").hide();
        $("label#select_plan_status_error").hide();

        var flag = $("#planaction option:selected").val();
        $.ajax({
            type: "POST",
            url: "{{route('updatePreventiveStatus')}}",
            data: {
                id: idsArr,
                value: flag
            },
            dataType: 'json',
            success: function(res) {
                if (res.msg == 1) {
                    $(".checkbox:checked").each(function() {
                        $(this).parents("tr").fadeOut(300);
                    });
                    $('#calendar').fullCalendar('refetchEvents');
                    toastr.success("Plan status changed successfully", 'Plan');
                    location.reload();
                }
            }
        });
    });
    // HOD Assign Check-box
    $(".btn_approve_assign").click(function() {
            var id = [];
            $(".checkbox:checked").each(function() {
                id.push($(this).attr('data-id'));
            });

            if (id.length <= 0) {
                $("label#select_checkbox").show();
                return false;
            }
            $('.error').hide();
            if ($("select[name=user_id]").val() == 0) {
                $("label#select_status_error").show();
                $("select#user_id").focus();
                return false;
            }
            $("label#select_checkbox").hide();
            $("label#select_status_error").hide();

            var user_id = $("#user_id option:selected").val();
            $.ajax({
                type: "post",
                url: "{{route('changeUserTicket')}}",
                data: {
                    id: id,
                    user_id: user_id
                },
                dataType: 'json',
                success: function(res) {
                    if (res.msg == 1) {
                        $(".checkbox:checked").each(function() {
                            $(this).parents("tr").fadeOut(300);
                        });
                        $('#calendar').fullCalendar('refetchEvents');
                        toastr.success("Assign user successfully", 'Assign user');
                    }
                }
            });
        });

    //Self Assign user 
    $('button[name="selfuser_id"]').on('click', function() {
        var selfuser_id = $(this).val();
        var id = $(this).data('id');
        $.ajax({
            type: "GET",
            dataType: "json",
            url: "{{route('changeUserselfTicket')}}",
            data: {
                'selfuser_id': selfuser_id,
                'id': id
            },
            success: function(data) {
                location.reload();
            }
        });
    })

    $('#tagCalender').on('click', function() {
        $("#calendershow").modal("show");
    });

    $('ul.expandible').each(function(){
        var $ul = $(this),
            $lis = $ul.find('li:gt(1)'),
            isExpanded = $ul.hasClass('expanded');
            $lis[isExpanded ? 'show' : 'hide']();
        
        if($lis.length > 0){
            $ul.append($('<a href="javascript:void(0)" class="text-primary mr-2">' + (isExpanded ? 'Less' : 'More') + '</a>')
                .click(function(event){
                    var isExpanded = $ul.hasClass('expanded');
                    event.preventDefault();
                    $(this).html(isExpanded ? 'More' : 'Less');
                    $ul.toggleClass('expanded');
                    $lis.slideToggle();
                }));
        }
    });

    function scrollParagraph1(id) {
        var $target = $("#"+id);
        if($target.length != 0) {
            $('html, body').stop().animate({
                'scrollTop': $target.offset().top - 70
            }, 900, 'swing', function () {
                // window.location.hash = target;
            });
        }
    }

</script>