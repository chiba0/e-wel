<section class="content" >

    <div class="row ">
        <div class="col-md-12">

            <div class="box">
                <div class="box-body">
                    <h4><i class="fa fa-fw fa-list-ul"></i><?=__('pmenu4').__('gamen')?></h4>
                    <form action="/partners/menu4/type" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-12">
                                <input type="file" name="file"  />
                            </div>
                            <div class="col-md-12 mt20">
                            <input type="button"  id="partner_back" value="<?=__("modoru")?>" class="btn btn-warning" />
                            <input type="submit" name="regist" value="<?=__("pmenu4")?>"  class="btn btn-success" />
                            <input type="submit" name="pdflogodelete" value="<?=__("pdflogodelete")?>"  class="btn btn-danger" />
                            </div>
                        </div>
                        <div class="row">
                            
                            <?php if($logoImage): ?>
                                <div class="col-md-12">
                                    <?=__("pdflogoText1")?><br />
                                    <img src="<?=$url?><?=$logoImage?>" height=60 class="imagebox" />
                                </div>
                            <?php endif;?>
                            
                        </div>
                    </form>
                    <input type="hidden" id="pdflogodeleteText" value="<?=__("pdflogodeleteText")?>" />
                </div>
            </div><!-- /.box -->
        </div>
    </div>
</section>