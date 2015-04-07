<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Competence;

/**
 * CompetenceSearch represents the model behind the search form about `app\models\Competence`.
 */
class CompetenceSearch extends Competence
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created', 'updated', 'name', 'description', 'code'], 'safe'],
            [['author_id', 'competence_id'], 'integer'],
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
        $query = Competence::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'created' => $this->created,
            'updated' => $this->updated,
            'author_id' => $this->author_id,
            'competence_id' => $this->competence_id,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'code', $this->code]);

        return $dataProvider;
    }
}
