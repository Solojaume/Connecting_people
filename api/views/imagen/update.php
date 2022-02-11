<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Imagen */

$this->title = Yii::t('app', 'Update Imagen: {name}', [
    'name' => $model->imagen_id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Imagens'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->imagen_id, 'url' => ['view', 'imagen_id' => $model->imagen_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="imagen-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
