<div class="div-payment">
    <p>You have a pending transaction. <b>Complete</b> or <b>terminate</b> it before procceeding to another one.</p>
    <p id="p-pending" class="div-payment">Pay Ksh. <?php echo number_format($p_amount, 2);?> to reserve a space at <?php echo $p_house_name;?></p>
    <div id="div-btn">
    <form action="<?php echo $url;?>" method="post">
        <input type="hidden" name="first_name" value="<?php echo $p_firstname;?>">
        <input type="hidden" name="last_name" value="<?php echo $p_lastname;?>">
        <input type="hidden" name="email" value="<?php echo $p_email;?>">
        <input type="hidden" name="reference" value="<?php echo $p_reference;?>">
        <input type="hidden" name="description" value="<?php echo $p_desc;?>">
        <input type="hidden" name="type" value="MERCHANT">
        <input type="hidden" name="amount" value="<?php echo $p_amount;?>">
        <input type="submit" value="Complete Transaction">
    </form>
    <button id="btn-terminate" onclick="terminateTransaction('<?php echo $p_reference;?>')">Terminate Transaction</button>
</div>
</div>