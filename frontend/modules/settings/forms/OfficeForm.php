<?php
/**
 * Created by PhpStorm.
 * User: alt
 * Date: 06.07.17
 * Time: 17:18
 */

namespace frontend\modules\settings\forms;


use common\repositories\OfficeRepository;
use frontend\forms\AddressForm;

class OfficeForm extends OfficeRepository
{
    public $addressJsonInfo;
    public $addressText;

    /** @var  AddressForm */
    public $addressModel;

    public function rules()
    {
        return [
            [['type', 'status'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['addressJsonInfo', 'addressText'], 'string'],
            ['addressText', 'validateAddress'],
            [['phone', 'phone_second'],
                'match',
                'pattern' => '/^\([0-9]{3}\) [0-9]{3}-[0-9]{4}$/',
                'message' => 'Неверный номер'
            ],
        ];
    }

    public function validateAddress()
    {
        if (!($this->addressModel->load(\Yii::$app->request->post(), 'AddressForm') && $this->addressModel->validate())){
            $this->addError('addressText', 'Неверный адрес');
        }
    }

    public function beforeSave($insert)
    {
        $this->phone = preg_replace('/[^0-9,.]/', '', $this->phone);
        $this->phone_second = preg_replace('/[^0-9,.]/', '', $this->phone_second);

        return parent::beforeSave($insert);
    }
}