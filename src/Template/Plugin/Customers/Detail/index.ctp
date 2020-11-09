
<section class=" " >

    <div class="row ">
        
        <div class="col-md-12">
        
                <h3 class="box-title"><i class="fa fa-fw fa-wrench"></i>
                <?= __d("custom",'customerreg10')?></h3>
            
            <div class="box box-info">
                <div class="box-header">
                    <h3 class="box-title"><?= __('filter')?></h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <form action="/customers/detail/index/<?=$id?>" method="POST" >
                        <div class="row">
                            <div class="col-md-3">
                                <p><?= __d('custom','clist2')?></p>
                                <input type="text" name="id" value="<?=$this->request->getdata('id')?>" class="form-control"  />
                            </div>
                            <div class="col-md-3">
                                <p><?= __d('custom','clist3')?></p>
                                <input type="text" name="name" value="<?=$this->request->getdata('name')?>" class="form-control"  />
                            </div>
                            <div class="col-md-3">
                                <p><?= __d('custom','clist4')?></p>
                                <input type="text" name="kana" value="<?=$this->request->getdata('kana')?>" class="form-control"  />
                            </div>
                            <div class="col-md-3">
                                <p><?= __d('custom','dlist1')?></p>
                                <select name="exam_state" class="form-control">
                                    <option value="">-</option>
                                    <?php foreach($d_exam_state as $key=>$value ):
                                            $sel = "";
                                            if($this->request->getData("exam_state")) $sel = "SELECTED";
                                        ?>
                                        <option value="<?=$key?>" <?=$sel?> ><?=$value?></option>
                                    <?php endforeach;?>
                                </select>

                            </div>
                        </div>
                        <div class="row mt20">
                            <div class="col-md-2">
                                <p><?= __d('custom','start_search')?></p>
                                <input type="text" name="start_search" value="<?=$this->request->getdata('start_search')?>" class="w100p calenderSelect "  />
                            </div>
                            <div class="col-md-2">
                                <p><?= __d('custom','end_search')?></p>
                                <input type="text" name="end_search" value="<?=$this->request->getdata('end_search')?>" class="w100p calenderSelect"  />
                            </div>
                            <div class="col-md-8">
                                <p><?= __d('custom','memo')?></p>
                                <input type="text" name="memo" value="<?=$this->request->getdata('memo')?>" class="form-control"  />
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <p>&nbsp;</p>
                                <input type="submit" name="partner_search" class="btn btn-success"   value=<?= __('search');?> />
                            </div>
                        </div>
                    </form>
                </div><!-- /.box-body -->
            </div>

            <div class="box-body content" >
                <div class=" mt20">
                    <div class="col-md-1">
                        <?php if($pg > 0):?>
                            <a href="/customers/detail/index/<?=$id?>/?p=<?=$pg-1?>" class="btn btn-default">
                            <?=__("mae50")?>
                            </a>
                        <?php else:?>
                            <a href="#" class="btn btn-default " disabled>
                            <?=__("mae50")?>
                            </a>
                        <?php  endif; ?>
                    </div>
                    
                    <div class="col-md-1">
                        <?php if($ceil > $pg):?>
                            <a href="/customers/detail/index/<?=$id?>/?p=<?=$pg+1?>" class="btn btn-default" >
                            <?=__("tugi50")?>
                            </a>
                        <?php else:?>
                            <a href="#" disabled class="btn btn-default" >
                            <?=__("tugi50")?>
                            </a>
                        <?php endif; ?>
                    </div>
                    
                </div>
                
                <br clear=all />
                <?php if(isset($wt->weight) && $wt->weight == 1): ?>
                ※行動価値適合度は５段階で表示しています。１が貴社にとってリスクの高い応募者となります。
                <?php endif; ?>
                <div class="row mt20 " style="width:<?=$width?>%;height:500px;">
                
                    <table class="table table-bordered">
                        <tr class="bg-blue  ">
                            <th class="text-center valign w160p" rowspan="2"><?=__("kino")?></th>
                            <th class="text-center valign w60p" rowspan="2"><?=__d("custom","clist1")?></th>
                            <th class="text-center valign w100p" rowspan="2"><?=__d("custom","clist2")?></th>
                            <th class="text-center valign w150p" rowspan="2"><?=__d("custom","clist3")?></th>
                            <th class="text-center valign w150p" rowspan="2"><?=__d("custom","clist4")?></th>
                            <th class="text-center valign w100p" rowspan="2"><?=__d("custom","clist5")?></th>
                            <th class="text-center valign w100p" rowspan="2"><?=__d("custom","dlist1")?></th>
                            <?php foreach($examGroup as $value):
                                $col = $D_COLSPAN[$value['eg'][ 'name' ]];
                                //行動価値で重み付けがないときは-1を行う
                                if($value[ 'em' ][ 'exam_group_id' ] == 1 && $wt->weight == 0 ){
                                    $col = $col-1;
                                }
                                ?>
                            <th class="text-center valign " colspan=<?=$col?> ><?=$value['em'][ 'name' ]?></th>
                            <?php endforeach;?>
                            <th  class="text-center  valign" rowspan="2" ><?=__d("custom","memo1")?></th>
                            <th  class="text-center  valign" rowspan="2" ><?=__d("custom","memo2")?></th>
                            <?php if($testdata['pdf_log_use']):?>
                                <th class="text-center valign w100p" rowspan="2"><?=__d("custom","ctable9")?></th>
                            <?php endif; ?>
                        </tr>
                        <tr class="bg-blue valign">
                            <?php foreach($examGroup as $value):?>
                                <?=$this->element("examDetail/".$value['eg'][ 'name' ]."/head");?>
                            <?php endforeach;?>
                        </tr>
                        <?php foreach($lists as $list): ?>
                            <tr>
                                <td class="text-center">
                                    <a href="/customers/detail/edit/<?=$list[ 'id' ]?>" class="btn btn-info">
                                    <span class="glyphicon glyphicon-edit"></span> <?=__d("custom","edit")?></a>
                                    <?php if($checkPdf): ?>
                                    <a href="/customers/pdf/<?=$list[ 'id' ]?>" class="btn btn-default">
                                        <span class="glyphicon glyphicon-cloud-download"></span> PDF</a>
                                    <?php endif;?>
                                </td>
                                <td><?=$list[ 'number' ]?></td>
                                <td><?=$list[ 'exam_id' ]?></td>
                                <td><?=$list[ 'name' ]?></td>
                                <td><?=$list[ 'kana' ]?></td>
                                <td class="text-center"><?=$list[ 'birth' ]?>
                                <?php if($list[ 'age' ] > 0): ?>
                                    (<?=$list[ 'age' ]?>)
                                <?php endif;?>
                                </td>
                                <td class="text-center"><?=$list[ 'pass' ]?></td>
                                <?php foreach($examGroup as $value):?>
                                    <?=$this->element("examDetail/".$value['eg'][ 'name' ]."/body",['arg'=>$list]);?>
                                <?php endforeach;?>
                                <td><?=nl2br($list[ 'memo1' ])?></td>
                                <td><?=nl2br($list[ 'memo2' ])?></td>
                                <?php if($testdata['pdf_log_use']):?>
                                    <td class="text-center">
                                    <?php if(
                                        isset($log_pdf[$list[ 'exam_id' ]]) 
                                        && $log_pdf[$list[ 'exam_id' ]] == "on" ): ?>
                                        <small class="badge bg-green"><?=$D_PDF_OUTPUT[1]?></small>
                                    <?php else: ?>
                                        <small class="badge bg-red"><?=$D_PDF_OUTPUT[0]?></small>

                                    <?php endif;?>
                                    </td>
                                <?php endif;?>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                
            </div><!-- /.box-body -->
            
        </div>
    </div>
</section>
<input type="hidden" id="sakujyoText" value="<?=__("sakujyoText")?>" />
<!--行動価値検査用結果表示モーダル-->
<div class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="modal-title">Loading...</h4>
      </div>
      <div class="modal-body">
      Loading...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript" >
$(function(){
    var _url = "";
    //モーダル表示
    $('.click_btn').on('click', function(){
        $("#modal-title").html("Loading...");
        $(".modal-body").html("Loading...");
        $('.modal').modal('show');
        var _id = $(this).attr("id").split("-");
        _url = "/customers/detail/eabj/"+_id[1];
        $.ajax({
            url:_url,
            type:"post",
            dataType:"json"
        }).done(function(rlt){
            var _name = rlt['name']+"さんの結果";
            $("#modal-title").html(_name);
            var _body = "";
            _body = rlt['text0'];
            _body += "<br />";
            _body += "<br />";
            _body += rlt['text1'];
            _body += "<br />";
            _body += "<br />";
            _body += rlt['text2'];
            _body += "<br />";
            _body += "<br />";
            _body += "<center><img src=/img/baj/"+rlt['text3']+" /></center>";
            _body += "<br />";
            _body += "<br />";
            _body += rlt['text4'];

            $(".modal-body").html(_body);
            
            
        }).fail(function(){
            alert("error");
        });
        
        return false;
    });

});

</script>