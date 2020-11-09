<?php
    $k = $value['key'];
?>
<table class="table table-bordered">
    <tr>
        <th class="w300p bg-blue"><?=__d("custom","taisyokensa")?></th>
        <td><?=$value[ 'name' ]?></td>
        <th class="w300p bg-blue"><?=__d("custom","jyukensyasu")?></th>
        <td><span class="examcount">-</span><?=__d("custom","mei")?></td>
    </tr>
    <tr>
        <th class="bg-blue" ><?=__d("custom","time")?></th>
        <td colspan=3 >
            <select name="minute_rest[<?=$k?>]" class="form-control w100p">
                <?php foreach($D_EXAM_TIME as $value):
                    $sel = "";
                    if($minute_rest[$k] == $value){
                        $sel = "SELECTED";
                    }
                    if($value == 60 && empty($minute_rest[$k])) $sel = "SELECTED";
                    
                    
                    
                    ?>
                    <option value="<?=$value?>" <?=$sel?> ><?=$value?>分</option>
                <?php endforeach;?>
            </select>
        </td>
    </tr>
</table>


