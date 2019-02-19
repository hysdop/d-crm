<?php
/**
 * Created by PhpStorm.
 * User: alt
 * Date: 15.05.17
 * Time: 15:49
 */

namespace common\repositories;

use common\components\Icons;
use common\models\Phones;
use yii\behaviors\TimestampBehavior;

class PhonesRepository extends Phones
{
    const TYPE_COMING = 1;
    const TYPE_CLIENT = 2;
    const TYPE_MEASUREMENT = 3;
    const TYPE_DOG = 4;

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className()
        ];
    }

    public function rules()
    {
        return [
            [['phone'], 'required'],
            [['phone'], 'match', 'pattern' => '/^\([0-9]{3}\) [0-9]{3}-[0-9]{4}||[0-9]{10}/'],
        ];
    }

    public function beforeValidate()
    {
        if (preg_match('/^\([0-9]{3}\) [0-9]{3}-[0-9]{4}/', $this->phone)) {
            $this->phone = preg_replace('/[^0-9,.]/', '', $this->phone);
        }
        return parent::beforeValidate();
    }

    public static function getPhones($type, $obj_id)
    {
        return self::find()
            ->select('phone')
            ->where(['type' => $type])
            ->andWhere(['obj_id' => $obj_id])
            ->asArray()
            ->all();
    }

    public static function phoneFormat($phone, $withIcon = false)
    {
        if (!$phone) return '';
        $result = "(".substr($phone, 0, 3).") ".substr($phone, 3, 3)."-".substr($phone,6);

        if ($withIcon) {
            $result = Icons::get(Icons::PHONE, 'green') . ' ' . $result;
        }

        return $result;
    }
}
