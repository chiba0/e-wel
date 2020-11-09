<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * TTest Model
 *
 * @property \App\Model\Table\EirsTable&\Cake\ORM\Association\BelongsTo $Eirs
 * @property \App\Model\Table\PartnersTable&\Cake\ORM\Association\BelongsTo $Partners
 * @property \App\Model\Table\CustomersTable&\Cake\ORM\Association\BelongsTo $Customers
 * @property \App\Model\Table\TestsTable&\Cake\ORM\Association\BelongsTo $Tests
 *
 * @method \App\Model\Entity\TTest get($primaryKey, $options = [])
 * @method \App\Model\Entity\TTest newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\TTest[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\TTest|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TTest saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TTest patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\TTest[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\TTest findOrCreate($search, callable $callback = null, $options = [])
 */
class TTestTable extends Table
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

        $this->setTable('t_test');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

    }
    

    /***************
     * 編集用のバリデーションチェック
     */
    public function validationEdit(Validator $validator){
        $validator
        ->requirePresence('name', 'create')
        ->notEmptyString('name',__d("custom","vf_errmsg1"));

        $validator
            ->allowEmptyString('RegNumber')
            ->numeric('RegNumber',__d("custom","vf_errmsg9"));


        $validator
            ->notEmpty('period_from',__d("custom","vf_errmsg5"));
        
        $validator
            ->notEmpty('period_to',__d("custom","vf_errmsg6"));

        return $validator;
    }
    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        /*
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');
        */

        $validator
        ->requirePresence('name', 'create')
        ->notEmptyString('name',__d("custom","vf_errmsg1"));

        $validator
            ->requirePresence('number', 'create')
            ->notEmptyString('number',__d("custom","vf_errmsg2"))
            ->numeric('number',__d("custom","vf_errmsg3"));

        $validator
            ->add('number', 'message', [
                'rule' => [$this,"lisencefunction"],
                "message"=>__d("custom","vf_errmsg8")
            ]);


        $validator
            ->allowEmptyString('rest_mail_count')
            ->numeric('rest_mail_count',__d("custom","vf_errmsg4"));

        $validator
            ->notEmpty('period_from',__d("custom","vf_errmsg5"));
        
        $validator
            ->notEmpty('period_to',__d("custom","vf_errmsg6"));
        
        $validator
            ->allowEmptyString('pdf_output_limit_from',__d("custom","vf_errmsg6"));

        $validator
            ->add('selectType', 'message', [
                'rule' => function($data, $providor) {

                    $flg = 0;
                    foreach($data as $values){
                        if($values > 0) $flg++;
                    }
                    
                    return ($flg == 0 )?false:true;
                },
                "message"=>__d("custom","vf_errmsg7")
            ]);
       

        return $validator;
    }
    /*******************
     * リクエスト値の登録
     */
    public function setRequest($request){
        $this->request = $request;
    }
    public function getRequest(){
        return $this->request;
    }
    /******************
     * ライセンス数の確認
     */
    public function setLicense($license){
        $this->license = $license;
    }
    public function getLicense(){
        return $this->license;
    }
    public function lisencefunction($check){
        $license = $this->getLicense();
        $request = $this->getRequest();
        $selectType = $request[ 'selectType' ];
       // var_dump($check,$license);
       // print "<hr />";
       // var_dump($selectType);
        /*****************
         * テストの残数の確認
         */
        $li = [];
        foreach($license['lists'] as $value){
            $li[$value[ 'type' ]] = $value[ 'remain' ];
        }
        $error = 0;
        $errorkey = [];
        foreach($selectType as $key){
            //var_dump($li[$key],$check);
            if(
                $key > 0 && 
                isset($li[$key]) && 
                $li[$key] <= $check){
                $error++;
            }
        }
        return ($error > 0 )?false:true;
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
