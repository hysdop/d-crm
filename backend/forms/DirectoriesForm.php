<?php
/**
 * Created by PhpStorm.
 * User: alt
 * Date: 27.05.17
 * Time: 14:09
 */

namespace backend\forms;


use common\repositories\DirectoriesRepository;

class DirectoriesForm extends DirectoriesRepository
{
    public function rules()
    {
        return [
            [['type', 'status', 'sort'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['name', 'type'], 'required']
        ];
    }
}