<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Project;

/**
 * ProjectsSearch represents the model behind the search form about `app\models\Project`.
 */
class ProjectsSearch extends Project
{
    public $companies;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['project_id', 'author_id', 'report_type', 'settings'], 'integer'],
            [['created', 'updated', 'date_start', 'date_end', 'description','name','companies'], 'safe'],
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

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Project::find();

        $query->joinWith(['companies']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['companies'] = [
            // The tables are the ones our relation are configured to
            // in my case they are prefixed with "tbl_"
            'asc' => ['company.name' => SORT_ASC],
            'desc' => ['company.name' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'project_id' => $this->project_id,
            'created' => $this->created,
            'updated' => $this->updated,
            'author_id' => $this->author_id,
            'date_start' => $this->date_start,
            'date_end' => $this->date_end,
            'report_type' => $this->report_type,
            'settings' => $this->settings,
            //'companies' => $this->companies
        ]);

        $query->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'company.name', $this->companies]);

        return $dataProvider;
    }
}
