<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ExamGroup Model
 *
 * @property \App\Model\Table\GroupsTable&\Cake\ORM\Association\BelongsTo $Groups
 * @property \App\Model\Table\ExamMasterTable&\Cake\ORM\Association\HasMany $ExamMaster
 *
 * @method \App\Model\Entity\ExamGroup get($primaryKey, $options = [])
 * @method \App\Model\Entity\ExamGroup newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ExamGroup[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ExamGroup|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ExamGroup saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ExamGroup patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ExamGroup[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ExamGroup findOrCreate($search, callable $callback = null, $options = [])
 */
class ExamGroupUseTable extends Table
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

        $this->setTable('exam_group');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->belongsTo('Groups', [
            'foreignKey' => 'group_id',
            'joinType' => 'LEFT',
        ]);
        $this->hasMany('ExamMaster', [
            'foreignKey' => 'exam_group_id',
        ])
        ->setConditions(['ExamMaster.del' => '0'])
        ;
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
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('name')
            ->maxLength('name', 45)
            ->allowEmptyString('name');

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
        $rules->add($rules->existsIn(['group_id'], 'Groups'));

        return $rules;
    }
}
