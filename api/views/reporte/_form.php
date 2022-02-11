<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Reporte */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="reporte-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'reporte_id')->textInput() ?>

    <?= $form->field($model, 'reporte_motivo_id')->textInput() ?>

    <?= $form->field($model, 'reporte_usuario_id')->textInput() ?>

    <?= $form->field($model, 'reporte_match_id')->textInput() ?>

    <?= $form->field($model, 'reporte_resolucion')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
