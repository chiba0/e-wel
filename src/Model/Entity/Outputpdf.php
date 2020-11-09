<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Outputpdf Entity
 *
 * @property int $id
 * @property int|null $uid
 * @property int|null $pdf_id
 * @property int|null $status
 * @property \Cake\I18n\FrozenTime|null $regist_ts
 * @property \Cake\I18n\FrozenTime|null $update_ts
 *
 * @property \App\Model\Entity\Pdf $pdf
 */
class Outputpdf extends Entity
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
        'uid' => true,
        'pdf_id' => true,
        'status' => true,
        'regist_ts' => true,
        'update_ts' => true,
        'pdf' => true
    ];
}
