$(function(){

    // パートナー検索
    $("#partner_name").keyup(function(){
        var name = $(this).val();
        $(".partners option").each(function(){
            if ($(this).text().match(name)) {
                $(this).prop("hidden", false);
            } else {
                $(this).prop("hidden", true);
            }
        });
    });

    // パートナー表示移動
    var p_move = function(from, to) {
        $("#"+from+" option:selected").each(function(){
            $(this).prop("selected", false).appendTo("#"+to);
        });
        var arr = $("#"+to+" option").sort(function(a, b){
            return (parseInt($(a).attr("class")) > parseInt($(b).attr("class")) ? 1 : -1);
        });
        $("#"+to).empty();
        arr.each(function(){
            $("#"+to).append($(this));
        });
    };
    $("#btn_all_r").click(function(){
        $("#partner_list option:visible").prop("selected", true);
        p_move("partner_list", "partner_selected");
    });
    $("#btn_r").click(function(){
        p_move("partner_list", "partner_selected");
    });
    $("#btn_all_l").click(function(){
        $("#partner_selected option:visible").prop("selected", true);
        p_move("partner_selected", "partner_list");
    });
    $("#btn_l").click(function(){
        p_move("partner_selected", "partner_list");
    });
    
    // パートナー登録
    var total = $("#partner_count").text();
    $("#regist_partner").click(function(){
        var count = $("#partner_selected option").length;  
        if (count == total) {
            $("#disp_area").val("1");
            $("#disp_id_list").val("");
            $("#msg_please_select").prop("hidden", true);
            $("#msg_all_partner").prop("hidden", false);
            $("#msg_selected_count").prop("hidden", true);
            temp_save();
        } else if (count > 0) {
            var ids = "";
            $("#partner_selected option").each(function(){
                ids += $(this).val() + ":";
            });
            ids = ids.slice(0, -1);
            $("#disp_area").val("2");
            $("#disp_id_list").val(ids);
            $("#msg_please_select").prop("hidden", true);
            $("#msg_all_partner").prop("hidden", true);
            $("#msg_selected_count").prop("hidden", false);
            $("#selected_count").text(count);
            temp_save();
        }
        $("#modal_p").modal("hide");
    });

    // モーダル
    var partner_list_save = "";
    var partner_selected_save = "";
    var cancel = false;
    var temp_save = function(){
        partner_list_save = $("#partner_list option");
        partner_selected_save = $("#partner_selected option");
    };
    // 表示した時点の選択情報を一時保存
    $("#modal_p").on("show.bs.modal", function(){
        temp_save();
    });
    // キャンセル時
    $(".modal_cancel_btn").click(function(){
        cancel = true;
        $(".partners option").prop("selected", false);
    });
    // close時の処理
    $("#modal_p").on("hide.bs.modal", function(e){
        // パートナーを選択していない場合は閉じない
        if ($("#partner_selected option").length === 0 && !cancel) {
            $("#err_not_select").prop("hidden", false);
            return false;
        } else if (cancel) {
            $(".partners").empty();
            $("#partner_list").append(partner_list_save);
            $("#partner_selected").append(partner_selected_save);
        }
        $(".partner_name").val("");
        $(".partners option").each(function(){
            $(this).prop({"hidden":false, "selected":false});
        });
        $("#err_not_select").prop("hidden", true);
        cancel = false;
    });
});