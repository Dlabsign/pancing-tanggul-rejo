<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\customer $model */

$this->title = $model->nama;
$this->params['breadcrumbs'][] = ['label' => 'Customers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="customer-view">

    <h1>Member : <b><?= Html::encode($this->title) ?></b></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Apakah Anda Yakin ingin menghapus file ini?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <!-- <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'id',
            'nama',
        ],
    ]) ?> -->
    <hr>
    <div class="row">
        <div class="row" style="display: flex; justify-content: space-between;">
            <h3 class="col-md-3" style="text-align: center;">SS</h3>
            <div class="col-md-3 text-center">
                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        [
                            'attribute' => 'ss1',
                            'format' => 'raw',
                            'value' => function ($model) {
                                            return $model->ss1 == 1
                                                ? '<i class="fas fa-check" style=" padding: 5px; color: #fff; background-color:#28a745;"></i>'

                                                : '<i class="fas fa-ban" style="color:#f31212; font-size: 1.4rem;"></i>';
                                        },
                        ],
                    ],
                ]) ?>
            </div>
            <div class="col-md-3 text-center">
                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        [
                            'attribute' => 'ss2',
                            'format' => 'raw',
                            'value' => function ($model) {
                                return $model->ss2 == 1
                                    ? '<i class="fas fa-check" style=" padding: 5px; color: #fff; background-color:#28a745;"></i>'
                                    : '<i class="fas fa-ban" style="color:#f31212; font-size: 1.4rem;"></i>';
                            },
                        ],
                    ],
                ]) ?>
            </div>
            <div class="col-md-3 text-center">
                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        [
                            'attribute' => 'ss3',
                            'format' => 'raw',
                            'value' => function ($model) {
                                return $model->ss2 == 1
                                    ? '<i class="fas fa-check" style=" padding: 5px; color: #fff; background-color:#28a745;"></i>'
                                    : '<i class="fas fa-ban" style="color:#f31212; font-size: 1.4rem;"></i>';
                            },
                        ],
                    ],
                ]) ?>
            </div>

            <hr>
            <div style="margin-top: 1.2rem;">
                <div class="row" style="display: flex; justify-content: space-between;">
                    <h3 class="col-md-3" style="text-align: center;">Merah</h3>
                    <div class="col-md-2 text-center">
                        <?= DetailView::widget([
                            'model' => $model,
                            'attributes' => [
                                [
                                    'attribute' => 'c1',
                                    'format' => 'raw',
                                    'value' => function ($model) {
                                                return is_object($model->merah) && $model->merah->c1 == 1
                                                    ? '<i class="fas fa-check" style=" padding: 5px; color: #fff; background-color:#28a745;"></i>'

                                                    : '<i class="fas fa-ban" style="color:#f31212; font-size: 1.4rem;"></i>';
                                            },
                                ],
                            ],
                        ]) ?>
                    </div>
                    <div class="col-md-2 text-center">
                        <?= DetailView::widget([
                            'model' => $model,
                            'attributes' => [
                                [
                                    'attribute' => 'c2',
                                    'format' => 'raw',
                                    'value' => function ($model) {
                                        return is_object($model->merah) && $model->merah->c2 == 1
                                            ? '<i class="fas fa-check" style=" padding: 5px; color: #fff; background-color:#28a745;"></i>'

                                            : '<i class="fas fa-ban" style="color:#f31212; font-size: 1.4rem;"></i>';
                                    },
                                ],
                            ],
                        ]) ?>
                    </div>
                    <div class="col-md-2 text-center">
                        <?= DetailView::widget([
                            'model' => $model,
                            'attributes' => [
                                [
                                    'attribute' => 'c3',
                                    'format' => 'raw',
                                    'value' => function ($model) {
                                        return is_object($model->merah) && $model->merah->c3 == 1
                                            ? '<i class="fas fa-check" style=" padding: 5px; color: #fff; background-color:#28a745;"></i>'

                                            : '<i class="fas fa-ban" style="color:#f31212; font-size: 1.4rem;"></i>';
                                    },
                                ],
                            ],
                        ]) ?>
                    </div>
                    <div class="col-md-2 text-center">
                        <?= DetailView::widget([
                            'model' => $model,
                            'attributes' => [
                                [
                                    'attribute' => 'c4',
                                    'format' => 'raw',
                                    'value' => function ($model) {
                                        return is_object($model->merah) && $model->merah->c4 == 1
                                            ? '<i class="fas fa-check" style=" padding: 5px; color: #fff; background-color:#28a745;"></i>'

                                            : '<i class="fas fa-ban" style="color:#f31212; font-size: 1.4rem;"></i>';
                                    },
                                ],
                            ],
                        ]) ?>
                    </div>
                </div>

                <hr>
                <div style="margin-top: 1.2rem;">
                    <div class="row" style="display: flex; justify-content: space-between;">
                        <h3 class="col-md-3" style="text-align: center;">Hitam</h3>
                        <div class="col-md-2 text-center">
                            <?= DetailView::widget([
                                'model' => $model,
                                'attributes' => [
                                    [
                                        'attribute' => 'c1',
                                        'format' => 'raw',
                                        'value' => function ($model) {
                                                return is_object($model->hitam) && $model->hitam->c1 == 1
                                                    ? '<i class="fas fa-check" style=" padding: 5px; color: #fff; background-color:#28a745;"></i>'

                                                    : '<i class="fas fa-ban" style="color:#f31212; font-size: 1.4rem;"></i>';
                                            },
                                    ],
                                ],
                            ]) ?>
                        </div>
                        <div class="col-md-2 text-center">
                            <?= DetailView::widget([
                                'model' => $model,
                                'attributes' => [
                                    [
                                        'attribute' => 'c2',
                                        'format' => 'raw',
                                        'value' => function ($model) {
                                            return is_object($model->hitam) && $model->hitam->c2 == 1
                                                ? '<i class="fas fa-check" style=" padding: 5px; color: #fff; background-color:#28a745;"></i>'

                                                : '<i class="fas fa-ban" style="color:#f31212; font-size: 1.4rem;"></i>';
                                        },
                                    ],
                                ],
                            ]) ?>
                        </div>
                        <div class="col-md-2 text-center">
                            <?= DetailView::widget([
                                'model' => $model,
                                'attributes' => [
                                    [
                                        'attribute' => 'c3',
                                        'format' => 'raw',
                                        'value' => function ($model) {
                                            return is_object($model->hitam) && $model->hitam->c3 == 1
                                                ? '<i class="fas fa-check" style=" padding: 5px; color: #fff; background-color:#28a745;"></i>'

                                                : '<i class="fas fa-ban" style="color:#f31212; font-size: 1.4rem;"></i>';
                                        },
                                    ],
                                ],
                            ]) ?>
                        </div>
                        <div class="col-md-2 text-center">
                            <?= DetailView::widget([
                                'model' => $model,
                                'attributes' => [
                                    [
                                        'attribute' => 'c4',
                                        'format' => 'raw',
                                        'value' => function ($model) {
                                            return is_object($model->hitam) && $model->hitam->c4 == 1
                                                ? '<i class="fas fa-check" style=" padding: 5px; color: #fff; background-color:#28a745;"></i>'

                                                : '<i class="fas fa-ban" style="color:#f31212; font-size: 1.4rem;"></i>';
                                        },
                                    ],
                                ],
                            ]) ?>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>