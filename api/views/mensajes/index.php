<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\MensajesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Mensajes');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mensajes-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Mensajes'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'mensajes_id',
            'mensajes_match_id',
            'mensaje_contenido',
            'timestamp',
            'entregado',
            //'mensajes_usuario_id',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Mensajes $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'mensajes_id' => $model->mensajes_id]);
                 }
            ],
        ],
    ]); ?>


</div>
