<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\puntuacionesReview */

$this->title = $model->puntuaciones_review_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Puntuaciones Reviews'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="puntuaciones-review-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'puntuaciones_review_id' => $model->puntuaciones_review_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'puntuaciones_review_id' => $model->puntuaciones_review_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'puntuaciones_review_id',
            'puntuaciones_review_aspecto_id',
            'puntuaciones_review_puntuacion',
            'puntuaciones_review_review_id',
        ],
    ]) ?>

</div>
