<?php

namespace frontend\modules\dogs\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\repositories\DogsRepository;
use yii\data\ArrayDataProvider;
use yii\data\Sort;
use yii\db\Expression;
use yii\db\Query;

/**
 * DogsSearch represents the model behind the search form about `common\repositories\DogsRepository`.
 */
class DogsSearch extends DogsRepository
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
            [['id', 'sum', 'type', 'status', 'user_id', 'company_id', 'client_id', 'address_id', 'created_at', 'updated_at'], 'integer'],
            [['firstname', 'lastname', 'middlename', 'text', 'name', 'dateFrom', 'dateTo', 'dateRange'], 'safe'],
            [['discount'], 'number'],
        ];
    }

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'name' => 'Имя'
        ]);
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
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
        $query = (new Query())
            ->select(new Expression('d.*, concat(d.`firstname`, \' \', d.lastname, \' \', d.middlename) name'))
            ->from('{{%dogs}} d')
            ->where([
                'status' => DogsRepository::STATUS_ACTIVE,
                'user_id' => Yii::$app->user->id,
                'company_id' => Yii::$app->user->identity->company_id
            ]);

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

        $query->andFilterWhere(['>=', 'd.created_at', strtotime($this->dateFrom)])
            ->andFilterWhere(['<=', 'd.created_at', strtotime($this->dateTo)]);

        $query->andFilterWhere([
            'd.sum' => $this->sum,
            'd.discount' => $this->discount
        ]);
        $query->andFilterWhere(['like', 'p.phone', preg_replace('/\D/', '', $this->phone)]);

        $sort = new Sort([
            'defaultOrder' => ['created_at' => SORT_DESC],
            'attributes' => [
                'name' => [
                    'asc' => ['firstname' => SORT_ASC, 'lastname' => SORT_ASC],
                    'desc' => ['firstname' => SORT_DESC, 'lastname' => SORT_DESC],
                    'default' => SORT_ASC,
                    'label' => 'Name',
                ],
                'sum',
                'discount',
                'created_at',
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
