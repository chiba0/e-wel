<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * TElement Entity
 *
 * @property int $id
 * @property int $uid
 * @property int $element_status
 * @property int $partner_id
 * @property string $e_feel
 * @property string $e_cus
 * @property string $e_aff
 * @property string $e_cntl
 * @property string $e_vi
 * @property string $e_pos
 * @property string $e_symp
 * @property string $e_situ
 * @property string $e_hosp
 * @property string $e_lead
 * @property string $e_ass
 * @property string $e_adap
 * @property \Cake\I18n\FrozenTime $regist_ts
 *
 * @property \App\Model\Entity\Partner $partner
 */
class TElement extends Entity
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
        'element_status' => true,
        'partner_id' => true,
        'e_feel' => true,
        'e_cus' => true,
        'e_aff' => true,
        'e_cntl' => true,
        'e_vi' => true,
        'e_pos' => true,
        'e_symp' => true,
        'e_situ' => true,
        'e_hosp' => true,
        'e_lead' => true,
        'e_ass' => true,
        'e_adap' => true,
        'regist_ts' => true,
        'partner' => true
    ];
}
