<section class="content" >
    <div class="row ">
        <div class="col-md-12">
            <ul class="nav nav-tabs">
                <li><a href="/managers/menu10/"><?=__("menu10sub1")?></a></li>
                <li class="active"><a href="javascript:void(0);"><?=__("menu10sub2")?></a></li>
            </ul>
            <div class="box">
                <div class="box-body">
                    <h4><i class="fa fa-fw fa-list-ul"></i><?=__('menu10sub2').__('gamen')?></h4>

                    <form action="/managers/menu10/edit" method="POST" enctype="multipart/form-data">
                        <fieldset class="mt20">
                            <input type="hidden" name="id" value="<?= $info['id'] ?>">
                            <table class="table table-bordered">
                                <tr>
                                    <th class="w200p bg-blue fwhite valign ml20"><?=__("kenmei")?>
                                    <small class="label label-danger"><?=__("hissu")?></small></th>
                                    <td><input type="text" class="form-control" name="title" value="<?= $info['title'] ?>"></td>
                                </tr>
                                <tr>
                                    <th class="w200p bg-blue fwhite"><?=__("message")?></th>
                                    <td><textarea rows="10" class="form-control" name="message"><?= $info['message'] ?></textarea></td>
                                </tr>
                                <tr>
                                    <th class="bg-blue fwhite valign"><?=__("display_period") ?>
                                    <small class="label label-danger"><?=__("hissu")?></small></th>
                                    <td>
                                        <input type="text" class="calenderSelect" id="date1" name="date1" value="<?= $info['date1'] ?>" />
                                        <span class="ml20">～</span>
                                        <input type="text" class="calenderSelect ml20" id="date2" name="date2" value="<?= $info['date2'] ?>" />
                                    </td>
                                </tr>
                                <tr>
                                    <th class="w200p bg-blue fwhite valign"><?=__("filetemp")?></th>
                                    <input type="hidden" name="temp_file" value="<?= $info['temp_file'] ?>">
                                    <td><a href="<?= D_HOME_PATH . D_INFO_FILE_PATH . h($info['temp_file']) ?>" download="<?= h($info['temp_file']) ?>"><?= $info['temp_file'] ?></a>
                                        <input type="file" class="form-control-file" name="info_upfile">
                                    </td>
                                </tr>
                                <tr>
                                    <th class="w200p bg-blue fwhite valign ml20"><?=__("display_partner")?>
                                    <small class="label label-danger"><?=__("hissu")?></small></th></th>
                                    <td>
                                        <?php
                                            $hidden1 = "hidden";
                                            $hidden2 = "hidden";
                                            $hidden3 = "hidden";
                                            if ($info['disp_area'] == 1) $hidden1 = "";
                                            elseif ($info['disp_area'] == 2)  $hidden2 = "";
                                            else   $hidden3 = "";
                                        ?>
                                        <span id="msg_all_partner" <?= $hidden1 ?>><?= __('all_partner') ?></span>
                                        <span class="text-info" id="msg_selected_count" <?= $hidden2 ?>><span id="selected_count"><?= $info['disp_area_detaile'] ?></span><?= __('msg_selected_count') ?></span>
                                        <span id="msg_please_select" <?= $hidden3 ?>><?= __('msg_please_select') ?></span>
                                        <input type="hidden" name="disp_area" id="disp_area" value="<?= $info['disp_area'] ?>">
                                        <input type="hidden" name="disp_id_list" id="disp_id_list" value="<?= $info['disp_id_list'] ?>">
                                        <button type="button" class="btn btn-sm btn-primary ml20" data-toggle="modal" data-target="#modal_p" data-backdrop="static"><?= __("select") ?></button>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="bg-blue fwhite ml20"><?=__("display_area") ?>
                                    <small class="label label-danger"><?=__("hissu")?></small></th></th>
                                    <td>
                                        <?php
                                            $check1 = '';
                                            $check2 = '';
                                            $check3 = '';
                                            if ($info['disp_status'] == 1): $check1 = 'CHECKED';
                                            elseif ($info['disp_status'] == 2): $check2 = 'CHECKED';
                                            elseif ($info['disp_status'] == 3): $check3 = 'CHECKED';
                                            else: $check3 = "CHECKED";
                                            endif;
                                        ?>
                                        <div class="ml20">
                                            <div class="radio">
                                                <input type="radio" name="disp_status" id="disp_status3" value="3" <?= $check3 ?>>
                                                <label for="disp_status3"><?= __('partner_and_client') ?></label>
                                            </div>
                                            <div class="radio">
                                                <input class="" type="radio" name="disp_status" id="disp_status1" value="1" <?= $check1 ?>>
                                                <label for="disp_status1"><?= __('partner_only') ?></label>
                                            </div>
                                            <div class="radio">
                                                <input type="radio" name="disp_status" id="disp_status2" value="2" <?= $check2 ?>>
                                                <label for="disp_status2"><?= __('client_only') ?></label>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </fieldset>
                        <input type="submit" class="btn btn-success mt10" value="<?=__("regist")?>" name="regist"/>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal -->
<div class="modal fade" id="modal_p" tabindex="-1">
    <div class="modal-dialog modal-lg" >
        <div class="modal-content">
            <div class="modal-header">
				<h4 class="modal-title"><?= __('partner_select') ?></h4>
            </div>
            <div class="modal-body">
                <table>
                    <tr class="form-group">
                        <!-- Search -->
                        <input type="text" id="partner_name"  class="form-control mb10 partner_name" placeholder="<?=__("menu7CreateMessage4Text")?>" />
                    </tr>
                    <tr>
                        <td class="col-md-6">
                            <!-- Data List -->
                            <span id="partner_count" hidden><?= $p_count ?></span>
                            <select class="form-control partners" name="partners" id="partner_list" size="15" multiple>
                                <?php foreach ($p_not_reg as $partner): ?>
                                    <option value="<?= $partner['id'] ?>" class="<?= $partner['index'] ?>"><?= $partner['name'] ?></option>
                                <?php endforeach ?>
                            </select>
                        </td>
                        <td class="col-md">
                            <div class="btn-group-vertical">
                                <button type="button" id="btn_all_r" class="btn btn-sm btn-default mb5">>></button>
                                <button type="button" id="btn_r" class="btn btn-sm btn-default mb30">></button>
                                <button type="button" id="btn_l" class="btn btn-sm btn-default mb5"><</button>
                                <button type="button" id="btn_all_l" class="btn btn-sm btn-default"><<</button>
                            </div>
                        </td>
                        <!-- Selected Data List -->
                        <td class="col-md-6 vertical-bottom test">
                            <p class="text-danger" id="err_not_select" hidden><?= __('msg_please_select') ?></p>
                            <select class="form-control partners" name="partners" id="partner_selected" size="15" multiple>
                            <?php foreach ($p_reg as $partner): ?>
                                <option value="<?= $partner['id'] ?>" class="<?= $partner['index'] ?>"><?= $partner['name'] ?></option>
                            <?php endforeach ?>
                            </select>
                        </td>
                    </tr>
                </table>
            </div>

            <div class="modal-footer">
				<button type="button" class="btn btn-default modal_cancel_btn" data-dismiss="modal"><?= __('cancel') ?></button>
				<button type="button" class="btn btn-primary" id="regist_partner"><?= __('regist') ?></button>
			</div>
        </div>
    </div>
</div>

<script src="/js/partner-select.js"></script>