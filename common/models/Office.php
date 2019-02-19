<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%office}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $phone
 * @property string $phone_second
 * @property integer $type
 * @property integer $status
 * @property integer $company_id
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property User[] $users
 */
class Office extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%office}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'status', 'company_id', 'created_at', 'updated_at'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['phone', 'phone_second'], 'string', 'max' => 11],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'phone' => 'Телефон',
            'phone_second' => 'Дополнительный телефон',
            'type' => 'Тип',
            'status' => 'Статус',
            'company_id' => 'Компания',
            'created_at' => 'Создан',
            'updated_at' => 'Изменен',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['office_id' => 'id']);
    }
}
