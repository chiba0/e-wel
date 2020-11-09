<section class="content" >
    <div class="row ">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body">
                    <h4><i class="fa fa-fw fa-list-ul"></i><?=__('menu3').__('gamen')?></h4>
                    <!-- 検索 -->
                    <form action="" method="GET">
                        <table class="table table-bordered">
                            <tr>
                                <th class="w100p bg-blue fwhite valign text-center"><?=__d("other", "id")?></th>
                                <td><input type="text" class="form-control" name="id" value="<?=$id?>"></td>
                                <th class="w100p bg-blue fwhite valign text-center"><?=__d("other", "kokyakukigyoumei")?></th>
                                <td><input type="text" class="form-control" name="companyName" value="<?=$companyName?>"></td>
                            </tr>
                            <tr>
                                <th class="bg-blue fwhite valign text-center"><?=__d("other", "shimei")?></th>
                                <td><input type="text" class="form-control" name="name" value="<?=$name?>"></td>
                                <th class="bg-blue fwhite valign text-center"><?=__d("other", "jukenbi")?></th>
                                <td><input type="text" class="calenderSelect" id="senddate" name="senddate" value="<?=$senddate?>"/></td>
                            </tr>
                        </table>
                        <input class="btn btn-success mt10 w100p" type="submit" value="<?=__d("other", "search")?>">
                    </form>
                    <!-- ページ移動 -->
                    <div class="row mt20">
                        <div class="col-md-1">
                            <?= $this->Paginator->prev(__("mae50"))?>
                        </div>
                        <div class="col-md-1">
                            <?= $this->Paginator->next(__("tugi50")) ?>
                        </div>
                    </div>
                    <!-- データ表示 -->
                    <table class="mt20 table table-bordered">
                        <tr class="bg-blue fwhite">
                            <th><?=__d("other", "kensamei")?></th>
                            <th><?=__d("other", "id")?></th>
                            <th><?=__d("other", "kokyakukigyoumei")?></th>
                            <th><?=__d("other", "partnerkaisya")?></th>
                            <th><?=__d("other", "shimei")?></th>
                            <th><?=__d("other", "jukenbi")?></th>
                        </tr>
                        <?php foreach($data as $rec):?>
                            <tr>
                                <td><?=h($rec['test_name'])?></td>
                                <td><?=h($rec['exam_id'])?></td>
                                <td><?=h($rec['customer_name'])?></td>
                                <td><?=h($rec['partner_name'])?></td>
                                <td><?=h($rec['exam_name'])?></td>
                                <td><?=h($rec['exam_date'])?></td>
                            </tr>
                        <?php endforeach ?>
                    </table>
                </div>
            </div><!-- /.box -->
        </div>
    </div>
</section>