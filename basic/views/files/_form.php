<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\CommitsFiles */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="commits-files-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'commit_id')->textInput() ?>

    <?= $form->field($model, 'path')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'additions')->textInput() ?>

    <?= $form->field($model, 'deletions')->textInput() ?>

    <?= $form->field($model, 'changes')->textInput() ?>

    <?= $form->field($model, 'blob_url')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
