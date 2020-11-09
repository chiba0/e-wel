
<td class="text-center">
    <?php if($arg[ 'exam_state' ] == 2):?>
        <a href="#" id="test-<?=$arg[ 'mv_id' ]?>" class="click_btn" ><?=$arg['mv_exam_date']?></a>
    <?php else: ?>
        <?=$arg['mv_exam_date']?>
    <?php endif; ?>

</td>
<?php if($wt->weight > 0):?>
<td class="text-center"><?=$arg['level']?></td>
<?php endif; ?>
<td class="text-center"><?=$arg['st_lv']?></td>


