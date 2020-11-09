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
        <th class="bg-blue" ><?=__d("custom","vf")?></th>
        <td colspan=3 >
            
            <input type="text" name="vf4_object[<?=$k?>]" value="<?=$vf4_object[$k]?>" class="form-control" />
            <p class="text-red">
                <?=__d("custom","vf_message")?>
            </p>
        </td>
    </tr>
</table>


