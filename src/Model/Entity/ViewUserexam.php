<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ViewUserexam Entity
 *
 * @property string|null $partner_name
 * @property string|null $customer_name
 * @property string|null $exam_id
 * @property string|null $exam_name
 * @property string|null $exam_kana
 * @property string|null $exam_date
 * @property \Cake\I18n\FrozenTime $fin_exam_date
 * @property string|null $test_name
 *
 * @property \App\Model\Entity\Exam $exam
 */
class ViewUserexam extends Entity
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
        'partner_name' => true,
        'customer_name' => true,
        'exam_id' => true,
        'exam_name' => true,
        'exam_kana' => true,
        'exam_date' => true,
        'fin_exam_date' => true,
        'test_name' => true,
        'exam' => true,
    ];
}
