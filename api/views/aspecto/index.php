<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii
/* @var $this yii\web\View */
/* @var $searchModel app\models\AspectoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Aspectos');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="aspecto-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Aspecto'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'aspecto_id',
            'aspecto_nombre',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action,  app\models\Aspecto $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'aspecto_id' => $model->aspecto_id]);
                 }
            ],
        ],
    ]); ?>


</div>
