<?php
/**
 * Created by PhpStorm.
 * User: alt
 * Date: 05.05.17
 * Time: 15:06
 */

namespace frontend\modules\settings\forms;


use common\repositories\AddressRepository;
use common\repositories\CompanyRepository;
use frontend\forms\AddressForm;

class CompanyForm extends CompanyRepository
{
    public $addressJsonInfo;
    public $addressText;

    /** @var  AddressForm */
    public $addressModel;

    public function rules()
    {
        return array_merge(parent::rules(), [
            [['addressJsonInfo', 'addressText'], 'string'],
            ['addressText', 'validateAddress'],
        ]);
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
        $this->addressText = $this->addressModel->full;
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
        //if ($this->addressModel->save()) {
            //$this->address_id = $this->addressModel->id;
        //}
        return parent::save($runValidation, $attributeNames);
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        $this->addressModel->type = AddressRepository::TYPE_COMPANY;
        $this->addressModel->obj_id = $this->id;
        $this->addressModel->save(false);
    }
}