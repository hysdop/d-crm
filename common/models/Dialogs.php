<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "dialogs".
 *
 * @property integer $id
 * @property integer $user_1
 * @property integer $user_2
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property User $user2
 * @property User $user1
 * @property DialogsMessages[] $dialogsMessages
 */
class Dialogs extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dialogs';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_1', 'user_2'], 'required'],
            [['user_1', 'user_2', 'status', 'created_at', 'updated_at'], 'integer'],
            [['user_2'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_2' => 'id']],
            [['user_1'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_1' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_1' => Yii::t('app', 'Пользователь 1'),
            'user_2' => Yii::t('app', 'Пользователь 2'),
            'status' => Yii::t('app', 'Прочитан'),
            'created_at' => Yii::t('app', 'Создан'),
            'updated_at' => Yii::t('app', 'Изменен'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser2()
    {
        return $this->hasOne(User::className(), ['id' => 'user_2']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser1()
    {
        return $this->hasOne(User::className(), ['id' => 'user_1']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDialogsMessages()
    {
        return $this->hasMany(DialogsMessages::className(), ['dialog_id' => 'id']);
    }
}
