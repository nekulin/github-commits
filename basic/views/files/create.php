<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\CommitsFiles */

$this->title = 'Create Commits Files';
$this->params['breadcrumbs'][] = ['label' => 'Commits Files', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="commits-files-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
