<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Mach */

$this->title = Yii::t('app', 'Update Mach: {name}', [
    'name' => $model->match_id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Maches'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->match_id, 'url' => ['view', 'match_id' => $model->match_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="mach-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
