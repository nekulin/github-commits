<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SearchCommitsFiles */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Коммиты';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="commits-files-index">

    <h1><?= Html::encode($this->title) ?> <a target="_blank" href="https://github.com/KnpLabs/php-github-api">https://github.com/KnpLabs/php-github-api</a></h1>
    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>

    <hr>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'filename',
            [
                'attribute' => 'count',
            ],
            [
                'header' => 'Авторы',
                'format' => 'html',
                'value'  => function(app\models\CommitsFiles $data){
                        $res = '';
                        foreach ($data->getUsersCountCommits() as $user) {
                            $res .= '<div>' . Html::encode($user['user_name']) . ' (' . $user['count'] . ')</div>';
                        }
                        return $res;
                    },
            ],
        ],
    ]); ?>

</div>
