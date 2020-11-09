<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * TUser Model
 *
 * @property \App\Model\Table\LoginsTable&\Cake\ORM\Association\BelongsTo $Logins
 * @property \App\Model\Table\EirsTable&\Cake\ORM\Association\BelongsTo $Eirs
 * @property \App\Model\Table\PartnersTable&\Cake\ORM\Association\BelongsTo $Partners
 *
 * @method \App\Model\Entity\TUser get($primaryKey, $options = [])
 * @method \App\Model\Entity\TUser newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\TUser[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\TUser|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TUser saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TUser patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\TUser[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\TUser findOrCreate($search, callable $callback = null, $options = [])
 */
class TUserTable extends Table
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

        $this->setTable('t_user');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

    }
    public function validationUpdate(Validator $validator)
    {

        $validator
        ->notEmpty('su_rep_name',"エラー");

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

        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');
        //企業名エラーチェック
        $validator
            ->scalar('name')
            ->notEmpty('name',"partnerErrMSG1");

        //IDエラーチェック
        $validator
            ->scalar('login_id')
            ->notEmpty('login_id',"partnerErrMSG2")
            ->add('login_id', [
                'length' => [
                    'rule' => ['minLength', 4],
                    'message' => 'hankakueisu4',
                ],
                'alphaNumeric' => [
                    'rule' => function ($value, $context) {
                        return preg_match('/^[a-zA-Z0-9]+$/', $value) ? true : false;
                    },
                    'message' => 'hankakueisu4',
                ],
            ]);
            
        $validator
            ->add('login_id','custom',[
                'rule'=>[$this,'sameidCheck'],
                'message'=>'partnerErrMSG3',
            ]);
        
        //パスワードエラーチェック
        $validator
            ->scalar('login_pw')
            ->notEmpty('login_pw',"partnerErrMSG11")
            ->add('login_pw', [
                'length' => [
                    'rule' => ['minLength', 4],
                    'message' => 'hankakueisu4',
                ],
                'alphaNumeric' => [
                    'rule' => function ($value, $context) {
                        return preg_match('/^[a-zA-Z0-9]+$/', $value) ? true : false;
                    },
                    'message' => 'hankakueisu4',
                ],
            ]);
        
        //担当者氏名エラーチェック
        $validator
        ->scalar('rep_name')
        ->notEmpty('rep_name',"partnerErrMSG4");
        //担当者メールアドレスエラーチェック
        $validator
        ->scalar('rep_email')
        ->notEmpty('rep_email',"partnerErrMSG5")
        ->email('rep_email',false,"partnerErrMSG6");
        
        //電話番号エラーチェック
        $validator
        ->scalar('tel')
        ->allowEmpty('tel')
        ->add('tel','tel', [
                'rule' => function ($value, $context) {
                    $value = preg_replace("/\-/","",$value);
                    return (bool) preg_match('/^0\d{9,10}$/', $value);
                },
                'message' => 'partnerErrMSG7',
        ]);
        $validator
        ->scalar('fax')
        ->allowEmpty('fax')
        ->add('fax','fax', [
                'rule' => function ($value, $context) {
                    $value = preg_replace("/\-/","",$value);
                    return (bool) preg_match('/^0\d{9,10}$/', $value);
                },
                'message' => 'partnerErrMSG8',
        ]);

        //担当者メールアドレスエラーチェック
        $validator
        ->scalar('rep_email2')
        ->allowEmpty('rep_email2')
        ->email('rep_email2',false,"partnerErrMSG9");
        
        //担当者連絡先電話番号
        $validator
        ->scalar('rep_tel1')
        ->allowEmpty('rep_tel1')
        ->add('rep_tel1','rep_tel1', [
                'rule' => function ($value, $context) {
                    $value = preg_replace("/\-/","",$value);
                    return (bool) preg_match('/^0\d{9,10}$/', $value);
                },
                'message' => 'partnerErrMSG10',
        ]);

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
        /*
        $rules->add($rules->existsIn(['login_id'], 'Logins'));
        $rules->add($rules->existsIn(['eir_id'], 'Eirs'));
        $rules->add($rules->existsIn(['partner_id'], 'Partners'));
*/
        return $rules;
    }
    public function sameidCheck($value,$context){
        
        $where = [];
        $where['login_id'] = $value;
        $query = $this->find()->select(['id','name','login_id'])->where($where)->first();
        if(is_null($query)){
            return true;
        }else{
                
            if(isset($context[ 'data' ]['editid']) && $context[ 'data' ]['editid'] == $query[ 'id' ]){
                return true;
            }
            return false;
        }
    }
}
