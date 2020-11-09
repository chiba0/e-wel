<section class="content" >
    <div class="row ">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body">
                    <h4><i class="fa fa-fw fa-list-ul"></i><?=__d('custom','cmenu5').__('gamen')?></h4>
                    <div class="nav-tabs-custom mt20">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="/customers/menu5" ><?= __d('custom','wt_tab1') ?></a></li>
                            <li><a href="/customers/menu5/regist" ><?= __d('custom','wt_tab2') ?></a></li>
                        </ul>


                        
                        <div class="tab-content">
                            <div class="row">
                                <div class="col-md-4">
                                    <h4><?=__("filter")?></h4>
                                </div>
                            </div>
                            
                            <div class="row">
                                <form action="/customers/menu5" method="post" > 
                                    <div class="col-md-4">
                                        <input type="text" name="search_text" value="<?=$this->request->getData('search_text')?>" class="form-control" />    
                                    </div>
                                    <div class="col-md-2">
                                        <button type="submit" class="btn btn-success" name="search_button" ><?=__("search")?></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        

                        <div class="tab-content">
                            
                            
                            <div class="row mt20">
                                <div class="col-md-12">
                                    <table class="table table-bordered">
                                        <tr class="bg-blue">
                                            <th class="w70"><?=__d("custom","wt_master_name")?></th>
                                            <th><?=__d("custom","wt_master_date")?></th>
                                            <th><?=__d("custom","wt_master_status")?></th>
                                        </tr>
                                        <?php foreach($data as $values):?>
                                            <tr>
                                                <td ><?=$values[ 'master_name' ]?></td>
                                                <td><?=$values[ 'update_ts' ]?></td>
                                                <td class="text-center">
                                                    <a href="/customers/menu5/regist/<?=$values['id']?>" class="btn btn-warning"><?=__("edit")?></a>
                                                    <a href="/customers/menu5/delete/<?=$values[ 'id' ]?>" class="btn btn-danger deleteconf"><?=__("sakujyo")?></a>
                                                </td>
                                            </tr>
                                        <?php endforeach;?>
                                    </table>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div><!-- /.box -->
        </div>
    </div>
</section>
<input type="hidden" id="wt_delete_conf" value="<?=__d("custom","wt_delete_conf")?>" /> 
<script type="text/javascript" >
$(function(){
    $("a.deleteconf").on("click",function(){
        var _wt_delete_conf = $("#wt_delete_conf").val();

        if(confirm(_wt_delete_conf)){
            return true;
        }else{
            return false;
        }
        
    });
});

</script>