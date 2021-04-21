<?php include_once('session.php');?>
<form action="static/api/add_pic.php" method="post" enctype="multipart/form-data">
    <input type="file" name="image" id="image">
    <input type="hidden" name="house_id" id="house_id">
    <input type="submit" value="upload" id="upload-btn">
</form>