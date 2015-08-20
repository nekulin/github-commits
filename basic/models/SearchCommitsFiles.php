<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\CommitsFiles;
use yii\db\Query;

/**
 * SearchCommitsFiles represents the model behind the search form about `app\models\CommitsFiles`.
 */
class SearchCommitsFiles extends CommitsFiles
{

    public $date_from;
    public $date_to;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'commit_id', 'additions', 'deletions', 'changes'], 'integer'],
            [['filename', 'status', 'blob_url', 'date_from', 'date_to'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'date_from' => 'Дата создания коммита от',
            'date_to'   => 'Дата создания коммита до',
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
        $query = CommitsFiles::find();
        $query->from('commits_files cm');
        $query->groupBy('filename');
        $query->select(['filename', 'date_add', 'status', 'COUNT(*) as count']);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 2,
            ],
        ]);

        $this->load($params);

        $dataProvider->setSort([
            'attributes' => [
                'filename',
                'count' => [
                    'asc' => ['count' => SORT_ASC],
                    'desc' => ['count' => SORT_DESC],
                    'default' => SORT_DESC
                ],
            ]
        ]);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'commit_id' => $this->commit_id,
            'additions' => $this->additions,
            'deletions' => $this->deletions,
            'changes' => $this->changes,
        ]);
        $query->andFilterWhere(['>=', 'date_add', $this->date_from])
            ->andFilterWhere(['<=', 'date_add', $this->date_to]);

        $query->andFilterWhere(['like', 'filename', $this->filename])
            ->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'blob_url', $this->blob_url]);

        return $dataProvider;
    }
}
