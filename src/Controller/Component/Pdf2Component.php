<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\I18n\I18n;
use Cake\Core\Configure;
use Cake\Http\Cookie\Cookie;
use App\Controller\AppController as BaseController;
use Cake\Mailer\Email;
use Cake\Routing\Router;




/**
 * Pdf component
 */
class Pdf2Component extends Component
{
    public function Initialize(array $config)
    {
        $this->_user = $this->request->Session()->read('Auth');
        



        $this->array_pdf_question = array(
            "dev1"=>array(
                    "自分がやりたいことを考えていないか、もしくは、気づいていないため、仕事に意欲をもって取り組めない可能性があります。"
                    ,"「あなたは、何かしている際に、自分がネガティブ（イライラ、怒り、不安等）な気持ちを持っていると気づいたことはありますか？」 「その際、ネガティブな気持ちに対してどのように対応しましたか。具体的な例を聞かせてください。」"
                    ,"自分のネガティブな感情を解消するための具体的な行動を説明することができれば問題ありません。ただし、解消できないような行動を取っている場合や、行動そのものが説明できない場合、ネガティブな感情を感じたことがない場合には、「リスクとなる行動」が起こる可能性を否定できません。"
                    ),
            "dev2"=>array(
                    "自分の能力を過信し、周囲の助言を受け入れようとしない、逆に、自分を過小評価してチャレンジしようとしない可能性があります"
                    ,"「あなたが最近、他者からミスや失敗を指摘された経験はありますか？」 「具体的な例を聞かせてください。また、指摘された際、あなたはどのように感じ、その後、指摘されたことを日々の行動においてどのように活かしましたか。"
                    ,"他人の指摘を素直に受け入れている事例があり、その後具体的な行動としての例を説明することができれば問題ありません。ただし、失敗を受け入れていない、もしくは、指摘内容を直そうとしていない場合や、失敗を指摘されたことがない場合には、「リスクとなる行動」が起こる可能性を否定できません。"
                    ),
            "dev3"=>array(
                    "自分の能力・知識・経験に自信をもてないため、何事にも不安に感じ、自分を卑下するような行動を取る可能性があります。"
                    ,"「あなたが一番自信をもてることは何ですか？」 「それを実践した具体的な例を聞かせてください。それは、いつ、どのような場面の、どんな行動として発揮しましたか。」"
                    ,"自分の中で自信をもっていることがあり、しかもそれが行動として発揮されている例があれば問題ありません。ただし、まったく自信をもっていることがない、あるいは、自信を持っていてもそれが実践されている行動が無かった場合には、「リスクとなる行動」が起こる可能性を否定できません。"
                    ),
            "dev4"=>array(
                    "不快な事態や不利な状況において、冷静さを欠いた行動を取る。もしくは、逃げてしまう可能性があります。"
                    ,"「あなたは、最近、ネガティブ（イライラ、不満、怒り、不安等）な気持ちを感じ、感情的な行動を取ってしまった出来事はありましたか？」 「その際、その出来事にどのように対応しましたか。具体的な例を聞かせてください。」"
                    ,"自分が感情的になった場合に、冷静な対応した具体的な行動を説明することができれば問題ありません。ただし、冷静とはいえない行動しか取れていない場合や、行動そのものが説明できない場合、感情的になるようなことがない場合には、「リスクとなる行動」が起こる可能性を否定できません。"
                    ),
            "dev5"=>array(
                    "自ら目標をもとうとせず、仕事を受身で行い前向きに取り組もうとしない可能性があります。"
                    ,"「あなたは、これまでに何か新しいことに挑戦したことはありますか？」ある場合：「どんなことが新しいことだったのですか？」ない場合：「目標を持って物事に取り組んだ経験を話してください。」"
                    ,"新しいことに積極的に挑戦したことがあり、しかもそれが行動として発揮されている例があれば問題ありません。ただし、まったく新しい挑戦をしたことを話せない、あるいは、周囲から言われて行動したような場合には、「リスクとなる行動」が起こる可能性を否定できません。"
                    ),
            "dev6"=>array(
                    "環境の変化に適応できず、悲観的な見通ししか立たず、困難と感じたら、あきらめてしまう可能性があります。"
                    ,"「学校（部活・サークル・バイト・仕事）を変わった際、あなたは自分の役割や立場をどのようにして把握しようとしましたか？」「それを実践した具体的な例を聞かせてください。」"
                    ,"新しい状況に応じた適切な対処をしたことがあり、しかもそれが行動として発揮されている例があれば問題ありません。ただし、新しい環境を経験したことをまったく話せない、あるいは、それが実践されている行動が無かった場合には、「リスクとなる行動」が起こる可能性を否定できません。"
                    ),
            "dev7"=>array(
                    "相手の感情や立場を理解できず、自分の考えや意見を述べてしまい、周囲と衝突する可能性があります。"
                    ,"「自分と他者の考え方がずれて衝突や対立をしたような経験はありますか？」ある場合：「その衝突や対立をどうやって解決しましたか？」ない場合：「他者を気遣い、うまく相手に合わせてあげた経験があれば、その内容を具体的にお話ください。」"
                    ,"ある場合、他者と衝突していても、相手の立場を尊重するような形で解決している事例があれば問題ありません。ない場合でも、他者に配慮した行動であれば問題ありません。ただし、衝突を解決した事例も、他者に配慮した事例も無い場合は、「リスクとなる行動」が起こる可能性を否定できません。"
                    ),
            "dev8"=>array(
                    "他者の状況や本当の気持ちが読み取れず、周囲から見るとずれた行動を取ってしまう可能性があります。"
                    ,"「相手に話をしていて、相手の微妙な表\情や会話から相手の気持ちの変化を感じた経験はありますか？」「その相手からの反応の意味をどう考え、その後どのような行動を取りましたか？」"
                    ,"相手の反応に応じて適切な対処をしたことがあり、しかもそれが行動として発揮されている例があれば問題ありません。ただし、相手の気持ちの変化を感じたことがない、あるいは、感じたとしても行動できていない場合には、「リスクとなる行動」が起こる可能性を否定できません。"
                    ),
            "dev9"=>array(
                    "他者を助ける姿勢に欠け、困っている人がいても気づかないふりをする可能性があります"
                    ,"「他者が困っている際、助けた経験はありますか？」「具体的な例を聞かせてください。それは、いつ、どのような場面でどのように行動しましたか。結果はどうなりましたか。」"
                    ,"他者が困っていることに対し、自分から積極的に関わっていく例があれば問題ありません。ただし、他者が困っている際に助けた経験がない、あるいは、周囲が困っていることを気づくことができない場合には、「リスクとなる行動」が起こる可能性を否定できません。"
                    ),
            "dev10"=>array(
                    "自分の考えをもたず、他者の意見に流されやすく、集団を率いるような行動が期待できない可能性があります。"
                    ,"「あなたは他者に対し、自分の意見を伝えたり、アドバイスを与えた経験はありますか？」「その相手からの反応やその後の行動に変化はありましたか？」"
                    ,"他者に対してアドバイスをしたり、自分の意見を伝えることで周囲に積極的に働きかけている事例が出てくれば問題ありません。ただし、相手に対して、自分の意見を伝えたり、アドバイスした事例も無い場合は、「リスクとなる行動」が起こる可能性を否定できません。"
                    ),
            "dev11"=>array(
                    "自分の考えをきちんと相手に伝えることができず、不適切な意見に対して同調しやすく、反論できない可能性があります。"
                    ,"「自分と他者の考え方がずれて衝突や対立をしたような経験はありますか？」ある場合：「その衝突や対立をどうやって解決しましたか？」ない場合：「他者を気遣い、うまく相手に合わせてあげた経験があれば、その内容を具体的にお話ください。」"
                    ,"「ある場合」に、他者と衝突・対立しても、相手の立場を尊重する形で解決している事例が出てくれば問題ありません。「ない場合」も、他者に配慮した行動をとっていることが確認できれば問題ありません。ただし、衝突を解決したり、他者に配慮した事例が無い場合は、「リスクとなる行動」が起こる可能性を否定できません。"
                    ),
            "dev12"=>array(
                    "自ら周囲に働きかけることはなく、また、周囲と気軽に会話ができず、孤立する可能性があります"
                    ,"「人とのコミュニケーションで失敗してしまったことがありますか？」「具体的な例を聞かせてください。それは、いつ、どのような場面でどのように失敗しましたか。結果はどうなりましたか。」"
                    ,"自分から積極的に相手に関わっていこうとする姿勢が伺える事例が出てくれば問題ありません。また、人の話を聞こうとする姿勢が確認できれば問題ありません。ただし、相手に対し、拒否や防御的な態度が原因で失敗している場合は、「リスクとなる行動」が起こる可能性を否定できません。"
                    )

        );


    }


        /****************************
     * 行動価値検査結果レポート(面接版適合あり)
     */
    public function __setHtml2($base,$pdf,$data,$myFont){
        
        
        $ttest = $data[ 'ttest' ];
        
        //エレメントデータ取得
        $element = $base->t_element->find()
                ->where([
                    'uid'=>$ttest[ 'partner_id' ]
                ])->first();

        //エレメントデータとdevの関連付け
        $devElement['dev1' ] = $element[ 'e_feel' ];
        $devElement['dev2' ] = $element[ 'e_cus' ];
        $devElement['dev3' ] = $element[ 'e_aff' ];
        $devElement['dev4' ] = $element[ 'e_cntl' ];
        $devElement['dev5' ] = $element[ 'e_vi'   ];
        $devElement['dev6' ] = $element[ 'e_pos' ];
        $devElement['dev7' ] = $element[ 'e_symp' ];
        $devElement['dev8' ] = $element[ 'e_situ' ];
        $devElement['dev9' ] = $element[ 'e_hosp' ];
        $devElement['dev10'] = $element[ 'e_lead' ];
        $devElement['dev11'] = $element[ 'e_ass' ];
        $devElement['dev12'] = $element[ 'e_adap' ];

        //テストデータ取得
        $test = $base->t_test->find()
                ->where([
                    'id'=>$ttest['test_id']
                ])->first();
        

        //重み付けフラグ
        //スコア取得
        $weight_flag = [];
        $score = [];
        for($i=1;$i<=12;$i++){
            $dev = "w".$i;
            $weight_flag[$i] = $test[$dev];
            $sc = "dev".$i;
            $score[$sc] = $ttest[$sc];
        }
        
        $stress_flg = $test['stress_flg'];
        //ストレスデータ取得        
        if($stress_flg == 1){
            list($st_level,$st_score) = $base->component->__getStress2($ttest[ 'dev1' ],$ttest[ 'dev2' ],$ttest[ 'dev6' ]);
        }else{
            list($st_level,$st_score) = $base->component->__getStress($ttest[ 'dev1' ],$ttest[ 'dev2' ]);
        }

        //質問用データ取得
        
        $question = $this->__getQuestion($score,$weight_flag);

        $id = $ttest[ 'id' ];
        //行動価値検査
        //スコア
        $score1 = sprintf("%2.1f",$ttest[ 'score' ]);
        //レベル
        $level1 = sprintf("%d",$ttest[ 'level' ]);
        //棒グラフ横棒
        $this->__createBarImage1($ttest,$score1,"move");
        
        //ストレス共生力
        $this->__createBarImage1($ttest,$st_score,"stress");
        
        
        //テンプレートファイル設定
        $pdf->setSourceFile(WWW_ROOT."pdf".DS."pdf2.pdf"); 
            
        // PDFの余白(上左右)を設定 
        $pdf->SetMargins(0, 0, 0); 

        // ヘッダーの出力を無効化 
        $pdf->setPrintHeader(false); 

        // フッターの出力を無効化 
        $pdf->setPrintFooter(false); 

        // ページを追加 
        $pdf->AddPage(); 
        $index = $pdf->importPage(1); 
        $pdf->useTemplate($index, 0, 0); 

        //日本語フォント 
        //$pdf->SetFont('kozminproregular','',8);  
        $pdf->SetFont($myFont, '', 8);

        
        //スパイダーチャート
        $spider   = D_BASE_URL."img".DS."pdf".DS."spider-".$id.".png";
        $filepath = WWW_ROOT."img".DS."pdf".DS."spider-".$id.".png";
      //  $filepath2 = WWW_ROOT."img/pdf/spider2-".$id.".png";
        $this->__SamplecreateSpiderImage($filepath,$ttest);
       // $this->__createSpiderImage($filepath,$ttest);

        $pdf->Image($spider, 55, 100, '', 99, '', '', '', true);
        $en = D_BASE_URL."img".DS."pdf".DS."en01.gif";
        $pdf->Image($en, 52, 97, '', 105, '', '', '', true);

        //ロゴ画像出力
        if(!$data['logo']){
            $pdf->Image(D_BASE_URL.'img'.DS.'welcome.jpg', 10, 10, '', 16, '', '', '', true);
        }else{
            $pdf->Image(D_BASE_URL.'img'.DS.'pdflogo'.DS.''.$data['logo'], 10, 10, '', 16, '', '', '', true);
        }

        // X : 42mm / Y : 108mm の位置に 
        $pdf->SetXY(50, 108);
        //受検日
        $pdf->Text(30, 36, $data['exam_date']);
        //受検者ID
        $pdf->Text(71, 36, $data['exam_id']);
        //氏名
        $name = $data[ 'name' ]."(".$data['kana'].")";
        $pdf->Text(111, 36, $name);
        //年齢
        $pdf->Text(182, 36, $data['age']);
        //企業名
        $pdf->Text(27, 30.8, $data['testname']);


        //行動価値
        //スコア
        $pdf->Text(32.8, 52.6, $score1);
        //レベル
        $pdf->Text(45.7, 52.6, $level1);
        //行動価値検査棒グラフ
        $img1 = D_BASE_URL."img".DS."pdf".DS."pdf2-".$id.".jpg";
        $pdf->Image($img1, 52, 52.6 );
        
        //ストレス共生力
        //スコア
        $pdf->Text(33.0, 58.4, $st_score);
        $pdf->Text(45.7, 58.4, $st_level);
        //行動価値検査棒グラフ
        $img2 = D_BASE_URL."img".DS."pdf".DS."pdf2-".$id."-2.jpg";
        $pdf->Image($img2, 52, 57.9 );

        
        //行動価値　12特性のスコアとチャート
        
        $pdf->Text(10, 76.2, substr($element[ 'e_feel' ],0,36));
        $pdf->Text(48.3, 76.2, sprintf("%0.1f",round($ttest[ 'dev1' ],1)));
        $pdf->Text(10, 81.3, substr($element[ 'e_cus' ],0,36));
        $pdf->Text(48.3, 81.3, sprintf("%0.1f",round($ttest[ 'dev2' ],1)));
        $pdf->Text(10, 86.6, substr($element[ 'e_aff' ],0,36));
        $pdf->Text(48.3, 86.6, sprintf("%0.1f",round($ttest[ 'dev3' ],1)));
        

        $pdf->Text(57, 76.2, substr($element[ 'e_cntl' ],0,45));
        $pdf->Text(101, 76.2, sprintf("%0.1f",round($ttest[ 'dev4' ],1)));
        $pdf->Text(57, 81.3, substr($element[ 'e_vi' ],0,45));
        $pdf->Text(101, 81.3, sprintf("%0.1f",round($ttest[ 'dev5' ],1)));
        $pdf->Text(57, 86.6, substr($element[ 'e_pos' ],0,45));
        $pdf->Text(101, 86.6, sprintf("%0.1f",round($ttest[ 'dev6' ],1)));

        
        $pdf->Text(109.5, 76.2, substr($element[ 'e_symp' ],0,36));
        $pdf->Text(147.8, 76.2, sprintf("%0.1f",round($ttest[ 'dev7' ],1)));
        $pdf->Text(109.5, 81.3, substr($element[ 'e_situ' ],0,36));
        $pdf->Text(147.8, 81.3, sprintf("%0.1f",round($ttest[ 'dev8' ],1)));
        $pdf->Text(109.5, 86.6, substr($element[ 'e_hosp' ],0,36));
        $pdf->Text(147.8, 86.6, sprintf("%0.1f",round($ttest[ 'dev9' ],1)));


        $pdf->Text(156.2, 76.2, substr($element[ 'e_lead' ],0,36));
        $pdf->Text(193.8, 76.2, sprintf("%0.1f",round($ttest[ 'dev10' ],1)));
        $pdf->Text(156.2, 81.3, substr($element[ 'e_ass' ],0,36));
        $pdf->Text(193.8, 81.3, sprintf("%0.1f",round($ttest[ 'dev11' ],1)));
        $pdf->Text(156.2, 86.6, substr($element[ 'e_adap' ],0,36));
        $pdf->Text(193.8, 86.6, sprintf("%0.1f",round($ttest[ 'dev12' ],1)));

        //グラフのメモリ数値の表示
        $pdf->Text(98.6, 105.7, "80");
        $pdf->Text(98.6, 111.5, "70");
        $pdf->Text(98.6, 117.9, "60");
        $pdf->Text(98.6, 123.9, "50");
        $pdf->Text(98.6, 129.8, "40");
        $pdf->Text(98.6, 135.9, "30");
        $pdf->Text(98.6, 145.8, "20");


        //グラフのエレメント名
        //Multicellに色が乗らないので背景色を別途乗せる
        
        //背景色指定
        $x = 91.2;
        $y = 98.9;
        $this->__setBackColor($pdf,$weight_flag[1],$x,$y,mb_strlen($element['e_feel'],'UTF-8'));
        $pdf->MultiCell(31, 11, $element[ 'e_feel' ], 1,'C',1,0,$x,$y);

        $x = 131;
        $y = 109;
        $this->__setBackColor($pdf,$weight_flag[2],$x,$y,mb_strlen($element['e_cus'],'UTF-8'));
        $pdf->MultiCell(31, 12, $element[ 'e_cus' ], 1,'C',1,0,$x,$y);

        $x = 147;
        $y = 127;
        $this->__setBackColor($pdf,$weight_flag[3],$x,$y,mb_strlen($element['e_aff'],'UTF-8'));
        $pdf->MultiCell(31, 12, $element[ 'e_aff' ], 1,'C',1,0,$x,$y);

        $x = 151;
        $y = 146.5;
        $this->__setBackColor($pdf,$weight_flag[4],$x,$y,mb_strlen($element['e_cntl'],'UTF-8'));
        $pdf->MultiCell(31, 12, $element[ 'e_cntl' ], 1,'C',1,0,$x,$y);

        $x = 145;
        $y = 172;
        $this->__setBackColor($pdf,$weight_flag[5],$x,$y,mb_strlen($element['e_vi'],'UTF-8'));
        $pdf->MultiCell(31, 12, $element[ 'e_vi' ], 1,'C',1,0,$x,$y);

        $x = 130;
        $y = 189;
        $this->__setBackColor($pdf,$weight_flag[6],$x,$y,mb_strlen($element['e_pos'],'UTF-8'));
        $pdf->MultiCell(31, 12, $element[ 'e_pos' ], 1,'C',1,0,$x,$y);

        $x = 91.2;
        $y = 195;
        $this->__setBackColor($pdf,$weight_flag[7],$x,$y,mb_strlen($element['e_symp'],'UTF-8'));
        $pdf->MultiCell(31, 12, $element[ 'e_symp' ], 1,'C',1,0,$x,$y);

        $x = 51.2;
        $y = 189;
        $this->__setBackColor($pdf,$weight_flag[8],$x,$y,mb_strlen($element['e_situ'],'UTF-8'));
        $pdf->MultiCell(31, 12, $element[ 'e_situ' ], 1,'C',1,0,$x,$y);

        $x = 36.4;
        $y = 172;
        $this->__setBackColor($pdf,$weight_flag[9],$x,$y,mb_strlen($element['e_hosp'],'UTF-8'));
        $pdf->MultiCell(31, 12, $element[ 'e_hosp' ], 1,'C',1,0,$x,$y);

        $x = 24.4;
        $y = 146.5;
        $this->__setBackColor($pdf,$weight_flag[10],$x,$y,mb_strlen($element['e_lead'],'UTF-8'));
        $pdf->MultiCell(31, 12, $element[ 'e_lead' ], 1,'C',1,0,$x,$y);

        $x = 36.4;
        $y = 127;
        $this->__setBackColor($pdf,$weight_flag[11],$x,$y,mb_strlen($element['e_ass'],'UTF-8'));
        $pdf->MultiCell(31, 12, $element[ 'e_ass' ], 1,'C',1,0,$x,$y);

        $x = 51.2;
        $y = 109;
        $this->__setBackColor($pdf,$weight_flag[12],$x,$y,mb_strlen($element['e_adap'],'UTF-8'));
        $pdf->MultiCell(31, 12, $element[ 'e_adap' ], 1,'C',1,0,$x,$y);
        
        
        $pdf->Text(14, 211.5, $ttest['name']."さんへの質問例",0,45);

        $dev = $question[1][ 'dev' ];
        $title = $devElement[$dev];
        $pdf->MultiCell(43, 5, $title, 0,'L',0,0,11.4,232);

        $text1 = $this->array_pdf_question[$dev][0];
        $pdf->MultiCell(33, 30, $text1, 0,'L',0,0,56.5,221);

        $text2 = $this->array_pdf_question[$dev][1];
        $pdf->MultiCell(50, 30, $text2, 0,'L',0,0,92.5,221);
        
        $text3 = $this->array_pdf_question[$dev][2];
        $pdf->MultiCell(55, 30, $text3, 0,'L',0,0,146.5,221);


        $dev = $question[2][ 'dev' ];
        $title = $devElement[$dev];
        $pdf->MultiCell(43, 5, $title, 0,'L',0,0,11.4,264);

        $text1 = $this->array_pdf_question[$dev][0];
        $pdf->MultiCell(33, 30, $text1, 0,'L',0,0,56.5,252);

        $text2 = $this->array_pdf_question[$dev][1];
        $pdf->MultiCell(50, 30, $text2, 0,'L',0,0,92.5,252);
        
        $text3 = $this->array_pdf_question[$dev][2];
        $pdf->MultiCell(55, 30, $text3, 0,'L',0,0,146.5,252);

        $pdf->Text(155, 286, "powered by Innovation Gate.Inc");
    }

    /******************************
     * 質問用データ
     */
    public function __getQuestion($score,$weight){
        asort($score);
        //重みつけがある時は
        //重みつけのデータを優先にする
        //重みと値を持つ連想配列の作成
        $list=[];
        foreach($score as $key=>$val){
            $k = preg_replace("/^dev/","",$key);
            $list[$key]['score'] = $val;
            $list[$key]['weight'] = $weight[$k];
        }
        //重み付けでソート
        //スコアでソート
        $wt = [];
        $sc = [];
        foreach($list as $key=>$val){
            $wt[$key] = $val[ 'weight' ];
            $sc[$key] = $val[ 'score' ];
        }
        array_multisort($wt, SORT_DESC, $sc,SORT_ASC,$list);
        $pt = [];
        $num=1;
        foreach($list as $key=>$val){
            if($num <= 2){
                $pt[$num][ 'score'  ] = $val[ 'score'  ];
                $pt[$num][ 'weight' ] = $val[ 'weight' ];
                $pt[$num][ 'dev'    ] = $key;
            }
            $num++;
        }
        return $pt;
    }
    /*****************
     * 背景色指定
     */
    public function __setBackColor($pdf,$flg,$x,$y,$length){
        
       $this->log("PDFのエレメントの文字数=>".$length);
        if($flg){
            $pdf->SetDrawColor(128,128,128);
            $pdf->SetFillColor(162,199,255);
            //10文字より多い枠の位置を変える
            if($length > 10){
                $x = $x-3;
                $y = $y-0.5;
            }else{
                $x = $x-3;
                $y = $y-2;
            }
            $pdf->Rect($x,$y, 35, 8.0, 'DF');
        }
        
    }
    
    /***************************
     * スパイダーチャート
     */
    public function __SamplecreateSpiderImage($filename,$ttest){
 
        $values = [];
        for($i=1;$i<=12;$i++){
            $dev="dev".$i;
            if($ttest[$dev] < 30){
                $values[] = ($ttest[$dev]-20)*1.8;
            }else{
                $values[] = $ttest[$dev]-10;
            }
        }
 
        //ラベル
        $labels = array(
            "red", "green", "blue", "yellow", "black", "white",
            "red", "green", "blue", "yellow", "black", "white",
        );
        
        $max         = 70;    //上限
        $step        = 10;     //目盛の間隔
        $margin      = 100;    //グラフの余白
        $text_margin = 20;    //ラベルの余白
        $size        = 640;   //サイズ（正方形）
        
        //フォント
        $font = WWW_ROOT.DS."fonts".DS."tahoma.ttf";
        $font_size = 0;
        
        //画像
        $image = imagecreatetruecolor( $size + $margin , $size + $margin);
        
        
        //色
        $bg   = imagecolorallocate($image, 255, 255, 255);    // 背景
        $line = imagecolorallocate($image, 65, 105, 225); // チャートの線
        $grid = imagecolorallocate($image, 192 , 192 , 192 );    // グリッドの色
        $font_color = imagecolorallocate($image, 255, 160, 200);
        
        $center_x = round(($size + $margin) / 2);
        $center_y = round(($size + $margin) / 2);
        $count = count($values);
        $div = round(360 / $count);
        $length = round($size / 2);
        
        // 背景の描画
        imagefill($image, 0, 0, $bg);
        //背景の線の太さ
        imagesetthickness($image, 4);
        for($i = 20;$i<=$max;$i++){   
            if($i%$step != 0) continue;
            $points = array();
            for($j=0;$j<$count;$j++){
                list($x, $y) = $this->point_rotate($length * ($i / $max), $div * $j - 90);
        
                $point = array($x + $center_x, $y + $center_y);
                imageline($image, $center_x, $center_y, $point[0], $point[1], $grid);
                $points = array_merge($points, $point);
            }
            imagepolygon($image, $points, $count, $grid);
        }
        //グラフの線の太さ
        imagesetthickness($image, 4.5);

        

        /*
        // 文字の描画
        for($i = 0;$i<$count;$i++){
            $box = imagettfbbox($font_size, 0, $font, $labels[$i]);
            $text_width = $box[2] - $box[6];
            $text_height = $box[3] - $box[7];
        
            list($x, $y) = $this->point_rotate($length + $text_margin, $div * $i - 90);
            
            $text_x = (-1 * $text_width / 2) + $center_x + $x;
            $text_y = ($text_height / 2) + $center_y + $y;
            imagettftext($image, $font_size, 0, $text_x, $text_y, $font_color, $font, $labels[$i]);
        }
        */

        for($i=20;$i<=$max;$i=$i+$step){
            $box = imagettfbbox($font_size, 0, $font, $i);
            $text_width = $box[2] - $box[6];
            $text_height = $box[3] - $box[7];
            
            $text_x = (-1 * $text_width) + $center_x - $font_size;
            $text_y = ($text_height / 2) + $center_y - ($length * ($i / $max));
            imagettftext($image, $font_size, 0, $text_x, $text_y, $grid, $font, $i);
        }
        
        
        // グラフの描画
        $points = array();
        for($i=0;$i<$count;$i++){
            $value = $length * $values[$i] / $max;
            list($x, $y) = $this->point_rotate($value, $div * $i - 90);
            $point = array($x + $center_x, $y + $center_y);
            $points = array_merge($points, $point);
            
        }
        imagepolygon($image, $points, $count, $line);
        
        // 画像の出力
        header('Content-type: image/png');
        imagepng($image,$filename);
        imagedestroy($image);

    }
    

    function point_rotate($length, $angle){
        $angle = deg2rad($angle);
        $x = round($length * cos($angle));
        $y = round($length * sin($angle));
        return array($x, $y);
    }


    public function __createSpiderImage($filename,$ttest){

        require_once(ROOT.DS."vendor".DS."pChart".DS."pChart".DS."pData.class");
        require_once(ROOT.DS."vendor".DS."pChart".DS."pChart".DS."pChart.class");
        
        

        $DataSet = new \pData;

        $DataSet->AddPoint(array("Memory","Disk","Network","Slots","CPU"),"Label");
        $DataSet->AddPoint(array(1,2,3,4,3),"Serie1");
        $DataSet->AddPoint(array(1,4,2,6,2),"Serie2");
        $DataSet->AddSerie("Serie1");
        $DataSet->AddSerie("Serie2");
        $DataSet->SetAbsciseLabelSerie("Label");
       
       
        $DataSet->SetSerieName("Reference","Serie1");
        $DataSet->SetSerieName("Tested computer","Serie2");
       
        // Initialise the graph
        $Test = new \pChart(400,400);
        $Test->setFontProperties(WWW_ROOT."fonts/tahoma.ttf",8);
        $Test->drawFilledRoundedRectangle(7,7,393,393,5,240,240,240);
        $Test->drawRoundedRectangle(5,5,395,395,5,230,230,230);
        $Test->setGraphArea(30,30,370,370);
        $Test->drawFilledRoundedRectangle(30,30,370,370,5,255,255,255);
        $Test->drawRoundedRectangle(30,30,370,370,5,220,220,220);
        
        
        // Draw the radar graph
        $Test->drawRadar($DataSet->GetData(),$DataSet->GetDataDescription(),TRUE,20,120,120,120,230,230,230);
        $Test->drawFilledRadar($DataSet->GetData(),$DataSet->GetDataDescription(),50,20);
       

        // Finish the graph
        $Test->drawLegend(15,15,$DataSet->GetDataDescription(),255,255,255);
        $Test->setFontProperties(WWW_ROOT."fonts/tahoma.ttf",10);
        $Test->drawTitle(0,22,"Example 8",50,50,50,400);
        $Test->Render($filename);

exit();



        
    }

    /*************
     * 棒画像作成
     */
    public function __createBarImage1($ttest,$score1,$flg){

        $wid = 0;
        $score1 = sprintf("%d",$score1);
        if($score1 >= 80){
            $wid = 414;
        }elseif($score1 >= 70){
            $one = $score1-20;
            $wid =  6.95*$one;
            if($wid > 413) $wid=413;
        }elseif($score1 >= 60){
            $one = $score1-20;
            $wid =  7.0*$one;
            if($wid > 345) $wid=345;
        }elseif($score1 >= 50){
            $one = $score1-20;
            $wid =  7.1*$one;
            if($wid > 279) $wid=279;
            //$wid = $w1 + 279.75;
        }elseif($score1 >= 40){
            $one = $score1-20;
            $wid =  7.1*$one;
            if($wid > 211) $wid=211;
        }elseif($score1 >= 30){
            $one = $score1-20;
            $wid =  7.35*$one;
            if($wid > 141) $wid=141;
        }elseif($score1 > 20){
            $one = $score1-20;
            $wid =  7.7*$one;
            if($wid > 72) $wid=72;
        }else{
            $wid = 1;
        }

        $im = imagecreatetruecolor($wid, 10);
        
        $id = $ttest[ 'id' ];
        if($flg == "stress"){
            $img1 = WWW_ROOT."/img/pdf/pdf2-".$id."-2.jpg";
            $img_color = imagecolorallocate($im, 1, 101, 255);
        }else{
            $img1 = WWW_ROOT."/img/pdf/pdf2-".$id.".jpg";
            $img_color = imagecolorallocate($im, 64, 64, 64);
        }
        
        $gray      = imagecolorallocate($im, 169, 169, 169);

        imagefill($im , 0 , 0 , $gray);
        imagefilledrectangle($im, 1, 1, $wid-2, 8, $img_color);

        $text_color = imagecolorallocate($im, 255, 0, 0);
        imagestring($im, 1, 5, 5,  "", $text_color);
        imagejpeg($im, $img1);
        imagedestroy($im);
        
    }
}
