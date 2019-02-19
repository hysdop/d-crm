<?php
/**
 * Created by PhpStorm.
 * User: alt
 * Date: 22.04.17
 * Time: 11:58
 */

namespace frontend\blocks\topnav;

use yii\base\Widget;

class TopNavBlock extends Widget
{
    public function run()
    {
        $lastMsgs = (new \yii\db\Query())
            ->select("d.*, m.text, m.user_id as msg_user_id,
                CONCAT_WS(' ', p.firstname, p.lastname) as `userName`,
                CONCAT_WS('/', p.avatar_base_url, p.avatar_path) as `avatar`
            ")
            ->from('{{%dialogs}} d')
            ->innerJoin('(select * from {{%dialogs_messages}} m WHERE m.read_at IS NULL ORDER BY m.id DESC) m',
                'm.dialog_id = d.id AND m.user_id <> ' . \Yii::$app->user->id)
            ->innerJoin('{{%user_profile}} p', 'p.user_id = m.user_id')
            ->where(['d.user_1' => \Yii::$app->user->id])
            ->orWhere(['d.user_2' => \Yii::$app->user->id])
            ->groupBy(['d.id'])
            ->orderBy(['m.id' => SORT_DESC])
            ->all();

        return $this->render('index', [
            'user' => \Yii::$app->user->identity,
            'lastMsgs' => $lastMsgs,
            'cntMsgs' => count($lastMsgs)
        ]);
    }
}
