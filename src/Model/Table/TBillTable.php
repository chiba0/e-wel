<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * TBill Model
 *
 * @property \App\Model\Table\EirsTable&\Cake\ORM\Association\BelongsTo $Eirs
 * @property \App\Model\Table\PartnersTable&\Cake\ORM\Association\BelongsTo $Partners
 * @property \App\Model\Table\CustomersTable&\Cake\ORM\Association\BelongsTo $Customers
 * @property \App\Model\Table\TBillListTable&\Cake\ORM\Association\HasMany $TBillList
 *
 * @method \App\Model\Entity\TBill get($primaryKey, $options = [])
 * @method \App\Model\Entity\TBill newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\TBill[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\TBill|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TBill saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TBill patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\TBill[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\TBill findOrCreate($search, callable $callback = null, $options = [])
 */
class TBillTable extends Table
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

        $this->setTable('t_bill');

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
            ->notEmptyString('title',__("件名を入力してください。"));
        $validator
            ->notEmptyString('bill_num',__("請求書番号を入力してください。"));
           
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

        
        return $rules;
    }
}
