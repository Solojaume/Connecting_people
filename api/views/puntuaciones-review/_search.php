<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PuntuacionesReviewSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="puntuaciones-review-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'puntuaciones_review_id') ?>

    <?= $form->field($model, 'puntuaciones_review_aspecto_id') ?>

    <?= $form->field($model, 'puntuaciones_review_puntuacion') ?>

    <?= $form->field($model, 'puntuaciones_review_review_id') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
