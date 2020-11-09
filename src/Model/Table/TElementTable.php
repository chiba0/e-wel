<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * TElement Model
 *
 * @property \App\Model\Table\PartnersTable&\Cake\ORM\Association\BelongsTo $Partners
 *
 * @method \App\Model\Entity\TElement get($primaryKey, $options = [])
 * @method \App\Model\Entity\TElement newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\TElement[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\TElement|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TElement saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TElement patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\TElement[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\TElement findOrCreate($search, callable $callback = null, $options = [])
 */
class TElementTable extends Table
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

        $this->setTable('t_element');
        $this->setDisplayField('id');
        $this->setPrimaryKey(['id', 'uid']);

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
//        $rules->add($rules->existsIn(['partner_id'], 'Partners'));

        return $rules;
    }
}
