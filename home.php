<?php
    include_once('./static/api/home.php');
?>

<div id="home-div">
    <div id="home-intro-div">
        <p><b>NYUMBA READY</b> helps you find a new home with just a few key strokes. We've compiled an assortment of unoccupied bedsitters and single rooms around Juja.</p>
        <p>A space can be reserved for any house at <b>10%</b> of the rent.</p>
    </div>
    <div id="home-select-div" onchange="displayInfo()">
        <p>Pick a house to view details: </p>
        <select id="house-option">
            <?php
                foreach($all_houses as $key => $value){
                    echo '<option value="' . $key . '">' . $value . "</option>";
                }
            ?>
        </select>
    </div>
    <div id="house">
        <div id="home-info"></div>
        <div id="home-pic"></div>
    </div>
    <div id="reviews">
        <h3>Website Reviews</h3>
        <div id="reviews-write">
            <?php 
                if(isset($_COOKIE['token'])){
                    include_once('add_review.php');
                }else{
                    echo "<p>Login to add a review.</p>";
                }
            ?>
        </div>
        <div id="reviews-display"></div>
    </div>
</div>