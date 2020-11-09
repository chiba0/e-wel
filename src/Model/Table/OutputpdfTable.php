<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Outputpdf Model
 *
 * @property \App\Model\Table\PdfsTable&\Cake\ORM\Association\BelongsTo $Pdfs
 *
 * @method \App\Model\Entity\Outputpdf get($primaryKey, $options = [])
 * @method \App\Model\Entity\Outputpdf newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Outputpdf[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Outputpdf|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Outputpdf saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Outputpdf patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Outputpdf[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Outputpdf findOrCreate($search, callable $callback = null, $options = [])
 */
class OutputpdfTable extends Table
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

        $this->setTable('outputpdf');
        $this->setDisplayField('id');
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

        $validator
            ->integer('uid')
            ->allowEmptyString('uid');

        $validator
            ->integer('status')
            ->allowEmptyString('status');

        $validator
            ->dateTime('regist_ts')
            ->allowEmptyDateTime('regist_ts');

        $validator
            ->dateTime('update_ts')
            ->allowEmptyDateTime('update_ts');

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
     //   $rules->add($rules->existsIn(['pdf_id'], 'Pdfs'));

        return $rules;
    }
}
