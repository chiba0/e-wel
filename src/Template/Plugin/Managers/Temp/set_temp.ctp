<section class="content" >

    <div class="row ">
        <div class="col-md-12">
            <ul class="nav nav-tabs">
                <li ><a href="/managers/temp/lists/<?=$id?>"><?=__("tempfilelist")?></a></li>
                <li class="active"><a href="javascript:void(0);"><?=__("filetemp")?></a></li>
            </ul>
            <div class="box">
                <div class="box-body">
                    <h4><i class="fa fa-fw fa-list-ul"></i><?=__('filetemp').__('gamen')?></h4>
                    <form action="/managers/temp/setTemp/<?=$id?>" method="POST" enctype="multipart/form-data" >
                        <input type="file" name="upfile">
                        <br />
                        <input type="submit" name="fileupload" class="btn btn-primary" value="<?=__("fileupload")?>"  />
                    </form>
                </div>
            </div><!-- /.box -->
        </div>
    </div>
</section>