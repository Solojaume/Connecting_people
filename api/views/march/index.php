<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\MachSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Maches');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mach-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Mach'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'match_id',
            'match_id_usu1',
            'match_id_usu2',
            'match_estado_u1',
            'match_estado_u2',
            //'match_fecha',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Mach $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'match_id' => $model->match_id]);
                 }
            ],
        ],
    ]); ?>


</div>
