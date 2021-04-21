<?php include_once('./static/api/book.php');?>
<div id="div-pay" class="div-payment">
<p>Pay Ksh. <?php echo number_format($amount, 2);?> to reserve a space at <?php echo $house_info -> name;?></p>
<div id="div-btn">
    <form action="<?php echo $url;?>" method="post">
        <input type="hidden" name="first_name" value="<?php echo $user_info -> firstname;?>">
        <input type="hidden" name="last_name" value="<?php echo $user_info -> lastname;?>">
        <input type="hidden" name="email" value="<?php echo $user_info -> email;?>">
        <input type="hidden" name="reference" value="<?php echo $reference;?>">
        <input type="hidden" name="description" value="<?php echo $house_info -> house_id;?>">
        <input type="hidden" name="type" value="MERCHANT">
        <input type="hidden" name="amount" value="<?php echo $amount;?>">
        <input type="submit" value="Proceed to Payment">
    </form>
    <button id="btn-terminate" onclick="terminateTransaction('<?php echo $reference;?>')">Terminate Transaction</button>
</div>
</div>