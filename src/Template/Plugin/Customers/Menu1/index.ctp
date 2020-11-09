



    <section class="content " >
        <div class="box" >
            
            <div class="box-header">
                <h3 class="box-title"><?=__d('custom','cmenu1')?></h3>
            </div>
            <form action="/customers/menu1/" method="POST" id="myform"  enctype="multipart/form-data">
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-bordered">
                                <tr>
                                    <th class="w200p bg-primary" ><?=__("company_name")?></th>
                                    <td><?=h($partner[ 'name' ])?></td>
                                </tr>
                                <tr>
                                    <th class="w200p bg-primary" ><?=__("sale_license")?></th>
                                    <td>
                                        <?=__("all")?>:<?=number_format($license[ 'total' ])?><?=__d("custom","ken")?>
                                        &nbsp;
                                        <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#sale_license">
                                            <?=__("detaile")?>
                                        </button>

                                        <!-- モーダル・ダイアログ -->
                                        <div class="modal fade" id="sale_license" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal"><span>×</span></button>
                                                        <h4 class="modal-title"><?=__("sale_license")?></h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        
                                                        <table class="table table-bordered ">
                                                            <tr class="bg-blue">
                                                                <td><?=__("pmenu6th2")?></td>
                                                                <td><?=__d("custom","kensasu")?></td>
                                                            </tr>
                                                            <?php foreach($license['lists'] as $value):?>
                                                            <tr>
                                                                <td><?=$value[ 'typename' ]?></td>
                                                                <td class="text-right">
                                                                    <?=number_format($value[ 'remain' ])?><?=__d("custom","ken")?>
                                                                </td>
                                                            </tr>
                                                            <?php endforeach;?>
                                                        </table>
                                                        
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-default" data-dismiss="modal"><?=__("close")?></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                    </td>
                                </tr>
                                <tr>
                                    <th class="w200p bg-primary" ><?=__d("custom","customerreg3")?></th>
                                    <td><?=h($user[ 'name' ])?></td>
                                </tr>
                                <tr>
                                    <th class="w200p bg-primary" ><?=__d("custom","customerreg4")?>
                                    <small class="label label-danger"><?=__("hissu")?></small>
                                    </th>
                                    <td>
                                        <input type="text" name="name" class="form-control" value="<?=$name?>" />
                                    </td>
                                </tr>
                                <!--編集の時-->
                                <?php if($id > 0):?>
                                    <tr>
                                        <th class="w200p bg-primary" >
                                        <?=__d("custom","customerreg17")?>/
                                        <?=__d("custom","customerreg18")?>
                                        </th>
                                        <td>
                                        <?=$examcount['examcount']?>名/
                                        <?=$examcount['notexamcount']?>名
                                        </td>
                                    </tr>
                                    <!--受検者数変更-->
                                    <tr>
                                        <th class="w200p bg-primary" >
                                        <?=__d("custom","customerreg19")?>
                                        </th>
                                        <td>
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <input type="text" class="form-control" name="RegNumber" value="" placeholder=0 />
                                                    <input type="hidden" name="number" value="<?=$examcount['examcount']?>" />
                                                </div>
                                                
                                                <div class="col-md-9">
                                                    <select name="exam_type" class="form-control" >
                                                    <?php foreach($D_EXAM_TYPE as $key=>$val): ?>
                                                        <option value="<?=$key?>"><?=__d("custom",$val)?></option>
                                                    <?php endforeach;?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                <small class="text-red"><?=__d("custom","vf_errmsg3")?></small>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                <?php else: ?>
                                    <!--受検者数-->
                                    <tr>
                                        <th class="w200p bg-primary" ><?=__d("custom","customerreg5")?>
                                        <small class="label label-danger"><?=__("hissu")?></small>
                                        </th>
                                        <td>
                                            <input type="text" name="number" class="form-control w80p" value="<?=$number?>" />
                                            <small class="text-red"><?=__("hankakusu")?></small>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                                
                                <tr>
                                    <th class="w200p bg-primary" ><?=__d("custom","customerreg6")?>
                                    </th>
                                    <td>
                                        <input type="text" name="rest_mail_count" class="form-control w80p" value="<?=$rest_mail_count?>" />
                                        <small class="text-red"><?=__("hankakusu")?><?=__d("custom","customerZanmail")?></small>
                                    </td>
                                </tr>
                                <!--
                                <tr>
                                    <th class="w200p bg-primary" ><?=__d("custom","customerreg7")?></th>
                                    <td>
                                        <select name="RegSystem" class="form-control w200p" >
                                        <?php foreach($D_SYSTEM_TYPE as $key=>$value):?>
                                            <option value="<?=$key?>"><?=$value?></option>
                                        <?php endforeach;?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="w200p bg-primary" ><?=__d("custom","customerreg8")?></th>
                                    <td>
                                        <select name="RegSystem" class="form-control w200p" >
                                        <?php foreach($D_LANGUAGE_TYPE as $key=>$value):?>
                                            <option value="<?=$key?>"><?=$value?></option>
                                        <?php endforeach;?>
                                        </select>
                                    </td>
                                </tr>
                                        -->
                                <tr>
                                    <th class="w200p bg-primary" ><?=__d("custom","customerreg9")?>
                                    <small class="label label-danger"><?=__("hissu")?></small>
                                    </th>
                                    <td>
                                        <div >
                                            <input type="text" name="period_from" value="<?=$period_from?>" class="w100p calenderSelect "  />
                                            ～
                                            <input type="text" name="period_to" value="<?=$period_to?>" class="w100p calenderSelect"  />
                                        </div>
                                        
                                    </td>
                                </tr>
                                <tr>
                                    <th class="w200p bg-primary" ><?=__d("custom","customerreg10")?></th>
                                    <td>
                                        <div class="btn-group" data-toggle="buttons">
                                            <?php $act=$chk= "";
                                                if($disp_fin == 1){$act = "active";$chk="checked";}
                                            ?>
                                            <label class="btn btn-default <?=$act?>">
                                                <input type="radio" name="disp_fin" value=1  autocomplete="off" <?=$chk?>> <?=__d("custom","customerResultDispON")?>
                                            </label>
                                            <?php $act=$chk= "";
                                                if($disp_fin == 0){$act = "active";$chk="checked";}
                                                
                                            ?>
                                            <label class="btn btn-default <?=$act?>">
                                                <input type="radio" name="disp_fin" value=0  autocomplete="off" <?=$chk?> > <?=__d("custom","customerResultDispOFF")?>
                                            </label>
                                        </div>
                                        <br />
                                        <small class="text-red"><?=__d("custom","customerResultDispMSG")?></small>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="w200p bg-primary" ><?=__d("custom","customerreg11")?></th>
                                    <td>
                                        <div class="btn-group" data-toggle="buttons">
                                            <?php $act=$chk= "";
                                                if($judge_login == 1){$act = "active";$chk="checked";}
                                            ?>

                                            <label class="btn btn-default <?=$act?>">
                                                <input type="radio" name="judge_login" value=1  autocomplete="off" <?=$chk?>> <?=__d("custom","customerJudgeDispON")?>
                                            </label>
                                            <?php $act=$chk= "";
                                                if($judge_login == 0){$act = "active";$chk="checked";}
                                            ?>
                                            <label class="btn btn-default <?=$act?>">
                                                <input type="radio" name="judge_login" value=0  autocomplete="off" <?=$chk?>> <?=__d("custom","customerJudgeDispOFF")?>
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="w200p bg-primary" ><?=__d("custom","customerreg12")?></th>
                                    <td>
                                        <div class="btn-group" data-toggle="buttons">
                                            <?php $act=$chk= "";
                                                if($enq_status == 1) $act = "active";$chk="checked";
                                            ?>
                                            <label class="btn btn-default <?=$act?>">
                                                <input type="radio" name="enq_status" value=1  autocomplete="off" <?=$chk?>> <?=__d("custom","customerEnqDispON")?>
                                            </label>

                                            <?php $act=$chk= "";
                                                if($enq_status == 0){$act = "active";$chk="checked";}
                                            ?>
                                            <label class="btn btn-default <?=$act?>">
                                                <input type="radio" name="enq_status" value=0  autocomplete="off" <?=$chk?>> <?=__d("custom","customerEnqDispOFF")?>
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="w200p bg-primary" ><?=__d("custom","customerreg13")?></th>
                                    <td>
                                        <div class="btn-group" data-toggle="buttons">
                                            <?php $act=$chk= "";
                                                if($pdf_slice == 1){$act = "active";$chk="checked";}
                                            ?>
                                            <label class="btn btn-default <?=$act?>">
                                                <input type="radio" name="pdf_slice" value=1  autocomplete="off" <?=$chk?>> <?=__d("custom","customerPDFDispON")?>
                                            </label>
                                            <?php $act=$chk= "";
                                                if($pdf_slice == 0){$act = "active";$chk="checked";}
                                            ?>
                                            <label class="btn btn-default <?=$act?>">
                                                <input type="radio" name="pdf_slice" value=0  autocomplete="off" <?=$chk?>> <?=__d("custom","customerPDFDispOFF")?>
                                            </label>
                                        </div>
                                        <br />
                                        <small class="text-red"><?=__d("custom","pdf_slice_msg")?></small>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="w200p bg-primary" ><?=__d("custom","customerreg14")?></th>
                                    <td>
                                        <div class="btn-group" data-toggle="buttons">
                                            <?php $act=$chk= "";
                                                if($recommen == 1){$act = "active";$chk="checked";}
                                            ?>
                                            <label class="btn btn-default <?=$act?>">
                                                <input type="radio" name="recommen" value=1  autocomplete="off" <?=$chk?>> <?=__d("custom","customerEnqDispON")?>
                                            </label>
                                            <?php $act=$chk= "";
                                                if($recommen == 0){$act = "active";$chk="checked";}
                                            ?>
                                            <label class="btn btn-default <?=$act?> ">
                                                <input type="radio" name="recommen" value=0  autocomplete="off" <?=$chk?>> <?=__d("custom","customerEnqDispOFF")?>
                                            </label>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <th class="w200p bg-primary" ><?=__d("custom","customerreg15")?></th>
                                    <td>
                                        <div class="btn-group" data-toggle="buttons">
                                            <?php
                                                $act=$chk= "";    
                                                if($loginDisp == 1){$act = "active";$chk="checked";}
                                            ?>
                                            <label class="btn btn-default <?=$act?>">
                                                <input type="radio" name="loginDisp" value=1  autocomplete="off" <?=$chk?>> <?=__d("custom","customerLoginDispON")?>
                                            </label>
                                            <?php $act=$chk= "";
                                                $disable = "";
                                                if($loginDisp == 0){
                                                    $act = "active";
                                                    $chk="checked";
                                                    $disable="readonly";
                                                }
                                            ?>
                                            <label class="btn btn-default <?=$act?>">
                                                <input type="radio" name="loginDisp" value=0  autocomplete="off" <?=$chk?> > <?=__d("custom","customerLoginDispOFF")?>
                                            </label>
                                        </div>

                                        <textarea name="explain" class="form-control mt10" rows=6 <?=$disable?> ><?=$explain?></textarea>
                                        
                                        <small class="text-red"><?=__d("custom","customerLoginExplain1")?></small><br />
                                        <small class="text-red"><?=__d("custom","customerLoginExplain2")?></small>
                                    </td>
                                </tr>
                            </table>

                        </div>
                    </div>

                    <div class="row mt20">
                        <div class="col-md-12">
                            <!-- Warning box -->
                            <div class="box box-solid box-warning">
                                <div class="box-header">
                                    <h3 class="box-title"><?=__d("custom","customerreg16")?></h3>
                                    
                                </div>
                                <div class="box-body bg-seashell">
                                    <p><?=__d("custom","customerreg16Text1")?></p>
                                    
                                    <div class="row">
                                        <div class="col-md-2">
                                            <b><?=__d("custom","customerreg16Text2")?></b>
                                        </div>
                                        <div class="col-md-3">
                                            
                                            <div class="btn-group" data-toggle="buttons">
                                                <?php $act=$chk= "";
                                                    if($pdf_output_limit == 1){
                                                        $act = "active";
                                                        $chk="checked";
                                                    }
                                                ?>
                                                <label class="btn btn-default <?=$act?>">
                                                    <input type="radio" name="pdf_output_limit" value=1  autocomplete="off" <?=$chk?>> <?=__d("custom","customerreg16use")?>
                                                </label>
                                                <?php $act=$chk= "";
                                                    if($pdf_output_limit == 0){
                                                        $act = "active";
                                                        $chk="checked";
                                                    }
                                                ?>
                                                <label class="btn btn-default <?=$act?>">
                                                    <input type="radio" name="pdf_output_limit" value=0  autocomplete="off" <?=$chk?>> <?=__d("custom","customerreg16no")?>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col-md-2 text-right">
                                            <b><?=__d("custom","customerreg16Text3")?></b>
                                        </div>
                                        <div class="col-md-5">
                                        
                                            <input type="text" name="pdf_output_limit_from" value="<?=$pdf_output_limit_from?>" class="w100p calenderSelect "  />
                                            ～
                                            <input type="text" name="pdf_output_limit_to" value="<?=$pdf_output_limit_to?>" class="w100p calenderSelect"  />
                                            <br />
                                            <small class="text-red"><?=__d("custom","customerreg16Text4")?></small>
                                        </div>
                                </div>
                                <hr />
                                <div class="row mt10">
                                        <div class="col-md-2">
                                            <b><?=__d("custom","customerreg16Text5")?></b>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="btn-group" data-toggle="buttons">
                                                <?php $act=$chk= "";
                                                    if($pdf_output_limit_count == 1){
                                                        $act = "active";
                                                        $chk="checked";
                                                    }
                                                ?>
                                                <label class="btn btn-default <?=$act?>">
                                                    <input type="radio" name="pdf_output_limit_count" value=1  autocomplete="off" <?=$chk?>> <?=__d("custom","customerreg16use")?>
                                                </label>
                                                <?php $act=$chk= "";
                                                    if($pdf_output_limit_count == 0){
                                                        $act = "active";
                                                        $chk="checked";
                                                    }
                                                ?>
                                                <label class="btn btn-default <?=$act?>">
                                                    <input type="radio" name="pdf_output_limit_count" value=0  autocomplete="off" <?=$chk?>> <?=__d("custom","customerreg16no")?>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-2 text-right">
                                            <b><?=__d("custom","customerreg16Text6")?></b>
                                        </div>
                                        <div class="col-md-1">
                                            <input type="text" name="pdf_output_count" value="<?=$pdf_output_count?>" class="form-control "  maxlength="4" />
                                        </div>
                                        <div class="col-md-1 ">
                                            <p class="ml_20 mt10"><?=__d("custom","mei")?></p>
                                        </div>
                                </div>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div>
                    </div>

                    <div class="row mt20">
                        <div class="col-md-12">
                            <!-- Success box -->
                            <div class="box box-solid box-info">
                                <div class="box-header">
                                    <h3 class="box-title"><?=__d('custom','customerreg16Text8')?></h3>
                                </div>
                                <div class="box-body bg-lavender">
                                    <p><?=__d('custom','customerreg16Text9')?></p>
                                    <p><?=__d('custom','customerreg16Text10')?></p>
                                    <?php foreach($D_EXAM_BASE as $key=>$values):?>
                                    <?php 
                                        //在庫のあるもののみ検査の対象にする
                                        if(isset($examGroup[ $values['group_id'] ]) && 
                                        $examGroup[ $values['group_id'] ]): ?>
                                        <h2 class="page-header"><?=$values[ 'name' ]?>(<?=$values[ 'jp' ]?>)</h2>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <!-- Custom Tabs -->
                                                <div class="nav-tabs-custom">
                                                    <ul class="nav nav-tabs">
                                                        <?php 
                                                        $selectTypeValue = "";
                                                        foreach($values[ 'exam_master' ] as $value):
                                                            
                                                            $active = "";
                                                            if(in_array($value['key'],$typegroup,true)){
                                                                $active = "active";
                                                                $selectTypeValue = $value[ 'key' ];
                                                            }
                                                            
                                                            ?>
                                                        <li class="bg-smoke <?=$active?>"><a href="#<?=$value['key']?>" data-toggle="tab" class="tab" id="tab-<?=$values[ 'group_id' ]?>-<?=$value[ 'key' ]?>"  ><?=$value[ 'name' ]?></a>
                                                        </li>
                                                        <?php endforeach;?>
                                                        <li class="bg-smoke"><a href="#del<?=$value['key']?>" data-toggle="tab" class="tab" id="tab-<?=$values[ 'group_id' ]?>-0"><?=__d("custom","misentaku")?></a></li>
                                                        
                                                    </ul>
                                                    <?php 
                                                        if(!$selectTypeValue){
                                                            $selectTypeValues = $this->request->getData('selectType');
                                                            $selectTypeValue = $selectTypeValues[$values[ 'name' ]];
                                                        }
                                                    ?>
                                                    <input type="hidden" name="selectType[<?=$values[ 'name' ]?>]"  value="<?=$selectTypeValue?>" id="selectType_<?=$values['group_id']?>" class="selectType" />
                                                    


                                                    <div class="tab-content">
                                                        <?php foreach($values[ 'exam_master' ] as $value):
                                                            $active = "";
                                                            if(in_array($value['key'],$typegroup,true)){
                                                                $active = "active";
                                                            }
                                                            
                                                            ?>
                                                            <div class="tab-pane <?=$active?>" id="<?=$value['key']?>">
                                                                <?=$this->element("Exam/".$values[ 'name' ],['value'=>$value]);?>
                                                            </div><!-- /.tab-pane -->
                                                            <div class="tab-pane" id="del<?=$value['key']?>">
                                                            </div>
                                                        <?php endforeach;?>
                                                    </div><!-- /.tab-content -->
                                                </div><!-- nav-tabs-custom -->
                                            </div><!-- /.col -->
                                        </div>
                                    <?php endif;?>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!--PDF出力形式選択-->
                    <div class="row mt20 ">
                        <div class="col-md-12 ">
                            <!-- Success box -->
                            <div class="box box-solid box-success">
                                <div class="box-header">
                                    <h3 class="box-title"><?=__d('custom','customerreg16Text7')?></h3>
                                    
                                </div>
                                <div class="box-body bg-lightyellow">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <!-- Default box -->
                                            <div class="box">
                                                <div class="box-header">
                                                    <h3 class="box-title"><?=h($pdf_group_data[0][ 'name' ])?></h3>
                                                    <br clear=all />
                                                    <?php 
                                                        foreach($pdf_group_data[0][ 'pdf_exam_master' ] as $value):
                                                        $key = $value[ 'key' ];
                                                       
                                                        ?>
                                                        
                                                        <div class="col-md-4">
                                                            <dl>    
                                                                <dt>
                                                                <?php
                                                                    $chk = "";
                                                                    if(isset($pdf[$key]) && $pdf[$key] == "on"){
                                                                        $chk="checked";
                                                                    }
                                                                ?>
                                                                <input type="checkbox" name="pdf[<?=$key?>]" value="on" id="pdf-<?=$key?>" <?=$chk?> /></dt>
                                                                <dd><label for="pdf-<?=$key?>"><?=$value[ 'name' ]?></label></dd>
                                                            </dl>
                                                        </div>
                                                    <?php endforeach;?>
                                                    
                                                </div>
                                                <div class="box-body">
                                                    
                                                </div><!-- /.box-body -->
                                            </div><!-- /.box -->
                                        </div>
                                    </div>
                                    <div class="row mt10">
                                        <?php for($i=1;$i<count($pdf_group_data);$i++):?>
                                        <div class="col-md-6">
                                            <!-- Default box -->
                                            <div class="box">
                                                <div class="box-header">
                                                    <h3 class="box-title"><?=$pdf_group_data[$i][ 'name' ]?></h3>
                                                    <br clear=all />
                                                    <?php
                                                        foreach($pdf_group_data[$i][ 'pdf_exam_master' ] as $value ):
                                                            
                                                            $key = $value[ 'key' ];
                                                        ?>
                                                        <div class="col-md-12">
                                                            <dl>    
                                                                <dt>
                                                                <?php
                                                                    $chk = "";
                                                                    if(isset($pdf[$key]) && $pdf[$key] == "on") $chk="checked";
                                                                ?>    
                                                                <input type="checkbox" name="pdf[<?=$key?>]" value="on" id="pdf-<?=$key?>" <?=$chk?> /></dt>
                                                                <dd><label for="pdf-<?=$key?>"><?=$value[ 'name' ]?></label></dd>
                                                            </dl>
                                                        </div>
                                                    <?php endforeach;?>
                                                </div>
                                            </div><!-- /.box -->
                                        </div>
                                        <?php if($i%2 == 0 ): ?>
                                            <br clear=all />
                                        <?php endif;?>
                                        <?php endfor;?>

                                        
                                    </div>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div>
                    </div>


                    

                    <input type="button" name="back" value="<?=__("modoru")?>" class="btn btn-warning" />
                    
                    <?php 
                        $text = __("regist");
                        if($id){$text = __("edit");}
                    ?>
                    <input type="submit" name="regist" value="<?=$text?>" class="btn btn-primary" />
                    
                    <input type="hidden" name="id" value="<?=$id?>" />
                </div>
            </form>
        </div><!-- /.box-body -->  
    </section>
    <input type="hidden" id="backtext" value="<?=__d("custom","backtext")?>" />
    <input type="hidden" id="registtext" value="<?=__d("custom","registtext")?>" />
    <input type="hidden" id="edittext" value="<?=__d("custom","edittext")?>" />
<script type="text/javascript" > 
$(function(){
    /***************************
    *登録ボタン
     */
    $("input[name='regist']").on("click",function(){
        var _id = $("input[name='id']").val();
        var _text ="";
        if(_id){
            //更新
            _text = $("#edittext").val();
        }else{
            //登録
            _text = $("#registtext").val();
        }
        if(confirm(_text)){
            return true;
        }
        return false;
    });
    /*************************
    *戻るボタン
     */
    $("input[name='back']").on("click",function(){
        var _backtext = $("#backtext").val();
        if(confirm(_backtext)){
            location.href="/customers/app/";
        }
        return false;
    });
    /**********************************
    *タブ選択
    */
    $("a.tab").on("click",function(){
        var _id = $(this).attr("id").split("-");
        var _key = _id[2];
        var _group = "selectType_"+_id[1];
        $("#"+_group).val(_key);
        return true;
    });

    /*******************************
    *タブ初期選択
     */
    $(".selectType").each(function(key,value){
        var _key = "";
        if($(this).val() > 0 ){
            _key = $(this).val();
            $("div#"+_key).addClass("active");
        }
    });

    /*************
    受検者数表示
     */
     $("input[name='number']").on("change",function(){
        var _val = $(this).val();
        $("span.examcount").text(_val);
        return true;
     });
    /***********************
    重みマスタからデータ取得
    *********************/
    $(".weightSelect").change(function(){
        var _id = $(this).attr("id");
        var _val = $(this).val();
        if(!_val){
            $("."+_id).val('');
        }else{
            $("."+_id).val('loading・・・');

        }
        var data = {};
        $.ajax({
            type: 'POST',
            datatype:'json',
            url: "/customers/menu1/getWeightMaster/"+_val,
            data: data,
            success: function(data,dataType)
            {   
                $("#"+_id+"_w1").val(data[ 'e_feel' ]);
                $("#"+_id+"_w2").val(data[ 'e_cus' ]);
                $("#"+_id+"_w3").val(data[ 'e_aff' ]);
                $("#"+_id+"_w4").val(data[ 'e_cntl' ]);
                $("#"+_id+"_w5").val(data[ 'e_vi' ]);
                $("#"+_id+"_w6").val(data[ 'e_pos' ]);
                $("#"+_id+"_w7").val(data[ 'e_symp' ]);
                $("#"+_id+"_w8").val(data[ 'e_situ' ]);
                $("#"+_id+"_w9").val(data[ 'e_hosp' ]);
                $("#"+_id+"_w10").val(data[ 'e_lead' ]);
                $("#"+_id+"_w11").val(data[ 'e_ass' ]);
                $("#"+_id+"_w12").val(data[ 'e_adap' ]);
                $("#"+_id+"_ave").val(data[ 'avg' ]);
                $("#"+_id+"_sd").val(data[ 'hensa' ]);
            },
            /**
             * Ajax通信が失敗した場合に呼び出されるメソッド
             */
            error: function(XMLHttpRequest, textStatus, errorThrown)
            {
                //alert('Error : ' + errorThrown);
            }
        });
        return false;
    });
});
</script>