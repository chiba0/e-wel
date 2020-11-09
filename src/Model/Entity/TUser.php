<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * TUser Entity
 *
 * @property int $id
 * @property string $password
 * @property string|null $login_id
 * @property string|null $login_pw
 * @property int|null $type
 * @property bool $super
 * @property int|null $eir_id
 * @property int|null $partner_id
 * @property string|null $name
 * @property string|null $post1
 * @property string|null $post2
 * @property string|null $prefecture
 * @property string|null $address1
 * @property string|null $address2
 * @property string|null $tel
 * @property string|null $fax
 * @property string|null $rep_name
 * @property string|null $rep_email
 * @property string $rep_name2
 * @property string $rep_email2
 * @property string|null $rep_busyo
 * @property string|null $rep_tel1
 * @property string|null $rep_tel2
 * @property string $license
 * @property string $license_parts
 * @property string|null $logo
 * @property string $logo_name
 * @property int $del
 * @property int $privacy_flg
 * @property int $csvupload
 * @property int $pdf_button
 * @property string $form_code
 * @property int $form_status
 * @property int $user_status
 * @property int $temp_flg
 * @property string $outputPdf
 * @property int $element_flg
 * @property int $sendDayStatus
 * @property int $pdf_master_status
 * @property int $excel_master_status
 * @property bool $ptTestBtn
 * @property bool $csTestBtn
 * @property int $exam_pattern
 * @property \Cake\I18n\FrozenTime $registtime
 * @property \Cake\I18n\FrozenTime $regist_ts
 * @property int $explain_page
 * @property int $ssltype
 *
 * @property \App\Model\Entity\Login $login
 * @property \App\Model\Entity\Eir $eir
 * @property \App\Model\Entity\Partner $partner
 */
class TUser extends Entity
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
        'password' => true,
        'login_id' => true,
        'login_pw' => true,
        'type' => true,
        'super' => true,
        'eir_id' => true,
        'partner_id' => true,
        'name' => true,
        'post1' => true,
        'post2' => true,
        'prefecture' => true,
        'address1' => true,
        'address2' => true,
        'tel' => true,
        'fax' => true,
        'rep_name' => true,
        'rep_email' => true,
        'rep_name2' => true,
        'rep_email2' => true,
        'rep_busyo' => true,
        'rep_tel1' => true,
        'rep_tel2' => true,
        'license' => true,
        'license_parts' => true,
        'logo' => true,
        'logo_name' => true,
        'del' => true,
        'privacy_flg' => true,
        'csvupload' => true,
        'pdf_button' => true,
        'form_code' => true,
        'form_status' => true,
        'user_status' => true,
        'temp_flg' => true,
        'outputPdf' => true,
        'element_flg' => true,
        'sendDayStatus' => true,
        'pdf_master_status' => true,
        'excel_master_status' => true,
        'ptTestBtn' => true,
        'csTestBtn' => true,
        'exam_pattern' => true,
        'registtime' => true,
        'regist_ts' => true,
        'explain_page' => true,
        'ssltype' => true,
        'login' => true,
        'eir' => true,
        'partner' => true
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'password'
    ];
}
