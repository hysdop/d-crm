<?php
/**
 * Created by PhpStorm.
 * User: alt
 * Date: 25.04.17
 * Time: 11:23
 */

namespace frontend\controllers;



use common\repositories\DialogsMessagesRepository;
use common\repositories\DialogsRepository;
use common\repositories\PhonesRepository;
use frontend\forms\MessageSendForm;
use League\Uri\Components\Query;
use yii\base\InvalidParamException;
use yii\db\Expression;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class MessagesController extends Controller
{
    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@']
                    ]
                ]
            ]
        ];
    }

    public function actionIndex()
    {
        $dialogs = (new \yii\db\Query())
            ->select("d.*, m.text, m.user_id as msg_user_id, CONCAT_WS(' ', p.firstname, p.lastname) as `userName1`, CONCAT_WS(' ', p2.firstname,  p2.lastname) as `userName2`, 
                           CONCAT_WS('/', p.avatar_base_url, p.avatar_path) as `avatar1`, CONCAT_WS('/', p2.avatar_base_url, p2.avatar_path) as `avatar2`")
            ->from('{{%dialogs}} d')
            ->innerJoin('{{%user_profile}} p', 'p.user_id = d.user_1')
            ->innerJoin('{{%user_profile}} p2', 'p2.user_id = d.user_2')
            ->innerJoin('(select * from {{%dialogs_messages}} m ORDER BY id DESC) m', 'm.dialog_id = d.id')
            ->where(['d.user_1' => \Yii::$app->user->id])
            ->orWhere(['d.user_2' => \Yii::$app->user->id])
            ->groupBy('d.id')
            ->orderBy(['m.created_at' => SORT_DESC])
            ->all();

        return $this->render('index', [
            'dialogs' => $dialogs
        ]);
    }

    public function actionDialog($id)
    {
        $userId = \Yii::$app->user->id;
        $dialog = (new \yii\db\Query())
            ->select("d.*, CONCAT_WS(' ', p.firstname, p.lastname) as `userName1`, CONCAT_WS(' ', p2.firstname,  p2.lastname) as `userName2` , 
                           CONCAT_WS('/', p.avatar_base_url, p.avatar_path) as `avatar1`, CONCAT_WS('/', p2.avatar_base_url, p2.avatar_path) as `avatar2`")
            ->from('{{%dialogs}} d')
            ->innerJoin('{{%user_profile}} p',  'p.user_id = d.user_1')
            ->innerJoin('{{%user_profile}} p2', 'p2.user_id = d.user_2')
            ->where(['id' => $id])
            ->andWhere("d.user_1 = '$userId' OR d.user_2 = '$userId'")
            ->one();
        if (!$dialog) {
            throw new NotFoundHttpException('Диалог не найден');
        }

        if ($dialog['status'] != DialogsRepository::STATUS_ACTIVE) {
            throw new ForbiddenHttpException('Диалог заблокирован');
        }

        $sendForm = new MessageSendForm();
        $sendForm->dialog_id = $id;

        $messages = (new \yii\db\Query())
            ->select("m.*")
            ->from('{{%dialogs_messages}} m')
            ->where(['m.dialog_id' => $dialog['id']])
            ->orderBy(['m.id' => SORT_ASC])
            ->all();

        DialogsMessagesRepository::updateAll([
            'read_at' => time()
        ],  "dialog_id = $dialog[id] AND read_at IS NULL AND user_id <> " . \Yii::$app->user->id);

        return $this->render('dialog', [
            'sendForm' => $sendForm,
            'dialog'   => $dialog,
            'messages' => $messages
        ]);
    }

    public function actionOpenDialog($userId)
    {
        $currentUserId = \Yii::$app->user->id;

        if (!$userId || ($userId == $currentUserId)) {
            throw new \HttpInvalidParamException();
        }

        $dialog = DialogsRepository::find()
            ->where(['user_1' => $userId, 'user_2' => $currentUserId])
            ->orWhere(['user_1' => $currentUserId, 'user_2' => $userId])
            ->one();

        if (!$dialog) {
            $dialog = new DialogsRepository();
            $dialog->user_1 = $currentUserId;
            $dialog->user_2 = $userId;
            $dialog->status = DialogsRepository::STATUS_ACTIVE;
            $dialog->save();
        }

        return $this->redirect(['messages/dialog', 'id' => $dialog->id]);
    }

    public function actionSend()
    {
        $model = new MessageSendForm();
        \Yii::$app->response->format = Response::FORMAT_JSON;

        $model->user_id   = \Yii::$app->user->id;
        $model->text      = \Yii::$app->request->post('text');
        $model->dialog_id = \Yii::$app->request->post('dialog_id');

        if ($model->validate()) {
            if ($model->save()) {
                $messages = (new \yii\db\Query())
                    ->select("m.*")
                    ->from('{{%dialogs_messages}} m')
                    ->where(['m.dialog_id' => $model->dialog_id])
                    ->andWhere(['>', 'id', \Yii::$app->request->post('last_item')])
                    ->orderBy(['m.id' => SORT_ASC])
                    ->all();

                return $messages;
            }
        } else {
            throw new InvalidParamException();
        }

        return [];
    }

    public function actionNewMessages()
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;

        $messages = (new \yii\db\Query())
            ->select("m.*")
            ->from('{{%dialogs_messages}} m')
            ->where(['m.dialog_id' => \Yii::$app->request->post('dialog_id')])
            ->andWhere(['>', 'id', \Yii::$app->request->post('last_item')])
            ->orderBy(['m.id' => SORT_ASC])
            ->all();

        return $messages;
    }
}