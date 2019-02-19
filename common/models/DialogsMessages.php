<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%dialogs_messages}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $dialog_id
 * @property integer $read_at
 * @property integer $ip
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $text
 *
 * @property Dialogs $dialog
 * @property User $user
 */
class DialogsMessages extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%dialogs_messages}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'dialog_id'], 'required'],
            [['user_id', 'dialog_id', 'read_at', 'ip', 'created_at', 'updated_at'], 'integer'],
            [['text'], 'string', 'max' => 1024],
            [['dialog_id'], 'exist', 'skipOnError' => true, 'targetClass' => Dialogs::className(), 'targetAttribute' => ['dialog_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'Пользователь',
            'dialog_id' => 'Диалог',
            'read_at' => 'Прочитан',
            'ip' => 'IP',
            'created_at' => 'Создан',
            'updated_at' => 'Изменен',
            'text' => 'Текст',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDialog()
    {
        return $this->hasOne(Dialogs::className(), ['id' => 'dialog_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
