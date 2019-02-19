<?php
/**
 * Created by PhpStorm.
 * User: alt
 * Date: 04.05.17
 * Time: 17:20
 */

namespace common\repositories;

use common\models\Address;
use yii\behaviors\TimestampBehavior;

class AddressRepository extends Address
{
    const TYPE_COMING = 1;
    const TYPE_CLIENT = 2;
    const TYPE_MEASUREMENT = 3;
    const TYPE_COMPANY = 4;
    const TYPE_DOG = 5;
    const TYPE_OFFICE = 6;

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className()
        ];
    }

    public static function getAddresses($type, $obj_id)
    {
        return self::find()
            ->where(['type' => $type])
            ->andWhere(['obj_id' => $obj_id])
            ->asArray()
            ->all();
    }

    public static function getAddress($type, $obj_id)
    {
        return self::find()
            ->where(['type' => $type])
            ->andWhere(['obj_id' => $obj_id])
            ->one();
    }
}
