<?php

namespace frontend\modules\clients\forms;

use common\forms\PhonesForm;
use common\repositories\AddressRepository;
use common\repositories\ClientsRequisitesRepository;
use yii;
use common\repositories\ClientsRepository;
use common\repositories\PhonesRepository;
use frontend\forms\AddressForm;

/**
 * Created by PhpStorm.
 * User: alt
 * Date: 30.05.17
 * Time: 11:10
 */
class ClientForm extends ClientsRepository
{
    const SCENARIO_FIZ = 1; // Физ. лицо
    const SCENARIO_UR = 2;  // Юр. лицо

    /** @var AddressForm */
    public $addressModel;
    public $addressText;

    /** @var  ClientsRequisitesForm */
    public $clientsRequisitesModel;

    /** @var  $phonesModel PhonesForm */
    public $phonesModel;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'sex', 'status', 'user_id', 'passport_series', 'passport_number', 'created_at', 'updated_at'], 'integer'],
            [['birthday', 'passport_date', 'addressText'], 'safe'],
            [['firstname', 'lastname', 'middlename', 'passport_issue'], 'string', 'max' => 255],
            [['text'], 'string'],

            [[ 'firstname',
            ], 'required', 'on' => self::SCENARIO_FIZ],

            [[ 'firstname',
            ], 'required', 'on' => self::SCENARIO_UR],

            ['addressText', 'validateAddress'],
        ];
    }

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'addressText' => 'Адрес',
        ]);
    }

    public function init()
    {
        parent::init();
        $this->addressModel = new AddressForm();
        $this->clientsRequisitesModel = new ClientsRequisitesForm();
        $this->phonesModel = new PhonesForm([
            'fromType' => PhonesRepository::TYPE_CLIENT
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
        // Адрес
        $this->addressModel = AddressForm::find()
            ->where(['obj_id' => $this->id])
            ->andWhere(['type' => AddressRepository::TYPE_CLIENT])
            ->one();
        if (!$this->addressModel) {
            $this->addressModel = new AddressForm();
        }
        $this->addressText = $this->addressModel->full;

        // Телефоны
        $this->phonesModel->init(PhonesRepository::TYPE_CLIENT, $this->id);

        // Реквезиты
        $this->clientsRequisitesModel = ClientsRequisitesForm::find()
            ->where(['client_id' => $this->id])
            ->one();
        if (!$this->clientsRequisitesModel) {
            $this->clientsRequisitesModel = new ClientsRequisitesForm();
        }
    }

    public function beforeValidate()
    {
        // Перед валидацией, создаем нужное кол-во моделей, загружаем в них телефоны и валидируем.
        if (!$this->phonesModel->validate()) {
            $this->addError('phonesModel', '');
        }

        // Проверяем реквезиты
        if (($this->scenario == self::SCENARIO_UR) && !($this->clientsRequisitesModel->load(Yii::$app->request->post()) && $this->clientsRequisitesModel->validate())) {
            $this->addError('clientsRequisitesModel', 'Неверно заполнены реквизиты');
        }

        if (parent::beforeValidate()) {
            return true;
        }
        return false;
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        // Адрес
        $this->addressModel->type = AddressRepository::TYPE_CLIENT;
        $this->addressModel->obj_id = $this->id;
        $this->addressModel->save();

        // Телефоны
        if (!$insert) {
            PhonesRepository::deleteAll(['type' => PhonesRepository::TYPE_CLIENT, 'obj_id' => $this->id]);
            $this->phonesModel->fromId = $this->id;
            $this->phonesModel->save();
        }

        // Реквезиты
        if (($this->scenario  == self::SCENARIO_UR)
                && $this->clientsRequisitesModel->load(Yii::$app->request->post())) {
            $this->clientsRequisitesModel->client_id = $this->id;
            $this->clientsRequisitesModel->save();
        }
    }
}