<?php

use app\models\Lomba;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\LombaSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var app\models\Lomba $model */

$this->title = 'Daftar Lomba';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lomba-index">

    <h1><?= Html::encode($this->title) ?></h1>


    <div class="lomba-form" style="margin-bottom: 30px;">
        <!-- <h4>Tambah Tanggal Lomba</h4> -->

        <?php $form = ActiveForm::begin([
            'action' => ['index'],
            'method' => 'post',
        ]); ?>

        <!-- <?= $form->field($model, 'tanggal')->textInput(['type' => 'date']) ?>

        <div class="form-group">
            <?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
        </div> -->

        <?php ActiveForm::end(); ?>
    </div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'tanggal',
            // [
            //     'class' => ActionColumn::className(),
            //     'urlCreator' => function ($action, Lomba $model, $key, $index, $column) {
            //     return Url::toRoute([$action, 'id' => $model->id]);
            // }
            // ],
    
            [
                'label' => 'Halaman Undian',
                'format' => 'raw',
                'value' => function ($model) {
                return Html::a('Masuk ke Halaman Undian', ['undian/index', 'id' => $model->id, 'tanggal' => $model->tanggal], ['class' => 'btn btn-warning']);
            },
            ],
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, $model, $key, $index, $column) {
                return Url::toRoute([$action, 'id' => $model->id]);
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