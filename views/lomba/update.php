<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Lomba $model */

$this->title = 'Update Lomba: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Lombas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="lomba-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
