<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * TBill Entity
 *
 * @property int $id
 * @property int $eir_id
 * @property int $testid
 * @property string $bill_num
 * @property int $partner_id
 * @property int $customer_id
 * @property int $send_status
 * @property int $money_total
 * @property string $name
 * @property string $title
 * @property \Cake\I18n\FrozenTime $pay_date
 * @property string $pay_bank
 * @property string $pay_num
 * @property string $pay_name
 * @property string $post1
 * @property string $post2
 * @property string $address
 * @property string $address2
 * @property string $busyo
 * @property string $post
 * @property string $tanto
 * @property string $registdate
 * @property string $company_post1
 * @property string $company_post2
 * @property string $company_address
 * @property string $company_address2
 * @property string $company_name
 * @property string $company_telnum
 * @property string $other
 * @property int $download_status
 * @property string $bill_term_date_from
 * @property string $bill_term_date_to
 * @property string $syahan_sts
 * @property string $tantohan_sts
 * @property \Cake\I18n\FrozenTime $update_ts
 * @property \Cake\I18n\FrozenTime $regist_ts
 *
 * @property \App\Model\Entity\Eir $eir
 * @property \App\Model\Entity\Partner $partner
 * @property \App\Model\Entity\Customer $customer
 * @property \App\Model\Entity\TBillList[] $t_bill_list
 */
class TBill extends Entity
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
        'testid' => true,
        'bill_num' => true,
        'partner_id' => true,
        'customer_id' => true,
        'send_status' => true,
        'money_total' => true,
        'name' => true,
        'title' => true,
        'pay_date' => true,
        'pay_bank' => true,
        'pay_num' => true,
        'pay_name' => true,
        'post1' => true,
        'post2' => true,
        'address' => true,
        'address2' => true,
        'busyo' => true,
        'post' => true,
        'tanto' => true,
        'registdate' => true,
        'company_post1' => true,
        'company_post2' => true,
        'company_address' => true,
        'company_address2' => true,
        'company_name' => true,
        'company_telnum' => true,
        'other' => true,
        'download_status' => true,
        'bill_term_date_from' => true,
        'bill_term_date_to' => true,
        'syahan_sts' => true,
        'tantohan_sts' => true,
        'update_ts' => true,
        'regist_ts' => true,
        'eir' => true,
        'partner' => true,
        'customer' => true,
        't_bill_list' => true,
    ];
}
