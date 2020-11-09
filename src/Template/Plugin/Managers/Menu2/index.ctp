
<section class="content" >

    <div class="row ">
        <div class="col-md-12">
            <div class="mt10 mb10">
                <h3 class="box-title"><i class="fa fa-fw  fa-user"></i><?=__("menu2")?><?=__("gamen")?></h3>
            </div>
            <form action="" method="POST" >
                <input type="hidden" name="editid" value="<?=h($editid)?>" />
                <div class="box">
                    <div class="box-header ui-sortable-handle">
                        <div class="box-body">
                            <table class="table table-bordered " >
                                <tr>
                                    <th class="bg-blue fwhite w200p valign"><?=__("company_name")?>
                                        <small class="label label-danger"><?=__("hissu")?></small>
                                    </th>
                                    <td>
                                        <input type="text" class="form-control" value="<?=h($name)?>" name="name" />
                                    </td>
                                </tr>
                                <tr>
                                    <th class="bg-blue fwhite w200p valign"><?=__("login_id")?>
                                        <small class="label label-danger"><?=__("hissu")?></small>
                                    </th>
                                    <td>
                                        <input type="text" class="form-control" value="<?=h($login_id)?>" name="login_id" />
                                        <small><?=__("hankakueisu4")?></small>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="bg-blue fwhite w200p valign"><?=__("password")?>
                                        <small class="label label-danger"><?=__("hissu")?></small>
                                    </th>
                                    <td>
                                        <input type="text" class="form-control" value="<?=h($login_pw)?>" name="login_pw" />
                                        <small><?=__("hankakueisu4")?></small>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="bg-blue fwhite w200p valign"><?=__("yuubin")?>
                                    </th>
                                    <td>
                                        <div class="row">
                                            <div class="col-md-1">
                                                <input type="text" class="form-control w60p" value="<?=h($post1)?>" name="post1"  maxlength="3" />
                                            </div>
                                            <div class="col-md-1 w10p text-center pd0 mg0">-</div>
                                            <div class="col-md-1">
                                                <input type="text" class="form-control w80p" value="<?=h($post2)?>" name="post2"  maxlength="4" />
                                            </div>
                                            <div class="col-md-9 pd-lt60">
                                                <input type="button" class="btn btn-success" name="prefSearch" value="<?=__("search")?>" />
                                            </div>
                                        </div>
                                        <small><?=__("hankakueisu")?></small>
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
                                        <input type="text" name="address1" class="form-control" value="<?=h($address1)?>" />
                                    </td>
                                </tr>
                                <tr>
                                    <th class="bg-blue fwhite w200p valign"><?=__("jyusyo2")?>
                                    </th>
                                    <td>
                                        <input type="text" name="address2" class="form-control" value="<?=h($address2)?>" />
                                    </td>
                                </tr>
                                <tr>
                                    <th class="bg-blue fwhite w200p valign"><?=__("denwabango")?>
                                    </th>
                                    <td>
                                        <input type="text" name="tel" class="form-control w300p" value="<?=h($tel)?>" />
                                        <small><?=__("hankakueisu")?></small>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="bg-blue fwhite w200p valign"><?=__("faxbango")?>
                                    </th>
                                    <td>
                                        <input type="text" name="fax" class="form-control w300p" value="<?=h($fax)?>" />
                                        <small><?=__("hankakueisu")?></small>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="bg-blue fwhite w200p valign"><?=__("mousikomikensa")?>
                                    </th>
                                    <td>
                                        <div class="col-md-1 pd0 w20p">
                                            <?php 
                                                $chk = "";
                                                if($ptTestBtn == "on" ) $chk="CHECKED";
                                                ?>
                                            <input type="checkbox" id="ptTestBtn" name="ptTestBtn" class="form-control pd0 mg0" value="on" <?=$chk?> />
                                        </div>
                                        <div class="col-md-11 mt10" >
                                            <label for="ptTestBtn"><?=__("riyousuru")?></label>
                                        </div>
                                    </td>
                                </tr>

                            </table>

                            <table class="table table-bordered mt20" >
                                <tr>
                                    <th class="bg-blue fwhite w200p valign"><?=__("tanto1")?>
                                        <small class="label label-danger"><?=__("hissu")?></small>
                                    </th>
                                    <td>
                                        <input type="text" class="form-control" value="<?=h($rep_name)?>" name="rep_name" />
                                    </td>
                                </tr>
                                <tr>
                                    <th class="bg-blue fwhite w200p valign"><?=__("tanto1address")?>
                                        <small class="label label-danger"><?=__("hissu")?></small>
                                    </th>
                                    <td>
                                        <input type="text" class="form-control" value="<?=h($rep_email)?>" name="rep_email" />
                                        <small><?=__("hankaku")?></small>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="bg-blue fwhite w200p valign"><?=__("tanto2")?>
                                    </th>
                                    <td>
                                        <input type="text" class="form-control" value="<?=h($rep_name2)?>" name="rep_name2" />
                                    </td>
                                </tr>
                                <tr>
                                    <th class="bg-blue fwhite w200p valign"><?=__("tanto2address")?>
                                    </th>
                                    <td>
                                        <input type="text" class="form-control" value="<?=h($rep_email2)?>" name="rep_email2" />
                                        <small><?=__("hankaku")?></small>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="bg-blue fwhite w200p valign"><?=__("tantotel")?>
                                    </th>
                                    <td>
                                        <input type="text" class="form-control" value="<?=h($rep_tel1)?>" name="rep_tel1" />
                                        <small><?=__("hankakusu")?></small>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="bg-blue fwhite w200p valign"><?=__("kanrisystem")?>
                                    </th>
                                    <td>
                                        <div class="col-md-3 pd-lt0">
                                            <input type="text" class="form-control" value="<?=h($logo_name)?>" name="logo_name" />
                                        </div>
                                        <div class="col-md-9 pd-lt0 mt10"><?=__("kanrisystem")?></div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div><!-- /.box -->
                <!--行動価値要素名-->
                <div class="box box-warning">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-10">
                                <?php 
                                    $chk = "";
                                    if($element_status == 1) $chk = "CHECKED"; 
                                ?>
                                <label>
                                    <input type="checkbox" name="element_status" value="1" <?=$chk?> />
                                    <?=__("koudoukatiyousomei")?>
                                </label>
                                <br />
                                <small><?=__("message1")?></small>
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="btn btn-success mb-12" data-toggle="modal" data-target="#modal1"><?=__("yousomeikakunin")?></button>
                            </div>
                        </div>
                    </div>
                </div>
                <!--モーダルウィンドウ行動価値要素名-->
                <div class="modal fade" id="modal1" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
                    <div class="modal-dialog w98">
                        <div class="modal-content">
                            
                            <div class="modal-body">
                                <table class="table table-bordered " >
                                    <tr>
                                        <th class="bg-blue fwhite valign"><?=$D_ELEMENT[0]?></th>
                                        <td><input type="text" class="form-control w300" name="elementText[0]" value="<?=$elementText0?>" /></td>
                                        <th class="bg-blue fwhite valign"><?=$D_ELEMENT[1]?></th>
                                        <td><input type="text" class="form-control w300" name="elementText[1]" value="<?=$elementText1?>" /></td>
                                    </tr>
                                    <tr>
                                        <th class="bg-blue fwhite valign"><?=$D_ELEMENT[2]?></th>
                                        <td><input type="text" class="form-control w300" name="elementText[2]" value="<?=$elementText2?>" /></td>
                                        <th class="bg-blue fwhite valign"><?=$D_ELEMENT[3]?></th>
                                        <td><input type="text" class="form-control w300" name="elementText[3]" value="<?=$elementText3?>" /></td>
                                    </tr>
                                    <tr>
                                        <th class="bg-blue fwhite valign"><?=$D_ELEMENT[4]?></th>
                                        <td><input type="text" class="form-control w300" name="elementText[4]" value="<?=$elementText4?>" /></td>
                                        <th class="bg-blue fwhite valign"><?=$D_ELEMENT[5]?></th>
                                        <td><input type="text" class="form-control w300" name="elementText[5]" value="<?=$elementText5?>" /></td>
                                    </tr>
                                    <tr>
                                        <th class="bg-blue fwhite valign"><?=$D_ELEMENT[6]?></th>
                                        <td><input type="text" class="form-control w300" name="elementText[6]" value="<?=$elementText6?>" /></td>
                                        <th class="bg-blue fwhite valign"><?=$D_ELEMENT[7]?></th>
                                        <td><input type="text" class="form-control w300" name="elementText[7]" value="<?=$elementText7?>" /></td>
                                    </tr>
                                    <tr>
                                        <th class="bg-blue fwhite valign"><?=$D_ELEMENT[8]?></th>
                                        <td><input type="text" class="form-control w300" name="elementText[8]" value="<?=$elementText8?>" /></td>
                                        <th class="bg-blue fwhite valign"><?=$D_ELEMENT[9]?></th>
                                        <td><input type="text" class="form-control w300" name="elementText[9]" value="<?=$elementText9?>" /></td>
                                    </tr>
                                    <tr>
                                        <th class="bg-blue fwhite valign"><?=$D_ELEMENT[10]?></th>
                                        <td><input type="text" class="form-control w300" name="elementText[10]" value="<?=$elementText10?>" /></td>
                                        <th class="bg-blue fwhite valign"><?=$D_ELEMENT[11]?></th>
                                        <td><input type="text" class="form-control w300" name="elementText[11]" value="<?=$elementText11?>" /></td>
                                    </tr>

                                </table>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal"><?=__("close")?></button>
                            </div>
                        </div>
                    </div>
                </div>
                <!--//モーダルウィンドウ-->
                
                <!--会員自動登録の際に出力されるＰＤＦ-->
                <div class="box box-info">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-10">
                                <small><?=__("message3")?></small>
                                <p id="outputPDF"></p>
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="btn btn-success mb-12" data-toggle="modal" data-target="#modal2"><?=__("pdfkakunin")?></button>
                            </div>
                        </div>
                    </div>
                </div>
                <!--モーダルウィンドウ会員自動登録の際に出力されるＰＤＦ-->
                <div class="modal fade" id="modal2" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
                    <div class="modal-dialog w98">
                        <div class="modal-content">
                            <div class="modal-body">
                               <?php $num=0; foreach($D_EXAM_PDF as $lists): 
                                    $key = $lists[ 'key' ];
                                    $value = $lists[ 'name' ];
                                ?>
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <div class="checkbox">
                                                
                                                <?php
                                                    $chk = "";
                                                    
                                                    $outPutPDF = $this->request->getData('outPutPDF');
                                                    if($this->request->is('post')):
                                                        $outPutPDF = $this->request->getData("outPutPDF");
                                                        if(isset($outPutPDF[$key]) && $outPutPDF[$key]):
                                                            $chk="CHECKED";
                                                        endif;
                                                    elseif($valiable):
                                                        if(isset($outputpdfList[$key])):
                                                            $chk="CHECKED";
                                                        endif;
                                                    else:
                                                        if($key == 1) $chk="CHECKED";
                                                        if($key == 5) $chk="CHECKED";
                                                    endif;
                                                ?>
                                                    <input type="hidden" name="outputPDF_hidden[<?=$key?>]" value="on" />
                                                    <label for="outputpdf-<?=$key?>">
                                                    <input type="checkbox" name="outPutPDF[<?=$key?>]" id="outputpdf-<?=$key?>" <?=$chk?> value="1" class="outPutPdf" >
                                                    <?=$value?></label>
                                            </div>
                                        </div><!-- /input-group -->
                                    </div>
                                <?php $num++; endforeach; ?>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal"><?=__("close")?></button>
                            </div>
                        </div>
                    </div>
                </div>
                <!--//モーダルウィンドウ-->

                <!--ライセンス登録数-->
                <div class="box box-primary">
                    <div class="box-body">
                        <?=__("message2")?>
                        <?php $num=0; foreach($D_EXAM_BASE as $value): 
                        
                            $key = $value[ 'name' ];
                           
                            ?>
                        <?php if($num%4 == 0): ?> <div class="row mt10"><?php endif;?>
                        <div class="col-md-3">
                            <table class="table table-bordered ">
                                <tr>
                                    <th colspan=2 class="bg-blue fwhite" ><?=$key?></th>
                                </tr>
                                <?php foreach($value[ 'exam_master' ] as $val): 
                                    $k=$val['key'];
                                    ?>
                                    <tr>
                                        <td class="w100p"><?=$val[ 'name' ]?></td>
                                        <?php 
                                            $elemkey =""; 
                                            if(isset($elem[$k]) && $elem[$k]) $elemkey = $elem[$k]; 
                                        ?>
                                        <td><input type="text" name="elem[<?=$k?>]" value="<?=$elemkey?>" class="form-control " /></td>
                                    </tr>
                                <?php endforeach;?>
                            </table>
                        </div>
                        <?php if($num%4 == 3): ?> </div> <?php endif;?>
                        <?php $num++; endforeach;?>
                        <?php if($num != 3): ?> </div> <?php endif;?>
                    </div>
                </div>

                <!--//ライセンスを登録数-->
                <div class="row">
                    <div class="col-md-12">
                    <input type="submit" class="btn btn-primary" value="<?=__("regist")?>" name="regist"  id="TUserRegist" />
                    <input type="hidden" value="<?=__("confirmRegist")?>"  id="TUserRegistMsg" />
                    </div>
                </div>

            </form>
        </div>
    </div>
</section>