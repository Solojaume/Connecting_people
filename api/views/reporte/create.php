<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Reporte */

$this->title = Yii::t('app', 'Create Reporte');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Reportes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="reporte-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
