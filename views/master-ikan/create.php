<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\MasterIkan $model */

$this->title = 'Create Master Ikan';
$this->params['breadcrumbs'][] = ['label' => 'Master Ikans', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="master-ikan-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
