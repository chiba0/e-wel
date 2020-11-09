<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * TTestpaper Entity
 *
 * @property int $id
 * @property int $number
 * @property int|null $partner_id
 * @property int|null $customer_id
 * @property int|null $test_id
 * @property int $testgrp_id
 * @property string|null $exam_id
 * @property string $type
 * @property string|null $name
 * @property string|null $kana
 * @property string|null $birth
 * @property string $birth2
 * @property int $sex
 * @property int $exam_state
 * @property int $complete_flg
 * @property string|null $exam_date
 * @property string|null $start_time
 * @property string|null $exam_time
 * @property int|null $level
 * @property float|null $score
 * @property string|null $pass
 * @property string|null $memo1
 * @property string|null $memo2
 * @property int $disabled
 * @property int|null $q1
 * @property int|null $q2
 * @property int|null $q3
 * @property int|null $q4
 * @property int|null $q5
 * @property int|null $q6
 * @property int|null $q7
 * @property int|null $q8
 * @property int|null $q9
 * @property int|null $q10
 * @property int|null $q11
 * @property int|null $q12
 * @property int|null $q13
 * @property int|null $q14
 * @property int|null $q15
 * @property int|null $q16
 * @property int|null $q17
 * @property int|null $q18
 * @property int|null $q19
 * @property int|null $q20
 * @property int|null $q21
 * @property int|null $q22
 * @property int|null $q23
 * @property int|null $q24
 * @property int|null $q25
 * @property int|null $q26
 * @property int|null $q27
 * @property int|null $q28
 * @property int|null $q29
 * @property int|null $q30
 * @property int|null $q31
 * @property int|null $q32
 * @property int|null $q33
 * @property int|null $q34
 * @property int|null $q35
 * @property int|null $q36
 * @property float|null $dev1
 * @property float|null $dev2
 * @property float|null $dev3
 * @property float|null $dev4
 * @property float|null $dev5
 * @property float|null $dev6
 * @property float|null $dev7
 * @property float|null $dev8
 * @property float|null $dev9
 * @property float|null $dev10
 * @property float|null $dev11
 * @property float|null $dev12
 * @property int|null $soyo
 * @property int $del
 * @property int $temp_flg
 * @property \Cake\I18n\FrozenTime $fin_exam_date
 * @property \Cake\I18n\FrozenTime $registtime
 * @property int $middle_time_status
 * @property int $tensaku_status
 * @property string $tensaku_name
 * @property string $tensaku_mail
 * @property string $mail
 * @property string $inspection
 * @property \Cake\I18n\FrozenDate $enterdate
 * @property \Cake\I18n\FrozenDate $retiredate
 * @property string $retirereason
 * @property string $evaluation
 * @property string $adopt
 * @property int $judge_login_flag
 *
 * @property \App\Model\Entity\Partner $partner
 * @property \App\Model\Entity\Customer $customer
 * @property \App\Model\Entity\Test $test
 * @property \App\Model\Entity\Testgrp $testgrp
 * @property \App\Model\Entity\Exam $exam
 */
class TTestpaper extends Entity
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
        'number' => true,
        'partner_id' => true,
        'customer_id' => true,
        'test_id' => true,
        'testgrp_id' => true,
        'exam_id' => true,
        'type' => true,
        'name' => true,
        'kana' => true,
        'birth' => true,
        'birth2' => true,
        'sex' => true,
        'exam_state' => true,
        'complete_flg' => true,
        'exam_date' => true,
        'start_time' => true,
        'exam_time' => true,
        'level' => true,
        'score' => true,
        'pass' => true,
        'memo1' => true,
        'memo2' => true,
        'disabled' => true,
        'q1' => true,
        'q2' => true,
        'q3' => true,
        'q4' => true,
        'q5' => true,
        'q6' => true,
        'q7' => true,
        'q8' => true,
        'q9' => true,
        'q10' => true,
        'q11' => true,
        'q12' => true,
        'q13' => true,
        'q14' => true,
        'q15' => true,
        'q16' => true,
        'q17' => true,
        'q18' => true,
        'q19' => true,
        'q20' => true,
        'q21' => true,
        'q22' => true,
        'q23' => true,
        'q24' => true,
        'q25' => true,
        'q26' => true,
        'q27' => true,
        'q28' => true,
        'q29' => true,
        'q30' => true,
        'q31' => true,
        'q32' => true,
        'q33' => true,
        'q34' => true,
        'q35' => true,
        'q36' => true,
        'dev1' => true,
        'dev2' => true,
        'dev3' => true,
        'dev4' => true,
        'dev5' => true,
        'dev6' => true,
        'dev7' => true,
        'dev8' => true,
        'dev9' => true,
        'dev10' => true,
        'dev11' => true,
        'dev12' => true,
        'soyo' => true,
        'del' => true,
        'temp_flg' => true,
        'fin_exam_date' => true,
        'registtime' => true,
        'middle_time_status' => true,
        'tensaku_status' => true,
        'tensaku_name' => true,
        'tensaku_mail' => true,
        'mail' => true,
        'inspection' => true,
        'enterdate' => true,
        'retiredate' => true,
        'retirereason' => true,
        'evaluation' => true,
        'adopt' => true,
        'judge_login_flag' => true,
        'partner' => true,
        'customer' => true,
        'test' => true,
        'testgrp' => true,
        'exam' => true,
    ];
}
