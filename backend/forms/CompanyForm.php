<?php
/**
 * Created by PhpStorm.
 * User: alt
 * Date: 05.05.17
 * Time: 15:06
 */

namespace backend\forms;


use common\repositories\AddressRepository;
use common\repositories\CompanyRepository;
use common\repositories\DirectoriesRepository;
use frontend\forms\AddressForm;

class CompanyForm extends CompanyRepository
{
    public $addressText;

    /** @var  AddressForm */
    public $addressModel;

    public function rules()
    {
        return [
            [['type'], 'required'],
            [['type', 'status', 'created_at', 'updated_at'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['phone', 'phone_second'], 'string', 'max' => 11],
            [['addressText'], 'string'],
            ['addressText', 'validateAddress'],
        ];
    }

    public function afterFind()
    {
        $this->addressModel = AddressForm::find()
            ->where(['obj_id' => $this->id])
            ->andWhere(['type' => AddressRepository::TYPE_COMPANY])
            ->one();
        if (!$this->addressModel) {
            $this->addressModel = new AddressForm();
        }
    }

    public function init()
    {
        $this->addressModel = new AddressForm();
        parent::init();
    }

    public function validateAddress()
    {
        if (!($this->addressModel->load(\Yii::$app->request->post(), 'AddressForm') && $this->addressModel->validate())){
            $this->addError('addressText', 'Неверный адрес');
        }
    }

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'addressText' => 'Адрес'
        ]);
    }

    public function save($runValidation = true, $attributeNames = null)
    {
        if ($this->isNewRecord) {
            $this->status = CompanyRepository::STATUS_ACTIVE;
        }

        return parent::save($runValidation, $attributeNames); // TODO: Change the autogenerated stub
    }

    public function afterSave($insert, $changedAttributes)
    {
        $this->addressModel->type = AddressRepository::TYPE_COMPANY;
        $this->addressModel->obj_id = $this->id;
        $this->addressModel->save(false);

        if ($insert) {
            $systemDirs = DirectoriesRepository::getOnlySystem();
            /**
             * Создает копии системных справочников для новой компании. Если их станет слишком много можно заменить
             * на это, но надо исключить любые возможные ошибки.
             *   CREATE TEMPORARY TABLE tmptable SELECT * FROM directories WHERE company_id is NULL;
             *   INSERT INTO directories SELECT NULL, name, `type`, `status`,`sort`, NULL, NULL, NULL FROM tmptable;
             *   drop TEMPORARY  table tmptable;
             */
            foreach ($systemDirs as $item) {
                unset($item['id']);
                $dir = new DirectoriesRepository();
                $dir->load($item, '');
                $dir->company_id = $this->id;
                $dir->save();
                unset($dir);
            }
        }
        parent::afterSave($insert, $changedAttributes);
    }
}