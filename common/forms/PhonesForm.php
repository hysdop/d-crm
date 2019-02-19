<?php
/**
 * Created by PhpStorm.
 * User: alt
 * Date: 07.07.17
 * Time: 16:31
 */

namespace common\forms;


use yii;
use yii\base\Model;
use common\repositories\PhonesRepository;

class PhonesForm extends Model
{
    public $phonesItems;

    public $_phonesLoaded = false;
    public $fromId = null;
    public $fromType = null;

    public function rules()
    {
        return array_merge(parent::rules(), [
            [['phonesItems'], 'safe'],
        ]);
    }

    public function init($fromType = null, $fromId = null)
    {
        if ($fromId || $fromId) {
            $this->fromId = $fromId;
            $this->fromType = $fromType;
            $phones = PhonesRepository::find()
                ->where(['type' => $fromType])
                ->andWhere(['obj_id' => $fromId])
                ->all();
        } else {
            $phones = [new PhonesRepository()];
        }

        if (!$phones) {
            $phones = [new PhonesRepository()];
        }
        $this->phonesItems = $phones;

        parent::init();
    }

    public function beforeValidate()
    {
        // Перед валидацией, создаем нужное кол-во моделей, загружаем в них телефоны и валидируем.
        $this->phonesItems = [new PhonesRepository()];
        $cnt = count(Yii::$app->request->post('PhonesRepository', 0));
        for ($i=1;$i<$cnt;$i++) {
            $this->phonesItems[] = new PhonesRepository();
        }
        if (PhonesRepository::loadMultiple($this->phonesItems, array_values(Yii::$app->request->post('PhonesRepository')), '')) {
            $this->_phonesLoaded = true;
        }
        if (!PhonesRepository::validateMultiple($this->phonesItems)) {
            $this->addError('phonesItems');
        }

        if (parent::beforeValidate()) {
            return true;
        }
        return false;
    }

    public function loadFrom($fromType = null, $fromId = null)
    {
        $phones = PhonesRepository::getPhones($fromType, $fromId);
        foreach ($phones as $k => $item) {
            $this->phonesItems[$k] = new PhonesRepository();
            $this->phonesItems[$k]->phone = $item['phone'];
        }
    }

    public function save()
    {
        if ($this->_phonesLoaded) {
            /** @var $item PhonesRepository  */
            foreach ($this->phonesItems as $item) {
                $item->type = $this->fromType;
                $item->obj_id = $this->fromId;
                $item->phone = preg_replace('/[^0-9,.]/', '', $item->phone);
                if (!$item->save()) {
                    // var_dump($item->phone); die('no!');
                };
            }
        }

        return true;
    }
}