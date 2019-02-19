<?php
/**
 * Created by PhpStorm.
 * User: alt
 * Date: 26.04.17
 * Time: 10:21
 */

namespace common\repositories;

use common\behaviors\IpBehavior;
use common\models\DialogsMessages;
use yii\behaviors\TimestampBehavior;

class DialogsMessagesRepository extends DialogsMessages
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            IpBehavior::className()
        ];
    }
}
