<?php

namespace app\models;

use Yii;
use yii\db\Query;

/**
 * This is the model class for table "commits_files".
 *
 * @property integer $id
 * @property integer $commit_id
 * @property integer $sha
 * @property string $filename
 * @property string $status
 * @property integer $additions
 * @property integer $deletions
 * @property integer $changes
 * @property string $blob_url
 * @property string $date_add
 */
class CommitsFiles extends \yii\db\ActiveRecord
{
    public $count;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'commits_files';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['commit_id', 'sha', 'filename', 'status', 'additions', 'deletions', 'changes', 'blob_url', 'date_add'], 'required'],
            [['commit_id', 'additions', 'deletions', 'changes'], 'integer'],
            [['filename', 'blob_url'], 'string', 'max' => 255],
            [['status'], 'string', 'max' => 30],
            [['sha'], 'string', 'max' => 128],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sha' => 'Sha',
            'commit_id' => 'Коммит',
            'filename' => 'Название файла',
            'status' => 'Статус',
            'additions' => 'Добавлено строк',
            'deletions' => 'Удалено строк',
            'changes' => 'Изменено строк',
            'blob_url' => 'Ссылка',
            'date_add' => 'Дата',
            'count' => 'Количество изменений',
        ];
    }

    /**
     * @return array
     */
    public function getUsersCountCommits()
    {
        $query = new Query();
        $res = $query->select('user_name, COUNT(*) as count')
            ->from('commits')
            ->where('id IN (SELECT commit_id FROM commits_files cm WHERE cm.filename=:filename GROUP BY commit_id)')
            ->groupBy('user_name')
            ->orderBy('count DESC')
            ->params(['filename' => $this->filename])
            ->all();
        return $res;
    }
}
