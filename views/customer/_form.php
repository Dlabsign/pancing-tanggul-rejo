<?php

use app\models\MasterIkan;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\customer $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="customer-form">

    <?php $form = ActiveForm::begin(); ?>
    <hr>

    <div class="row">
        <div class="col-lg-6">
            <h3>Nama</h3>
            <?= $form->field($model, 'nama')->textInput(['maxlength' => true, 'style' => 'font-weight: bold; font-size: 2rem; height: 3rem;'])->label(false) ?>
        </div>
        <div class="col-lg-6">
        <h3>Lapak</h3>
        <?= $form->field($model, 'lapak')->dropDownList(['1' => '1', '2' => '2'], ['prompt' => 'Jumlah Lapak', 'style' => 'font-weight: bold; font-size: 1.2rem; height: 3rem;'])->label(false) ?>
        </div>
    </div>
    <div class="card mt-3 p-4">
        <div class="row">
            <div class="col-lg-4">
                <div class="row">
                    <div class="col-lg-4" style="display: flex; align-items: center;">
                        <?= $form->field($model, 'ikan_id_merah')->checkbox([
                            'class' => 'form-check-input',
                            'style' => 'transform: scale(2); background-color:red;', // Membesarkan ukuran checkbox
                            'value' => 1,
                            'uncheck' => 0,
                            'label' => false,
                            'id' => 'ikan_id_merah_checkbox'
                        ]) ?>
                        <h4 style="margin-left: 1rem;">Merah</h4>
                    </div>
                    <div class="col">
                        <div class="col-lg-4" style="display: flex; align-items: center;">
                            <?= $form->field($model, 'c1_merah')->checkbox([
                                'class' => 'form-check-input c-merah-checkbox',
                                'style' => 'transform: scale(2); background-color:red;', // Membesarkan ukuran checkbox
                                'value' => 1,
                                'label' => false,

                                'uncheck' => 0,
                                'id' => 'c1_merah_checkbox'
                            ]) ?>
                            <h5 style="margin-left: 1.2rem;">C1</h5>
                        </div>
                        <div class="col-lg-4" style="display: flex; align-items: center;">
                            <?= $form->field($model, 'c2_merah')->checkbox([
                                'class' => 'form-check-input c-merah-checkbox',
                                'style' => 'transform: scale(2); background-color:red;', // Membesarkan ukuran checkbox
                                'value' => 1,
                                'label' => false,

                                'uncheck' => 0,
                                'id' => 'c2_merah_checkbox'
                            ]) ?>
                            <h5 style="margin-left: 1.2rem;">C2</h5>

                        </div>

                        <div class="col-lg-4" style="display: flex; align-items: center;">
                            <?= $form->field($model, 'c3_merah')->checkbox([
                                'class' => 'form-check-input c-merah-checkbox',
                                'style' => 'transform: scale(2); background-color:red;', // Membesarkan ukuran checkbox
                                'value' => 1,
                                'label' => false,

                                'uncheck' => 0,
                                'id' => 'c3_merah_checkbox'
                            ]) ?>
                            <h5 style="margin-left: 1.2rem;">C3</h5>

                        </div>
                        <div class="col-lg-4" style="display: flex; align-items: center;">
                            <?= $form->field($model, 'c4_merah')->checkbox([
                                'class' => 'form-check-input c-merah-checkbox',
                                'style' => 'transform: scale(2); background-color:red;', // Membesarkan ukuran checkbox
                                'label' => false,
                                'value' => 1,
                                'uncheck' => 0,

                                'id' => 'c4_merah_checkbox'
                            ]) ?>
                            <h5 style="margin-left: 1.2rem;">C4</h5>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="row">
                    <div class="col-lg-4" style="display: flex; align-items: center;">
                        <?= $form->field($model, 'ikan_id_hitam')->checkbox([
                            'class' => 'form-check-input',
                            'style' => 'transform: scale(2); background-color:black;', // Membesarkan ukuran checkbox
                            'value' => 2,
                            'uncheck' => 0,
                            'label' => false,
                            'id' => 'ikan_id_hitam_checkbox'
                        ]) ?>
                        <h4 style="margin-left: 1rem;">Hitam</h4>

                    </div>
                    <div class="col">
                        <div class="col-lg-4" style="display: flex; align-items: center;">
                            <?= $form->field($model, 'c1_hitam')->checkbox([
                                'class' => 'form-check-input c-hitam-checkbox',
                                'style' => 'transform: scale(2); background-color:black;', // Membesarkan ukuran checkbox
                                'value' => 1,
                                'label' => false,

                                'uncheck' => 0,
                                'id' => 'c1_hitam_checkbox'
                            ]) ?>
                            <h5 style="margin-left: 1.2rem;">C1</h5>
                        </div>
                        <div class="col-lg-4" style="display: flex; align-items: center;">
                            <?= $form->field($model, 'c2_hitam')->checkbox([
                                'class' => 'form-check-input c-hitam-checkbox',
                                'style' => 'transform: scale(2); background-color:black;', // Membesarkan ukuran checkbox
                                'value' => 1,
                                'label' => false,

                                'uncheck' => 0,
                                'id' => 'c2_hitam_checkbox'
                            ]) ?>
                            <h5 style="margin-left: 1.2rem;">C2</h5>

                        </div>

                        <div class="col-lg-4" style="display: flex; align-items: center;">
                            <?= $form->field($model, 'c3_hitam')->checkbox([
                                'class' => 'form-check-input c-hitam-checkbox',
                                'style' => 'transform: scale(2); background-color:black;', // Membesarkan ukuran checkbox
                                'value' => 1,
                                'label' => false,
                                'uncheck' => 0,
                                'id' => 'c3_hitam_checkbox'
                            ]) ?>
                            <h5 style="margin-left: 1.2rem;">C3</h5>

                        </div>
                        <div class="col-lg-4" style="display: flex; align-items: center;">
                            <?= $form->field($model, 'c4_hitam')->checkbox([
                                'class' => 'form-check-input c-hitam-checkbox',
                                'style' => 'transform: scale(2); background-color:black;', // Membesarkan ukuran checkbox
                                'label' => false,
                                'value' => 1,
                                'uncheck' => 0,
                                'id' => 'c4_hitam_checkbox'
                            ]) ?>
                            <h5 style="margin-left: 1.2rem;">C4</h5>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="col">
                    <div class="col-lg-4" style="display: flex; align-items: center;">
                        <?= $form->field($model, 'ss1')->checkbox([
                            'class' => 'form-check-input',
                            'style' => 'transform: scale(2); background-color:orange;', // Membesarkan ukuran checkbox
                            'value' => 1,
                            'uncheck' => 0,
                            'label' => false,
                        ]) ?>
                        <h4 style="margin-left: 1rem;">SS1</h4>
                    </div>
                    <div class="col-lg-4" style="display: flex; align-items: center;">
                        <?= $form->field($model, 'ss2')->checkbox([
                            'class' => 'form-check-input',
                            'style' => 'transform: scale(2); background-color:orange;', // Membesarkan ukuran checkbox
                            'value' => 1,
                            'uncheck' => 0,
                            'label' => false,
                        ]) ?>
                        <h4 style="margin-left: 1rem;">SS2</h4>
                    </div>
                    <div class="col-lg-4" style="display: flex; align-items: center;">
                        <?= $form->field($model, 'ss3')->checkbox([
                            'class' => 'form-check-input',
                            'style' => 'transform: scale(2); background-color:orange;', // Membesarkan ukuran checkbox
                            'value' => 1,
                            'uncheck' => 0,
                            'label' => false,
                        ]) ?>
                        <h4 style="margin-left: 1rem;">SS3</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group row mt-4">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>

<?php
$this->registerJs(
    <<<JS
    $(document).ready(function() {
        function toggleMerahCheckboxes() {
            var isMerahChecked = $('#ikan_id_merah_checkbox').prop('checked');
            $('.c-merah-checkbox').prop('disabled', !isMerahChecked);
        }

        function toggleHitamCheckboxes() {
            var isHitamChecked = $('#ikan_id_hitam_checkbox').prop('checked');
            $('.c-hitam-checkbox').prop('disabled', !isHitamChecked);
        }

        // Panggil saat halaman pertama kali dimuat
        toggleMerahCheckboxes();
        toggleHitamCheckboxes();

        // Panggil saat checkbox 'Merah' diubah
        $('#ikan_id_merah_checkbox').change(function() {
            toggleMerahCheckboxes();
        });

        // Panggil saat checkbox 'Hitam' diubah
        $('#ikan_id_hitam_checkbox').change(function() {
            toggleHitamCheckboxes();
        });
    });
JS
);
?>