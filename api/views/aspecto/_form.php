<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Aspecto */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="aspecto-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'aspecto_id')->textInput() ?>

    <?= $form->field($model, 'aspecto_nombre')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
