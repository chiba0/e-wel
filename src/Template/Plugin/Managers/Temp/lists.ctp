<section class="content" >

    <div class="row ">
        <div class="col-md-12">
            <ul class="nav nav-tabs">
                <li class="active"><a href="javascript:void(0);"><?=__("tempfilelist")?></a></li>
                <li><a href="/managers/temp/setTemp/<?=$id?>"><?=__("filetemp")?></a></li>
            </ul>
            <div class="box">
                <div class="box-body">
                    <h4><i class="fa fa-fw fa-list-ul"></i><?=__('tempfilelist').__('gamen')?></h4>
                    <form action="/managers/temp/lists/<?=$id?>" method="POST">
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
                                    <?php foreach($list as $key=>$value):?>
                                        <tr >
                                            <td class="text-center valign" ><input type="checkbox" class="deletecheck" name="delete[<?=$value['id']?>]" value="on" /></td>
                                            <td class="text-center valign" >
                                                <?=h($value[ 'regist_ts' ])?></td>
                                            <td><a href="/managers/temp/download/<?=$value[ 'id' ]?>"><?=h($value[ 'filename' ])?></a></td>
                                            <td><?=h($value[ 'size' ])?></td>
                                            <td><?=h($value[ 'statusDisp' ])?></td>
                                            <td class="text-center">
                                                <a href="/managers/temp/delete/<?=$value[ 'id' ]?>/<?=$id?>" class="btn btn-danger delete-temp" ><?=__("sakujyo")?></a> 
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