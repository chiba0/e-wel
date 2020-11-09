<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * TWeightMaster Model
 *
 * @method \App\Model\Entity\TWeightMaster get($primaryKey, $options = [])
 * @method \App\Model\Entity\TWeightMaster newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\TWeightMaster[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\TWeightMaster|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TWeightMaster saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TWeightMaster patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\TWeightMaster[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\TWeightMaster findOrCreate($search, callable $callback = null, $options = [])
 */
class TWeightMasterTable extends Table
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

        $this->setTable('t_weight_master');
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
            ->scalar('master_name')
            ->notEmpty('master_name',__d("custom","wtErrMSG1"));

        
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
        $rules->add($rules->isUnique(['id']));

        return $rules;
    }
}
