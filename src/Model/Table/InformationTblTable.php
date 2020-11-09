<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * InformationTbl Model
 *
 * @method \App\Model\Entity\InformationTbl get($primaryKey, $options = [])
 * @method \App\Model\Entity\InformationTbl newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\InformationTbl[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\InformationTbl|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\InformationTbl saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\InformationTbl patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\InformationTbl[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\InformationTbl findOrCreate($search, callable $callback = null, $options = [])
 */
class InformationTblTable extends Table
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

        $this->setTable('information_tbl');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');
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
            // ->requirePresence('id', 'update')
            // ->notEmptyString('id', null, 'update');

        $validator
            ->scalar('title')
            ->requirePresence('title')
            ->notEmptyString('title', __('errmsg_title_empty'));

        $validator
            ->scalar('disp_area')
            ->requirePresence('disp_area')
            ->notEmptyString('disp_area', __('msg_please_select'));

        $validator
            ->scalar('disp_status')
            ->requirePresence('disp_area')
            ->notEmptyString('disp_area');
        
        $validator
            ->date('date1')
            ->requirePresence('date1')
            ->notEmptyString('date1', __('errmsg_date1_empty'));

        $validator
            ->date('date2')
            ->requirePresence('date2')
            ->notEmptyString('date2', __('errmsg_date2_empty'));

        // $validator
        //     ->allowEmpty('temp_file')
        //     ->add('temp_file', 'orversize', [
        //         'rule' => function ($value) {
        //                 return $value["size"] > D_FILESIZE_LIMIT;
        //         },
        //         'message' => 'エラーメッセージ'
        //     ]);

        return $validator;
    }
}
