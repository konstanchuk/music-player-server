<?php

namespace modules\music\models;

use Yii;
use yii\data\ActiveDataProvider;


class TrackSearch extends Track
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_merge([
            [['genre_id'], 'integer'],
            [['title', 'file'], 'string', 'max' => 255],
            [['created_at', 'updated_at'], 'safe'],
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
        $query = Track::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'title', $this->title]);
        return $dataProvider;
    }
}