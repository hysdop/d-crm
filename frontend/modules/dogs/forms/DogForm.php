<?php
/**
 * Created by PhpStorm.
 * User: alt
 * Date: 26.06.17
 * Time: 17:49
 */

namespace frontend\modules\dogs\forms;


use common\repositories\AddressRepository;
use common\repositories\DogsRepository;
use common\repositories\MeasurementsRepository;
use common\repositories\PhonesRepository;
use frontend\forms\AddressForm;
use yii\db\Query;
use yii;

class DogForm extends DogsRepository
{
    public $phone;
    public $phonesItems;
    public $addressModel;
    public $addressText;

    private $_phonesLoaded = false;

    public function rules()
    {
        return [
            [['sum', 'type', 'status', 'user_id', 'company_id', 'client_id', 'address_id', 'created_at', 'updated_at'], 'integer'],
            [['discount'], 'number'],
            [['text'], 'string'],
            [['firstname', 'lastname', 'middlename'], 'string', 'max' => 255],
        ];
    }

    public function loadFrom($type, $id)
    {
        if ($id) {
            switch ($type) {
                case DogsRepository::FROM_MEASUREMENT:
                    $from = (new Query())
                        ->from('{{%measurements}}')
                        ->where([
                            'id' => $id,
                            'company_id' => \Yii::$app->user->identity->company_id,
                            'user_id' => \Yii::$app->user->id
                        ])
                        ->one();
                    if (!$from) throw new \HttpInvalidParamException();

                    $this->firstname = $from['firstname'];
                    $this->middlename = $from['middlename'];
                    $this->lastname = $from['lastname'];
                    $this->measurement_id = $id;

                    $phones = PhonesRepository::getPhones(PhonesRepository::TYPE_MEASUREMENT, $id);
                    foreach ($phones as $k => $item) {
                        $this->phonesItems[$k] = new PhonesRepository();
                        $this->phonesItems[$k]->phone = $item['phone'];
                    }

                    $this->addressModel = AddressForm::getAddress(AddressRepository::TYPE_MEASUREMENT, $id);
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

    public function init()
    {
        parent::init();
        $this->addressModel = new AddressForm();
        $this->phonesItems = [new PhonesRepository()];
    }

    public function afterFind()
    {
        // Адрес
        $this->addressModel = AddressForm::find()
            ->where(['obj_id' => $this->id])
            ->andWhere(['type' => AddressRepository::TYPE_DOG])
            ->one();
        if (!$this->addressModel) {
            $this->addressModel = new AddressForm();
        }
        $this->addressText = $this->addressModel->full;

        // Телефоны
        $phones = PhonesRepository::find()
            ->where(['type' => PhonesRepository::TYPE_DOG])
            ->andWhere(['obj_id' => $this->id])
            ->all();
        if (!$phones) {
            $phones = [new PhonesRepository()];
        }
        $this->phonesItems = $phones;
    }

    public function save($runValidation = true, $attributeNames = null)
    {
        // Телефоны
        if (!$this->isNewRecord) {
            PhonesRepository::deleteAll(['type' => PhonesRepository::TYPE_DOG, 'obj_id' => $this->id]);
        }
        $this->phonesItems = [new PhonesRepository()];
        $cnt = count(\Yii::$app->request->post('PhonesRepository', 0));
        for ($i=1;$i<$cnt;$i++) {
            $this->phonesItems[] = new PhonesRepository();
        }
        if (PhonesRepository::loadMultiple($this->phonesItems, Yii::$app->request->post())) {
            $this->_phonesLoaded = true;
            //$this->phone = count($this->phonesItems) > 0 ? $this->phonesItems[0]->phone : null;
        }

        return parent::save($runValidation, $attributeNames);
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        // Адрес
        $this->addressModel->type = AddressRepository::TYPE_DOG;
        $this->addressModel->obj_id = $this->id;
        $this->addressModel->save();

        // Телефоны
        if ($this->_phonesLoaded) {
            /** @var $item PhonesRepository */
            foreach ($this->phonesItems as $item) {
                $item->type = PhonesRepository::TYPE_DOG;
                $item->obj_id = $this->id;
                $item->save();
            }
        }
    }
}