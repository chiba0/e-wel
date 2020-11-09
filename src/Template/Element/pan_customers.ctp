<?php 
    $dash = "fa fa-dashboard";
    if($base_logintype == 1):
        $dash = "";
?>
    <li><a href="/managers/app"><i class="fa fa-dashboard"></i> TOP</a></li>
<?php endif;?>

<?php 
    $dash = "";
    if($base_logintype == 2):
        $dash = "fa fa-dashboard";
?>
<li><a href="/partners/app/<?=$pid?>"><i class="<?=$dash?>"></i> Partner</a></li>
<?php endif;?>

<?php if(isset($panlink) && $panlink):?>
    <li ><a href="<?=$panlink?>"><?=$pan?></a></li>
<?php else: ?>
    <li class="active"><?=$pan?></li>
<?php endif; ?>

<?php if(isset($panlink2) && $panlink2):?>
    <li ><a href="<?=$panlink2?>"><?=$pan2?></a></li>
<?php elseif(isset($pan2) && $pan2):?>
    <li class="active"><?=$pan2?></li>
<?php endif; ?>

<?php if(isset($panlink3) && $panlink3):?>
    <li ><a href="<?=$panlink3?>"><?=$pan3?></a></li>
<?php elseif(isset($pan3) && $pan3):?>
    <li class="active"><?=$pan3?></li>
<?php endif; ?>

<?php if(isset($panlink4) && $panlink4):?>
    <li ><a href="<?=$panlink4?>"><?=$pan4?></a></li>
<?php elseif(isset($pan4) && $pan4):?>
    <li class="active"><?=$pan4?></li>
<?php endif; ?>