<?php
/**
 * Created by PhpStorm.
 * User: alt
 * Date: 23.06.17
 * Time: 11:00
 */

namespace frontend\modules\measurements\controllers;


use common\repositories\AddressRepository;
use common\repositories\UserProfileRepository;
use common\repositories\UserRepository;
use Yii;
use common\repositories\MeasurementsRepository;
use yii\db\Expression;
use yii\db\Query;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class CalendarController extends Controller
{
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
            ],
        ];
    }

    /**
     * Календарь замеров
     * @param $id integer ключ исходного объекта
     * @param $type integer тип исходного объекта(замер, клиент и т.п)
     * @return string
     */
    public function actionIndex($id = null, $type = null, $date = null)
    {
        $users =(new Query())
            ->select('p.*, m.date, m.time, m.status, u.username')
            ->from(UserProfileRepository::tableName() . ' p')
            ->innerJoin(UserRepository::tableName() . ' u', 'u.id = p.user_id')
            ->leftJoin(MeasurementsRepository::tableName() . ' m', 'm.employee_id = p.user_id')
            ->where(['u.status' => UserRepository::STATUS_ACTIVE])
            ->andWhere(['u.company_id' => Yii::$app->user->identity->company_id])
            ->orderBy(['p.firstname' => SORT_ASC, 'm.time' => SORT_ASC])
            ->all();

        $buf = [];
        foreach ($users as $item) {
            if (!isset($buf[$item['user_id']])) {
                $name = trim($item['firstname'] . ' ' . $item['lastname']);
                $buf[$item['user_id']]['user'] = [
                    'name' => ($name ? : $item['username'])
                ];
                $buf[$item['user_id']]['measurements'][$item['date']] = [];
            }
            $buf[$item['user_id']]['measurements'][$item['date']][] = [
                'time' => Yii::$app->formatter->asTime($item['time']),
                'status' => $item['status']
            ];
        }

        $days = [];
        if (!$date) {
            $date = date('Y-m-d', strtotime('U') - 86400);
        }
        for($i=0;$i<7;$i++) {
            $days[$i]['day'] = date('Y-m-d', strtotime($date) + 86400 * $i);
            //var_dump($days[$i]['day']);
            $days[$i]['dayFormatted'] = Yii::$app->formatter->asDate($days[$i]['day']);
        }

        $filter = [
            'date' => $date,
            'leftDate' => date('Y-m-d', strtotime($date) - 86400 * 7),
            'rightDate' => date('Y-m-d', strtotime($date) + 86400 * 7),
            'fromId' => $id,
            'fromType' => $type
        ];

        return $this->render('index', [
            'users' => $buf,
            'days' => $days,
            'fromId' => $id,
            'fromType' => $type,
            'filter' => $filter
        ]);
    }

    public function actionUser($uid, $date)
    {
        $user = (new Query())
            ->select(new Expression('concat(p.`firstname`, \' \', p.lastname) employeeName, u.id, u.username'))
            ->from('{{%user}} u')
            ->innerJoin('{{%user_profile}} p', 'p.user_id = u.id')
            ->where(['u.id' => $uid])
            ->andWhere(['u.company_id' => Yii::$app->user->identity->company_id])
            ->one();

        if (!$user) {
            throw new NotFoundHttpException('Сотрудник не найден или нет доступа');
        }

        $measurements = (new Query())
            ->select(new Expression('a.full address,  m.*'))
            ->from('{{%measurements}} m')
            ->leftJoin('{{%address}} a', 'a.obj_id = m.id AND a.type = ' . AddressRepository::TYPE_MEASUREMENT)
            ->where([
                'employee_id' => $uid,
                'date' => $date
            ])
            ->orderBy(['m.time' => SORT_ASC])
            ->groupBy('m.id')
            ->all();

        return $this->render('userMeasurements', [
            'measurements' => $measurements,
            'user' => $user,
            'date' => $date
        ]);
    }
}