<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Aspecto */

$this->title = Yii::t('app', 'Update Aspecto: {name}', [
    'name' => $model->aspecto_id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Aspectos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->aspecto_id, 'url' => ['view', 'aspecto_id' => $model->aspecto_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="aspecto-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
