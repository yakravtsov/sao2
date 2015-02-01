<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Scale;

/**
 * ScaleSearch represents the model behind the search form about `app\models\Scale`.
 */
class ScaleSearch extends Scale
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created', 'updated', 'name'], 'safe'],
            [['author_id', 'scale_id', 'test_id', 'default'], 'integer'],
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
        $query = Scale::find();

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
            'scale_id' => $this->scale_id,
            'test_id' => $this->test_id,
            'default' => $this->default,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}
