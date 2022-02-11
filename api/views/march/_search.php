<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\MachSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="mach-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'match_id') ?>

    <?= $form->field($model, 'match_id_usu1') ?>

    <?= $form->field($model, 'match_id_usu2') ?>

    <?= $form->field($model, 'match_estado_u1') ?>

    <?= $form->field($model, 'match_estado_u2') ?>

    <?php // echo $form->field($model, 'match_fecha') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
