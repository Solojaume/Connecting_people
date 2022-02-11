<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Imagen */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="imagen-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'imagen_id')->textInput() ?>

    <?= $form->field($model, 'imagen_usuario_id')->textInput() ?>

    <?= $form->field($model, 'imagen_src')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'imagen_timestamp')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
