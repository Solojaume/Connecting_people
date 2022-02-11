<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ReporteSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="reporte-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'reporte_id') ?>

    <?= $form->field($model, 'reporte_motivo_id') ?>

    <?= $form->field($model, 'reporte_usuario_id') ?>

    <?= $form->field($model, 'reporte_match_id') ?>

    <?= $form->field($model, 'reporte_resolucion') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
