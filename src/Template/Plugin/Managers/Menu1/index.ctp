
<section class="content" >

    <div class="row ">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body">
                    <h3><?=__('menu1').__('gamen')?></h3>
                    <form action="" method="POST">
                        <fieldset class="mt20">
                            <legend><i class="fa fa-inbox"></i> <?=__d("other","super_user") ?></legend>
                            <input type="hidden" name="su_id" value="<?=$su_data['id']?>">
                            <input type="hidden" name="su_login_id" value="<?=$su_data['login_id'] ?>">
                            <table class="table table-bordered">
                                <tr>
                                    <th class="w200p bg-blue fwhite"><?=__d("other", "id")?></th>
                                    <td><?=h($su_data['login_id']) ?></td>
                                </tr>
                                <tr>
                                    <th class="bg-blue fwhite"><?=__d("other", "password") ?></th>
                                    <td><?=h($su_data['login_pw']) ?></td>
                                </tr>
                                <tr>
                                    <th class="bg-blue fwhite"><?=__d("other", "tantousya_shimei") ?></th>
                                    <td><input class="form-control" type="text" name="su_rep_name" value="<?=h($su_data['rep_name']) ?>"></td>
                                </tr>
                                <tr>
                                    <th class="bg-blue fwhite"><?=__d("other", "tantousya_email") ?></th>
                                    <td><input class="form-control" type="email" name="su_rep_email" value="<?=h($su_data['rep_email']) ?>"></td>
                                </tr>
                            </table>
                        </fieldset>
                        <fieldset class="mt20">
                            <legend><i class="fa fa-inbox"></i> <?=__d("other", "general_user") ?></legend>
                            <?php for($i=0; $i<5; $i++): ?>
                                <input type="hidden" name="gu_id_<?=$i+1?>" value="<?=$gu_data[$i]['id']?>">
                                <input type="hidden" name="gu_login_id_<?=$i+1?>" value="<?=$gu_data[$i]['login_id']?>">
                                <table class="table table-bordered mt10">
                                    <tr>
                                        <th class="w200p bg-blue fwhite"><?=__d("other", "id")?></th>
                                        <td><?=h($gu_data[$i]['login_id']) ?></td>
                                    </tr>
                                    <tr>
                                        <th class="bg-blue fwhite"><?=__d("other", "password") ?></th>
                                        <td><?=h($gu_data[$i]['login_pw']) ?></td>
                                    </tr>
                                    <tr>
                                        <th class="bg-blue fwhite"><?=__d("other", "tantousya_shimei") ?></th>
                                        <td>
                                            <input class="form-control" type="text" name="gu_rep_name_<?=$i+1?>" value="<?=h($gu_data[$i]['rep_name']) ?>">
                                            <small><?=__d("other", "shimei_note") ?></small>
                                        </td>
                                    </tr>
                                </table>
                            <?php endfor;?>
                        </fieldset>
                        <input class="btn btn-success mt20 w150p" type="submit" value="<?=__d("other", "register")?>" id="TUserRegist" />
                        <input type="hidden" value="<?=__("confirmRegist")?>"  id="TUserRegistMsg" />
                    </form>
                </div>
            </div><!-- /.box -->
        </div>
    </div>
</section>