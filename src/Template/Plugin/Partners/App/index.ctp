<div class="row">
    <div class="col-md-12">
        
        <h3 class="box-title"><i class="fa fa-list"></i> <?=$pan?></h3>
    </div>
</div>


<section class="content" >
    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-body">
                    <div class="col-md-9">
                        <table class="table table-bordered">
                            <tr class="bg-blue">
                                <th class="text-center"><?=__("kensasyubetsu")?></th>
                                <th class="text-center"><?=__("buy_license")?></th>
                                <th class="text-center"><?=__("sale_license")?></th>
                                <th class="text-center"><?=__("examinees")?></th>
                                <th class="text-center"><?=__("syori")?></th>
                                <th class="text-center"><?=__("zan")?></th>
                            </tr>
                            <?php foreach($license as $key=>$val ):?>
                            <tr>
                                <td><?=h($val[ 'examname' ])?></td>
                                <td class="text-right"><?=h(number_format($val[ 'buyNumber' ]))?></td>
                                <td class="text-right"><?=h(number_format($val[ 'sale' ]))?></td>
                                <td class="text-right"><?=h(number_format($val[ 'examCount' ]))?></td>
                                <td class="text-right"><?=h(number_format($val[ 'syori' ]))?></td>
                                <td class="text-right"><?=h(number_format($val[ 'zan' ]))?></td>
                            </tr>
                            <?php endforeach; ?>
                        </table>
                    </div>
                    <div class="col-md-3">
                        <div class="row"><a href="/partners/edit/" class="btn btn-success w100"><?=__("pmenu1")?></a></div>
                        <div class="row mt5"><a href="/partners/menu2/" class="btn btn-success w100"><?=__("pmenu2")?></a></div>
                        <div class="row mt5"><a href="/partners/menu3/" class="btn btn-success w100"><?=__("pmenu3")?></a></div>
                        <div class="row mt5"><a href="/partners/menu4/" class="btn btn-success w100"><?=__("pmenu4")?></a></div>
                        <div class="row mt5"><a href="/partners/menu5/" class="btn btn-success w100"><?=__("pmenu5")?></a></div>
                        <div class="row mt5"><a href="/partners/menu6/" class="btn btn-success w100"><?=__("pmenu6")?></a></div>
                        <div class="row mt5"><a href="" class="btn btn-success w100"><?=__("pmenu7")?></a></div>
                        <div class="row mt5"><a href="" class="btn btn-success w100"><?=__("pmenu8")?></a></div>

                    </div>
                    <br clear=all />
                </div><!-- /.box-body -->
            </div><!-- /.box -->            
        </div>
    </div>
   
    <div class="row ">
        
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header">
                    <h3 class="box-title"><?= __('filter')?></h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                        <form action="/partners/app#lists" method="POST" >
                            <div class="col-md-3">
                                <p><?= __('company_name')?></p>
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
            <div class="box" id="lists">

                <div class="box-body">
                    <ul class="pagination pagination-sm  pull-left mt10 mb10" id="data">
                        <?php for($i=0;$i<=$ceil;$i++):?>
                            <li><a href="/partners/app?username=<?=$this->request->getQuery('username')?>&sort=&p=<?=$i?>"><?=$i+1?></a></li>
                        <?php endfor;?>
                    </ul>
                    <table class="table table-bordered">
                        <tr class="bg-blue">
                            <th class="text-center"><?=__("company_name")?></th>
                            <th class="text-center"><?=__("examinees")?></th>
                            <th class="text-center"><?=__("syori")?></th>
                            <th class="text-center"><?=__("zan")?></th>
                            <th class="text-center"><?=__("kinou")?></th>
                        </tr>
                        <?php foreach($customer as $key=>$val): ?>
                        <tr>
                            <td><?=h($val[ 'name' ])?></td>
                            <td><?=h(number_format($val[ 'cnt'   ]))?></td>
                            <td><?=h(number_format($val[ 'syori' ]))?></td>
                            <td><?=h(number_format($val[ 'zan'   ]))?></td>
                            <td class="w300p">
                                <div class="row ">
                                    <div class="col-md-12">
                                        <a href="/customers/app/<?=$val[ 'id' ]?>" class="btn btn-primary"><?=__("customerImage")?></a>
                                    
                                        <a href="/partners/menu2/edit/<?=$val[ 'id' ]?>" class="btn btn-success"><?=__("edit")?></a>
                                    
                                        <a href="/partners/delete/<?=$val[ 'id' ]?>" class="btn btn-danger sakujyo"><?=__("sakujyo")?></a>
                                    
                                        <a href="/partners/temp/<?=$val[ 'id' ]?>" class="btn btn-info"><?=__("temp")?></a>
                                    </div>
                                    
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
    </div>
</section>
<input type="hidden" id="sakujyoText" value="<?=__("sakujyoText")?>" />
<script type="text/javascript" >
$(function(){
    $(".sakujyo").click(function(){
        var _val = $("#sakujyoText").val();
        if(confirm(_val)){
            return true;
        }
        return false;
    });
});
</script>