<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\customer $model */

$this->title = 'Update Customer: ' . $model->nama;
$this->params['breadcrumbs'][] = ['label' => 'Customers', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="customer-update" style="background-color: #06202B; padding: 20px; ">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>