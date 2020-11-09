<section class="content" >

    <div class="row ">
        <div class="col-md-12">
            <ul class="nav nav-tabs">
                <li class="active"><a href="javascript:void(0);"><?=__("menu7sub1")?></a></li>
                <li><a href="/managers/menu7/create/"><?=__("menu7sub2")?></a></li>
            </ul>
            <div class="box">
                <div class="box-body">
                    <h4><i class="fa fa-fw fa-list-ul"></i><?=__('menu7').__('gamen')?></h4>
                    <form action="/managers/menu7" method="POST">
                        <table class="table table-bordered">
                            <tr>
                                <th class="w100p bg-blue fwhite valign text-center"><?=__("billNumber")?></th>
                                <td><input type="text" class="form-control" name="billNumber" value="<?=$billNumber?>" /></td>
                                <th class="w100p bg-blue fwhite valign text-center"><?=__("company_name")?></th>
                                <td>
                                    <input type="text"  class="form-control" name="company_name" value="<?=$company_name?>" />
                                </td>
                            </tr>
                            <tr>
                                <th class="w100p bg-blue fwhite valign text-center"><?=__("senddate")?></th>
                                <td><input type="text" class="calenderSelect" id="senddate" name="senddate" value="<?=$senddate?>" /></td>
                                <th class="w100p bg-blue fwhite valign text-center"><?=__("kenmei")?></th>
                                <td>
                                    <input type="text"  class="form-control" name="kenmei" value="<?=$kenmei?>" />
                                </td>
                            </tr>
                            <tr>
                                <th class="w100p bg-blue fwhite valign text-center"><?=__("status")?></th>
                                <td colspan=3 >
                                    <select class="form-control" name="download_status" >
                                        <option value="">-</option>
                                        <?php foreach($pdf_status as $key=>$val):?>
                                            <?php 
                                                $selected = "";
                                                if(strlen($download_status) > 0  && $download_status == $key) $selected = "SELECTED";    
                                            ?>
                                            <option value="<?=$key?>" <?=$selected?> ><?=$val?></option>
                                        <?php endforeach;?>
                                    </select>
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
                            <th nowrap><?=__("billNumber")?></th>
                            <th><?=__("company_name")?></th>
                            <th><?=__("kenmei")?></th>
                            <th><?=__("senddate")?></th>
                            <th><?=__("kinou")?></th>
                            <th nowrap><?=__("status")?></th>
                            <th><?=__("billMoney")?></th>
                        </tr>
                        <?php foreach($bill as $key=>$val):?>
                            <tr>
                                <td><?=h($val[ 'bill_num' ])?></td>
                                <td><?=h($val[ 'name' ])?></td>
                                <td><?=h($val[ 'title' ])?></td>
                                <td><?=date("Y/m/d",strtotime($val[ 'update_ts' ]))?></td>
                                <td nowrap >
                                    <a href="" class="btn btn-default"><?=__("nouhinsyo")?></a>
                                    <a href="/managers/menu7/write/<?=$val[ 'bill_num' ]?>" class="btn btn-default"><?=__("seikyusyo")?></a>
                                    <a href="" class="btn btn-default"><?=__("sakujyo")?></a>
                                </td>
                                <?php $bgRed=""; if($val['download_status'] != 1 ) $bgRed = "bg-red";?>
                                <td class="<?=$bgRed?>"><?=$pdf_status[$val[ 'download_status' ]]?></td>
                                <td>￥<?=number_format(h($val[ 'money_total' ]))?></td>
                            </tr>
                        <?php endforeach;?>
                    </table>
                </div>
            </div><!-- /.box -->
        </div>
    </div>
</section>