<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * TBillList Model
 *
 * @property \App\Model\Table\TBillsTable&\Cake\ORM\Association\BelongsTo $TBills
 *
 * @method \App\Model\Entity\TBillList get($primaryKey, $options = [])
 * @method \App\Model\Entity\TBillList newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\TBillList[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\TBillList|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TBillList saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TBillList patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\TBillList[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\TBillList findOrCreate($search, callable $callback = null, $options = [])
 */
class TBillListTable extends Table
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

        $this->setTable('t_bill_list');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        /*
        $this->belongsTo('TBills', [
            'foreignKey' => 't_bill_id',
            'joinType' => 'INNER',
        ]);
        */
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
/*
        $validator
            ->integer('number')
            ->requirePresence('number', 'create')
            ->notEmptyString('number');

        $validator
            ->scalar('name')
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->scalar('brand')
            ->requirePresence('brand', 'create')
            ->notEmptyString('brand');

        $validator
            ->scalar('kikaku')
            ->requirePresence('kikaku', 'create')
            ->notEmptyString('kikaku');

        $validator
            ->integer('count')
            ->requirePresence('count', 'create')
            ->notEmptyString('count');

        $validator
            ->scalar('unit')
            ->requirePresence('unit', 'create')
            ->notEmptyString('unit');

        $validator
            ->integer('money')
            ->requirePresence('money', 'create')
            ->notEmptyString('money');

        $validator
            ->integer('price')
            ->requirePresence('price', 'create')
            ->notEmptyString('price');

        $validator
            ->dateTime('update_ts')
            ->notEmptyDateTime('update_ts');

        $validator
            ->dateTime('regist_ts')
            ->notEmptyDateTime('regist_ts');
*/
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
     //   $rules->add($rules->existsIn(['t_bill_id'], 'TBills'));

        return $rules;
    }
}
