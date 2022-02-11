<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PuntuacionesReviewSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Puntuaciones Reviews');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="puntuaciones-review-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Puntuaciones Review'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'puntuaciones_review_id',
            'puntuaciones_review_aspecto_id',
            'puntuaciones_review_puntuacion',
            'puntuaciones_review_review_id',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, puntuacionesReview $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'puntuaciones_review_id' => $model->puntuaciones_review_id]);
                 }
            ],
        ],
    ]); ?>


</div>
