<section class="content" >

    <div class="row ">
        <div class="col-md-12">
            <ul class="nav nav-tabs">
                <li class="active"><a href="/managers/menu4/"><?=__("menu4sub1")?></a></li>
                <li><a href="/managers/menu4/customers/"><?=__("menu4sub2")?></a></li>
            </ul>
            <div class="box">
                <div class="box-body">
                    <h4><i class="fa fa-fw fa-list-ul"></i><?=__('menu4').__('gamen')?></h4>
                    <form action="/managers/menu4/" method="POST">
                        <table class="table table-bordered">
                            <tr>
                                <th class="w100p bg-blue fwhite valign text-center"><?=__("company_name")?></th>
                                <td><input type="text" class="form-control" name="company_name" value="<?=$company_name?>" /></td>
                                <th class="w100p bg-blue fwhite valign text-center"><?=__("registdate")?></th>
                                <td>
                                    <input type="text"  class="calenderSelect"  id="registdate" name="registdate" value="<?=$registdate?>" />
                                </td>
                            </tr>
                        </table>
                        <input class="btn btn-success mt10 w100p" type="submit" value="<?=__("search")?>">
                    </form>
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
                            <th><?=__("torokukigyoumei")?></th>
                            <th><?=__("testgata")?></th>
                            <th><?=__("status")?></th>
                            <th><?=__("tourokunitiji")?></th>
                        </tr>
                        <?php foreach($data as $key=>$val): ?>
                        <tr>
                            <td><?=h($val[ 'name' ])?></td>
                            <td><?=h($val[ 'exam_name' ])?></td>
                            <td><?=h($val[ 'status' ])?></td>
                            <td><?=h($val[ 'regist_ts' ])?></td>
                        </tr>
                        <?php endforeach;?>
                    </table>
                </div>
            </div><!-- /.box -->
        </div>
    </div>
</section>