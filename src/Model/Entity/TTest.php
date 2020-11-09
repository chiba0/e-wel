<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * TTest Entity
 *
 * @property int $id
 * @property int $eir_id
 * @property int|null $partner_id
 * @property int|null $customer_id
 * @property int $test_id
 * @property string|null $name
 * @property string|null $period_from
 * @property string|null $period_to
 * @property int|null $number
 * @property string $dir
 * @property int $fin_disp
 * @property string|null $url
 * @property string|null $qrcode
 * @property string|null $type
 * @property int $weight
 * @property float $w1
 * @property float $w2
 * @property float $w3
 * @property float $w4
 * @property float $w5
 * @property float $w6
 * @property float $w7
 * @property float $w8
 * @property float $w9
 * @property float $w10
 * @property float $w11
 * @property float $w12
 * @property float $ave
 * @property float $sd
 * @property int $enabled
 * @property int $del
 * @property \Cake\I18n\FrozenTime $registtime
 * @property int $minute_rest
 * @property int $rsei_type
 * @property int $language
 * @property string $tamen_type
 * @property string $vf4_object
 * @property int $send_mail
 * @property string $pdfdownload
 * @property int $stress_flg
 * @property int $no_disp_flg
 * @property int $temp_flg
 * @property int $rest_mail_count
 * @property int $rowflg
 * @property int $enq_status
 * @property int $pdf_slice
 * @property string $array_tensaku_title_status
 * @property string $array_tensaku_text
 * @property int $recommen
 * @property int $graph_status
 * @property int $pdf_output_limit
 * @property \Cake\I18n\FrozenDate $pdf_output_limit_from
 * @property \Cake\I18n\FrozenDate $pdf_output_limit_to
 * @property int $pdf_output_limit_count
 * @property int $pdf_output_count
 * @property int $download_excel
 * @property int|null $pdf_log_use
 * @property int $excel_type
 * @property int|null $judge_login
 *
 * @property \App\Model\Entity\Eir $eir
 * @property \App\Model\Entity\Partner $partner
 * @property \App\Model\Entity\Customer $customer
 * @property \App\Model\Entity\Test $test
 */
class TTest extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'eir_id' => true,
        'partner_id' => true,
        'customer_id' => true,
        'test_id' => true,
        'name' => true,
        'period_from' => true,
        'period_to' => true,
        'number' => true,
        'dir' => true,
        'fin_disp' => true,
        'url' => true,
        'qrcode' => true,
        'type' => true,
        'weight' => true,
        'w1' => true,
        'w2' => true,
        'w3' => true,
        'w4' => true,
        'w5' => true,
        'w6' => true,
        'w7' => true,
        'w8' => true,
        'w9' => true,
        'w10' => true,
        'w11' => true,
        'w12' => true,
        'ave' => true,
        'sd' => true,
        'enabled' => true,
        'del' => true,
        'registtime' => true,
        'minute_rest' => true,
        'rsei_type' => true,
        'language' => true,
        'tamen_type' => true,
        'vf4_object' => true,
        'send_mail' => true,
        'pdfdownload' => true,
        'stress_flg' => true,
        'no_disp_flg' => true,
        'temp_flg' => true,
        'rest_mail_count' => true,
        'rowflg' => true,
        'enq_status' => true,
        'pdf_slice' => true,
        'array_tensaku_title_status' => true,
        'array_tensaku_text' => true,
        'recommen' => true,
        'graph_status' => true,
        'pdf_output_limit' => true,
        'pdf_output_limit_from' => true,
        'pdf_output_limit_to' => true,
        'pdf_output_limit_count' => true,
        'pdf_output_count' => true,
        'download_excel' => true,
        'pdf_log_use' => true,
        'excel_type' => true,
        'judge_login' => true,
        'eir' => true,
        'partner' => true,
        'customer' => true,
        'test' => true,
    ];
}
