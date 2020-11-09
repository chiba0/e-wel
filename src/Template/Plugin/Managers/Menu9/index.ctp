<section class="content" >

    <div class="row ">
        <div class="col-md-12">

            <div class="box">
                <div class="box-body">
                    <h4><i class="fa fa-fw fa-list-ul"></i><?=__('menu6').__('gamen')?></h4>
                    
                    <div class="row mt20">
                        <div class="col-md-1">
                            <?= $this->Paginator->prev(__("mae50"))?>
                        </div>
                        <div class="col-md-1">
                            <?= $this->Paginator->next(__("tugi50")) ?>
                        </div>
                    </div>

                    
                    <table class="mt20 table table-bordered">
                        <tr class="bg-blue fwhite">
                            <th ><?=__("menu7CreateMessage4")?></th>
                            <th ><?=__("menu7CreateMessage5")?></th>
                            <th ><?=__("hakkou")?></th>
                            <th ><?=__("examinees")?></th>
                            <th ><?=__("mijyuken")?></th>
                            <th ><?=__("zan")?></th>
                            <th ><?=__("registdate")?></th>
                            
                        </tr>
                        <?php foreach($trial as $values):?>
                        <tr>
                            <td><?=$values[ 'ptname' ]?></td>
                            <td><?=$values[ 'cname' ]?></td>
                            <td class="text-center"><?=$values[ 'number' ]?></td>
                            <td class="text-center"><?=$values[ 'sumi' ]?></td>
                            <td class="text-center"><?=$values[ 'mi' ]?></td>
                            <td class="text-center"><?=$values[ 'zan' ]?></td>
                            <td class="text-center"><?=$values[ 'registtime' ]?></td>
                        </tr>
                        <?php endforeach;?>
                    </table>
                </div>
            </div><!-- /.box -->
        </div>
    </div>
</section>