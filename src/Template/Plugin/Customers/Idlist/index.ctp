<section class="content " >
    <h4 class="page-header">
        <?=__d('custom','customerreg11')?>
    </h4>
    <div class="row">
        <div class="col-md-6">
            <div class="box" >
                <div class="box-header">
                    <h3 class="box-title">
                        <?=$test[ 'name' ]?>
                    </h3>
                </div>
                <div class="box-body">
                    <label>テストURL</label>
                    <p><?=D_EXAM?>users/login/<?=$test[ 'dir' ]?></p>
                    <?=$this->QrCode->text('https://blog.s-giken.net/',array("size"=>"150x150"));?>
                </div>
                <div class="box-body">
                    <label><?=__d("custom","examterm")?></label>
                    <p>
                        <?=$test[ 'period_from' ]?>～
                        <?=$test[ 'period_to' ]?>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="box" >
                <div class="box-header">
                    <h3 class="box-title">
                    <?=__d('custom','customerreg11')?>
                    </h3>
                </div>
                <div class="box-body">
                    
                    <div class="row">
                        <div class="col-md-3">
                            <?= $this->Paginator->prev(__("mae50"))?>
                        </div>
                        <div class="col-md-3">
                            <?= $this->Paginator->next(__("tugi50")) ?>
                        </div>
                    </div>

                    <br clear=all />
                    <label><?=__d('custom','customerreg11')?></label>
                    <table class="table table-bordered">
                        <tr>
                            <th>#</th>
                            <th>ID</th>
                            <th><?=__d('custom','name')?></th>
                        </tr>
                        <?php foreach($list as $key=>$value):?>
                            <tr>
                                <td><?=$value['number']?></td>
                                <td><?=$value['exam_id']?></td>
                                <td><?=$value['name']?></td>
                            </tr>
                        <?php endforeach;?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>