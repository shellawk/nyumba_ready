<?php include_once('session.php');?>
<?php include(realpath(dirname(__DIR__)) . '/static/api/records.php');?>

<div id="all-records">
    <div id="div-book-report">
        <p><?php echo "NUMBER OF RECORDS: $no_of_records"?></p>
    </div>
    <p id="msg-p"></p>
    <table id="table-all-users" class="table table-records">
    <?php
    if($no_of_records > 0){
        echo "
            <tr>
                <th>House</th>
                <th>Email</th>
                <th>Amount</th>
                <th>Status</th>
                <th>Manage</th>
            </tr>
        ";
    }
        foreach($records as $record){
            echo "
                <tr>
                    <td>{$record['house']}</td>
                    <td>{$record['email']}</td>
                    <td>{$record['amount']}</td>
                    <td>{$record['status']}</td>
                    <td><button class=\"btn-remove-record\" onclick=\"removeRecord('{$record['ref']}')\">CLEAR</button></td>
                </tr>
            ";
        }
    ?>
    </table>
</div>