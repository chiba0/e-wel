<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * TBillList Entity
 *
 * @property int $id
 * @property int $t_bill_id
 * @property int $number
 * @property string $name
 * @property string $brand
 * @property string $kikaku
 * @property int $count
 * @property string $unit
 * @property int $money
 * @property int $price
 * @property \Cake\I18n\FrozenTime $update_ts
 * @property \Cake\I18n\FrozenTime $regist_ts
 *
 * @property \App\Model\Entity\TBill $t_bill
 */
class TBillList extends Entity
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
        't_bill_id' => true,
        'number' => true,
        'name' => true,
        'brand' => true,
        'kikaku' => true,
        'count' => true,
        'unit' => true,
        'money' => true,
        'price' => true,
        'update_ts' => true,
        'regist_ts' => true,
        't_bill' => true,
    ];
}
