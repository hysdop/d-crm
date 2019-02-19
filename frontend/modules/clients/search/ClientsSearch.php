<?php

namespace frontend\modules\clients\search;

use common\repositories\PhonesRepository;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\repositories\ClientsRepository;
use yii\data\ArrayDataProvider;
use yii\data\Sort;
use yii\db\Expression;
use yii\db\Query;

/**
 * ClientsSearch represents the model behind the search form about `common\repositories\ClientsRepository`.
 */
class ClientsSearch extends ClientsRepository
{
    public $name;
    public $phone;

    public $dateFrom;
    public $dateTo;
    public $dateRange;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'type', 'sex', 'status', 'user_id', 'passport_series', 'passport_number', 'created_at', 'updated_at'], 'integer'],
            [['firstname', 'lastname', 'middlename', 'birthday', 'phone', 'passport_date',
                'passport_issue', 'name', 'dateFrom', 'dateTo', 'dateRange', 'text', 'phone'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'name' => 'Имя',
            'phone' => 'Телефон'
        ]);
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        //$query = ClientsRepository::find();
        $query = (new Query())
            ->select(new Expression('c.*, group_concat(p.phone) phones, 
            concat(c.`firstname`, \' \', c.lastname, \' \', c.middlename) name'))
            ->from(ClientsRepository::tableName() . ' c')
            ->leftJoin('{{%phones}} p', 'p.obj_id = c.id AND p.type = ' . PhonesRepository::TYPE_CLIENT)
            ->where(['c.user_id' => Yii::$app->user->id])
            ->andWhere(['c.status' => ClientsRepository::STATUS_ACTIVE])
            ->groupBy('c.id');

        $this->load($params);

        if (!$this->dateFrom) $this->dateFrom = '2017-01-01';
        if (!$this->dateTo) $this->dateTo = date('Y-m-d', strtotime('+1 day'));

        // фильтр по имени
        if ($this->name) {
            $names = explode(' ', preg_replace('/\s+/', ' ', $this->name));
            if (count($names) <= 3) {
                foreach ($names as $item) {
                    $query->andFilterHaving(['or', ['like', 'name',  $item]]);
                }
            }
        }

        $query->andFilterWhere(['>=', 'c.created_at', strtotime($this->dateFrom)])
            ->andFilterWhere(['<=', 'c.created_at', strtotime($this->dateTo)]);

        $query->andFilterWhere(['c.type' => $this->type]);
        $query->andFilterWhere(['like', 'p.phone', preg_replace('/\D/', '', $this->phone)]);
        $query->andFilterWhere(['like', 'text', $this->text]);

        $sort = new Sort([
            'defaultOrder' => ['created_at' => SORT_DESC],
            'attributes' => [
                'type',
                'created_at',
                'name' => [
                    'asc' => ['firstname' => SORT_ASC, 'lastname' => SORT_ASC],
                    'desc' => ['firstname' => SORT_DESC, 'lastname' => SORT_DESC],
                    'default' => SORT_ASC,
                    'label' => 'Name',
                ],
            ],
        ]);

        $dataProvider = new ArrayDataProvider([
            'allModels' => $query->all(),
            'sort' => $sort,
            'key' => 'id'
        ]);

        return $dataProvider;
    }
}
