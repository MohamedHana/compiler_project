
<?php foreach($message as $error):?>
    <?php if(!empty($error)):?>
        <div class="alert alert-success" role="alert">Check your code at (<strong><?php echo $error?></strong>) not accepted token!!</div>
    <?php endif;?>
<?php endforeach;?>

