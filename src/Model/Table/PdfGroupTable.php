<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PdfGroup Model
 *
 * @property \App\Model\Table\GroupsTable&\Cake\ORM\Association\BelongsTo $Groups
 * @property \App\Model\Table\PdfExamMasterTable&\Cake\ORM\Association\HasMany $PdfExamMaster
 *
 * @method \App\Model\Entity\PdfGroup get($primaryKey, $options = [])
 * @method \App\Model\Entity\PdfGroup newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\PdfGroup[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\PdfGroup|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PdfGroup saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PdfGroup patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\PdfGroup[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\PdfGroup findOrCreate($search, callable $callback = null, $options = [])
 */
class PdfGroupTable extends Table
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

        $this->setTable('pdf_group');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->belongsTo('Groups', [
            'foreignKey' => 'group_id',
            'joinType' => 'LEFT',
        ]);
        $this->hasMany('PdfExamMaster', [
            'foreignKey' => 'pdf_group_id',
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
