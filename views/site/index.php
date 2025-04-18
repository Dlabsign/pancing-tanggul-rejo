<?php

use yii\helpers\Html;

/** @var yii\web\View $this */

$this->title = 'My Yii Application';
?>
<div
    style="width: 100%; height: 70vh; display: flex; flex-direction: column; justify-content: center; align-items: center;">

    <?= Html::a('Customer', ['customer/index'], ['class' => 'btn btn-primary mb-3', 'style' => 'width:100%; padding:1.2rem 0; font-size: 2rem; font-weight:bold;']) ?>
    <?= Html::a('Lomba', ['lomba/index'], ['class' => 'btn btn-warning mb-3', 'style' => 'width:100%; padding:1.2rem 0; font-size: 2rem; font-weight:bold;']) ?>
    <?= Html::a('Undian', ['undian/index'], ['class' => 'btn btn-success', 'style' => 'width:100%; padding:1.2rem 0; font-size: 2rem; font-weight:bold;']) ?>
</div>