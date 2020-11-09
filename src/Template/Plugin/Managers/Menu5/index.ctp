<section class="content" >

    <div class="row ">
        <div class="col-md-12">

            <div class="box">
                <div class="box-body">
                    <h4><i class="fa fa-fw fa-list-ul"></i><?=__('menu6').__('gamen')?></h4>
                    <form action="" method="POST">
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
                            <a href="#" class="btn btn-default"><?=__("mae50")?></a>
                        </div>
                        <div class="col-md-1">
                            <a href="#" class="btn btn-default"><?=__("tugi50")?></a>
                        </div>
                    </div>
                    <table class="mt20 table table-bordered">
                        <tr class="bg-blue fwhite">
                            <th><?=__("torokukigyoumei")?></th>
                            <th><?=__("testgata")?></th>
                            <th><?=__("status")?></th>
                            <th><?=__("tourokunitiji")?></th>
                        </tr>
                        
                    </table>
                </div>
            </div><!-- /.box -->
        </div>
    </div>
</section>