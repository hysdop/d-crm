<?php
/**
 * Created by PhpStorm.
 * User: alt
 * Date: 26.05.17
 * Time: 15:19
 */

namespace frontend\modules\settings\forms;


use common\repositories\DirectoriesRepository;

class SettingsDirectoryForm extends DirectoriesRepository
{
    public function rules()
    {
        return [
            [['type', 'status'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['name', 'type'], 'required']
        ];
    }
}