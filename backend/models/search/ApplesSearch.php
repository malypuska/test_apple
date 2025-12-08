<?php

namespace app\models\search;

use yii\data\ActiveDataProvider;
use yii\base\Model;

/**
 * SingleSpamTasksSearch represents the model behind the search form of `app\models\SingleSpamTasks`.
 */
class ApplesSearch  extends \common\models\Apples
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return parent::rules();
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
        $query = self::find();

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
        
        return $dataProvider;
    }
}
