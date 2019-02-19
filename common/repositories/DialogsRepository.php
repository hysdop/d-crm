<?php
/**
 * Created by PhpStorm.
 * User: alt
 * Date: 25.04.17
 * Time: 12:20
 */

namespace common\repositories;

use common\behaviors\IpBehavior;
use common\models\Dialogs;
use yii\behaviors\TimestampBehavior;

class DialogsRepository extends Dialogs
{
    const STATUS_ACTIVE = 1;
    const STATUS_BLOCKED = 2;

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
