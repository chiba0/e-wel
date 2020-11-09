<div class="row">
    <div class="col-lg-3 "><a href="/managers/menu1/" class="btn btn-default btn-block bg-blue fwhite" ><?= __('menu1') ?></a></div>
    <div class="col-lg-3 "><a href="/managers/menu2/" class="btn btn-default btn-block bg-blue fwhite" ><?= __('menu2') ?></a></div>
    <div class="col-lg-2 "><a href="/managers/menu3/" class="btn btn-default btn-block bg-blue fwhite" ><?= __('menu3') ?></a></div>
    <div class="col-lg-2 "><a href="/managers/menu4/" class="btn btn-default btn-block bg-blue fwhite" ><?= __('menu4') ?></a></div>
    <div class="col-lg-2 "><a href="/managers/menu5/" class="btn btn-default btn-block bg-blue fwhite" ><?= __('menu5') ?></a></div>
</div>
<div class="row mt10">
    <div class="col-lg-3 "><a href="/managers/menu6/" class="btn btn-default btn-block bg-blue fwhite" ><?= __('menu6') ?></a></div>
    <div class="col-lg-3 "><a href="/managers/menu7/" class="btn btn-default btn-block bg-blue fwhite" ><?= __('menu7') ?></a></div>
    <div class="col-lg-2 "><a href="/managers/menu8/" class="btn btn-default btn-block bg-blue fwhite" ><?= __('menu8') ?></a></div>
    <div class="col-lg-2 "><a href="/managers/menu9/" class="btn btn-default btn-block bg-blue fwhite" ><?= __('menu9') ?></a></div>
    <div class="col-lg-2 "><a href="/managers/menu10/" class="btn btn-default btn-block bg-blue fwhite" ><?= __('menu10') ?></a></div>
</div>
<div class="row mt10">
    <div class="col-lg-3 "><a href="/managers/menu11/" class="btn btn-default btn-block bg-blue fwhite" ><?= __('menu11') ?></a></div>
    <div class="col-lg-3 "><a href="/managers/menu12/" class="btn btn-default btn-block bg-blue fwhite" ><?= __('menu12') ?></a></div>
    <div class="col-lg-2 "><a href="/managers/menu13/" class="btn btn-default btn-block bg-blue fwhite" ><?= __('menu13') ?></a></div>
    <div class="col-lg-2 "></div>
    <div class="col-lg-2 "></div>
</div>

<section class="content" >
    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header">
                    <h3 class="box-title"><?= __('filter')?></h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-3">
                            <p><?= __('company_name')?></p>
                            <input type="text" name="username" value="<?=$this->request->getQuery('username')?>" class="form-control"  />
                        </div>
                        <div class="col-md-9">
                            <p>&nbsp;</p>
                            <input type="button" name="search" class="btn btn-success"   value=<?= __('search');?> />
                        </div>
                    </div>
                </div><!-- /.box-body -->

                <ul class="pagination pagination-sm  pull-left mt10 mb10" id="data">
                    <?php for($i=0;$i<=$ceil;$i++):?>
                        <li><a href="/managers/app?username=<?=$this->request->getQuery('username')?>&sort=&p=<?=$i?>"><?=$i+1?></a></li>
                    <?php endfor;?>
                </ul>

            </div><!-- /.box -->            
        </div>
    </div>
    <div class="row ">
        <div class="col-md-12">
            <div class="box">
                
                <div class="box-body">
                    <table class="table table-bordered">
                        <tr class="bg-blue fwhite" >
                            <th class="w300p" ><a class="fwhite" href="/managers/app?username=<?=filter_input(INPUT_GET, 'username')?>&sort=username#data" ><?= __('company_name')?> <i class="fwhite fa fa-fw fa-sort<?=$sortMarks['username']?>"></i></a></th>
                            <th ><a class="fwhite" href="/managers/app?username=<?=filter_input(INPUT_GET, 'username')?>&sort=userlicense#data"><?= __('buy_license')?> <i class="fwhite fa fa-fw fa-sort<?=$sortMarks['userlicense']?>"></i></a></th>
                            <th ><a class="fwhite" href="/managers/app?username=<?=filter_input(INPUT_GET, 'username')?>&sort=hanbaikano#data"><?= __('sale_license')?> <i class="fwhite fa fa-fw fa-sort<?=$sortMarks['hanbaikano']?>"></i></a></th>
                            <th ><a class="fwhite" href="/managers/app?username=<?=filter_input(INPUT_GET, 'username')?>&sort=jyukensya#data"><?= __('examinees')?> <i class="fwhite fa fa-fw fa-sort<?=$sortMarks['jyukensya']?>"></i></a></th>
                            <th ><a class="fwhite" href="/managers/app?username=<?=filter_input(INPUT_GET, 'username')?>&sort=syori#data" ><?= __('syori')?> <i class="fwhite fa fa-fw fa-sort<?=$sortMarks['syori']?>"></i></a></th>
                            <th ><a class="fwhite" href="/managers/app?username=<?=filter_input(INPUT_GET, 'username')?>&sort=zan#data" ><?= __('zan')?> <i class="fwhite fa fa-fw fa-sort<?=$sortMarks['zan']?>"></i></a></th>
                            <th class="w200p"><?= __('kinou')?></th>
                        </tr>
                        <?php foreach($partner as $key=>$val): ?>
                            <tr>
                                <td><?=h($val['username'])?></td>
                                <td ><?=h(number_format((int)$val['userlicense']))?></td>
                                <td ><?=h(number_format((int)$val['hanbaikano']))?></td>
                                <td ><?=h(number_format((int)$val['jyukensya']))?></td>
                                <td ><?=h(number_format((int)$val['syori']))?></td>
                                <td ><?=h(number_format((int)$val['zan']))?></td>
                                <td>
                                    <a href="/partners/app/<?=$val['userid']?>" class="btn btn-sm btn-primary" ><?= __('partner') ?></a>
                                    <a href="/managers/menu2/edit/<?=$val['userid']?>" class="btn btn-sm btn-success" ><?= __('edit') ?></a>
                                    <a href="/managers/temp/lists/<?=$val['userid']?>" class="btn btn-sm btn-info" ><?= __('temp') ?></a>                                    
                                </td>
                            </tr>
                        <?php endforeach;?>

                    </table>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
    </div>
</section>