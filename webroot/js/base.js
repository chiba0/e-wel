$(function() {
    
    // 削除確認
    $(".btn-delete").click(function(){
        var _val = $("#msg-delete").text();
        if(confirm(_val)){
            return true;
        }
        return false;
    });

    //パートナー画面検索ボタン押した
    $('input[name="pdflogodelete"]').click(function(){
        var _text1 = $('#pdflogodeleteText').val();
        if(confirm(_text1)){
            return true;
        }
        return false;
    });


    //パートナー画面一覧に戻る
    $("#partner_back").click(function(){
        if(confirm("一覧画面に戻ります。よろしいですか?")){
            location.href="/partners/app";
            return true;
        }
        return false;
    });


    //パートナー画面データ更新
    $("input[name='partner_edit']").click(function(){
        var _txt1 = $("#partnerEditConfirm").val();
        if(confirm(_txt1)){
            return true;
        }
        return false;
    });
    //添付ファイル一括選択
    $('input[name="checkDelete"]').click(function(){
        var _txt1 = $("#TempDeleteAllMsg").val();
        if(confirm(_txt1)){
            return true;
        }
        return false;
    });
    $("#tempAllCheck").click(function(){
        $(".deletecheck").prop("checked",$(this).prop("checked"));
        return true;
    });
    //添付ファイル削除
    $(document).on("click","a.delete-temp",function(){
        var _txt1 = $("#TempDeleteMsg").val();
        if(confirm(_txt1)){
            return true;
        }
        return false;
    });
    //パートナー新規登録画面登録ボタン
    $("#TUserRegist").click(function(){
        var _txt1 = $("#TUserRegistMsg").val();
       if(confirm(_txt1)){
           return true;
       }
       return false;
    });
    //パートナー画面検索ボタン押した
    $('input[name="search"]').click(function(){
        var _val = $('input[name="username"]').val();
        location.href = "/managers/app?username="+_val;
        return false;
    });
    //住所確認
    $('input[name="prefSearch"]').click(function(){

        AjaxZip3.zip2addr("post1","post2","prefecture","address1");
        return false;
    });

    //会員自動登録の際に出力されるPDFを選択
    //選択値を表示
    outputPDF();
    $("input.outPutPdf").click(function(){
        outputPDF();
    });


    $(".calenderSelect").datepicker({
        buttonImage: "/img/calendar-icon2.png",        // カレンダーアイコン画像
        buttonText: "カレンダーから選択", // ツールチップ表示文言
        buttonImageOnly: true,           // 画像として表示
        showOn: "both"                   // カレンダー呼び出し元の定義
    });

    
    
    //請求書計算
    setCalc();
    //担当ハンコ非表示
    hanko();
    //担当ハンコ非表示
    try{
        $("#tantohan_sts").on("click",function(){ hanko(); });
        $("#syahan_sts").on("click",function(){ hanko(); });
    }catch(e){}
});
var hanko = function(){
    //担当ハンコ非表示
    try{
        var _chk = $("#tantohan_sts:checked").val();
        $("#tantoImg").hide();
        if(_chk == "on") $("#tantoImg").show();

        var _chk = $("#syahan_sts:checked").val();
        $("#syahanImg").hide();
        if(_chk == "on") $("#syahanImg").show();
    }catch(e){}
}
var setCalc = function(){
    
    $(".calc").on("keyup",function(){
        var _num = [];
        var _p = [];
        var _v = 0;
        $(".number").each(function(k,v){
            _v = 0;
            if($(this).val() > 0 )_v= $(this).val();
            _num.push(_v);
        });
        
        $(".prices").each(function(k,v){
            _v = 0;
            if($(this).val() > 0 )_v= $(this).val();
            _p.push(_v);
        });
        var _tax = $("#tax").val();
        //個別の計算
        

        //全体の計算
        var _total=0;
        $(_p).each(function(k,v){
            var _numKey=parseInt(k)+1;
            var _tl = _p[k]*_num[k];
            if(_tl == "0") _tl="";
            //個別
            $("#total-"+_numKey).val(_tl);
            _total += _tl;
        });
        
        _total = Math.round(_total*_tax);
        $("[name='money_total']").val(_total);
        
    });
}


var outputPDF = function(){
    if($('#outputPDF').length){
        $("#outputPDF").html("");
        var _text = "";
        $('input:checkbox.outPutPdf:checked').each(function(k,v){
            var _id = $(v).attr("id");
            _text +=  "・"+$("#"+_id).parent("label").text()+"<br />";
            
        });
        $("#outputPDF").html(_text);
        return false;
    }
}

