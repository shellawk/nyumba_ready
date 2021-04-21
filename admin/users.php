<?php include_once('session.php');?>
<?php include(realpath(dirname(__DIR__)) . '/static/api/users.php');?>
<div id="all-users">
    <div id="div-user-report">
        <p><?php echo "NUMBER OF USERS: $no_of_users"?></p>
    </div>
    <p id="msg-p"></p>
    <table id="table-all-users" class="table">
    <?php
    if($no_of_users > 0){
        echo "
            <tr>
                <th>Email</th>
                <th>Name</th>
                <th>Manage</th>
            </tr>
        ";
    }
        foreach($all_users as $user){
            echo "
                <tr>
                    <td>{$user['email']}</td>
                    <td>{$user['name']}</td>
                    <td><button class=\"btn-remove-user\" onclick=\"removeUser('{$user['id']}')\">REMOVE</button></td>
                </tr>
            ";
        }
    ?>
    </table>
</div>