<?php
/**
 * Created by PhpStorm.
 * User: alt
 * Date: 25.04.17
 * Time: 11:42
 */

namespace frontend\forms;

use common\repositories\DialogsMessagesRepository;

class MessageSendForm extends DialogsMessagesRepository
{
    public function attributeLabels()
    {
        return [
            'text' => 'Текст'
        ];
    }
}