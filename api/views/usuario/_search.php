<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\UsuarioSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="usuario-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'email') ?>

    <?= $form->field($model, 'password') ?>

    <?= $form->field($model, 'nombre') ?>

    <?= $form->field($model, 'rol') ?>

    <?php // echo $form->field($model, 'timestamp_nacimiento') ?>

    <?php // echo $form->field($model, 'token') ?>

    <?php // echo $form->field($model, 'cad_token') ?>

    <?php // echo $form->field($model, 'token_recuperar_pass') ?>

    <?php // echo $form->field($model, 'cad_token_recuperar_pass') ?>

    <?php // echo $form->field($model, 'activo') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
