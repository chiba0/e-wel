<div class="row">
    <div class="col-lg-3 "><a href="/customers/menu1" class="btn btn-default btn-block bg-maroon fwhite" ><?= __d('custom','cmenu1') ?></a></div>
    <div class="col-lg-3 "><a href="/customers/menu2" class="btn btn-default btn-block bg-maroon fwhite" ><?= __d('custom','cmenu2') ?></a></div>
    <div class="col-lg-3 "><a href="/customers/menu3" class="btn btn-default btn-block bg-maroon fwhite" ><?= __d('custom','cmenu3') ?></a></div>
    <div class="col-lg-3 "><a href="" class="btn btn-default btn-block bg-maroon fwhite" ><?= __d('custom','cmenu4') ?></a></div>
</div>


<div class="row mt10">
    <div class="col-lg-3 "><a href="/customers/menu5" class="btn btn-default btn-block bg-maroon fwhite" ><?= __d('custom','cmenu5') ?></a></div>

    <!--受検者傾向確認-->
    <?php if($user[ 'exam_pattern' ] == 1):?>
        <div class="col-lg-3 "><a href="/customers/menu6" class="btn btn-default btn-block bg-maroon fwhite" ><?= __d('custom','cmenu6') ?></a></div>
    <?php endif;?>

    
</div>




<section class="content mt20" >
    


   
    <div class="row mt20">
        
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header">
                    <h3 class="box-title"><?= __('filter')?></h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                        <form action="/customers/app#lists" method="POST" >
                            <div class="col-md-3">
                                <p><?= __('kensamei')?></p>
                                <input type="text" name="username" value="<?=$this->request->getdata('username')?>" class="form-control"  />
                            </div>

                            <div class="col-md-9">
                                <p>&nbsp;</p>
                                <input type="submit" name="partner_search" class="btn btn-success"   value=<?= __('search');?> />
                            </div>
                        </form>
                    </div>
                </div><!-- /.box-body -->
            </div>
            <div class="box-body" id="lists">
                <div class="row">
                    <div class="col-md-12">
                        <div class="nav-tabs-custom">
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="/customers/app" ><?= __d('custom','ctab1') ?></a></li>
                                <li><a href="/customers/app/lists" ><?= __d('custom','ctab2') ?></a></li>
                            </ul>
                            <div class="tab-content">
                                <div class="row">
                                    <div class="col-md-12">
                                        <ul class="pagination pagination-sm  pull-left mt10 mb10" id="data">
                                            <?php for($i=0;$i<=$ceil;$i++):?>
                                                <li><a href="/customers/app?username=<?=$this->request->getQuery('username')?>&sort=&p=<?=$i?>"><?=$i+1?></a></li>
                                            <?php endfor;?>
                                        </ul>
                                        <table class="table table-bordered">
                                            <tr class="bg-blue">
                                                <th class="text-center"><?=__d("custom","ctable1")?></th>
                                                <th class="text-center"><?=__d("custom","ctable2")?></th>
                                                <th class="text-center"><?=__d("custom","ctable3")?></th>
                                                <th class="text-center"><?=__d("custom","ctable4")?></th>
                                                <th class="text-center"><?=__d("custom","ctable5")?></th>
                                                <th class="text-center"><?=__d("custom","ctable6")?></th>
                                                <th class="text-center"><?=__d("custom","ctable7")?></th>
                                                <th class="text-center"><?=__d("custom","ctable8")?></th>
                                                <th class="text-center"><?=__d("custom","ctable9")?></th>
                                            </tr>
                                            <?php foreach($list as $key=>$val):?>
                                            <tr>
                                                <td><a href="/customers/detail/index/<?=$val[ 'id' ]?>"><?=h($val['name'])?></a></td>
                                                <td class="text-center"><?=h($val['term'])?></td>
                                                <td class="text-right w80p" ><?=h(number_format($val[ 'examcount' ]))?></td>
                                                <td class="text-right w80p" ><?=h(number_format($val[ 'syori' ]))?></td>
                                                <td class="text-right w60p" ><?=h(number_format($val[ 'zan' ]))?></td>
                                                <td class="text-center w80p"><?=h($array_status[$val[ 'status' ]])?></td>
                                                <td class="text-center">
                                                    <a href="/customers/idlist/<?=$val[ 'id' ]?>" class="btn btn-sm btn-primary"><?=__d("custom","cbutton1")?></a>
                                                
                                                    <a href="/customers/menu1/<?=$val[ 'id' ]?>" class="btn btn-sm btn-info"><?=__d("custom","cbutton2")?></a>
                                                
                                                    <a href="" class="btn btn-sm btn-danger"><?=__d("custom","cbutton3")?></a>

                                                    
                                                </td>
                                                <td class="w120p text-center">
                                                    <div class="btn-group-sm btn-group-toggle" data-toggle="buttons">
                                                        <?php
                                                            $chk = $act = "";
                                                            $on = __d("custom","off");
                                                            if($val[ 'send_mail' ] == 1):
                                                                $act = "active";
                                                                $chk = "checked";
                                                                $on = __d("custom","on");
                                                            endif;
                                                        ?>
                                                        <label class="btn send_mail_label <?=$act?>" >
                                                            <input type="checkbox" name="send_mail" id="send_mail-<?=$val[ 'id' ]?>" autocomplete="off" <?=$chk?> >
                                                            <span><?=$on?></span>
                                                        </label>
                                                    </div>
                                                </td>
                                                <td class="w80p text-center">
                                                    <div class="btn-group-sm btn-group-toggle" data-toggle="buttons">
                                                        <?php
                                                            $chk = $act = "";
                                                            $on = __d("custom","clink2");
                                                            if($val[ 'pdf_log_use' ] == 1):
                                                                $act = "active";
                                                                $chk = "checked";
                                                                $on = __d("custom","clink1");
                                                            endif;
                                                        ?>
                                                        <label class="btn  send_pdf_log_label  <?=$act?>">
                                                            <input type="checkbox" name="pdf_log" id="pdf_log-<?=$val[ 'id' ]?>"  autocomplete="off" <?=$chk?> >
                                                            <span><?=$on?></span>
                                                        </label>
                                                    </div>

                                                </td>
                                            </tr>
                                            <tr class="bd">
                                                <td colspan="9">
                                                    [<?=__d("custom","usetest")?>]
                                                    <?=$val[ 'typename' ]?>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </table>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
                
            </div><!-- /.box-body -->
            
        </div>
    </div>
</section>
<input type="hidden" id="sakujyoText" value="<?=__("sakujyoText")?>" />
<script type="text/javascript" >
$(function(){
    $('label.send_mail_label').on("click",function(){
        $('label.send_mail_label').addClass("disabled");

        var _id = $(this).children("input").attr("id").split("-")[1];
        
        if($(this).children("input").prop('checked')){
            _status = 0;
            $(this).children("span").text("<?=__d('custom','off')?>");
        }else{
            _status = 1;
            $(this).children("span").text("<?=__d('custom','on')?>");
        }
        var _data = {
            "id":_id,
            "status":_status
        };
        $.ajax({
            type:"POST",
            url:"/customers/app/sendmailstatus",
            data:_data,
            success:function(data){
                alert("<?=__d('custom','sendmailmessage')?>");
                $('label.send_mail_label').removeClass("disabled");
                
            }

        });
    });
    $('label.send_pdf_log_label').on("click",function(){
        $('label.send_pdf_log_label').addClass("disabled");


        var _id = $(this).children("input").attr("id").split("-")[1];
        
        if($(this).children("input").prop('checked')){
            _status = 0;
            $(this).children("span").text("<?=__d('custom','clink2')?>");
        }else{
            _status = 1;
            $(this).children("span").text("<?=__d('custom','clink1')?>");
        }
        var _data = {
            "id":_id,
            "status":_status
        };
        $.ajax({
            type:"POST",
            url:"/customers/app/pdflogstatus",
            data:_data,
            success:function(data){
                alert("<?=__d('custom','pdflogstatusmessage')?>");
                $('label.send_pdf_log_label').removeClass("disabled");
                
            }

        });
        
    });
});
</script>