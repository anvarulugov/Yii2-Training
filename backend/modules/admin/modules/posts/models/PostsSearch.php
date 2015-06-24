<?php

namespace backend\modules\admin\modules\posts\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\admin\modules\posts\models\Posts;

/**
 * PostsSearch represents the model behind the search form about `backend\modules\admin\modules\posts\models\Posts`.
 */
class PostsSearch extends Posts
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID', 'post_parent', 'post_author', 'comment_count'], 'integer'],
            [['post_name', 'post_date', 'post_title', 'post_content', 'post_password', 'post_modified', 'post_status', 'post_type', 'comment_status', 'post_terms'], 'safe'],
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
        $query = Posts::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['ID' => SORT_DESC]],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        //$query->joinWith('terms');

        $query->andFilterWhere([
            'ID' => $this->ID,
            'post_parent' => $this->post_parent,
            'post_author' => $this->post_author,
            'post_date' => $this->post_date,
            'post_modified' => $this->post_modified,
            'comment_count' => $this->comment_count,
        ]);

        $query->andFilterWhere(['like', 'post_name', $this->post_name])
            ->andFilterWhere(['like', 'post_title', $this->post_title])
            ->andFilterWhere(['like', 'terms.term_id', $this->post_terms])
            ->andFilterWhere(['like', 'post_content', $this->post_content])
            ->andFilterWhere(['like', 'post_password', $this->post_password])
            ->andFilterWhere(['like', 'post_status', $this->post_status])
            ->andFilterWhere(['like', 'post_type', $this->post_type])
            ->andFilterWhere(['like', 'comment_status', $this->comment_status]);

        return $dataProvider;
    }
}
