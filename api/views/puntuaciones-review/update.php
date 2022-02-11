<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\puntuacionesReview */

$this->title = Yii::t('app', 'Update Puntuaciones Review: {name}', [
    'name' => $model->puntuaciones_review_id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Puntuaciones Reviews'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->puntuaciones_review_id, 'url' => ['view', 'puntuaciones_review_id' => $model->puntuaciones_review_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="puntuaciones-review-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
