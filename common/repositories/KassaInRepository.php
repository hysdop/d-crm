<?php
/**
 * Created by PhpStorm.
 * User: alt
 * Date: 04.07.17
 * Time: 17:58
 */

namespace common\repositories;


use common\models\KassaIn;
use yii\behaviors\TimestampBehavior;

class KassaInRepository extends KassaIn
{
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }
}