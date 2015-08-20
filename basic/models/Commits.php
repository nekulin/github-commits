<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "commits".
 *
 * @property integer $id
 * @property string $sha
 * @property string $user_name
 * @property string $date_commit
 * @property string $message
 */
class Commits extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'commits';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sha', 'user_name', 'date_commit'], 'required'],
            [['date_commit'], 'safe'],
            [['message'], 'string'],
            [['sha'], 'string', 'max' => 128],
            [['user_name'], 'string', 'max' => 200]
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
            'user_name' => 'User Name',
            'date_commit' => 'Date Commit',
            'message' => 'Message',
        ];
    }
}
