<div class="row">
    <div class="col-md-12">
        
        <h3 class="box-title"><i class="fa fa-list"></i> <?=$pan2?></h3>
    </div>
</div>


<section class="content" >
    <div class="row ">
        
        <div class="col-md-12">
            
            <div class="box" id="lists">

                <div class="box-body">
                    <form action="/partners/edit/edit/" method="POST" >
                        <table class="table table-bordered " >
                            <tr>
                                <th class="bg-blue fwhite w200p valign"><?=__("company_name")?></th>
                                <td><?=h($user[ 'name' ])?></td>
                            </tr>
                            <tr>
                                <th class="bg-blue fwhite w200p valign"><?=__("login_id")?></th>
                                <td><?=h($user[ 'login_id' ])?></td>
                            </tr>
                            <tr>
                                <th class="bg-blue fwhite w200p valign"><?=__("password")?>
                                    <small class="label label-danger"><?=__("hissu")?></small>
                                </th>
                                <td>
                                    <input type="text" name="login_pw" value="<?=$login_pw?>" class="form-control" />
                                    <small><?=__("hankakueisu4")?></small>
                                </td>
                            </tr>
                            <tr>
                                <th class="bg-blue fwhite w200p valign"><?=__("yuubin")?></th>
                                <td>
                                    <div class="row">
                                        <div class="col-md-1">
                                            <input type="text" class="form-control w60p" value="<?=h($post1)?>" name="post1"  maxlength="3" />
                                        </div>
                                        <div class="col-md-1 w10p text-center  mg0">-</div>
                                        <div class="col-md-1">
                                            <input type="text" class="form-control w80p" value="<?=h($post2)?>" name="post2"  maxlength="4" />
                                        </div>
                                        <div class="col-md-9 pd-lt60">
                                            <input type="button" class="btn btn-success" name="prefSearch" value="<?=__("search")?>" />
                                        </div>
                                    </div>
                                    <small><?=__("hankakusu")?></small>
                                </td>
                            </tr>
                            <tr>
                                <th class="bg-blue fwhite w200p valign"><?=__("todofuken")?>
                                </th>
                                <td>
                                    <select name="prefecture" class="form-control w200p" >
                                        <?php foreach($D_prefecture as $key=>$val):?>
                                        <?php
                                            $sel = "";
                                            if($prefecture == $val) $sel = "SELECTED";
                                        ?>
                                            <option value="<?=$val?>" <?=$sel?> ><?=$val?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th class="bg-blue fwhite w200p valign"><?=__("jyusyo1")?>
                                </th>
                                <td>
                                    <input type="text" name="address1" class="form-control" value="<?=h($address1)?>" />
                                </td>
                            </tr>
                            <tr>
                                <th class="bg-blue fwhite w200p valign"><?=__("jyusyo2")?>
                                </th>
                                <td>
                                    <input type="text" name="address2" class="form-control" value="<?=h($address2)?>" />
                                </td>
                            </tr>
                            <tr>
                                <th class="bg-blue fwhite w200p valign"><?=__("denwabango")?>
                                </th>
                                <td>
                                    <input type="text" name="tel" class="form-control w300p" value="<?=h($tel)?>" />
                                    <small><?=__("hankakueisu")?></small>
                                </td>
                            </tr>
                            <tr>
                                <th class="bg-blue fwhite w200p valign"><?=__("faxbango")?>
                                </th>
                                <td>
                                    <input type="text" name="fax" class="form-control w300p" value="<?=h($fax)?>" />
                                    <small><?=__("hankakueisu")?></small>
                                </td>
                            </tr>
                        </table>
                        <table class="table table-bordered mt20" >
                            <tr>
                                <th class="bg-blue fwhite w200p valign"><?=__("tanto1")?>
                                    <small class="label label-danger"><?=__("hissu")?></small>
                                </th>
                                <td>
                                    <input type="text" class="form-control" value="<?=h($rep_name)?>" name="rep_name" />
                                </td>
                            </tr>
                            <tr>
                                <th class="bg-blue fwhite w200p valign"><?=__("tanto1address")?>
                                    <small class="label label-danger"><?=__("hissu")?></small>
                                </th>
                                <td>
                                    <input type="text" class="form-control" value="<?=h($rep_email)?>" name="rep_email" />
                                    <small><?=__("hankaku")?></small>
                                </td>
                            </tr>

                            <tr>
                                <th class="bg-blue fwhite w200p valign"><?=__("tanto2")?>
                                </th>
                                <td>
                                    <input type="text" class="form-control" value="<?=h($rep_name2)?>" name="rep_name2" />
                                </td>
                            </tr>
                            <tr>
                                <th class="bg-blue fwhite w200p valign"><?=__("tanto2address")?>
                                </th>
                                <td>
                                    <input type="text" class="form-control" value="<?=h($rep_email2)?>" name="rep_email2" />
                                    <small><?=__("hankaku")?></small>
                                </td>
                            </tr>
                            <tr>
                                <th class="bg-blue fwhite w200p valign"><?=__("tantotel")?>
                                </th>
                                <td>
                                    <input type="text" class="form-control" value="<?=h($rep_tel1)?>" name="rep_tel1" />
                                    <small><?=__("hankakusu")?></small>
                                </td>
                            </tr>
                        </table>
                        <div class="box box-warning mt20">
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-10">
                                        <small><?=__("message1")?></small>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-success mb-12" data-toggle="modal" data-target="#modal1"><?=__("yousomeikakunin")?></button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!--モーダルウィンドウ行動価値要素名-->
                        <div class="modal fade" id="modal1" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
                            <div class="modal-dialog w98">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <table class="table table-bordered" >
                                            <tr>
                                                <th class="bg-blue fwhite  valign" colspan=2><?=__("message1")?>
                                            </tr>
                                            <?php 
                                                $no=1;
                                                foreach($element as $key=>$val):?>
                                                <?php if($no%2 == 1): ?><tr><?php endif; ?>
                                                <td ><?=h($val)?></td>
                                                <?php if($no%2 == 0): ?></tr><?php endif; ?>
                                            <?php 
                                                $no++;
                                                endforeach;?>
                                        </table>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal"><?=__("close")?></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--//モーダルウィンドウ-->
                        <input type="button"  id="partner_back" value="<?=__("modoru")?>" class="btn btn-warning" />
                        <input type="submit" name="partner_edit" value="<?=__("edit")?>" class="btn btn-primary" />
                    </form>
                    <input type="hidden" id="partnerEditConfirm" value="<?=__("partnerEditConfirm")?>" />
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
    </div>
</section>