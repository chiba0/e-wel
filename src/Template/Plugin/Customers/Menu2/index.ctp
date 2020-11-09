<div class="row">
    <div class="col-md-12">
        
        <h3 class="box-title"><i class="fa fa-list"></i> <?=$pan3?></h3>
    </div>
</div>


<section class="content" >
    <div class="row ">
        
        <div class="col-md-12">
            
            <div class="box" id="lists">

                <div class="box-body">
                    <form action="/customers/menu2/edit" method="POST" enctype="multipart/form-data" >
                    <input type="hidden" name="editid" value="<?=$editid?>" />
                    <table class="table table-bordered " >
                            <tr>
                                <th class="bg-blue fwhite w200p valign">
                                    <?=__("company_name")?>
                                    <small class="label label-danger"><?=__("hissu")?></small>
                                </th>
                                <td>
                                    <input type="text" class="form-control" value="<?=$name?>" name="name" />
                                </td>
                            </tr>
                            <tr>
                                <th class="bg-blue fwhite w200p valign">
                                    <?=__("login_id")?>
                                </th>
                                <td>
                                    <?=$login_id?>
                                    <input type="hidden"  value="<?=$login_id?>" name="login_id" />
                                </td>
                            </tr>
                            <tr>
                                <th class="bg-blue fwhite w200p valign"><?=__("password")?>
                                    <small class="label label-danger"><?=__("hissu")?></small>
                                </th>
                                <td>
                                    <input type="text" name="login_pw" value="<?=$login_pw?>" class="form-control" />
                                    <small><?=__("hankakueisu4")?></small>
                                </td>
                            </tr>
                            
                            <tr>
                                <th class="bg-blue fwhite w200p valign"><?=__("yuubin")?></th>
                                <td>
                                    <div class="row">
                                        <div class="col-md-1">
                                            <input type="text" class="form-control w60p" value="<?=$post1?>" name="post1"  maxlength="3" />
                                        </div>
                                        <div class="col-md-1 w10p text-center  mg0">-</div>
                                        <div class="col-md-1">
                                            <input type="text" class="form-control w80p" value="<?=$post2?>" name="post2"  maxlength="4" />
                                        </div>
                                        <div class="col-md-9 pd-lt60">
                                            <input type="button" class="btn btn-success" name="prefSearch" value="<?=__("search")?>" />
                                        </div>
                                    </div>
                                    <small><?=__("hankakusu")?></small>
                                </td>
                            </tr>

                            <tr>
                                <th class="bg-blue fwhite w200p valign"><?=__("todofuken")?>
                                </th>
                                <td>
                                    <select name="prefecture" class="form-control w200p" >
                                        <?php foreach($D_prefecture as $key=>$val):?>
                                        <?php
                                            $sel = "";
                                            if($prefecture == $val) $sel = "SELECTED";
                                        ?>
                                            <option value="<?=$val?>" <?=$sel?> ><?=$val?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th class="bg-blue fwhite w200p valign"><?=__("jyusyo1")?>
                                </th>
                                <td>
                                    <input type="text" name="address1" class="form-control" value="<?=$address1?>" />
                                </td>
                            </tr>
                            <tr>
                                <th class="bg-blue fwhite w200p valign"><?=__("jyusyo2")?>
                                </th>
                                <td>
                                    <input type="text" name="address2" class="form-control" value="<?=$address2?>" />
                                </td>
                            </tr>
                            <tr>
                                <th class="bg-blue fwhite w200p valign"><?=__("denwabango")?>
                                </th>
                                <td>
                                    <input type="text" name="tel" class="form-control w300p" value="<?=$tel?>" />
                                    <small><?=__("hankakueisu")?></small>
                                </td>
                            </tr>
                            <tr>
                                <th class="bg-blue fwhite w200p valign"><?=__("faxbango")?>
                                </th>
                                <td>
                                    <input type="text" name="fax" class="form-control w300p" value="<?=$fax?>" />
                                    <small><?=__("hankakueisu")?></small>
                                </td>
                            </tr>
                            <tr>
                                <th class="bg-blue fwhite w200p valign"><?=__("jyukensyakeiko")?>
                                </th>
                                <td>
                                    <div class="btn-group" data-toggle="buttons">
                                        <?php 
                                            $chk = $act = "";
                                            if($exam_pattern == 1){$chk="CHECKED"; $act="active";}
                                        ?>
                                        <label class="btn btn-default <?=$act?>">
                                            <input type="radio" name="exam_pattern" value=1 autocomplete="off" <?=$chk?>> <?=__("canuse")?>
                                        </label>
                                        <?php 
                                            $chk = $act = "";
                                            if($exam_pattern == 0){$chk="CHECKED"; $act="active";}
                                        ?>
                                        <label class="btn btn-default <?=$act?>">
                                            <input type="radio" name="exam_pattern" value=0 autocomplete="off"  <?=$chk?> > <?=__("cantuse")?>
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th class="bg-blue fwhite w200p valign"><?=__("csvupload")?>
                                </th>
                                <td>
                                    <div class="btn-group" data-toggle="buttons">
                                        <?php 
                                            $chk = $act = "";
                                            if($csvupload == 1){$chk="CHECKED"; $act="active";}
                                        ?>
                                        <label class="btn btn-default <?=$act?>">
                                            <input type="radio" name="csvupload" value=1 autocomplete="off" <?=$chk?> > <?=__("canuse")?>
                                        </label>
                                        <?php 
                                            $chk = $act = "";
                                            if($csvupload == 0){$chk="CHECKED"; $act="active";}
                                        ?>
                                        <label class="btn btn-default <?=$act?> ">
                                            <input type="radio" name="csvupload" value=0 autocomplete="off" <?=$chk?> > <?=__("cantuse")?>
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th class="bg-blue fwhite w200p valign"><?=__("pdfbutton")?>
                                </th>
                                <td>
                                    <div class="btn-group" data-toggle="buttons">
                                        <?php 
                                            $chk = $act = "";
                                            if($pdf_button == 1){$chk="CHECKED"; $act="active";}
                                        ?>
                                        <label class="btn btn-default <?=$act?>">
                                            <input type="radio" name="pdf_button" value=1 autocomplete="off" <?=$chk?>> <?=__("canuse")?>
                                        </label>
                                        <?php 
                                            $chk = $act = "";
                                            if($pdf_button == 0){$chk="CHECKED"; $act="active";}
                                        ?>
                                        <label class="btn btn-default <?=$act?>">
                                            <input type="radio" name="pdf_button" value=0 autocomplete="off" <?=$chk?> > <?=__("cantuse")?>
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th class="bg-blue fwhite w200p valign"><?=__("pdfmasterstatus")?>
                                </th>
                                <td>
                                    <div class="btn-group" data-toggle="buttons">
                                        <?php 
                                            $chk = $act = "";
                                            if($pdf_master_status == 1){$chk="CHECKED"; $act="active";}
                                        ?>
                                        <label class="btn btn-default <?=$act?>">
                                            <input type="radio" name="pdf_master_status" value=1 autocomplete="off" <?=$chk?>> <?=__("canuse")?>
                                        </label>
                                        <?php 
                                            $chk = $act = "";
                                            if($pdf_master_status == 0){$chk="CHECKED"; $act="active";}
                                        ?>
                                        <label class="btn btn-default <?=$act?>">
                                            <input type="radio" name="pdf_master_status" value=0 autocomplete="off" <?=$chk?> > <?=__("cantuse")?>
                                        </label>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <th class="bg-blue fwhite w200p valign"><?=__("excelmasterstatus")?>
                                </th>
                                <td>
                                    <div class="btn-group" data-toggle="buttons">
                                        <?php 
                                            $chk = $act = "";
                                            if($excel_master_status == 1){$chk="CHECKED"; $act="active";}
                                        ?>
                                        <label class="btn btn-default <?=$act?>">
                                            <input type="radio" name="excel_master_status" value=1 autocomplete="off" <?=$chk?>> <?=__("canuse")?>
                                        </label>
                                        <?php 
                                            $chk = $act = "";
                                            if($excel_master_status == 0){$chk="CHECKED"; $act="active";}
                                        ?>
                                        <label class="btn btn-default <?=$act?>">
                                            <input type="radio" name="excel_master_status" value=0 autocomplete="off" <?=$chk?> > <?=__("cantuse")?>
                                        </label>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <th class="bg-blue fwhite w200p valign"><?=__("cstestbtn")?>
                                </th>
                                <td>
                                    <div class="btn-group" data-toggle="buttons">
                                        <?php 
                                            $chk = $act = "";
                                            if($csTestBtn == 1){$chk="CHECKED"; $act="active";}
                                        ?>
                                        <label class="btn btn-default <?=$act?>">
                                            <input type="radio" name="csTestBtn" value=1 autocomplete="off" <?=$chk?>> <?=__("canuse")?>
                                        </label>
                                        <?php 
                                            $chk = $act = "";
                                            if($csTestBtn == 0){$chk="CHECKED"; $act="active";}
                                        ?>
                                        <label class="btn btn-default <?=$act?>">
                                            <input type="radio" name="csTestBtn" value=0 autocomplete="off" <?=$chk?>> <?=__("cantuse")?>
                                        </label>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <th class="bg-blue fwhite w200p valign"><?=__("ssltype")?>
                                </th>
                                <td>
                                    <div class="btn-group" data-toggle="buttons">
                                        <?php 
                                            $chk = $act = "";
                                            if($ssltype == 1){$chk="CHECKED"; $act="active";}
                                        ?>
                                        <label class="btn btn-default <?=$act?>">
                                            <input type="radio" name="ssltype" value=1 autocomplete="off" <?=$chk?> > <?=__("canuse")?>
                                        </label>
                                        <?php 
                                            $chk = $act = "";
                                            if($ssltype == 0){$chk="CHECKED"; $act="active";}
                                        ?>
                                        <label class="btn btn-default <?=$act?>">
                                            <input type="radio" name="ssltype" value=0 autocomplete="off" <?=$chk?> > <?=__("cantuse")?>
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th class="bg-blue fwhite w200p valign"><?=__("logoImage")?>
                                </th>
                                <td>
                                    <div class="btn-group" >
                                        <input type="file" name="logoImage"  />
                                        <small><?=__("logoImageText")?></small>
                                    </div>
                                    <?php if($logoname): ?>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <img src="/logo/<?=$logoname?>" class="logoimage" />
                                            </div>
                                            <div class="col-md-12">
                                                <input type="checkbox" id="logodelete" name="logodelete" value="on" />
                                                <label for="logodelete"><?=__("logodelete")?></label>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </td>
                            </tr>

                            <tr>
                                <th class="bg-blue fwhite w200p valign"><?=__("privacy")?>
                                </th>
                                <td>
                                    <div class="btn-group" data-toggle="buttons">
                                        <?php 
                                            $chk = $act = "";
                                            if($privacy_flg == 1){$chk="CHECKED"; $act="active";}
                                        ?>
                                        <label class="btn btn-default <?=$act?>">
                                            <input type="radio" name="privacy_flg" value=1 autocomplete="off" <?=$chk?>> <?=__("privacytext")?>
                                        </label>
                                        <?php 
                                            $chk = $act = "";
                                            if($privacy_flg == 0){$chk="CHECKED"; $act="active";}
                                        ?>
                                        <label class="btn btn-default <?=$act?>">
                                            <input type="radio" name="privacy_flg" value=0 autocomplete="off" <?=$chk?>> <?=__("privacytextdefault")?>
                                        </label>
                                        
                                    </div>
                                    <br clear=all />
                                    <small><?=__("privacyexplain")?></small>
                                </td>
                            </tr>
                        </table>
                        
                        <table class="table table-bordered mt20" >
                            <tr>
                                <th class="bg-blue fwhite w200p valign"><?=__("tanto1")?>
                                <small class="label label-danger"><?=__("hissu")?></small>
                                </th>
                                <td>
                                    <input type="text" name="rep_name" value="<?=$rep_name?>" id="rep_name" class="form-control" >
                                </td>
                            </tr>
                            <tr>
                                <th class="bg-blue fwhite w200p valign"><?=__("tanto1address")?>
                                <small class="label label-danger"><?=__("hissu")?></small>
                                </th>
                                <td>
                                    <input type="text" name="rep_email" value="<?=$rep_email?>" id="rep_email" class="form-control" >
                                </td>
                            </tr>
                            <tr>
                                <th class="bg-blue fwhite w200p valign"><?=__("busymei")?>
                                </th>
                                <td>
                                    <input type="text" name="rep_busyo" value="<?=$rep_busyo?>" id="rep_busyo" class="form-control" >
                                </td>
                            </tr>
                            <tr>
                                <th class="bg-blue fwhite w200p valign"><?=__("tantotel")?>
                                </th>
                                <td>
                                    <input type="text" name="rep_tel1" value="<?=$rep_tel1?>" id="rep_tel1" class="form-control" >
                                </td>
                            </tr>
                            <tr>
                                <th class="bg-blue fwhite w200p valign"><?=__("tantotel")?>2
                                </th>
                                <td>
                                    <input type="text" name="rep_tel2" value="<?=$rep_tel2?>" id="rep_tel2" class="form-control" >
                                </td>
                            </tr>
                            
                            <tr>
                                <th class="bg-blue fwhite w200p valign"><?=__("tanto2")?>
                                </th>
                                <td>
                                    <input type="text" name="rep_name2" value="<?=$rep_name2?>" id="rep_name2" class="form-control" >
                                </td>
                            </tr>

                            <tr>
                                <th class="bg-blue fwhite w200p valign"><?=__("tanto2address")?>
                                </th>
                                <td>
                                    <input type="text" name="rep_email2" value="<?=$rep_email2?>" id="rep_email2" class="form-control" >
                                </td>
                            </tr>


                        </table>
                        <div class="mt20" >
                            <input type="button"  id="customer_back" value="<?=__("modoru")?>" class="btn btn-warning" />
                             
                            <input type="submit" name="customer_edit" value="<?=__("edit")?>" class="btn btn-primary" />

                        </div>
                    </form>
                    <input type="hidden" id="customerEditConfirm" value="<?=__("customerEditConfirm")?>" />
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
    </div>
</section>
<script type="text/javascript" >
$(function(){
    //パートナー画面データ登録
    $("input[name='customer_edit']").click(function(){
        var _txt1 = $("#customerEditConfirm").val();
        if(confirm(_txt1)){
            return true;
        }
        return false;
    });
    //戻るボタン
    $("#customer_back").click(function(){
        location.href="/customers/app";
    });
});
</script>