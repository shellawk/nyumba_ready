<?php include_once('session.php');?>
<?php include(realpath(dirname(__DIR__)) . '/static/api/houses.php');?>

<div id="show-houses">
    <div id="add-houses">
        <input type="text" id="name" placeholder="Name">
        <input type="text" id="location" placeholder="Location">
        <input type="number" id="vacancy" placeholder="Vacancy">
        <input type="number" id="rent" placeholder="Rent">
        <select id="type">
            <option value="Bedsitter">Bedsitter</option>
            <option value="Single Room">Single Room</option>
        </select>
        <input type="text" id="owner_contact" placeholder="Owner Contact">
    </div>
    <div id="div-add-house-btn">
        <button onclick="addHouse()" id="btn-add-house">ADD HOUSE</button>
    </div>
    <div>
        <p id="msg-p"></p>
    </div>
    <div id="manage-houses">
        <table class="table" id="table-house">
            <?php 
                if($no_of_houses > 0){
                    echo "
                        <tr class=\"class-th\">
                            <th>Name</th>
                            <th>Location</th>
                            <th>Vacancy</th>
                            <th>Rent</th>
                            <th>Type</th>
                            <th>Owner Contact</th>
                            <th colspan=\"2\">Manage</th>
                        </tr>
                    ";
                        foreach($all_houses as $house){
                            echo "<tr class=\"class-td\">";
                            for($i=0; $i<count($house) -1; $i++){
                                echo "<td>". $house[$i] . "</td>";
                                //echo($house[$i]);
                            }
                            
                            echo "<td><button onclick=\"addPic('". $house[count($house) -1] . "')\">ADD  PHOTO</button></td>";
                            echo "<td><button onclick=\"removeHouse('". $house[count($house) -1] . "')\">REMOVE</button></td>";
                            //echo "</td>";
                        }
                }
            ?>
        </table>
    </div>
    <div id="add-pic"></div>
</div>