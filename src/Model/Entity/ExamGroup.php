<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ExamGroup Entity
 *
 * @property int $id
 * @property string $group_id
 * @property string|null $name
 *
 * @property \App\Model\Entity\Group $group
 * @property \App\Model\Entity\ExamMaster[] $exam_master
 */
class ExamGroup extends Entity
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
        'group_id' => true,
        'name' => true,
        'group' => true,
        'exam_master' => true,
    ];
}
