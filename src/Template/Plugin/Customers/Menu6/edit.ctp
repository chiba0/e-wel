<section class="content" >
    <div class="row ">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body">
                    <h4><i class="fa fa-fw fa-list-ul"></i><?=__d('custom','cmenu6edit').__('gamen')?></h4>

                    <form action="/customers/menu6/edit/<?=$id?>" method="post" > 
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-border" >
                                    <tr>
                                        <th class="w300p"><?=__d("custom","inspection")?></th>
                                        <td>
                                            <input type="text" name="inspection" value="<?=$data[ 'inspection' ]?>" class="form-control" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="w300p"><?=__d("custom","judge")?></th>
                                        <td>
                                        <input type="text" name="evaluation" value="<?=$data[ 'evaluation' ]?>" class="form-control" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="w300p"><?=__d("custom","pass")?></th>
                                        <td>
                                        <input type="text" name="adopt" value="<?=$data[ 'adopt' ]?>" class="form-control" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="w300p"><?=__d("custom","enterdate")?></th>
                                        <td>
                                        <input type="text" name="enterdate" value="<?=$data[ 'enterdate' ]?>" class=" calenderSelect" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="w300p"><?=__d("custom","retiredate")?></th>
                                        <td>
                                        <input type="text" name="retiredate" value="<?=$data[ 'retiredate' ]?>" class=" calenderSelect" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="w300p"><?=__d("custom","retirereason")?></th>
                                        <td>
                                            <textarea class="form-control" name="retirereason" rows=6 ><?=$data[ 'retirereason' ]?></textarea> 
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="row mt20">
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-success" id="edit" value="on" name="edit" ><?=__("edit")?></button>
                            </div>
                        </div>

                            
                    </form>
                    <input type="hidden" id="edittext" value="<?=$edittext?>" />
                </div>
            </div><!-- /.box -->
        </div>
    </div>
</section>

<script type="text/javascript" >
$(function(){
    $("#edit").click(function(){
        var _txt = $("#edittext").val();
        if(confirm(_txt)){
            return true;
        }else{
            return false;
        }
    });
});

</script>