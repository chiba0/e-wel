
<td class="text-center">
<?php if($arg[ 'exam_state' ] == 2):?>
<a href="#" id="test-<?=$arg[ 'bav_id' ]?>" class="click_btn" ><?=$arg['bav_exam_date']?></a>
<?php else: ?>
        <?=$arg['exam_state_jp']?>
    <?php endif; ?>
</td>
<td class="text-center"><?=$arg['st_lv']?></td>


