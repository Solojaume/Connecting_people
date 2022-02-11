<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\puntuacionesReview */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="puntuaciones-review-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'puntuaciones_review_id')->textInput() ?>

    <?= $form->field($model, 'puntuaciones_review_aspecto_id')->textInput() ?>

    <?= $form->field($model, 'puntuaciones_review_puntuacion')->textInput() ?>

    <?= $form->field($model, 'puntuaciones_review_review_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
