<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Mach */

$this->title = Yii::t('app', 'Create Mach');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Maches'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mach-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
