<section class="content" >
    <div class="row ">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body">
                    <h4><i class="fa fa-fw fa-list-ul"></i><?=__d('custom','cmenu3').__('gamen')?></h4>
              

                    <!-- データ表示 -->
                    <table class="mt20 table table-bordered">
                        <tr class="bg-blue fwhite">
                            <th class="text-center"><?=__("registdate")?></th>
                            <th class="text-center"><?=__("filename")?></th>
                            <th class="text-center"><?=__("size")?></th>
                            <th class="text-center"><?=__("status")?></th>
                            <th class="text-center"><?=__("kino")?></th>
                            
                        </tr>
                        <?php foreach($data as $rec):?>
                            <tr class="text-center">
                                <td><?=h($rec['regist_date'])?></td>
                                <td><?=h($rec['filename'])?></td>
                                <td><?=h($rec['size'])?> Byte</td>
                                <td><?=h($d_status[$rec['status']])?></td>
                                <td><a href="/customers/menu3/download/<?=$rec['id']?>" class="btn btn-primary"><?=__("pmenu3")?></a></td>
                            </tr>
                        <?php endforeach ?>
                    </table>
                </div>
            </div><!-- /.box -->
        </div>
    </div>
</section>