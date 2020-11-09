<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ViewUserexam Model
 *
 * @property \App\Model\Table\ExamsTable&\Cake\ORM\Association\BelongsTo $Exams
 *
 * @method \App\Model\Entity\ViewUserexam get($primaryKey, $options = [])
 * @method \App\Model\Entity\ViewUserexam newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ViewUserexam[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ViewUserexam|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ViewUserexam saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ViewUserexam patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ViewUserexam[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ViewUserexam findOrCreate($search, callable $callback = null, $options = [])
 */
class ViewUserexamTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('view_userexam');

        $this->belongsTo('Exams', [
            'foreignKey' => 'exam_id',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->scalar('partner_name')
            ->allowEmptyString('partner_name');

        $validator
            ->scalar('customer_name')
            ->allowEmptyString('customer_name');

        $validator
            ->scalar('exam_name')
            ->allowEmptyString('exam_name');

        $validator
            ->scalar('exam_kana')
            ->allowEmptyString('exam_kana');

        $validator
            ->scalar('exam_date')
            ->allowEmptyString('exam_date');

        $validator
            ->dateTime('fin_exam_date')
            ->requirePresence('fin_exam_date', 'create')
            ->notEmptyDateTime('fin_exam_date');

        $validator
            ->scalar('test_name')
            ->allowEmptyString('test_name');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['exam_id'], 'Exams'));

        return $rules;
    }
}
