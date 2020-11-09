<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * InformationTbl Entity
 *
 * @property int $id
 * @property string $title
 * @property \Cake\I18n\FrozenDate $date1
 * @property \Cake\I18n\FrozenDate $date2
 * @property string $disp_status
 * @property string $disp_area
 * @property string $message
 * @property string $temp_file
 * @property string $disp_id_list
 * @property \Cake\I18n\FrozenTime $regist_ts
 */
class InformationTbl extends Entity
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
        'title' => true,
        'date1' => true,
        'date2' => true,
        'disp_status' => true,
        'disp_area' => true,
        'message' => true,
        'temp_file' => true,
        'disp_id_list' => true,
        'regist_ts' => true,
    ];
}
