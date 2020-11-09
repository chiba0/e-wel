<section class="content" >
    <div class="row ">
        <div class="col-md-12">
            <form action="/managers/menu7/recipe" method="POST">
                <div class="box">
                    <div class="box-body">
                        <h4><i class="fa fa-fw fa-list-ul"></i><?=__('menu7sub3').__('gamen')?></h4>
                        <p class="text-center">請求書</p>
                        <div class="row">
                            <div class="col-md-6">
                                
                                <div class="col-xs-1  pd0 w20p ">〒</div>
                                <div class="col-xs-1  pd0">
                                    <input type="text" class="form-control input-sm pd2" name="post1" placeholder="000" maxlength="3" value="<?=$post1?>" />
                                </div>
                                <div class="col-xs-1 text-center pd0 w20p">-</div>
                                <div class="col-xs-2 pd0">
                                    <input type="text"  class="form-control input-sm pd2" name="post2" placeholder="0000" maxlength="4" value="<?=$post2?>" />
                                </div>
                                <div class="col-xs-12 pd5">
                                    <input type="text"  class="form-control input-sm pd2" name="address" placeholder="請求書発行先住所を入力" value="<?=$address?>" />
                                    <input type="text"  class="form-control input-sm pd2" name="address2" placeholder="請求書発行先住所を入力" value="<?=$address2?>" />
                                    <input type="text"  class="form-control input-sm pd2" name="name" placeholder="請求書発行先名を入力" value="<?=$name?>" />
                                </div>
                                <div class="col-xs-12 pd5">
                                    <input type="text"  class="form-control input-sm pd2 w300p" name="busyo" placeholder="部署名を入力" value="<?=$busyo?>"  />
                                </div>
                                <div class="col-xs-4 pd5">
                                    <input type="text"  class="form-control input-sm pd2" name="yakusyoku" placeholder="役職名を入力" value="<?=$yakusyoku?>" />
                                </div>
                                <div class="col-xs-4 pd5">
                                    <input type="text"  class="form-control input-sm pd2" name="atena" placeholder="宛名を入力" value="<?=$atena?>" />
                                </div>
                                <div class="col-xs-2 text-left pd0 pt pd-tp10">様</div>
                                <br clear=all />
                                <div class="billborder">
                                    <div class="col-md-12">
                                        <p>下記の通りご請求申し上げます。</p>
                                    </div>
                                </div>
                                <div class="billborder ">
                                    <div class="col-md-2 w100p">
                                        <p class="mt5">請求金額</p>
                                    </div>
                                    <div class="col-md-1 w10p"><p class="mt5">￥</p></div>
                                    <div class="col-md-6 text-left">
                                        <input type="text" class="form-control" name="money_total" value="<?=$money_total?>" />
                                    </div>
                                    <div class="col-md-2"><p class="mt5">税込</p></div>
                                </div>
                                <div class="billborder ">
                                    <div class="col-md-2 w100p">
                                        <p class="mt5">件名</p>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control input-sm" name="title" value="<?=$title?>" />
                                    </div>
                                </div>
                                <div class="billborder ">
                                    <div class="col-md-2 w100p">
                                        <p class="mt5">御支払日</p>
                                    </div>
                                    <div class="col-md-3 pd-rt0">
                                        <input type="text" class="form-control input-sm" name="pay_date_year" value="<?=$pay_date_year?>" />
                                    </div>
                                    <div class="col-md-1 w5p pd-lt0"><p class="mt5">年</p></div>
                                    <div class="col-md-2 pd-rt0">
                                        <input type="text" class="form-control input-sm" name="pay_date_month" value="<?=$pay_date_month?>" />
                                    </div>
                                    <div class="col-md-1 w5p pd-lt0"><p class="mt5">月</p></div>
                                    <div class="col-md-2 pd-rt0">
                                        <input type="text" class="form-control input-sm" name="pay_date_day" value="<?=$pay_date_day?>" />
                                    </div>
                                    <div class="col-md-1 w5p pd-lt0"><p class="mt5">日</p></div>
                                </div>
                                <div class="billborder  ">
                                    <div class="col-md-2 w100p">
                                        <p class="mt5">御振込先</p>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control input-sm" name="pay_bank" value="<?=$pay_bank?>" />
                                    </div>
                                    <div class="col-md-2 w100p">
                                        <p class="mt5">口座番号</p>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control input-sm" name="pay_num" value="<?=$pay_num?>" />
                                    </div>
                                </div>

                                <div class="billborder ">
                                    <div class="col-md-2 w100p">
                                        <p class="mt5">口座名義</p>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control input-sm" name="pay_name" value="<?=$pay_name?>" />
                                    </div>
                                </div>
                                <div class="billborder ">
                                    <p>※振込手数料は、貴社負担にてお願い申し上げます。</p>
                                </div>
                            </div>
                            <div class="col-md-1">&nbsp;</div>
                            <div class="col-md-5">
                                <div class="rel">
                                    <img src="/img/innovation.gif" id="syahanImg" />
                                </div>
                                <div class="row">
                                    <div class="col-md-3 text-right">
                                        <p class="mt5" >請求書No.</p>
                                    </div>
                                    <div class="col-md-9 pd-lt0">
                                        <input type="text" class="form-control" value="<?=$bill_num?>" name="bill_num" placeholder="請求書番号を入力してください。" /> 
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3 text-right">
                                        <p class="mt5" >発行日</p>
                                    </div>
                                    <div class="col-md-9 pd-lt0 ml0 ">
                                        <div class="col-md-3 pd-lt0 ">
                                            <input type="text" class="ml0 form-control input-sm" name="registdate_year" value="<?=$registdate[ 'y' ]?>" placeholder="0000"  maxlength="4" />
                                        </div>
                                        <div class="col-md-1 w5p pd-lt0"><p class="mt5">年</p></div>
                                        <div class="col-md-2 pd-rt0">
                                            <input type="text" class="form-control input-sm" name="registdate_month" value="<?=$registdate[ 'm' ]?>"  placeholder="00" maxlength="2" />
                                        </div>
                                        <div class="col-md-1 w5p pd-lt0"><p class="mt5">月</p></div>
                                        <div class="col-md-2 pd-rt0">
                                            <input type="text" class="form-control input-sm" name="registdate_day" value="<?=$registdate[ 't' ]?>" placeholder="00" maxlength="2" />
                                        </div>
                                        <div class="col-md-1 w5p pd-lt0"><p class="mt5">日</p></div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3 text-right">
                                        <p class="mt5" >〒</p>
                                    </div>
                                    <div class="col-md-9 pd-lt0 ml0 ">
                                        <div class="col-md-3 pd-lt0">
                                            <input type="text" class="ml0 form-control input-sm" name="company_post1" value="<?=$company_post1?>" maxlength=3 placeholder="0000"  />
                                        </div>
                                        <div class="col-md-1 w5p pd-lt0"><p class="mt5">-</p></div>
                                        <div class="col-md-4 pd-rt0">
                                            <input type="text" class="form-control input-sm" name="company_post2" value="<?=$company_post2?>" maxlength=4  placeholder="0000"  />
                                        </div>
                                        <div class="col-md-4 pd-rt0">
                                            &nbsp;
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-md-3 text-right">
                                        <p class="mt5" >&nbsp;</p>
                                    </div>
                                    <div class="col-md-9 pd-lt0 ml0 ">
                                        <input type="text" class="ml0 form-control input-sm" name="company_address" value="<?=$company_address?>" placeholder="発行元住所を入力してください。" />
                                        <input type="text" class="ml0 form-control input-sm" name="company_address2" value="<?=$company_address2?>" placeholder="発行元住所番地(建物名)を入力してください。" />
                                        <input type="text" class="ml0 form-control input-sm" name="company_name" value="<?=$company_name?>" placeholder="発行元会社名を入力してください。" />
                                        <input type="text" class="ml0 form-control input-sm" name="company_telnum" value="<?=$company_telnum?>" placeholder="発行元連絡先を入力してください。" />
                                    </div>
                                </div>
                                <div class="row">
                                    <table class="tantoTable">
                                        <tr><td>担当者</td></tr>
                                        <tr>
                                            <td class="text-center">
                                                <img src="/img/sasaki.gif" id="tantoImg" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                            <?php 
                                                $chk=""; 
                                                if($syahan_sts == "on") $chk = "CHECKED";
                                            ?>
                                            <input type="checkbox" <?=$chk?> name="syahan_sts" id="syahan_sts" value="on" class="simple" />
                                            <label for="syahan_sts" >社判あり</label>
                                            <br />
                                            <?php 
                                                $chk=""; 
                                                if($tantohan_sts == "on") $chk = "CHECKED";
                                            ?>
                                            <input type="checkbox" <?=$chk?>  name="tantohan_sts" id="tantohan_sts" value="on" class="simple" />
                                            <label for="tantohan_sts" >担当判あり</label>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <table class="mt20 table table-bordered" >
                    <tr class="bg-blue fwhite " >
                        <th class="w20p text-center" >No</th>
                        <th class="text-center" >品名</th>
                        <th class="text-center">銘柄</th>
                        <th class="text-center">規格</th>
                        <th class="w60p text-center">数量</th>
                        <th class="w60p text-center">単位</th>
                        <th class="w100p text-center">単価</th>
                        <th class="w100p text-center">金額</th>
                    </tr>
                    <?php for($i=1;$i<=15;$i++):?>
                    <tr>
                        <td><?=$i?></td>
                        <td><input type="text" name="bill[<?=$i?>][article]" value="<?=$bill[$i]['article']?>" class="input-sm form-control" /></td>
                        <td><input type="text" name="bill[<?=$i?>][brand]" value="<?=$bill[$i]['brand']?>" class="input-sm form-control" /></td>
                        <td><input type="text" name="bill[<?=$i?>][standard]" value="<?=$bill[$i]['standard']?>" class="input-sm form-control" /></td>
                        <td><input type="text" name="bill[<?=$i?>][number]" value="<?=$bill[$i]['number']?>" class="input-sm form-control calc number" /></td>
                        <td><input type="text" name="bill[<?=$i?>][unit]" value="<?=$bill[$i]['unit']?>" class="input-sm form-control" /></td>
                        <td><input type="text" name="bill[<?=$i?>][unitprice]" value="<?=$bill[$i]['unitprice']?>" class="input-sm form-control calc prices" /></td>
                        <td><input type="text" name="bill[<?=$i?>][price]" value="<?=$bill[$i]['price']?>" class="input-sm form-control price" id="total-<?=$i?>" /></td>
                    </tr>
                    <?php endfor; ?>
                </table>
                <p>※備考</p>
                <textarea name="other" class="form-control" rows=3><?=$other?></textarea>
                <div class="text-center mt20">
                    <input type="submit" name="billSend" value="請求書発行" class="btn btn-success" />
                </div>
            </form>
            <input type="hidden" id="tax" value="<?=$tax?>" />
        </div>
    </div>
</section>
