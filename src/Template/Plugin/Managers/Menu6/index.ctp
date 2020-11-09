<section class="content" >

    <div class="row ">
        <div class="col-md-12">

            <div class="box">
                <div class="box-body">
                    <h4><i class="fa fa-fw fa-list-ul"></i><?=__('menu6').__('gamen')?></h4>
                    
                    
                    <table class="mt20 table table-bordered">
                        <tr class="bg-blue fwhite">
                            <th class="w300p"><?=__("kata")?></th>
                            <th><?=__("kensamei")?></th>
                            <th><?=__("kinou")?></th>
                        </tr>
                        <?php foreach($exam as $value): ?>
                        <?php foreach($value[ 'exam_master' ] as $val):
                            $k = $val[ 'key' ];
                            ?>
                        <tr>
                            <td><?=$val[ 'name' ]?></td>
                            <td><?=$val['jp']?></td>
                            <td><a href="/managers/menu6/export/<?=$k?>"><?=__("csvdownload")?></a></td>
                        </tr>
                        <?php endforeach; ?>
                        <?php endforeach; ?>
                    </table>
                </div>
            </div><!-- /.box -->
        </div>
    </div>
</section>