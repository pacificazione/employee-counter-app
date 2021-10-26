<?php

namespace common\models\search;

use common\models\Employee2Department;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Employee;

/**
 * EmployeeSearch represents the model behind the search form of `common\models\Employee`.
 */
class EmployeeSearch extends Employee
{
    public $departmentId = null;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'age', 'departmentId', 'status', 'created_at', 'updated_at'], 'integer'],
            [['firstName', 'lastName', 'education', 'post', 'nationality','email'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = Employee::find()->alias('e');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'e.id' => $this->id,
            'e.age' => $this->age,
            'e.status' => $this->status,
            'e.created_at' => $this->created_at,
            'e.updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'e.firstName', $this->firstName])
            ->andFilterWhere(['like', 'e.lastName', $this->lastName])
            ->andFilterWhere(['like', 'e.education', $this->education])
            ->andFilterWhere(['like', 'e.post', $this->post])
            ->andFilterWhere(['like', 'e.nationality', $this->nationality])
            ->andFilterWhere(['like', 'e.email', $this->email]);

        return $dataProvider;
    }
}