<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * TTestpaper Model
 *
 * @property \App\Model\Table\PartnersTable&\Cake\ORM\Association\BelongsTo $Partners
 * @property \App\Model\Table\CustomersTable&\Cake\ORM\Association\BelongsTo $Customers
 * @property \App\Model\Table\TestsTable&\Cake\ORM\Association\BelongsTo $Tests
 * @property \App\Model\Table\TestgrpsTable&\Cake\ORM\Association\BelongsTo $Testgrps
 * @property \App\Model\Table\ExamsTable&\Cake\ORM\Association\BelongsTo $Exams
 *
 * @method \App\Model\Entity\TTestpaper get($primaryKey, $options = [])
 * @method \App\Model\Entity\TTestpaper newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\TTestpaper[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\TTestpaper|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TTestpaper saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TTestpaper patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\TTestpaper[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\TTestpaper findOrCreate($search, callable $callback = null, $options = [])
 */
class TTestpaperTable extends Table
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

        $this->setTable('t_testpaper');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->belongsTo('Partners', [
            'foreignKey' => 'partner_id',
        ]);
        $this->belongsTo('Customers', [
            'foreignKey' => 'customer_id',
        ]);
        $this->belongsTo('Tests', [
            'foreignKey' => 'test_id',
        ]);
        $this->belongsTo('Testgrps', [
            'foreignKey' => 'testgrp_id',
            'joinType' => 'INNER',
        ]);
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
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

       

        

            
        
        
        return $validator;
    }
    /**********
     * 更新画面用
     */
    public function validationEdit(Validator $validator){
        $validator
            ->scalar('sei')
            ->notEmpty('sei',__d("custom","detailEditErrorMsg1"));
        $validator
            ->scalar('mei')
            ->notEmpty('mei',__d("custom","detailEditErrorMsg2"));
        $validator
            ->scalar('kana_sei')
            ->notEmpty('kana_sei',__d("custom","detailEditErrorMsg3"));
        $validator
            ->scalar('kana_mei')
            ->notEmpty('kana_mei',__d("custom","detailEditErrorMsg4"));

        $validator ->add('birth','birth',[
                'rule'=>
                function($value,$context){
                    $ex = explode("/",$value);
                    $year = $ex[0];
                    $month = $ex[1];
                    $day = $ex[2];
                    if(checkdate($month,$day,$year)){
                        return true;
                    }else{
                        return false;
                    }

                },
                'message'=>__d("custom","detailEditErrorMsg5")
            ]);

        $validator
            ->scalar('gender')
            ->requirePresence('gender',true,__d("custom","detailEditErrorMsg6"));

        $validator
            ->scalar('pass')
            ->requirePresence('pass',true,__d("custom","detailEditErrorMsg7"));
        
        
        
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
