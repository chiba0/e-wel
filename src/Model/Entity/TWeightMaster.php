<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * TWeightMaster Entity
 *
 * @property int $id
 * @property int $uid
 * @property int $pid
 * @property string $master_name
 * @property float $e_feel
 * @property float $e_cus
 * @property float $e_aff
 * @property float $e_cntl
 * @property float $e_vi
 * @property float $e_pos
 * @property float $e_symp
 * @property float $e_situ
 * @property float $e_hosp
 * @property float $e_lead
 * @property float $e_ass
 * @property float $e_adap
 * @property float $avg
 * @property float $hensa
 * @property \Cake\I18n\FrozenTime $regist_ts
 * @property \Cake\I18n\FrozenTime $update_ts
 */
class TWeightMaster extends Entity
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
        'id' => true,
        'uid' => true,
        'pid' => true,
        'master_name' => true,
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
        'avg' => true,
        'hensa' => true,
        'regist_ts' => true,
        'update_ts' => true,
    ];
}
