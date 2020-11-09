<section class="content" >

    <div class="row ">
        <div class="col-md-12">
            <h4><i class="fa fa-fw fa-list-ul"></i><?=__('pmenu5').__('gamen')?></h4>
            <div class="box box-solid">
                <div class="box-body ">
                    
                    <p><?=__("pmenu5Text")?></p>

                    <div class="btn-group" data-toggle="buttons">
                        <?php
                            $chk = $act = "";
                            if($user->form_status == 1){ $chk="CHECKED"; $act="active"; }
                        ?>
                        <label class="btn btn-default luse <?=$act?>">
                            
                            <input type="radio" name="use" value=1 autocomplete="off" <?=$chk?> > <?=__("canuse")?>
                        </label>
                        <?php
                            $chk = $act = "";
                            if($user->form_status != 1 ){ $chk="CHECKED"; $act="active"; }
                        ?>
                        <label class="btn btn-default luse <?=$act?>">
                            <input type="radio" name="use" value=0 autocomplete="off"  <?=$chk?> > <?=__("cantuse")?>
                        </label>
                    </div>
                </div>
                
                <div class="overlay" id="hidden1"></div>
                <div class="loading-img" id="hidden2"></div>
                
            </div><!-- /.box -->

            <div class="box box-solid">
                <form action="/partners/menu5/manual" method="POST" enctype="multipart/form-data" >
                    <div class="box-body ">
                        <p><?=__("pmenu5Text2")?></p>
                        <p><?=__("pmenu5Text3")?></p>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="box box-danger">
                                    <div class="box-header">
                                        <i class="fa fa-file-text"></i>
                                        <h4 class=""><?=__("pmenu5Text4")?></h4>
                                    </div>
                                    <div class="box-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <input type="file" name="manual-system" /><br />
                                                
                                                <a href="<?=$manualurl1?>" target=_blank class="btn bg-navy btn-flat btn-sm "><i class="fa fa-download"></i> <?=__("pmenu5pdf1")?></a>
                                                <a href="/partners/menu5/delete/1" class="btn btn-danger btn-flat btn-sm delete"><?=__("syokika")?></a>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="box box-warning">
                                    <div class="box-header">
                                        <i class="fa fa-file-text-o"></i>
                                        <h4 class=""><?=__("pmenu5Text5")?></h4>
                                    </div>
                                    <div class="box-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <input type="file" name="manual-result" />
                                                <br />
                                                <a href="<?=$manualurl2?>" target=_blank class="btn bg-maroon btn-flat btn-sm "><i class="fa fa-download"></i> <?=__("pmenu5pdf2")?></a>
                                                <a href="/partners/menu5/delete/2" class="btn btn-danger btn-flat btn-sm delete"><?=__("syokika")?></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                            
                                <div class="btn-group" data-toggle="buttons">
                                    <p><?=__("pmenu5Text7")?></p>
                                    <?php
                                        $act = $chk = "";
                                        if($user['sendDayStatus'] == 0):
                                            $act = "active";
                                            $chk = "CHECKED";    
                                        endif;
                                    ?>
                                    <label class="btn btn-default btn-flat <?=$act?>">
                                        
                                        <input type="radio" name="sendDayStatus" value=0 autocomplete="off"  <?=$chk?> > <?=__("send_type1")?>
                                    </label>
                                    <?php
                                        $act = $chk = "";
                                        if($user['sendDayStatus']):
                                            $act = "active";
                                            $chk = "CHECKED";    
                                        endif;
                                    ?>
                                    <label class="btn btn-default btn-flat <?=$act?>">
                                        <input type="radio" name="sendDayStatus" value=1 autocomplete="off" <?=$chk?>  > <?=__("send_type2")?>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class=" mt20">
                            <input type="submit" name="manual_regist" value="<?=__("pmenu5Text6")?>" class="btn btn-success" />
                            <input type="hidden" id="manual_regist_conf" value="<?=__("pmenu5Text13")?>" />
                        </div>
                    </div>
                </form>
            </div><!-- /.box -->
            <div class="box box-solid">
                <form action="/partners/menu5/weight" method="POST"  >
                    <div class="box-body ">
                        <p><?=__("pmenu5Text8")?></p>
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th class="bg-blue f11 valign "><?=h($elementText0)?></th>
                                    <th class="bg-blue f11 valign "><?=h($elementText1)?></th>
                                    <th class="bg-blue f11 valign "><?=h($elementText2)?></th>
                                    <th class="bg-blue f11 valign "><?=h($elementText3)?></th>
                                    <th class="bg-blue f11 valign "><?=h($elementText4)?></th>
                                    <th class="bg-blue f11 valign "><?=h($elementText5)?></th>
                                    <th class="bg-blue f11 valign "><?=h($elementText6)?></th>
                                </tr>
                                <tr>
                                    <?php for($i=1;$i<=7;$i++): 
                                        $k="w".$i;
                                        ?>
                                    <td><input type="text" name="w<?=$i?>" value="<?=$weights[$k]?>" class="form-control" /></td>
                                    <?php endfor; ?>
                                </tr>
                                <tr>
                                    <th class="bg-blue f11 valign "><?=h($elementText7)?></th>
                                    <th class="bg-blue f11 valign "><?=h($elementText8)?></th>
                                    <th class="bg-blue f11 valign "><?=h($elementText9)?></th>
                                    <th class="bg-blue f11 valign "><?=h($elementText10)?></th>
                                    <th class="bg-blue f11 valign "><?=h($elementText11)?></th>
                                    <th class="bg-blue f11 valign "><?=__("heikin")?></th>
                                    <th class="bg-blue f11 valign "><?=__("hyojyunhensa")?></th>
                                </tr>
                                <tr>
                                    <?php for($i=8;$i<=12;$i++): 
                                        $k="w".$i;
                                        ?>
                                    <td><input type="text" name="w<?=$i?>" value="<?=$weights[$k]?>" class="form-control" /></td>
                                    <?php endfor; ?>
                                    <td><input type="text" name="ave" value="<?=$weights['ave']?>" class="form-control" /></td>
                                    <td><input type="text" name="sd" value="<?=$weights['sd']?>" class="form-control" /></td>
                                </tr>
                            </tbody>
                        </table>
                        <div class=" mt20">
                            <input type="submit" name="weight_regist" value="<?=__("pmenu5Text8")?>" class="btn btn-success" />
                        </div>
                    </div>
                    
                </form>
            </div><!-- /.box -->
            <div class="box box-solid">
                <form action="/partners/menu5/" method="POST"  >
                    <div class="box-body ">
                        <p><?=__("pmenu5Text9")?></p>
                        <b>Ａ</b>
                        <p><?=__("pmenu5Text10")?></p>
                        <p><?=__("pmenu5Text11")?></p>
                        <input type="text" class="form-control" value="<?=$formUrl?>" readonly />

                        <b>B</b>
                        <p><?=__("pmenu5Text12")?></p>
                        <p><?=__("pmenu5Text11")?></p>
                        <textarea class="form-control" readonly rows=5>
&lt;!--ここからコピー--!&gt;
&lt;a href="<?=$formUrl?>" target=_blank /&gt;
&lt;img src="<?=$url?>ams/images/ams.jpg" /&gt;
</a>
&lt;!--ここまでコピー--!&gt;
                        </textarea>

                    </div>
                </form>
            </div>

            <input type="button"  id="partner_back" value="<?=__("modoru")?>" class="btn btn-warning" />

        </div>
    </div>
</section>
<input type="hidden" id="deletemanualconf" value="<?=__("deletemanualconf")?>" />
<input type="hidden" id="weight_registconf" value="<?=__("weight_registconf")?>" />
<script type="text/javascript">
$(function(){
    $("input[name='weight_regist']").click(function(){
        var _val = $("#weight_registconf").val();
        if(confirm(_val)){
            return true;
        }
        return false;
    });

    $("a.delete").click(function(){
        var _val = $("#deletemanualconf").val();
        if(confirm(_val)){
            return true;
        }
        return false;
    });

    $("#hidden1").css("display","none");
    $("#hidden2").css("display","none");
    $('label.luse').on("click",function(){
        $("#hidden1").css("display","block");
        $("#hidden2").css("display","block");
        var _val = $("input[name='use']").val();
        $.ajax({
            url:'/partners/menu5/formStatus/',
            type:'POST',
            data:{
                'use':_val,
                'post':true
            }
        })
        // Ajaxリクエストが成功した時発動
        .done( (data) => {
            $("#hidden1").css("display","none");
            $("#hidden2").css("display","none");
            
        })
    });

    $("input[name='manual_regist']").click(function(){
        var _text = $("#manual_regist_conf").val();
        if(confirm(_text)){
            return true;
        }
        return false;
    });
});
</script>