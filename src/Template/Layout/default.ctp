<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = 'CakePHP: the rapid development php framework';
?>
<?=$this->element('base_header');?>


<div class="">
    <div class="">
        <div class="col-md-12 mt-1">

            <section class="content-header">
                <div class="w100 mr-0" >
                    <div class="pull-left box-tools">
                        <h2><?=h($title)?><?= __('admin') ?></h2>
                    </div>
                    <div class="pull-right box-tools mt10">
                        
                        <a href="<?=D_HOME_PATH?>users/login/logout" class="btn btn-default btn-sm daterange pull-right" ><?= __('logout') ?></a>
                        <button class="btn btn-default btn-sm pull-right mr-5" >HOME</button>
                    </div>
                </div>
                <?php if(!isset($languageArea)): ?>
                    <div class="navbar-right w100 mr-0" >
                        <div class="pull-right box-tools">
                            <a href="/managers/app/?lang=en" class="btn btn-primary btn-sm daterange pull-right" >中文</a>
                            <a href="/managers/app/?lang=jp" class="btn btn-primary btn-sm pull-right mr-5" >日本語</a>
                        </div>
                    </div>
                <?php endif; ?>
            </section>
            <br clear=all />
            
            <ol class="breadcrumb mt20">

                <?php if(preg_match("/^\/partners/",$this->Url->build(""))):?>
                    <?= $this->element('pan_partners') ?>
                <?php endif; ?>
                <?php if(preg_match("/^\/managers/",$this->Url->build(""))):?>
                    <?= $this->element('pan_managers') ?>
                <?php endif; ?>
                <?php if(preg_match("/^\/customers/",$this->Url->build(""))):?>
                    <?= $this->element('pan_customers') ?>
                <?php endif; ?>
            </ol>
            
            <div class=" panel panel-default">
                <?= $this->Flash->render() ?>
                <div class="panel-body">
                <?= $this->fetch('content') ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?=$this->element('base_footer');?>

