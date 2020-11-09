
<section class="content" >
    

    <div class="row ">
        <div class="col-md-12">
            
            <h3><i class="fa fa-list"></i>&nbsp; <?=__d('custom','ctab2').__('gamen')?></h3>
        </div>
    </div>
    <div class="row mt20">
        
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header">
                    <h3 class="box-title"><?= __('filter')?></h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                    
                    <div class="row">
                        <form action="/customers/app/lists#lists" method="POST" >
                            <div class="col-md-3">
                                <p><?= __('ID')?></p>
                                <input type="text" name="exam_id" value="<?=$this->request->getdata('exam_id')?>" class="form-control"  />
                            </div>
                            <div class="col-md-3">
                                <p><?= __d('custom','name')?></p>
                                <input type="text" name="name" value="<?=$this->request->getdata('name')?>" class="form-control"  />
                            </div>
                            <div class="col-md-3">
                                <p><?= __d('custom','examdate')?></p>
                                <div class="row">
                                    <div >
                                        <input type="text" name="examdate_st" value="<?=$this->request->getdata('examdate_st')?>" class="w100p calenderSelect "  />
                                        ～
                                        <input type="text" name="examdate_ed" value="<?=$this->request->getdata('examdate_ed')?>" class="w100p calenderSelect"  />
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 mt10">
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
                                <li ><a href="/customers/app" ><?= __d('custom','ctab1') ?></a></li>
                                <li class="active"><a href="/customers/app/lists" ><?= __d('custom','ctab2') ?></a></li>
                            </ul>
                            <div class="tab-content">
                                <div class="row">
                                    <div class="col-md-12">
                                        <!-- ページ移動 -->
                                        <div class="row mt20">
                                            <div class="col-md-1">
                                                <?= $this->Paginator->prev(__("mae50"))?>
                                            </div>
                                            <div class="col-md-1">
                                                <?= $this->Paginator->next(__("tugi50")) ?>
                                            </div>
                                        </div>
                                        <div class="row mt20">
                                            <div class="col-md-12">
                                                <table class="table table-bordered">
                                                    <tr class="bg-blue">
                                                        <th class="text-center"><?=__d("custom","clist2")?></th>
                                                        <th class="text-center"><?=__d("custom","clist3")?></th>
                                                        <th class="text-center"><?=__d("custom","clist4")?></th>
                                                        <th class="text-center"><?=__d("custom","clist5")?></th>
                                                        <th class="text-center"><?=__d("custom","clist6")?></th>
                                                        <th class="text-center"><?=__d("custom","clist7")?></th>
                                                        <th class="text-center"><?=__d("custom","clist8")?></th>
                                                        
                                                    </tr>
                                                    <?php foreach($list as $key=>$val):?>
                                                        <tr>
                                                            <td><?=h($val[ 'exam_id' ])?></td>
                                                            <td><?=h($val[ 'name' ])?></td>
                                                            <td><?=h($val[ 'kana' ])?></td>
                                                            <td class="text-center"><?=h($val[ 'birth' ])?></td>
                                                            <td class="text-center"><?=h($val[ 'testname' ])?></td>
                                                            <td class="text-center"><?=h($val[ 'typename' ])?></td>
                                                            <td class="text-center"><?=h($val[ 'exam_date' ])?></td>
                                                        </tr>
                                                    <?php endforeach;?>
                                                </table>
                                            </div>
                                        </div>
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

<script type="text/javascript" >
$(function(){
    
});
</script>