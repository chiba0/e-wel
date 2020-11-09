<section class="content" >
    <div class="row ">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body">
                    <h4><i class="fa fa-fw fa-list-ul"></i><?=__d('custom','examupdate').__('gamen')?></h4>

                    <form action="/customers/detail/edit/<?=$id?>" method="post" class="form-inline"> 
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-border" >
                                    <tr>
                                        <th><?=__d("custom","ID")?></th>
                                        <td>
                                            <div class="col-md-12">
                                                <?=$disp[ 'exam_id' ]?>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php
                                        //名前の分割
                                        $ex = explode(" ",preg_replace("/　/"," ",$disp[ 'name' ]));
                                    ?>
                                    <tr>
                                        <th ><?=__d("custom","name")?>
                                        <small class="label label-danger"><?=__("hissu")?></small>
                                        </th>
                                        <td>
                                            <div class="col-md-12">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="sei"><?=__d("custom","sei")?>
                                                        
                                                        </label>
                                                        <input type="text" id="sei" name="sei" value="<?=$ex[0]?>" class="form-control" />
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="mei"><?=__d("custom","mei")?></label>
                                                        <input type="text" id="mei" name="mei" value="<?=$ex[1]?>" class="form-control" />
                                                    </div>
                                                </div>
                                            </div>
                                            
                                        </td>
                                    </tr>
                                    <?php
                                        //フリガナの分割
                                        $ex = [];
                                        $ex = explode(" ",preg_replace("/　/"," ",$disp[ 'kana' ]));
                                    ?>
                                    <tr>
                                        <th ><?=__d("custom","kana_search")?>
                                        <small class="label label-danger"><?=__("hissu")?></small>
                                        </th>
                                        <td>
                                            <div class="col-md-12">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="kana_sei"><?=__d("custom","sei")?></label>
                                                        <input type="text" id="kana_sei" name="kana_sei" value="<?=$ex[0]?>" class="form-control" />
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="kana_mei"><?=__d("custom","mei")?></label>
                                                        <input type="text" id="kana_mei" name="kana_mei" value="<?=$ex[1]?>" class="form-control" />
                                                    </div>
                                                </div>
                                            </div>
                                            
                                        </td>
                                    </tr>
                                    <tr>
                                        <th ><?=__d("custom","birth")?>
                                        <small class="label label-danger"><?=__("hissu")?></small>
                                        </th>
                                        <td>
                                            <?php 
                                                $birth = explode("/",$disp['birth']);
                                            ?>
                                            <div class="form-group">
                                                <input type="text" name="year" value="<?=$birth[0]?>" class="form-control" />
                                                年
                                                <select name="month" class="form-control">
                                                    <?php for($i=1;$i<=12;$i++): 
                                                        $sel = "";
                                                        if($i == $birth[1]) $sel = "SELECTED";
                                                        ?>
                                                        <option value="<?=$i?>" <?=$sel?> ><?=$i?></option>
                                                    <?php endfor;?>
                                                </select>
                                                月
                                                <select name="day" class="form-control">
                                                    <?php for($i=1;$i<=31;$i++): 
                                                        $sel = "";
                                                        if($i == $birth[2]) $sel = "SELECTED";
                                                        ?>
                                                        <option value="<?=$i?>" <?=$sel?> ><?=$i?></option>
                                                    <?php endfor;?>
                                                </select>
                                                日
                                            </div>
                                            
                                        </td>
                                    </tr>
                                    <tr>
                                        <th ><?=__d("custom","gender")?>
                                        <small class="label label-danger"><?=__("hissu")?></small>
                                        </th>
                                        <td>
                                            <div class="btn-group btn-group-toggle" data-toggle="buttons">

                                                <?php 
                                                $act=$chk="";
                                                if($disp['sex'] == 1){
                                                    $act="active";
                                                    $chk="checked";
                                                }
                                                ?>
                                                <label class="btn btn-secondary <?=$act?>">
                                                    <input type="radio" name="gender" value=1 id="gender1" autocomplete="off" <?=$chk?>> <?=$D_GENDER[1]?>
                                                </label>
                                                <?php
                                                    $act=$chk="";
                                                    if($disp['sex'] == 2){
                                                        $act="active";
                                                        $chk="checked";
                                                    }
                                                ?>
                                                <label class="btn btn-secondary <?=$act?>">
                                                    <input type="radio" name="gender" value=2 id="gender2" autocomplete="off" <?=$chk?>> <?=$D_GENDER[2]?>
                                                </label>
                                                
                                            </div>
                                            
                                        </td>
                                    </tr>

                                    <tr>
                                        <th ><?=__d("custom","dlist1")?>
                                        <small class="label label-danger"><?=__("hissu")?></small>
                                        </th>
                                        <td>
                                            <div class="btn-group btn-group-toggle" data-toggle="buttons">

                                                <?php
                                                    $act = $chk = [];
                                                    $act[0]="";
                                                    $act[1]="";
                                                    $act[2]="";
                                                    $chk[0]="";
                                                    $chk[1]="";
                                                    $chk[2]="";
                                                    if($disp['pass'] == $D_PASS[1]){
                                                        $act[1]="active";
                                                        $chk[1]="checked";
                                                    }
                                                    if($disp['pass'] == $D_PASS[2]){
                                                        $act[2]="active";
                                                        $chk[2]="checked";
                                                    }
                                                    if($disp['pass'] == $D_PASS[0]){
                                                        $act[0]="active";
                                                        $chk[0]="checked";
                                                    }
                                                ?>

                                                <label class="btn btn-secondary <?=$act[1]?>">
                                                    <input type="radio" name="pass" id="pass1" autocomplete="off" <?=$chk[1]?> value="<?=$D_PASS[1]?>" > <?=$D_PASS[1]?>
                                                </label>
                                                <label class="btn btn-secondary <?=$act[2]?>">
                                                    <input type="radio" name="pass" id="pass2" autocomplete="off" <?=$chk[2]?> value="<?=$D_PASS[2]?>"  > <?=$D_PASS[2]?>
                                                </label>
                                                <label class="btn btn-secondary <?=$act[0]?>">
                                                    <input type="radio" name="pass" id="pass3" autocomplete="off" <?=$chk[0]?> value="<?=$D_PASS[0]?>" > <?=$D_PASS[0]?>
                                                </label>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <th ><?=__d("custom","memo1")?></th>
                                        <td>
                                            <input type="text" name="memo1" value="<?=$disp[ 'memo1' ]?>" class="form-control w100" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <th ><?=__d("custom","memo2")?></th>
                                        <td>
                                            <input type="text" name="memo2" value="<?=$disp[ 'memo2' ]?>" class="form-control w100" />
                                        </td>
                                    </tr>


                                   
                                </table>
                            </div>
                        </div>
                        <div class="row mt20">
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-success" id="edit" value="on" name="edit" ><?=__("edit")?></button>
                            </div>
                        </div>

                            
                    </form>
                    <input type="hidden" id="edittext" value="<?=$edittext?>" />
                </div>
            </div><!-- /.box -->
        </div>
    </div>
</section>

<script type="text/javascript" >
$(function(){
    $("#edit").click(function(){
        var _txt = $("#edittext").val();
        if(confirm(_txt)){
            return true;
        }else{
            return false;
        }
    });
});

</script>