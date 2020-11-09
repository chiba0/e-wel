<section class="content" >

    <div class="row ">
        <div class="col-md-12">
            <ul class="nav nav-tabs">
                <li ><a href="/managers/menu7/"><?=__("menu7sub1")?></a></li>
                <li class="active" ><a href="javascript:void(0);"><?=__("menu7sub2")?></a></li>
            </ul>
            <div class="box">
                <div class="box-body">
                    <h4><i class="fa fa-fw fa-list-ul"></i><?=__('menu7sub2').__('gamen')?></h4>
                    <form action="/managers/menu7/write" method="POST">
                        <div class="box-body">
                            <div class="ab">
                                <input type="submit" name="create" class="btn btn-success btn-lg" value="<?=__("menu7sub2")?>" />
                            </div>
                            <p>1.<?=__("menu7CreateMessage")?></p>
                            <button type="button" class="btn btn-default btn-sm billType" >
                                <b><?=__("kigyouate")?></b>
                                <input type="radio" name="billType" value="company" class="hidden" />
                            </button>
                            <button type="button" class="btn btn-default btn-sm billType" >
                                <b><?=__("kokyakuate")?></b>
                                <input type="radio" name="billType" value="customer" class="hidden" />
                            </button>
                        </div>
                        <div class="box-body">
                            <p>2.<?=__("menu7CreateMessage2")?></p>
                            <input type="text" class="calenderSelect" value="" /> ～ 
                            <input type="text" class="calenderSelect" value="" />
                        </div>
                        <div class="box-body">
                            <p>3.<?=__("menu7CreateMessage3")?></p>
                            <div class="row">
                                <div class="col-md-4 ">
                                    <div class="panel box box-primary">
                                        <div class="box-body">
                                            <p>▼<?=__("menu7CreateMessage4")?></p>
                                            <input type="text" id="partner_name"  class="form-control" placeholder="<?=__("menu7CreateMessage4Text")?>" />
                                            <div class="scrollbar pd5" id="partner_name_box">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="panel box box-primary">
                                        <div class="box-body">
                                            <p>▼<?=__("menu7CreateMessage5")?></p>
                                            <input type="text" id="customer_name" class="form-control" placeholder="<?=__("menu7CreateMessage5Text")?>" value="" />
                                            <div class="scrollbar pd5" id="customer_name_box">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="panel box box-primary">
                                        <div class="box-body">
                                            <p>▼<?=__("menu7CreateMessage6")?></p>
                                            <input type="text" id="test_name"  class="form-control" placeholder="<?=__("menu7CreateMessage6Text")?>" 　/>
                                            <div class="scrollbar pd5" id="test_name_box">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="box-body">
                            <input type="submit" name="create" class="btn btn-success btn-lg" value="<?=__("menu7sub2")?>" />
                        </div>
                    </form>
                </div>
            </div><!-- /.box -->
        </div>
    </div>
</section>
<script type="text/javascript">
var _pText="";
var _pTextc="";
var _pTextt="";
$(function(){
    //請求書作成画面　顧客宛　企業宛選択
    $(".billType").click(function(){
        $(this).find("input").prop("checked",true);
        $(".billType").find("b").css("color","#666");
        $(".billType").removeClass("active");
        $(this).addClass("active");
        $(this).find("b").css("color","red");
        return true;
    });
    //パートナー一覧
    $(this).getPartner();
    $("#partner_name").keyup(function(){
        $("input[name='partner_name']").prop("checked",false);
        _pText = $(this).val();
        $(this).getPartner();
    });
    //パートナー選択
    $(this).on("click","input[name='partner_name']",function(){
        $("input[name='partner_name']").prop("checked",false);
        $(this).prop("checked",true);
        //顧客一覧表示
        $(this).getCustomer();
        return true;
    });
    //顧客企業検索
    $("#customer_name").keyup(function(){
        $("input[name='customer_name']").prop("checked",false);
        _pTextc = $(this).val();
        $(this).getCustomer();
    });
    //顧客選択
    $(this).on("click","input[name='customer_name']",function(){
        $("input[name='customer_name']").prop("checked",false);
        $(this).prop("checked",true);
        $(this).getTest();
        return true;
    });
    //検査検索
    $("#test_name").keyup(function(){
        $("input[name='test_name']").prop("checked",false);
        _pTextt = $(this).val();
        $(this).getTest();
    });

});
//検査名選択
$.fn.getTest = function(){
    var _test_name_box;
    _test_name_box = $("#test_name_box");
    _test_name_box.empty();
    var _pt = $("input[name='partner_name']:checked").val();
    if(!_pt) return false;
    var _cs = $("input[name='customer_name']:checked").val();
    if(!_cs) return false;

    var _data = {
        "type":"test",
        "name":_pTextt,
        "partnerid":_pt,
        "customerid":_cs
    }
    $.ajax({
        url:"/managers/menu7/getTest/",
        type:"POST",
        data:_data,
        dataType: 'json',
        success(result){
            var _div = "";
            _test_name_box.empty();
            $.each(result,function(key,value){
                _div = "<div class='row'>";
                _div += "<div class='col-md-1'><input type='checkbox' id='ts-"+key+"' name='test_name' value='"+value.id+"' /></div>";
                _div += "<div class='col-md-10 pd-lt0'><label for='ts-"+key+"'>"+value.name+"</label></div>";                
                _div += "</div>";
                _test_name_box.append(_div);
            });

        }
    });
    return false;
};
//顧客企業名選択
$.fn.getCustomer = function(){
    var _customer_name_box;
    _customer_name_box = $("#customer_name_box");
    _customer_name_box.empty();
    var _pt = $("input[name='partner_name']:checked").val();
    if(!_pt) return false; 
    var _data = {
        "type":"customer",
        "name":_pTextc,
        "partnerid":_pt
    }
    $.ajax({
        url:"/managers/menu7/getCustomer/",
        type:"POST",
        data:_data,
        dataType: 'json',
        success(result){
            var _div = "";
            _customer_name_box.empty();
            $.each(result,function(key,value){
                _div = "<div class='row'>";
                _div += "<div class='col-md-1'><input type='checkbox' id='cs-"+key+"' name='customer_name' value='"+value.id+"' /></div>";
                _div += "<div class='col-md-10 pd-lt0'><label for='cs-"+key+"'>"+value.name+"</label></div>";                
                _div += "</div>";
                _customer_name_box.append(_div);
            });

        }
    });
    return false;
};

//パートナー一覧取得
$.fn.getPartner = function(){
    var _data = {
        "type":"partner",
        "name":_pText
    }
    $.ajax({
        url:"/managers/menu7/getPartner/",
        type:"POST",
        data:_data,
        dataType: 'json',
        success(result){
            var _partner_name_box;
            _partner_name_box = $("#partner_name_box");
            _partner_name_box.empty();
            var _div = "";
            $.each(result,function(key,value){
                _div = "<div class='row'>";
                _div += "<div class='col-md-1'><input type='checkbox' id='pt-"+key+"' name='partner_name' value='"+value.id+"' /></div>";
                _div += "<div class='col-md-10 pd-lt0'><label for='pt-"+key+"'>"+value.name+"</label></div>";                
                _div += "</div>";
                _partner_name_box.append(_div);
            });
        }
    });
    return false;
};


</script>