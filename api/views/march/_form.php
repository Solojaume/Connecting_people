<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Mach */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="mach-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'match_id')->textInput() ?>

    <?= $form->field($model, 'match_id_usu1')->textInput() ?>

    <?= $form->field($model, 'match_id_usu2')->textInput() ?>

    <?= $form->field($model, 'match_estado_u1')->textInput() ?>

    <?= $form->field($model, 'match_estado_u2')->textInput() ?>

    <?= $form->field($model, 'match_fecha')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
