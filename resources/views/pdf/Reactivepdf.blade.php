<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Reactive Maintenance Report</title>
    <style>
    td, th {
    padding: 3px;
    }
    h2 {
        text-align:center;
    }
    </style>

</head>

<body>
    <h2>Reactive Maintenance Report</h2>
      <table border='1' width='100%' style='border-collapse: collapse;'>
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
                <th>External Cost</th>
                <th>Loss Hour</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php 
                foreach($data as $d) {
                    if($d->endname==null) { $d->endname = '-'; }
                    if($d->done_task_list==null) { $d->done_task_list = '-'; }
                    echo '<tr><td>' . $d->id . '</td><td>' . $d->ename . '</td><td>' . $d->unitname . '</td><td>' . $d->dname . '</td><td>' . $d->uname . '</td><td>' . $d->endname . '</td><td>' . $d->vname . '</td><td>' . $d->maintenance_type . '</td><td>' . $d->service_cost_external_vendor . '</td><td>' . $d->loss_hrs . '</td><td>' . $d->ticket_status . '</td></tr>';
                }
            ?>
        </tbody>
    </table>
</body>

</html>