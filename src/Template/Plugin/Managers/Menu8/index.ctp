<section class="content" >

    <div class="row ">
        <div class="col-md-12">

            <div class="box">
                <div class="box-body">
                    <h4><i class="fa fa-fw fa-list-ul"></i><?=__('menu6').__('gamen')?></h4>
                    
                    
                    <table class="mt20 table table-bordered">
                        <tr class="bg-blue fwhite">
                            <th ><?=__("kensasyubetsu")?></th>
                            <th><?=__("buy_license")?></th>
                            <th><?=__("sale_license")?></th>
                            <th><?=__("examinees")?></th>
                            <th><?=__("syori")?></th>
                            <th><?=__("zan")?></th>
                        </tr>
                        <?php foreach($exam_master as $values):?>
                        <tr>
                            <td><?=$values[ 'name' ]?></td>
                            <?php 
                                $cnt1 = 0;
                                $cnt2 = 0;
                                $cnt3 = 0;
                                $cnt4 = 0;
                                $cnt5 = 0;
                                if(isset($buy[$values['key']])){
                                    $cnt1 = $buy[$values['key']];
                                }
                                
                                if(isset($count[$values['key']])){
                                    $cnt3 = $count[$values['key']];
                                }
                                $cnt2 = $cnt1-$cnt3;
                                if(isset($syori[$values['key']])){
                                    $cnt4 = $syori[$values['key']];
                                }
                                $cnt5 = $cnt3-$cnt4;
                            ?>
                            <td><?=$cnt1?></td>
                            <td><?=$cnt2?></td>
                            <td><?=$cnt3?></td>
                            <td><?=$cnt4?></td>
                            <td><?=$cnt5?></td>
                        </tr>
                        <?php endforeach;?>
                    </table>
                </div>
            </div><!-- /.box -->
        </div>
    </div>
</section>