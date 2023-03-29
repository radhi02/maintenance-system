<div id="download-btns">    
    <span>Total Record : {{count($data)}}</span>
    <a href="javascript:void(0)" class="btn btn-warning sm-2" onclick="exportpdf()" style=" margin: 7px; float:right"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> Export To PDF</a>
</div>
<table id="tblpmreport" class="table table-bordered table-hover table-responsive">
    <thead>
        <tr>
            <th width="40px">No.</th>
            <th>Equipment</th>
            <th>Unit</th>
            <th>Department</th>
            <th>Maintenance User</th>
            <th>End User</th>
            <th>Vendor</th>
            <th>Task Type</th>
            <th>Task List</th>
            <th>Done Task List</th>
            <th>External Cost</th>
            <th>Loss Hour</th>
            <th>Ticket Status</th>
        </tr>
    </thead>
    @if(count($data) > 0) 
    <tbody id="tbldata">
    <?php 
        foreach($data as $d) {
            if($d->endname==null) { $d->endname = '-'; }
            if($d->tasktype == "major") {
                $tt = $d->major .','. $d->minor;
            }else if($d->tasktype == "minor") {
                $tt = $d->minor;
            }
            $tt = explode(',',$tt);
            echo '<tr><td>' . $d->id . '</td><td>' . $d->equipment_name . '</td><td>' . $d->unitname . '</td><td>' . $d->dname . '</td><td>' . $d->uname . '</td><td>' . $d->endname . '</td><td>' . $d->vname . '</td><td>' . $d->tasktype . '</td>';
            echo '<td>';
            echo '<ul style="padding-inline-start: 20px;">';
            foreach($tt as $m) {
                echo '<li>'.$m.'</li>';
            }
            echo '</ul>';
            echo '</td>';
            if($d->done_task_list==null) { echo '<td> - </td>'; }
            else {
                $done_task_list = explode(',',$d->done_task_list);
                echo '<td>';
                echo '<ul style="padding-inline-start: 20px;">';
                foreach($done_task_list as $dd) {
                    echo '<li>'.$dd.'</li>';
                }
                echo '</ul>';
                echo '</td>';
            }
            echo '<td>' . $d->service_cost_external_vendor . '</td><td>' . $d->loss_hrs . '</td><td>' . $d->ticket_status . '</td></tr>';
        }
    ?>
    </tbody>
    @else
    <tbody class="report_message">
        <tr>
            <td colspan="13" style="text-align: center;">No record found</td>
        </tr>
    </tbody>
    @endif
</table>
