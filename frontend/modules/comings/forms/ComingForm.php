<?php
/**
 * Created by PhpStorm.
 * User: alt
 * Date: 15.05.17
 * Time: 10:09
 */

namespace frontend\modules\comings\forms;


use common\forms\PhonesForm;
use common\repositories\AddressRepository;
use common\repositories\ClientsRepository;
use common\repositories\ComingsRepository;
use common\repositories\PhonesRepository;
use frontend\forms\AddressForm;
use yii\validators\NumberValidator;
use yii;

class ComingForm extends ComingsRepository
{
    public $addressText;
    public $measurementBtn;

    /** @var  AddressForm */
    public $addressModel;

    // Если новое обращение, создаем карточку клиента
    public $clientModel = null;

    /** @var  $phonesModel PhonesForm */
    public $phonesModel;

    public function rules()
    {
        return array_merge(parent::rules(), [
            [['addressText'], 'string'],
            ['addressText', 'validateAddress'],
            [['firstname'], 'required'],
            [['measurementBtn'], 'safe']
        ]);
    }

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'phonesItems' => 'Телефон',
            'addressText' => 'Адрес',
            'expected_action_id' => 'Запланированное действие'
        ]);
    }

    public function init()
    {
        parent::init();
        $this->addressModel = new AddressForm();
        $this->phonesModel = new PhonesForm([
            'fromType' => PhonesRepository::TYPE_COMING
        ]);
    }

    public function validateAddress()
    {
        if (!($this->addressModel->load(\Yii::$app->request->post(), 'AddressForm') && $this->addressModel->validate())){
            $this->addError('addressText', 'Неверный адрес');
        }
    }

    public function afterFind()
    {
        $this->addressModel = AddressForm::find()
            ->where(['obj_id' => $this->id])
            ->andWhere(['type' => AddressRepository::TYPE_COMING])
            ->one();
        if (!$this->addressModel) {
            $this->addressModel = new AddressForm();
        }
        $this->addressText = $this->addressModel->full;

        $this->phonesModel->init(PhonesRepository::TYPE_COMING, $this->id);
    }

    public function beforeValidate()
    {
        // Перед валидацией, создаем нужное кол-во моделей, загружаем в них телефоны и валидируем.
        if (!$this->phonesModel->validate()) {
            $this->addError('phonesModel', '');
        }

        if (parent::beforeValidate()) {
            return true;
        }
        return false;
    }

    public function loadFrom($from)
    {
        $this->firstname = $from['firstname'];
        $this->middlename = $from['middlename'];
        $this->lastname = $from['lastname'];
        $this->client_id = $from['id'];

        $this->phonesModel->loadFrom(PhonesRepository::TYPE_CLIENT, $from['id']);

        $this->addressModel = AddressForm::getAddress(AddressRepository::TYPE_CLIENT, $from['id']);
        if (!$this->addressModel) {
            $this->addressModel = new AddressForm();
        }
        $this->addressText = $this->addressModel->full;
    }

    public function save($runValidation = true, $attributeNames = null)
    {
        if ($this->isNewRecord && !$this->client_id) {
            $this->clientModel = new ClientsRepository();
            $this->clientModel->firstname = $this->firstname;
            $this->clientModel->middlename = $this->middlename;
            $this->clientModel->lastname = $this->lastname;
            $this->clientModel->user_id = $this->user_id;
            $this->clientModel->company_id = $this->company_id;
            $this->clientModel->type = ClientsRepository::TYPE_FIZ;
            $this->clientModel->status = ClientsRepository::STATUS_ACTIVE;
            $this->clientModel->save();

            $this->client_id = $this->clientModel->id;
        } else {
            PhonesRepository::deleteAll(['type' => PhonesRepository::TYPE_COMING, 'obj_id' => $this->id]);
        }

        return parent::save($runValidation, $attributeNames);
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        $this->addressModel->type = AddressRepository::TYPE_COMING;
        $this->addressModel->obj_id = $this->id;
        $this->addressModel->save(false);

        if ($insert) {
            $address = new AddressRepository();
            $address->attributes = $this->addressModel->attributes;
            $address->type = AddressRepository::TYPE_CLIENT;
            $address->obj_id = $this->id;
            $address->save();
        }

        $this->phonesModel->fromId = $this->id;
        if ($this->phonesModel->save()) {
            if ($this->phonesModel->_phonesLoaded) {
                /**  @var $item PhonesRepository  **/
                if ($insert) {
                    foreach ($this->phonesModel->phonesItems as $item) {
                        $phone = new PhonesRepository([
                            'phone' => $item->phone,
                            'type' => PhonesRepository::TYPE_CLIENT,
                            'obj_id' => $this->clientModel['id']
                        ]);
                        $phone->save();
                    }
                }
            }
        }
    }
}