<?php
/**
 * Created by PhpStorm.
 * User: alt
 * Date: 15.06.17
 * Time: 13:37
 */

namespace frontend\modules\measurements\forms;


use common\models\Measurements;
use common\repositories\AddressRepository;
use common\repositories\MeasurementsRepository;
use common\repositories\PhonesRepository;
use frontend\forms\AddressForm;
use yii\db\Query;
use common\repositories\ClientsRepository;
use common\repositories\ComingsRepository;
use common\repositories\CompanyRepository;
use common\repositories\UserRepository;
use Yii;

class MeasurementsForm extends MeasurementsRepository
{
    public $phone;
    public $phonesItems;
    public $addressModel;
    public $addressText;

    public $timesList;

    private $_phonesLoaded = false;

    public function rules()
    {
        return [
            [['status', 'constructions', 'user_id'], 'integer'],
            [['time', 'phonesItems', 'addressText'], 'safe'],
            [['firstname', 'lastname', 'middlename'], 'string', 'max' => 255],
            [['user_id', 'firstname', 'time'], 'required'],
            [['time'], 'time'],
            [['date'], 'safe'],
            ['addressText', 'validateAddress'],

            [['time'], 'validateTime']
        ];
    }

    public function init()
    {
        parent::init();
        $this->addressModel = new AddressForm();
        $this->phonesItems = [new PhonesRepository()];
    }

    public function validateTime()
    {
        $measurement = Measurements::find()
            ->where([
                'employee_id' => $this->employee_id,
                'date' => $this->date,
                'time' => $this->time
            ])
            ->one();

        if ($measurement) {
            $this->addError('time', 'Время занято');
        }
    }

    public function validateAddress()
    {
        if (!($this->addressModel->load(\Yii::$app->request->post(), 'AddressForm') && $this->addressModel->validate())){
            $this->addError('addressText', 'Неверный адрес');
        }
    }

    public function fillAvailableTimesList()
    {
        $measurements = Measurements::find()
            ->select('time')
            ->where([
                'employee_id' => $this->employee_id,
                'date' => $this->date,
            ])
            ->asArray();

        if (!$this->isNewRecord) {
            $measurements->andWhere(['<>', 'id', $this->id]);
        }

        $measurements = $measurements->all();

        //echo $this->employee_id . '<br>';
        //echo $this->date;
        //var_dump($measurements);

        $busyTimes = [];
        foreach ($measurements as $item) {
            $item['time'] = substr($item['time'], 0, -3);
            $busyTimes[] = $item['time'];
        }

        for ($i=8;$i<19;$i++) {
            $time = str_pad($i, 2, '0', STR_PAD_LEFT) . ':00';
            if (!in_array($time, $busyTimes)) {
                $this->timesList[] = $time;
            }
        }
    }

    public function loadFrom($type, $id)
    {
        if ($id) {
            switch ($type) {
                case MeasurementsRepository::FROM_COMING:
                    $from = (new Query())
                        ->from('{{%comings}}')
                        ->where([
                            'id' => $id,
                            'status' => ComingsRepository::STATUS_ACTIVE,
                            'company_id' => Yii::$app->user->identity->company_id,
                            'user_id' => Yii::$app->user->id
                        ])
                        ->one();
                    $this->firstname = $from['firstname'];
                    $this->middlename = $from['middlename'];
                    $this->lastname = $from['lastname'];
                    $this->constructions = $from['constructions'];

                    $phones = PhonesRepository::getPhones(PhonesRepository::TYPE_COMING, $id);
                    foreach ($phones as $k => $item) {
                        $this->phonesItems[$k] = new PhonesRepository();
                        $this->phonesItems[$k]->phone = $item['phone'];
                    }

                    $this->addressModel = AddressForm::getAddress(AddressRepository::TYPE_COMING, $id);
                    if (!$this->addressModel) {
                        $this->addressModel = new AddressForm();
                    }
                    $this->addressText = $this->addressModel->full;

                    break;
                case MeasurementsRepository::FROM_CLIENT:
                    /** @var $from ClientsRepository */
                    $from = (new Query())
                        ->from('{{%clients}}')
                        ->where([
                            'id' => $id,
                            'status' => ClientsRepository::STATUS_ACTIVE,
                            'company_id' => Yii::$app->user->identity->company_id,
                            'user_id' => Yii::$app->user->id
                        ])
                        ->one();
                    $this->firstname = $from['firstname'];
                    $this->middlename = $from['middlename'];
                    $this->lastname = $from['lastname'];
                    $this->client_id = $id;

                    $phones = PhonesRepository::getPhones(PhonesRepository::TYPE_CLIENT, $id);
                    foreach ($phones as $k => $item) {
                        $this->phonesItems[$k] = new PhonesRepository();
                        $this->phonesItems[$k]->phone = $item['phone'];
                    }

                    $this->addressModel = AddressForm::getAddress(AddressRepository::TYPE_CLIENT, $id);
                    if (!$this->addressModel) {
                        $this->addressModel = new AddressForm();
                    }
                    $this->addressText = $this->addressModel->full;

                    break;
                default:
                    return false;
            }
        }
        $this->from = $type;
        $this->from_id = $id;

        return $from;
    }

    public function beforeValidate()
    {
        if (parent::beforeValidate()) {
            // Перед валидацией, создаем нужное кол-во моделей, загружаем в них телефоны и валидируем.
            $this->phonesItems = [new PhonesRepository()];
            $cnt = count(Yii::$app->request->post('PhonesRepository', 0));
            for ($i=1;$i<$cnt;$i++) {
                $this->phonesItems[] = new PhonesRepository();
            }
            if (PhonesRepository::loadMultiple($this->phonesItems, array_values(Yii::$app->request->post('PhonesRepository')), '')) {
                $this->_phonesLoaded = true;
                $this->phone = count($this->phonesItems) > 0 ? $this->phonesItems[0]->phone : null;
            }
            if (!PhonesRepository::validateMultiple($this->phonesItems)) {
                $this->addError('phonesItems');
            }
            return true;
        }
        return false;
    }

    public function afterFind()
    {
        // Адрес
        $this->addressModel = AddressForm::find()
            ->where(['obj_id' => $this->id])
            ->andWhere(['type' => AddressRepository::TYPE_MEASUREMENT])
            ->one();
        if (!$this->addressModel) {
            $this->addressModel = new AddressForm();
        }
        $this->addressText = $this->addressModel->full;

        // Телефоны
        $phones = PhonesRepository::find()
            ->where(['type' => PhonesRepository::TYPE_MEASUREMENT])
            ->andWhere(['obj_id' => $this->id])
            ->all();
        if (!$phones) {
            $phones = [new PhonesRepository()];
        }
        $this->phonesItems = $phones;

        if ($this->time) {
            $this->time = substr($this->time, 0, -3);
        }
    }

    public function save($runValidation = true, $attributeNames = null)
    {
        // Телефоны
        if (!$this->isNewRecord) {
            PhonesRepository::deleteAll(['type' => PhonesRepository::TYPE_MEASUREMENT, 'obj_id' => $this->id]);
        }
        $this->phonesItems = [new PhonesRepository()];
        $cnt = count(Yii::$app->request->post('PhonesRepository', 0));
        for ($i=1;$i<$cnt;$i++) {
            $this->phonesItems[] = new PhonesRepository();
        }
        if (PhonesRepository::loadMultiple($this->phonesItems, Yii::$app->request->post())) {
            $this->_phonesLoaded = true;
            $this->phone = count($this->phonesItems) > 0 ? $this->phonesItems[0]->phone : null;
        }

        return parent::save($runValidation, $attributeNames);
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        // Адрес
        $this->addressModel->type = AddressRepository::TYPE_MEASUREMENT;
        $this->addressModel->obj_id = $this->id;
        $this->addressModel->save();

        // Телефоны
        if ($this->_phonesLoaded) {
            /** @var $item PhonesRepository */
            foreach ($this->phonesItems as $item) {
                $item->type = PhonesRepository::TYPE_MEASUREMENT;
                $item->obj_id = $this->id;
                $item->save();
            }
        }
    }
}