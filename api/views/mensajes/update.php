<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Mensajes */

$this->title = Yii::t('app', 'Update Mensajes: {name}', [
    'name' => $model->mensajes_id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Mensajes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->mensajes_id, 'url' => ['view', 'mensajes_id' => $model->mensajes_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="mensajes-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
