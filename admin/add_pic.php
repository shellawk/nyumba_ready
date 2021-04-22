<?php include_once('session.php');
    include_once('url.php');
?>
<form action="<?php echo $api_url . "add_pic.php";?>" method="post" enctype="multipart/form-data">
    <input type="file" name="image" id="image">
    <input type="hidden" name="house_id" id="house_id">
    <input type="submit" value="upload" id="upload-btn">
</form>