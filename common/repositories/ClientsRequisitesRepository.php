<?php
/**
 * Created by PhpStorm.
 * User: alt
 * Date: 30.05.17
 * Time: 10:50
 */

namespace common\repositories;


use common\models\ClientsRequisites;
use yii\behaviors\TimestampBehavior;

class ClientsRequisitesRepository extends ClientsRequisites
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className()
        ];
    }
}