<section class="content" >
    <div class="row ">
        <div class="col-md-12" id="container" style="width:3000px;">
            <div class="box">
                <div class="box-body">
                    <h4><i class="fa fa-fw fa-list-ul"></i><?=__d('custom','cmenu6').__('gamen')?></h4>

                    <div class="row">
                        <div class="col-md-4">
                            <h4><?=__("filter")?></h4>
                        </div>
                    </div>
                    <form action="/customers/menu6" method="post" > 
                        
                        
                        <div class="row w1200p">
                            <div class="col-md-1">
                                <label><?=__d('custom','id_search')?></label>
                                <input type="text" name="id_search" value="<?=$this->request->getData('id_search')?>" class="form-control" />    
                            </div>
                            <div class="col-md-2">
                                <label><?=__d('custom','name_search')?></label>
                                <input type="text" name="name_search" value="<?=$this->request->getData('name_search')?>" class="form-control" />    
                            </div>
                            <div class="col-md-2">
                                <label><?=__d('custom','kana_search')?></label>
                                <input type="text" name="kana_search" value="<?=$this->request->getData('kana_search')?>" class="form-control" />    
                            </div>
                            <div class="col-md-3 ">
                                <label><?=__d('custom','start_search')?></label><br />
                                <input type="text" name="start_search" value="<?=$this->request->getData('start_search')?>" class="calenderSelect" />    
                            </div>
                            <div class="col-md-3">
                                <label><?=__d('custom','end_search')?></label>
                                <br />
                                <input type="text" name="end_search" value="<?=$this->request->getData('end_search')?>" class="calenderSelect" />    
                            </div>
                        </div>
                        <div class="row mt20">
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-success" name="search_button" ><?=__("search")?></button>
                            </div>
                        </div>

                            
                    </form>
                        
                    <div class="row mt20">
                        <div class="col-md-12">
                            <!-- ページ移動 -->
                            <div class="row mt20 w400p">
                                <div class="col-md-3">
                                    <?= $this->Paginator->prev(__("mae50"))?>
                                </div>
                                <div class="col-md-3">
                                    <?= $this->Paginator->next(__("tugi50")) ?>
                                </div>
                            </div>
                            <table class="table table-bordered mt20">
                                <tr class="bg-blue">
                                    <th><?=__d("custom","inspection")?></th>
                                    <th><?=__d("custom","exam_year")?></th>
                                    <th><?=__d("custom","testname")?></th>
                                    <th>ID</th>
                                    <th><?=__d("custom","name")?></th>
                                    <th><?=__d("custom","kana_search")?></th>
                                    <th><?=__d("custom","cmenu6_birthday")?></th>
                                    <th><?=__d("custom","gender")?></th>
                                    <th><?=__d("custom","examdate")?></th>
                                    <th class="w300p"><?=__d("custom","memo1")?></th>
                                    <th class="w300p"><?=__d("custom","memo2")?></th>
                                    <th><?=__d("custom","judge")?></th>
                                    <th><?=__d("custom","pass")?></th>
                                    <th><?=__d("custom","enterdate")?></th>
                                    <th><?=__d("custom","retiredate")?></th>
                                    <th class="w300p"><?=__d("custom","retirereason")?></th>
                                    <th><?=__("kino")?></th>
                                    
                                </tr>
                                <?php foreach($data as $values):?>
                                    <tr>
                                        <td><?=$values->inspection?></td>
                                        <td><?=$values->exam_date?></td>
                                        <td><?=$values['t_test']['name']?></td>
                                        <td><?=$values->exam_id?></td>
                                        <td><?=$values->name?></td>
                                        <td><?=$values->kana?></td>
                                        <td><?=$values->birth?></td>
                                        <td><?=$d_gender[$values->sex]?></td>
                                        <td><?=$values->exam_date?></td>
                                        <td><?=$values->memo1?></td>
                                        <td><?=$values->memo2?></td>
                                        <td><?=$values->evaluation?></td>
                                        <td><?=$values->adopt?></td>
                                        <td><?=$values->enterdate?></td>
                                        <td><?=$values->retiredate?></td>
                                        <td><?=$values->retirereason?></td>
                                        <td>
                                            <a href="/customers/menu6/edit/<?=$values[ 'id' ]?>" class="btn btn-success"><?=__d("custom","edit")?></a>
                                        </td>

                                    </tr>
                                <?php endforeach;?>
                            </table>
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
    $(this).heights();
});
$.fn.heights = function(){
    h = $(window).height()-200;
    $("#container").css("height",h+"px");
}

</script>