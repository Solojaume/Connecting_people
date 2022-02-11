<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ReporteSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Reportes');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="reporte-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Reporte'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'reporte_id',
            'reporte_motivo_id',
            'reporte_usuario_id',
            'reporte_match_id',
            'reporte_resolucion',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Reporte $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'reporte_id' => $model->reporte_id]);
                 }
            ],
        ],
    ]); ?>


</div>
