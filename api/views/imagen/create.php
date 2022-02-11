<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Imagen */

$this->title = Yii::t('app', 'Create Imagen');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Imagens'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="imagen-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
