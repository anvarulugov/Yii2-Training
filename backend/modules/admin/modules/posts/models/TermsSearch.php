<?php

namespace backend\modules\admin\modules\posts\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\admin\modules\posts\models\Terms;

/**
 * TermsSearch represents the model behind the search form about `backend\modules\admin\modules\posts\models\Terms`.
 */
class TermsSearch extends Terms
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['term_id', 'term_parent', 'term_frequency'], 'integer'],
            [['term_name', 'term_title', 'term_description', 'term_language', 'term_type'], 'safe'],
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
        $query = Terms::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'term_id' => $this->term_id,
            'term_parent' => $this->term_parent,
            'term_frequency' => $this->term_frequency,
        ]);

        $query->andFilterWhere(['like', 'term_name', $this->term_name])
            ->andFilterWhere(['like', 'term_title', $this->term_title])
            ->andFilterWhere(['like', 'term_description', $this->term_description])
            ->andFilterWhere(['like', 'term_language', $this->term_language])
            ->andFilterWhere(['like', 'term_type', $this->term_type]);

        return $dataProvider;
    }
}
