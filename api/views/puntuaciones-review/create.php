<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\puntuacionesReview */

$this->title = Yii::t('app', 'Create Puntuaciones Review');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Puntuaciones Reviews'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="puntuaciones-review-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
