<section class="content" >
    <div class="row ">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body">
                    <h4><i class="fa fa-fw fa-list-ul"></i><?=__('menu10sub4').__('gamen')?></h4>

                    <table class="table table-bordered">
                        <tr>
                            <th class="w200p bg-blue fwhite valign"><?=__("kenmei")?>
                            <td><?= h($info['title']) ?></td>
                        </tr>
                        <tr>
                            <th class="bg-blue fwhite valign"><?=__("message")?></th>
                            <td><?= h($info['message']) ?></td>
                        </tr>
                        <tr>
                            <th class="bg-blue fwhite valign"><?=__("display_period") ?></th>
                            <td><?= h($info['date1']) ?> ～ <?= h($info['date2']) ?>
                            </td>
                        </tr>
                        <tr>
                            <th class="bg-blue fwhite valign"><?=__("filetemp")?></th>
                            <td><a href="<?= D_HOME_PATH . D_INFO_FILE_PATH . h($info['temp_file']) ?>" download="<?= h($info['temp_file']) ?>"><?= $info['temp_file'] ?></a></td>
                        </tr>
                        <tr>
                            <th class="bg-blue fwhite valign"><?=__("display_partner")?>
                            <td>
                                <?php
                                    $disp_area = "";
                                    if ($info['disp_area'] == 1) {
                                        $disp_area = __('all_partner');
                                    } else {
                                        foreach ($p_reg as $partner) {
                                            $disp_area .= $partner['name'];
                                            if ($partner != end($p_reg)) {
                                                $disp_area .= ', ';
                                            }
                                        }
                                    }
                                ?>
                                <?= $disp_area ?>
                            </td>
                        </tr>
                        <tr>
                            <th class="bg-blue fwhite valign"><?=__("display_area") ?>
                            <td>
                                <?php
                                    $status = "";
                                    if ($info['disp_status'] == 1)  $status = __("partner");
                                    elseif ($info['disp_status'] == 2)  $status = __("client");
                                    elseif ($info['disp_status'] == 3)  $status = __("partner") . " / " . __("client");
                                    else    $status = "";
                                ?>
                                <?= $status ?>
                            </td>
                        </tr>
                        <tr>
                            <th class="bg-blue fwhite valign"><?=__("registdate") ?>
                            <td><?= strstr($info['regist_ts'], ' ', true) ?></td>
                        </tr>
                        <!-- <tr>
                            <th class="bg-blue fwhite valign"><?=__("kidoku") ?>
                            <td><?= $info['already_read'] ?></td>
                        </tr> -->
                    </table>
                    <a href="/managers/menu10/edit/<?= $info['id'] ?>" class="btn btn-primary mt10"><?=__("edit")?></a>
                    <a href="/managers/menu10/delete/<?= $info['id'] ?>" class="btn btn-danger btn-delete mt10"><?=__("sakujyo")?></a>
                    <div id="msg-delete" hidden><?= __('msg_delete_config') ?></div>
                </div>
            </div>
        </div>
    </div>
</section>