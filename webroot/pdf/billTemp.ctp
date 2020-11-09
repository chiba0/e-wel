<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>請求書</title>
</head>
<style type="text/css">
.c{text-align:center;}
.r{text-align:right !important;}
.lt{text-align:left !important;}
.f9{font-size:9px;}
h3{
    font-weight: thin;
    font-size:18px;
}
.main{ font-size:11px; }
table.table1{ border-top:1px solid #000; }
table.table1 td,
table.table2 td
{
    border-bottom:1px solid #000;
    line-height: 200%;
    width:260px;
}
table.table2 td.w80{ width:80px; }
table.table2 td.w180{ width:180px; }
table.tanto{
    width:50px;
    border:1px solid #000;
    font-size:8px;
}
table.bill-1{ border-bottom:1px solid #000; }
table.bill-1 td{padding:5px; }

table.tanto td.one{
    border:1px solid #000;
    text-align: center;
}
table.tanto td.two{
    border-left:1px solid #000;
    border-right:1px solid #000;
    border-bottom:1px solid #000;
    text-align: center;
    height:50px;
    padding:10px;
}
.img{height:30px;}
.ht40{height:40px;}
.ht100{height:100px;}

.w20{width:20px;}
.w30{width:30px;}
.w60{width:60px;}
.w80{width:80px;}
.w100{width:100px;}
.w110{width:110px;}
.w120{width:120px;}
.w160{width:160px;}
.w180{width:180px;}
.w200{width:200px;}
.w220{width:220px;}
.w300{width:300px;}
.w320{width:320px;}
.w350{width:350px;}
.w400{width:400px;}


table.billTable{
    border-top:1px solid #ddd;
    border-left:1px solid #ddd;
}
table.billTable th{
    border-bottom:1px solid #ddd;
    border-right:1px solid #ddd;
    background-color:#0073b7;
    text-align: center;
    color:#fff;
    line-height: 200%;
}
table.billTable td{
    border-bottom:1px solid #ddd;
    border-right:1px solid #ddd;
    line-height: 180%;
    text-align:right;
}
table.billTable td.l{
    text-align:left !important;
}

</style>
<body>

<h3 class="c" >御請求書</h3>
<div class="main">
    <table>
        <tr>
            <td class="w350">〒 ##post1##-##post2##<br /><br />
                ##address##<br />
                ##address2##<br />
                ##name##<br /><br />
                ##busyo##<br />
                ##yakusyoku## ##atena## 様
                <br />
                <br />
                <table class="table1">
                    <tr><td colspan="2">下記の通りご請求申し上げます。</td></tr>
                </table>
                <table class="table2">
                    <tr>
                        <td class="w80">請求金額</td>
                        <td class="w180">##money_total##円　<small>税込</small></td>
                    </tr>
                    <tr>
                        <td class="w80">件名</td>
                        <td class="w180">##title##</td>
                    </tr>
                    <tr>
                        <td class="w80">御支払日</td>
                        <td class="w180">##pay_date_year##年
                            ##pay_date_month##月
                            ##pay_date_day##日
                        </td>
                    </tr>
                    <tr>
                        <td class="w80">御振込先<br />口座番号
                        </td>
                        <td class="w180">##pay_bank##<br />##pay_num##
                        </td>
                    </tr>
                    <tr>
                        <td class="w80">口座名義</td>
                        <td class="w180">##pay_name##</td>
                    </tr>
                </table>
                <p>※振込手数料は、貴社負担にてお願い申し上げます。</p>
            </td>
            <td class="r w200">
                <table class="bill-1">
                    <tr>
                        <td class="w60">請求書No.</td>
                        <td class="w120 r"> ##bill_num##</td>
                    </tr>
                </table>
                <table class="w180">
                    <tr><td>
                    ##registdate_year##年
                    ##registdate_month##月
                    ##registdate_day##日
                    </td></tr>
                </table>
                <table >
                    <tr><td class="ht100">&nbsp;</td></tr>
                </table>
                <table>
                    <tr><td class="lt">〒　##company_post1## - ##company_post2##</td></tr>
                    <tr><td class="lt">##company_address##</td></tr>
                    <tr><td class="lt">##company_address2##</td></tr>
                    <tr><td class="lt">##company_name##</td></tr>
                    <tr><td class="lt">##company_telnum##</td></tr>
                </table>
                <table >
                    <tr><td class="ht40">&nbsp;</td></tr>
                </table>
                <table >
                    <tr>
                        <td class="w120">&nbsp;</td>
                        <td class="r">
                            <table class="tanto">
                                <tr>
                                    <td class="one">担当者</td>
                                </tr>
                                <tr>
                                    <td class="two">
                                        <br /><br />
                                        ##tanto_image##
                                        
                                    </td>
                                </tr>
                            </table>

                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <br />
    <br />
    <br />
    <table class="billTable">
        <tr>
            <th class="w30">No</th>
            <th class="w110">品名</th>
            <th class="w110">銘柄</th>
            <th class="w80">規格</th>
            <th class="w30">数量</th>
            <th class="w30">単位</th>
            <th class="w80">単価</th>
            <th class="w80">金額</th>
        </tr>
        ##billtable##
    </table>
    <br /><br />
    ※備考<br />
    ##other##
</div>
</body>
</html>