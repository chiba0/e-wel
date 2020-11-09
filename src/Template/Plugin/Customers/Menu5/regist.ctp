<section class="content" >
    <div class="row ">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body">
                    <h4><i class="fa fa-fw fa-list-ul"></i><?=__d('custom','cmenu5').__('gamen')?></h4>
                    <div class="nav-tabs-custom mt20">
                        <ul class="nav nav-tabs">
                            <li ><a href="/customers/menu5" ><?= __d('custom','wt_tab1') ?></a></li>
                            <li class="active"><a href="/customers/menu5/regist" ><?= __d('custom','wt_tab2') ?></a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="box-header">
                                <h3 class="box-title"></h3>
                            </div><!-- /.box-header -->
                            <!-- form start -->

                            <form role="form" action="/customers/menu5/regist" method="POST" >
                                <div class="box-body">
                                    <label><?=__d("custom","wt_name")?></label><br />
                                    <div class="row">
                                        <div class="col-md-4">
                                            <input type="text" name="master_name" value="<?=$data[ 'master_name' ]?>" class="form-control" />
                                        </div>
                                    </div>
                                    <div class="row mt20">
                                        <div class="col-md-12">
                                            <table class="table table-bordered wt_table">
                                                <tr >
                                                    <th><?=$element[ 'e_feel' ]?></th>
                                                    <th><?=$element[ 'e_cus' ]?></th>
                                                    <th><?=$element[ 'e_aff' ]?></th>
                                                    <th><?=$element[ 'e_cntl' ]?></th>
                                                    <th><?=$element[ 'e_vi' ]?></th>
                                                    <th><?=$element[ 'e_pos' ]?></th>
                                                    <th><?=$element[ 'e_symp' ]?></th>
                                                </tr>
                                                <tr>
                                                    <td><input type="text" class="form-control" name="e_feel" value="<?=$data[ 'e_feel' ]?>" /></td>
                                                    <td><input type="text" class="form-control" name="e_cus" value="<?=$data[ 'e_cus' ]?>" /></td>
                                                    <td><input type="text" class="form-control" name="e_aff" value="<?=$data[ 'e_aff' ]?>" /></td>
                                                    <td><input type="text" class="form-control" name="e_cntl" value="<?=$data[ 'e_cntl' ]?>" /></td>
                                                    <td><input type="text" class="form-control" name="e_vi" value="<?=$data[ 'e_vi' ]?>" /></td>
                                                    <td><input type="text" class="form-control" name="e_pos" value="<?=$data[ 'e_pos' ]?>" /></td>
                                                    <td><input type="text" class="form-control" name="e_symp" value="<?=$data[ 'e_symp' ]?>" /></td>
                                                </tr>
                                                <tr >
                                                    <th><?=$element[ 'e_situ' ]?></th>
                                                    <th><?=$element[ 'e_hosp' ]?></th>
                                                    <th><?=$element[ 'e_lead' ]?></th>
                                                    <th><?=$element[ 'e_vi' ]?></th>
                                                    <th><?=$element[ 'e_adap' ]?></th>
                                                    <th><?=__d("custom","average")?></th>
                                                    <th><?=__d("custom","deviate")?></th>
                                                </tr>
                                                <tr>
                                                    <td><input type="text" class="form-control" name="e_situ" value="<?=$data[ 'e_situ' ]?>" /></td>
                                                    <td><input type="text" class="form-control" name="e_hosp" value="<?=$data[ 'e_hosp' ]?>" /></td>
                                                    <td><input type="text" class="form-control" name="e_lead" value="<?=$data[ 'e_lead' ]?>" /></td>
                                                    <td><input type="text" class="form-control" name="e_vi" value="<?=$data[ 'e_vi' ]?>" /></td>
                                                    <td><input type="text" class="form-control" name="e_adap" value="<?=$data[ 'e_adap' ]?>" /></td>
                                                    <td><input type="text" class="form-control" name="ave" value="<?=$data[ 'ave' ]?>" /></td>
                                                    <td><input type="text" class="form-control" name="sd" value="<?=$data[ 'sd' ]?>" /></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="box-footer">
                                    <button type="submit" class="btn btn-primary" name="regist" value="on" ><?=__("regist")?></button>
                                    <input type="hidden" id="registconf" value="<?=__d("custom","wt_conf")?>" />
                                    <input type="hidden" name="id" value="<?=$id?>" />
                                </div>
                            </form>
                            
                        </div>
                    </div>
                </div>
            </div><!-- /.box -->
        </div>
    </div>
</section>

<script type="text/javascript" >
$(function(){
    $("[name='regist']").click(function(){
        var _val = $("#registconf").val();
        if(confirm(_val)){
            return true;
        }else{
            return false;
        }
    });
});

</script>