<?php
    $k = $value['key'];
?>
<table class="table table-bordered">
    <tr>
        <th class="w300p bg-blue"><?=__d("custom","taisyokensa")?></th>
        <td><?=$value[ 'name' ]?></td>
        <th class="w300p bg-blue"><?=__d("custom","jyukensyasu")?></th>
        <td><span class="examcount"><?=$jyukensasu?></span><?=__d("custom","mei")?></td>
    </tr>
    <tr>
        <th class="bg-blue" ><?=__d("custom","threeElement")?></th>
        <td colspan=3 >
            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                    <?php 
                    $chk = $act = "";
                        if(isset($childtest[$k][ 'stress_flg' ]) 
                        && $childtest[$k][ 'stress_flg' ] == "1"
                        ){
                            $chk = "checked";
                            $act = "active";   
                        }
                        if($stress[$k] == "1" && empty($childtest) ){
                            $chk = "checked";
                            $act = "active";
                        }
                        
                    ?>
                <label class="btn btn-default <?=$act?>">
                    <input type="radio" name="stress[<?=$k?>]"  value="1" autocomplete="off" <?=$chk?> >
                    <?=__d("custom","customerreg16use")?>
                </label>
                    <?php 
                        $chk = $act = "";
                        if(
                            isset($childtest[$k][ 'stress_flg' ]) && 
                            $childtest[$k][ 'stress_flg' ] == "0"){
                            $chk = "checked";
                            $act = "active";
                        }
                        if(empty($childtest[$k][ 'stress_flg' ])){
                            if($stress[$k] == "0" || empty($stress[$k])  ){
                                $chk = "checked";
                                $act = "active";
                            }
                        }
                    ?>
                <label class="btn btn-default <?=$act?>">
                    <input type="radio" name="stress[<?=$k?>]" value="0"  autocomplete="off" <?=$chk?>>
                    <?=__d("custom","customerreg16no")?>
                </label>
            </div>
        </td>
    </tr>
</table>


<div class="box box-info mt20">
    <div class="box-body">
        <div class="btn-group btn-group-toggle" data-toggle="buttons">
            <?php 
                $chk = $act = "";
                if(isset($childtest[$k][ 'weight' ])){
                    if($childtest[$k]['weight'] == 1){
                        $chk = "checked";
                        $act = "active";
                    }
                }else{
                    if($weightchecked[$k] == "1" ){
                        $chk = "checked";
                        $act = "active";
                    }
                }
                
            ?>
            <label class="btn btn-default <?=$act?>">
                <input type="radio" name="weightchecked[<?=$k?>]"  value="1" autocomplete="off" <?=$chk?>>
                <?=__d("custom","weightuse")?>
            </label>

            <?php 
                $chk = $act = "";
                if(isset($childtest[$k][ 'weight' ])){
                    if($childtest[$k]['weight'] == 0){
                        $chk = "checked";
                        $act = "active";
                    }
                }else{
                    if($weightchecked[$k] == "0" || empty($weightchecked[$k]) ){
                        $chk = "checked";
                        $act = "active";
                    }
                }
                
            ?>
            <label class="btn btn-default <?=$act?>">
                <input type="radio" name="weightchecked[<?=$k?>]" value="0" autocomplete="off" <?=$chk?>>
                <?=__d("custom","weightnotuse")?>
            </label>
        </div>
        <p>
            <small class="text-red">
                <?=__d("custom","bajMessage1")?>
                <?=__d("custom","bajMessage2")?><br />
                <?=__d("custom","bajMessage3")?>
            </small>
        </p>
        <div class="row">
            <div class="col-md-6">
                <b><?=__d("custom","bjweight1")?></b>
                <select class="form-control w80 weightSelect" name="masters[<?=$k?>]" id="weight_<?=$k?>" >
                    <option value="" >-</option>
                    <?php foreach($weight_master as $value): 
                        $sel = "";
                        if($masters[$k] == $value[ 'id' ] ) $sel = "SELECTED";
                        ?>
                        <option value="<?=$value[ 'id' ]?>" <?=$sel?>><?=$value[ 'master_name' ]?></option>
                    <?php endforeach;?>
                </select>
            </div>

        </div>
        <div class="row mt10">
            <div class="col-md-12">
            <?php
                for($i=1;$i<=12;$i++):
                    $w = "w".$i;
                    if(isset( $childtest[$k][$w]) ){ $weight[$k][$w] = $childtest[$k][$w]; }
                endfor;
                if(isset( $childtest[$k]['ave']) ){ $weight[$k]['ave'] = $childtest[$k]['ave']; }
                if(isset( $childtest[$k]['sd']) ){ $weight[$k]['sd'] = $childtest[$k]['sd']; }

            ?>
                <table class="table table-bordered fixed">
                    <tr>
                        <th class="bg-olive"><?=$element->e_feel?></th>
                        <th class="bg-olive"><?=$element->e_cus?></th>
                        <th class="bg-olive"><?=$element->e_aff?></th>
                        <th class="bg-olive"><?=$element->e_cntl?></th>
                        <th class="bg-olive"><?=$element->e_vi?></th>
                        <th class="bg-olive"><?=$element->e_pos?></th>
                        <th class="bg-olive"><?=$element->e_symp?></th>
                    </tr>
                    <tr>
                        <td><input type="text" name="weight[<?=$k?>][w1]" id="weight_<?=$k?>_w1" value="<?=$weight[$k]['w1']?>" class="form-control weight_<?=$k?>" /></td>
                        <td><input type="text" name="weight[<?=$k?>][w2]" id="weight_<?=$k?>_w2" value="<?=$weight[$k]['w2']?>" class="form-control weight_<?=$k?>" /></td>
                        <td><input type="text" name="weight[<?=$k?>][w3]" id="weight_<?=$k?>_w3" value="<?=$weight[$k]['w3']?>" class="form-control weight_<?=$k?>" /></td>
                        <td><input type="text" name="weight[<?=$k?>][w4]" id="weight_<?=$k?>_w4" value="<?=$weight[$k]['w4']?>" class="form-control weight_<?=$k?>" /></td>
                        <td><input type="text" name="weight[<?=$k?>][w5]" id="weight_<?=$k?>_w5" value="<?=$weight[$k]['w5']?>" class="form-control weight_<?=$k?>" /></td>
                        <td><input type="text" name="weight[<?=$k?>][w6]" id="weight_<?=$k?>_w6" value="<?=$weight[$k]['w6']?>" class="form-control weight_<?=$k?>" /></td>
                        <td><input type="text" name="weight[<?=$k?>][w7]" id="weight_<?=$k?>_w7" value="<?=$weight[$k]['w7']?>" class="form-control weight_<?=$k?>" /></td>
                    </tr>

                    <tr>
                        <th class="bg-olive"><?=$element->e_situ?></th>
                        <th class="bg-olive"><?=$element->e_hosp?></th>
                        <th class="bg-olive"><?=$element->e_lead?></th>
                        <th class="bg-olive"><?=$element->e_ass?></th>
                        <th class="bg-olive"><?=$element->e_adap?></th>
                        <th class="bg-olive"><?=__d("custom","average")?></th>
                        <th class="bg-olive"><?=__d("custom","deviate")?></th>
                    </tr>
                    <tr>
                        <td><input type="text" name="weight[<?=$k?>][w8]" id="weight_<?=$k?>_w8" value="<?=$weight[$k]['w8']?>" class="form-control weight_<?=$k?>" /></td>
                        <td><input type="text" name="weight[<?=$k?>][w9]" id="weight_<?=$k?>_w9" value="<?=$weight[$k]['w9']?>" class="form-control weight_<?=$k?>" /></td>
                        <td><input type="text" name="weight[<?=$k?>][w10]" id="weight_<?=$k?>_w10" value="<?=$weight[$k]['w10']?>" class="form-control weight_<?=$k?>" /></td>
                        <td><input type="text" name="weight[<?=$k?>][w11]" id="weight_<?=$k?>_w11" value="<?=$weight[$k]['w11']?>" class="form-control weight_<?=$k?>" /></td>
                        <td><input type="text" name="weight[<?=$k?>][w12]" id="weight_<?=$k?>_w12" value="<?=$weight[$k]['w12']?>" class="form-control weight_<?=$k?>" /></td>
                        <td><input type="text" name="weight[<?=$k?>][ave]" id="weight_<?=$k?>_ave" value="<?=$weight[$k]['ave']?>" class="form-control weight_<?=$k?>" /></td>
                        <td><input type="text" name="weight[<?=$k?>][sd]" id="weight_<?=$k?>_sd"  value="<?=$weight[$k]['sd']?>" class="form-control weight_<?=$k?>" /></td>
                    </tr>
                </table>

            </div>
        </div>
    </div>
</div>

