<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\customer $model */

$this->title = 'Tambahkan Member';
$this->params['breadcrumbs'][] = ['label' => 'Customers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customer-create" style="background-color: #06202B; padding: 20px; ">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>