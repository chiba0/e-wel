<section class="content" >
    <form action="/partners/menu6/sets" method="POST" >
        <div class="row ">
            <div class="col-md-12">
                <h4><i class="fa fa-fw fa-list-ul"></i><?=__('pmenu6').__('gamen')?></h4>
                <p><?=__("pmenu6Text1")?></p>
                <div class="box box-solid">
                    
                    <table class="table table-bordered">
                        <tr class="bg-blue">
                            <th class="text-center w60p"><input type="checkbox" id="all" value="on" class="" /></th>
                            <th class="text-center valign"><?=__("pmenu6th2")?></th>
                            <th class="text-center valign"><?=__("pmenu6th3")?></th>
                            <th class="text-center valign"><?=__("pmenu6th4")?></th>
                        </tr>
                        <?php foreach($D_EXAM_BASE as $key=>$value): ?>
                            <?php foreach($value[ 'exam_master' ] as $k=>$val): 
                                $k = $val[ 'key' ];
                                ?>
                                <tr>
                                    <td class="text-center valign">
                                        <?php $chk = "CHECKED";
                                            if(isset($data[$k]) ): 
                                                $chk = ($data[$k][ 'status' ])?"checked":"";
                                            endif; 
                                        ?>
                                        <input type="checkbox" name="status[<?=$k?>]"  value="on" class=" status" <?=$chk?> />
                                    </td>
                                    <td class="text-center">
                                        <?=h($val['name'])?><br />
                                        <small>【<?=$val[ 'jp']?>】</small>
                                    </td>
                                    <td>
                                        <?php
                                        $valdata = $val['name'];
                                        if(isset($data[$k]) ): 
                                            $valdata = $data[$k][ 'dispname' ];
                                        endif; ?>
                                        <input type="text" name="dispname[<?=$k?>]" value="<?=h($valdata)?>"  class="form-control" />
                                    </td>
                                    <td>
                                        <?php
                                            $price = $D_EXAM_PRICE[$k];
                                            if(isset($data[$k]) ): 
                                                $price = (int)$data[$k][ 'dispmoney' ];
                                            endif; ?>
                                        <input type="text" name="dispmoney[<?=$k?>]" value="<?=$price?>"  class="form-control" />
                                    </td>
                                </tr>
                            <?php endforeach;?>
                        <?php endforeach;?>
                    </table>
                        
                    
                    
                </div><!-- /.box -->
            </div>
        </div>
        <div class="row" >
            <div class="col-md-12">
                <input type="button" id="partner_back" value="<?=__("modoru")?>" class="btn btn-warning" />
                <input type="submit" name="regist" value="<?=__("regist")?>" class="btn btn-success" />
            </div>
        </div>
    </form>
    <input type="hidden" id="pmenu6_registConf" value="<?=__("pmenu6_registConf")?>" />
</section>

<script type="text/javascript">
$(function(){
    $("#all").click(function(){
        var _chk = $("#all:checked").val();
        if(_chk == "on"){
            $(".status").prop("checked",true);
        }else{
            $(".status").prop("checked",false);
        }
        
    });
    $("input[name='regist']").click(function(){
        var _val = $("#pmenu6_registConf").val();
        if(confirm(_val)){
            return true;
        }
        return false;
    });
});
</script>