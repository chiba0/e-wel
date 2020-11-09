<section class="content" >
    <div class="row ">
        <div class="col-md-12">
            <ul class="nav nav-tabs">
                <li class="active"><a href="javascript:void(0);"><?=__("menu10sub1")?></a></li>
                <li><a href="/managers/menu10/edit/"><?=__("menu10sub2")?></a></li>
            </ul>
            <div class="box">
                <div class="box-body">
                    <h4><i class="fa fa-fw fa-list-ul"></i><?=__('menu10').__('gamen')?></h4>
                    
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
                            <th class="col-md-4"><?=__("kenmei")?></th>
                            <th class="col-md-2"><?=__("display_period")?></th>
                            <th class="col-md-2"><?=__("display_partner")?></th>
                            <th class="col-md-2"><?=__("display_area")?></th>
                            <th class="col-md-1"><?=__("registdate") ?></th>
                            <th class="col-md-1"><?=__("kinou")?></th>
                        </tr>
                        <?php foreach($infos as $info): ?>
                            <tr>
                                <td><?= h($info['title']) ?></td>
                                <td><?= h($info['date1']) ?>～<?= h($info['date2']) ?></td>
                                <td>
                                    <?php if ($info['disp_area'] == 1): ?>
                                        <?= __('all_partner') ?>
                                    <?php else: ?>
                                        <?= $info['disp_area_detail'] . ' ' . __('partner') ?>
                                    <?php endif ?>
                                </td>
                                <?php
                                    $status = "";
                                    if ($info['disp_status'] == 1)  $status = __("partner");
                                    elseif ($info['disp_status'] == 2)  $status = __("client");
                                    elseif ($info['disp_status'] == 3)  $status = __("partner") . " / " . __("client");
                                    else    $status = "";
                                ?>
                                <td><?= $status ?></td>
                                <td><?= strstr($info['regist_ts'], ' ', true) ?></td>
                                <td nowrap>
                                    <a href="/managers/menu10/view/<?= $info['id'] ?>" class="btn btn-info"><?=__("detaile")?></a>
                                    <a href="/managers/menu10/edit/<?= $info['id'] ?>" class="btn btn-primary"><?=__("edit")?></a>
                                    <a href="/managers/menu10/delete/<?= $info['id'] ?>" class="btn btn-danger btn-delete"><?=__("sakujyo")?></a>
                                    <div id="msg-delete" hidden><?= __('msg_delete_config') ?></div>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </table>
                </div>
            </div><!-- /.box -->
        </div>
    </div>
</section>