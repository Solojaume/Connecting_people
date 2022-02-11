<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ImagenSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Imagen');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="imagen-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Imagen'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'imagen_id',
            'imagen_usuario_id',
            'imagen_src',
            'imagen_timestamp',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Imagen $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'imagen_id' => $model->imagen_id]);
                 }
            ],
        ],
    ]); ?>


</div>
