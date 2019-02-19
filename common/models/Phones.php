<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%phones}}".
 *
 * @property integer $id
 * @property string $phone
 * @property integer $type
 * @property integer $obj_id
 * @property integer $created_at
 * @property integer $updated_at
 */
class Phones extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%phones}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'obj_id', 'created_at', 'updated_at'], 'integer'],
            [['phone'], 'string', 'max' => 10],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'phone' => 'Телефон',
            'type' => 'Тип',
            'obj_id' => 'Объект',
            'created_at' => 'Создан',
            'updated_at' => 'Изменен',
        ];
    }
}
