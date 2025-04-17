<?php

use app\models\customer;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\customerSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Member';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customer-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Tambahkan Member', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'nama',
            [
                'attribute' => 'SS1',
                'format' => 'raw',
                'value' => function ($model) {
                        return $model->ss1 == 1
                            ? '<div style="text-align: center;"><i class="fas fa-check"></i></div>'
                            : '<div style="text-align: center;"><i class="fas fa-ban" style="color:#f31212;"></i></div>';
                    },
            ],
            [
                'attribute' => 'SS2',
                'format' => 'raw',
                'value' => function ($model) {
                        return $model->ss2 == 1
                            ? '<div style="text-align: center; "><i class="fas fa-check"></i></div>'
                            : '<div style="text-align: center;"><i class="fas fa-ban" style="color:#f31212;"></i></div>';
                    },
            ],
            [
                'attribute' => 'SS',
                'format' => 'raw',
                'value' => function ($model) {
                        return $model->ss3 == 1
                            ? '<div style="text-align: center;"><i class="fas fa-check"></i></div>'
                            : '<div style="text-align: center;"><i class="fas fa-ban" style="color:#f31212;"></i></div>';
                    },
            ],
            [
                'header' => 'MERAH',
                'value' => function ($model) {
                        return '-';
                    },
            ],
            [
                'attribute' => 'C1',
                'format' => 'raw',
                'value' => function ($model) {
                        return is_object($model->merah) && $model->merah->c1 == 1
                            ? '<div style="text-align: center;"><i class="fas fa-check"></i></div>'
                            : '<div style="text-align: center;"><i class="fas fa-ban" style="color:#f31212;"></i></div>';
                    },
            ],
            [
                'attribute' => 'C2',
                'format' => 'raw',
                'value' => function ($model) {
                        return is_object($model->merah) && $model->merah->c2 == 1
                            ? '<div style="text-align: center;"><i class="fas fa-check"></i></div>'
                            : '<div style="text-align: center;"><i class="fas fa-ban" style="color:#f31212;"></i></div>';
                    },
            ],

            [
                'attribute' => 'C3',
                'format' => 'raw',
                'value' => function ($model) {
                        return is_object($model->merah) && $model->merah->c3 == 1
                            ? '<div style="text-align: center;"><i class="fas fa-check"></i></div>'
                            : '<div style="text-align: center;"><i class="fas fa-ban" style="color:#f31212;"></i></div>';
                    },
            ],
            [
                'attribute' => 'C4',
                'format' => 'raw',
                'value' => function ($model) {
                        return is_object($model->merah) && $model->merah->c4 == 1
                            ? '<div style="text-align: center;"><i class="fas fa-check"></i></div>'
                            : '<div style="text-align: center;"><i class="fas fa-ban" style="color:#f31212;"></i></div>';
                    },
            ],
            
            [
                'header' => 'HITAM',
                'value' => function ($model) {
                        return '-';
                    },
            ],
            [
                'attribute' => 'C1',
                'format' => 'raw',
                'value' => function ($model) {
                        return is_object($model->hitam) && $model->hitam->c1 == 1
                            ? '<div style="text-align: center;"><i class="fas fa-check"></i></div>'
                            : '<div style="text-align: center;"><i class="fas fa-ban" style="color:#f31212;"></i></div>';
                    },
            ],
            [
                'attribute' => 'C2',
                'format' => 'raw',
                'value' => function ($model) {
                        return is_object($model->hitam) && $model->hitam->c2 == 1
                            ? '<div style="text-align: center;"><i class="fas fa-check"></i></div>'
                            : '<div style="text-align: center;"><i class="fas fa-ban" style="color:#f31212;"></i></div>';
                    },
            ],
            [
                'attribute' => 'C3',
                'format' => 'raw',
                'value' => function ($model) {
                        return is_object($model->hitam) && $model->hitam->c3 == 1
                            ? '<div style="text-align: center;"><i class="fas fa-check"></i></div>'
                            : '<div style="text-align: center;"><i class="fas fa-ban" style="color:#f31212;"></i></div>';
                    },
            ],
            [
                'attribute' => 'C4',
                'format' => 'raw',
                'value' => function ($model) {
                        return is_object($model->hitam) && $model->hitam->c4 == 1
                            ? '<div style="text-align: center;"><i class="fas fa-check"></i></div>'
                            : '<div style="text-align: center;"><i class="fas fa-ban" style="color:#f31212;"></i></div>';
                    },
            ],
            [
                'attribute' => 'Lapak',
                'format' => 'raw',
                'value' => function ($model) {

                        return '<div style="text-align: center;"><b>' . ($model->lapak ?? '-') . '</b></div>';
                    },
            ],


            // [
            //     'attribute' => 'C1',
            //     'format' => 'raw',
            //     'value' => function ($model) {
            //             return $model->c1 == 1
            //                 ? '<div style="text-align: center;"><i class="fas fa-check"></i></div>'
            //                 : '<div style="text-align: center;"><i class="fas fa-ban" style="color:#f31212;"></i></div>';
            //         },
            // ],
    
            // [
            //     'attribute' => 'C2',
            //     'format' => 'raw',
            //     'value' => function ($model) {
            //             return $model->c2 == 1
            //                 ? '<div style="text-align: center;"><i class="fas fa-check"></i></div>'
            //                 : '<div style="text-align: center;"><i class="fas fa-ban" style="color:#f31212;"></i></div>';
            //         },
            // ],
            // [
            //     'attribute' => 'C3',
            //     'format' => 'raw',
            //     'value' => function ($model) {
            //             return $model->c3 == 1
            //                 ? '<div style="text-align: center;"><i class="fas fa-check"></i></div>'
            //                 : '<div style="text-align: center;"><i class="fas fa-ban" style="color:#f31212;"></i></div>';
            //         },
            // ],
            // [
            //     'attribute' => 'C4',
            //     'format' => 'raw',
            //     'value' => function ($model) {
            //             return $model->c4 == 1
            //                 ? '<div style="text-align: center;"><i class="fas fa-check"></i></div>'
            //                 : '<div style="text-align: center;"><i class="fas fa-ban" style="color:#f31212;"></i></div>';
            //         },
            // ],
            [
                'class' => \yii\grid\ActionColumn::className(),
                'urlCreator' => function ($action, $model, $key, $index, $column) {
                        return \yii\helpers\Url::toRoute([$action, 'id' => $model->id]);
                    },
                'buttons' => [
                    'view' => function ($url, $model) {
                            // Ganti ikon mata (lihat)
                            return Html::a('<button class="btn actionBtn btn-primary"><i class="fa fa-eye"></i></button>', $url, [
                                'title' => 'View',
                                'aria-label' => 'View',
                            ]);
                        },
                    'update' => function ($url, $model) {
                            // Ganti ikon pensil (edit)
                            return Html::a('<button class="btn actionBtn btn-warning"><i class="fa fa-pencil-alt"></i></button>', $url, [
                                'title' => 'Update',
                                'aria-label' => 'Update',
                            ]);
                        },
                    'delete' => function ($url, $model) {
                            // Ganti ikon sampah (hapus)
                            return Html::a('<button class="btn actionBtn btn-danger"><i class="far fa-trash-alt"></i></button>', $url, [
                                'title' => 'Delete',
                                'aria-label' => 'Delete',
                                'data' => [
                                    'confirm' => 'Are you sure you want to delete this item?',
                                    'method' => 'post',
                                ],
                            ]);
                        },
                ],
            ],
        ],
    ]); ?>


</div>