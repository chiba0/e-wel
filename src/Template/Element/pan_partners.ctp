<?php 
    $dash = "fa fa-dashboard";
    if($base_logintype == 1):
        $dash = "";
?>
    <li><a href="/managers/app"><i class="fa fa-dashboard"></i> TOP</a></li>
<?php endif;?>
<?php if(isset($panlink) && $panlink):?>
    <li ><a href="<?=$panlink?>"><?=$pan?></a></li>
<?php else: ?>
    <li class="active"><?=$pan?></li>
<?php endif; ?>
<?php if(isset($pan2) && $pan2):?>
    <li class="active"><?=$pan2?></li>
<?php endif; ?>