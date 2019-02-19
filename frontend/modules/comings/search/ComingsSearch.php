<?php

namespace frontend\modules\comings\search;

use common\repositories\PhonesRepository;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\repositories\ComingsRepository;
use yii\data\ArrayDataProvider;
use yii\data\Sort;
use yii\db\Expression;
use yii\db\Query;

/**
 * ComingsSearch represents the model behind the search form about `common\repositories\ComingsRepository`.
 */
class ComingsSearch extends ComingsRepository
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
            [['id', 'source_id', 'type_id', 'status', 'constructions', 'user_id', 'expected_action_id', 'sex', 'created_at', 'updated_at'], 'integer'],
            [['firstname', 'lastname', 'middlename', 'birthday', 'phone', 'expected_order_date', 'expected_action_date',
                'comment_user', 'comment_client', 'name', 'dateFrom', 'dateTo', 'dateRange'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'name' => 'Имя'
        ]);
    }

    public function init()
    {
        parent::init();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ArrayDataProvider
     */
    public function search($params)
    {
        $query = (new Query())
            ->select(new Expression('c.*, group_concat(p.phone) phones, 
                d1.name source, 
                concat(c.`firstname`, \' \', c.lastname, \' \', c.middlename) name'))
            ->from('{{%comings}} c')
            ->leftJoin('{{%phones}} p', 'p.obj_id = c.id AND p.type = ' . PhonesRepository::TYPE_COMING)
            ->leftJoin('{{%directories}} d1', 'd1.id = c.source_id')
            ->leftJoin('{{%directories}} d2', 'd2.id = c.expected_action_id')
            ->where(['c.user_id' => Yii::$app->user->id])
            ->groupBy('c.id');

        $this->load($params);

        if (!$this->dateFrom) $this->dateFrom = '2017-01-01';
        if (!$this->dateTo) $this->dateTo = date('Y-m-d', strtotime('+1 day'));

        $query->andFilterWhere([
            'id' => $this->id,
            'source_id' => $this->source_id,
            'type_id' => $this->type_id,
            'birthday' => $this->birthday,
            'status' => $this->status,
            'constructions' => $this->constructions,
            'expected_order_date' => $this->expected_order_date,
            'user_id' => $this->user_id,
            'expected_action_id' => $this->expected_action_id,
            'expected_action_date' => $this->expected_action_date,
            'sex' => $this->sex,
        ]);

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
            ->andFilterWhere(['<=', 'c.created_at', strtotime($this->dateTo)])
            ->andFilterWhere(['like', 'p.phone', preg_replace('/\D/', '', $this->phone)]);

        $sort = new Sort([
            'defaultOrder' => ['created_at' => SORT_DESC],
            'attributes' => [
                'source_id',
                'created_at',
                'name' => [
                    'asc' => ['firstname' => SORT_ASC, 'lastname' => SORT_ASC],
                    'desc' => ['firstname' => SORT_DESC, 'lastname' => SORT_DESC],
                    'default' => SORT_DESC,
                    'label' => 'Name',
                ],
            ],
        ]);

        $dataProvider = new ArrayDataProvider([
            'allModels' => $query->all(),
            'sort' => $sort,
            'key' => 'id',
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        return $dataProvider;
    }
}
