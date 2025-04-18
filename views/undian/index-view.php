<?php
use app\models\Undian;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Customer;
use app\models\Lomba;

// $customers = Customer::find()->all();
$customers = $dataProvider->getModels();

?>

<div class="undian-index">
    <?php $form = ActiveForm::begin([
        'method' => 'get',
        'action' => ['index'], // pastikan diarahkan ke action yang sesuai
    ]); ?>
    <h1>Undian (No. Lapak)</h1>
    <hr>
    <?php

    $lombaDates = Lomba::find()->select('tanggal')->all();
    ?>
    <div class="lomba-form col-lg-3" style="margin-bottom: 30px;">
        <?php $form = ActiveForm::begin([
            'action' => ['index'],
            'method' => 'post',
        ]); ?>
        <?php
        $tanggalInput = Yii::$app->request->get('tanggal', '');
        $id = Yii::$app->request->get('id', null);
        ?>

        <?php if (empty($id) && empty($tanggalInput)): ?>
            <?= $form->field($tanggal, 'tanggal')->textInput([
                'type' => 'date',
                'value' => $tanggal->tanggal ?? ''
            ]) ?>
            <div class="form-group">
                <?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
            </div>
        <?php elseif (!empty($id) && !empty($tanggalInput)): ?>
            <h3><?= Html::encode($tanggalInput) ?></h3>
        <?php endif; ?>

    </div>


    <!-- Form Pencarian -->
    <div style="display: flex;">
        <!-- Tabel di sisi kiri -->
        <div style="flex: 1; padding-right: 20px;">
            <hr>
            <table class="table table-bordered">
                <thead style="text-align: center;">
                    <tr>
                        <th>Pilih</th>
                        <th>Nama</th>
                        <th>Lapak</th>
                        <th>NO Lapak</th>
                    </tr>
                </thead>
                <?php if ($lomba_id !== null): ?>
                    <tbody>
                        <?php foreach ($customers as $customer): ?>
                            <?php
                            // Cek apakah customer sudah diundi berdasarkan lomba_id
                            $undian = Undian::find()
                                ->where(['customer_id' => $customer->id, 'lomba_id' => $lomba_id])
                                ->one();

                            $sudahDiundi = $undian !== null;
                            ?>
                            <tr>
                                <td style="text-align: center;">
                                    <?php if (!$sudahDiundi): ?>
                                        <input type="checkbox" class="customer-checkbox" data-lapak="<?= $customer->lapak ?>"
                                            value="<?= $customer->id ?>" style="transform: scale(1.5); background-color: blue;">
                                    <?php else: ?>
                                        <span style="color: gray;">Sudah</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= Html::encode($customer->nama) ?></td>
                                <td><?= Html::encode($customer->lapak) ?></td>
                                <td class="lapak-number" style="font-weight: bold; text-align: center;"
                                    id="lapak-<?= $customer->id ?>">
                                    <?php if ($sudahDiundi): ?>
                                        <?php
                                        // Tampilkan lapak yang diundi jika customer sudah diundi
                                        echo Html::encode($undian->lapak);
                                        ?>
                                    <?php else: ?>
                                        ---
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>

                <?php endif; ?>
            </table>

        </div>
        <!-- Area animasi undian -->
        <div style="text-align: center; padding-left: 20px;">
            <h3>Undian Nomor Lapak</h3>
            <div id="lottery-animation"
                style="font-size: 5rem; font-weight: bold; margin: 20px 0; background-color: red;">
                <span id="lottery-number" style="color: white;">-</span>
            </div>
            <button type="button" id="spin-lottery" class="btn btn-success">Mulai Putaran</button>
        </div>
    </div>

    <div id="lottery-modal" style="display: none;">
        <div
            style="position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0, 0, 0, 0.5); z-index: 999;">
            <div
                style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background: white; padding: 20px; border-radius: 5px;">
                <h3>
                    Nama:
                    <b id="modal-customer"></b>
                </h3>
                <h3>
                    No. Lapak:
                    <b id="modal-lapak"></b>
                </h3>
                <button type="button" onclick="closeModal()" class="btn btn-danger">Tutup</button>
            </div>
        </div>
    </div>
    <p>
        <?= Html::a('Cetak Daftar Undian', ['undian/print'], ['class' => 'btn btn-primary', 'target' => '_blank']) ?>

    </p>


    <?php ActiveForm::end(); ?>
</div>

<script>

    const totalLapak = 152;
    const lapakUsed = [];
    const customersDone = [];
    let orderedCustomers = [];
    let i = 0;

    document.getElementById('spin-lottery').addEventListener('click', function () {
        const checkboxes = document.querySelectorAll('.customer-checkbox:checked');
        const groupTwo = [];
        const groupOne = [];

        checkboxes.forEach(cb => {
            const id = cb.value;
            const jumlahLapak = parseInt(cb.getAttribute('data-lapak'));
            if (!customersDone.includes(id)) {
                if (jumlahLapak === 2) {
                    groupTwo.push(id);
                } else {
                    groupOne.push(id);
                }
            }
        });

        orderedCustomers = [...groupTwo, ...groupOne];
        i = 0;

        if (orderedCustomers.length === 0) {
            alert('Semua customer sudah diundi atau belum ada yang dipilih!');
            return;
        }

        undiBerikutnya();
    });

    function undiBerikutnya() {
        if (i >= orderedCustomers.length || lapakUsed.length >= totalLapak) return;

        const customerId = orderedCustomers[i];
        const cb = document.querySelector(`.customer-checkbox[value="${customerId}"]`);
        const jumlahLapak = parseInt(cb.getAttribute('data-lapak'));
        let customerName = '';

        <?php foreach ($customers as $customer): ?>
            if (customerId == <?= $customer->id ?>) {
                customerName = "<?= $customer->nama ?>";
            }
        <?php endforeach; ?>

        let lapakList = [];

        function generateUniqueLapak() {
            let rand = Math.floor(Math.random() * totalLapak) + 1;
            while (lapakUsed.includes(rand)) {
                rand = Math.floor(Math.random() * totalLapak) + 1;
            }
            return rand;
        }

        if (jumlahLapak === 2) {
            let lapak1 = generateUniqueLapak();
            let lapak2 = lapak1 + 1;

            while (
                lapakUsed.includes(lapak1) ||
                lapakUsed.includes(lapak2) ||
                lapak2 > totalLapak
            ) {
                lapak1 = generateUniqueLapak();
                lapak2 = lapak1 + 1;
            }

            lapakUsed.push(lapak1, lapak2);
            lapakList = [lapak1, lapak2];
        } else {
            let lapak = generateUniqueLapak();
            lapakUsed.push(lapak);
            lapakList = [lapak];
        }

        animateLotteryNumber(lapakList[0], () => {
            document.getElementById('lapak-' + customerId).textContent = lapakList.join(' - ');
            customersDone.push(customerId);
            if (cb) cb.parentElement.innerHTML = ''; // hapus checkbox
            showModal(lapakList.join(' - '), customerName);
        });
    }

    function animateLotteryNumber(finalNumber, callback) {
        let numberElement = document.getElementById('lottery-number');
        let duration = 3600;
        let startTime = null;

        function animate(time) {
            if (!startTime) startTime = time;
            let progress = time - startTime;
            let speed = Math.max(10, 300 - progress / 5);

            numberElement.textContent = Math.floor(Math.random() * totalLapak) + 1;

            if (progress < duration) {
                setTimeout(() => {
                    requestAnimationFrame(animate);
                }, speed);
            } else {
                numberElement.textContent = finalNumber;
                callback();
            }
        }

        requestAnimationFrame(animate);
    }

    function showModal(lapak, customerName) {
        document.getElementById('modal-lapak').textContent = lapak;
        document.getElementById('modal-customer').textContent = customerName;
        document.getElementById('lottery-modal').style.display = 'block';
        document.getElementById('lottery-modal').style.zIndex = '1000';
    }

    function closeModal() {
        // Menutup modal
        document.getElementById('lottery-modal').style.display = 'none';

        const customerName = document.getElementById('modal-customer').textContent;
        const lapak = document.getElementById('modal-lapak').textContent;

        // Mengambil ID customer dari orderedCustomers (asumsi orderedCustomers[i] sudah didefinisikan)
        const customerId = orderedCustomers[i];

        // Kirim data ke actionIndex controller menggunakan AJAX
        const urlParams = new URLSearchParams(window.location.search);
        const lombaId = urlParams.get('id');

        $.post(`http://localhost/pancing/web/undian/index?id=${lombaId}`, {
            // $.post('http://localhost/pancing/web/undian/index', {

            undian_data: JSON.stringify({
                customer_id: customerId,
                customer_name: customerName,
                lapak: lapak
            }),
            _csrf: '<?= Yii::$app->request->csrfToken ?>'
        }).done(function (response) {
            console.log('Server Response:', response);
            if (response.success) {
                console.log('Data berhasil disimpan ke tabel undian');
            } else {
                console.error('Gagal menyimpan data:', response.message);
            }
        }).fail(function (xhr, status, error) {
            console.error('Error:', error);
        });

        i++;
        setTimeout(undiBerikutnya, 500);
    }



    let selectedCustomers = JSON.parse(localStorage.getItem('selectedCustomers')) || [];

    selectedCustomers.forEach(id => {
        const checkbox = document.getElementById('checkbox-' + id);
        if (checkbox) checkbox.checked = true;
    });

    document.querySelectorAll('.customer-checkbox').forEach(function (checkbox) {
        checkbox.addEventListener('change', function () {
            const customerId = this.value;

            if (this.checked) {
                if (!selectedCustomers.includes(customerId)) {
                    selectedCustomers.push(customerId);
                }
            } else {
                selectedCustomers = selectedCustomers.filter(id => id !== customerId);
            }

            localStorage.setItem('selectedCustomers', JSON.stringify(selectedCustomers));
        });
    });
</script>