<section class="content" >

    <div class="row ">
        <div class="col-md-12">

            <div class="box">
                <div class="box-body">
                    <h4><i class="fa fa-fw fa-list-ul"></i><?=__('tempfilelist').__('gamen')?></h4>
                    <form action="/partners/menu3/" method="POST">
                        <table class="table table-bordered">
                            <tr>
                                <th class="bg-blue valign text-center"><?=__("filename")?></th>
                                <td>
                                    <input type="text" class="form-control" name="filename" value="<?=$this->request->getData("filename")?>" /></td>
                                <th class="bg-blue valign text-center"><?=__("registdate")?></th>
                                <td>
                                    <input type="text"  class="calenderSelect"  id="registdate" name="registdate" value="<?=$this->request->getData("registdate")?>" />
                                </td>
                            </tr>
                            <tr>
                                <th class="bg-blue valign text-center"><?=__("status")?></th>
                                <td colspan="3" >
                                    <select name="status" class="form-control w200p">
                                        <option value="">-</option>
                                    <?php 
                                        foreach($D_STATUS as $key=>$val):
                                            
                                            $sel="";
                                            if(
                                                strlen($this->request->getData("status")) > 0  && 
                                                $key == $this->request->getData("status"))
                                                {
                                                    $sel = "SELECTED";
                                                }
                                        ?>
                                        
                                        <option value="<?=$key?>" <?=$sel?>><?=$val?></option>
                                    <?php endforeach;?>
                                    </select>
                                </td>
                            </tr>
                        </table>
                        <div class="row mt10">
                            <div class="col-sm-1">
                                <input type="submit" name="tempSearch" class="w100p btn btn-success" value="<?=__("search")?>" />
                                                
                            </div>
                            <div class="col-sm-10 ml20">
                                <input type="submit" name="checkDelete" class="btn " value="<?=__("checkdelete")?>" />
                            </div>
                        </div>
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
                                    <tr>
                                        <th class="bg-blue valign text-center">
                                            <input type="checkbox" id="tempAllCheck" value="on" />
                                        </th>
                                        <th class="bg-blue valign text-center"><?=__("registdate")?></th>
                                        <th class="bg-blue valign text-center"><?=__("filename")?></th>
                                        <th class="bg-blue valign text-center"><?=__("size")?></th>
                                        <th class="bg-blue valign text-center"><?=__("status")?></th>
                                        <th class="bg-blue valign text-center"><?=__("kino")?></th>
                                    </tr>
                                    <?php foreach($list as $key=>$val):?>
                                        <tr>
                                            <td class="text-center">
                                                <input type="checkbox" name="delcheck[<?=$val[ 'id' ]?>]" value="on" class="deletecheck" >
                                            </td>
                                            <td class="text-center"><?=$val[ 'regist_ts' ]?></td>
                                            <td >
                                                <a href="/partners/menu3/tmp/<?=$val[ 'id' ]?>"><?=h($val[ 'filename' ])?></a>
                                            </td>
                                            <td class="text-center"><?=h(number_format($val[ 'size' ]))?></td>
                                            <td class="text-center">
                                                <?=$D_STATUS[$val[ 'status' ]]?>
                                            </td>
                                            <td class="text-center">
                                                <a href="/partners/menu3/delete/<?=h($val[ 'id' ])?>" class="btn-sm btn-danger delete-temp"><?=__("sakujyo")?></a>
                                            </td>
                                        
                                        </tr>
                                    <?php endforeach;?>
                                </table>
                            </div>
                        </div>

                    </form>
                    <input type="hidden" id="TempDeleteMsg" value="<?=__("TempDeleteMsg")?>" />
                    <input type="hidden" id="TempDeleteAllMsg" value="<?=__("TempDeleteAllMsg")?>" />
                </div>
            </div><!-- /.box -->
        </div>
    </div>
</section>