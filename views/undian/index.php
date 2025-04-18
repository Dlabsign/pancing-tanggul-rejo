<?php
use app\models\Undian;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Customer;
use app\models\Lomba;

// $customers = Customer::find()->all();
$customers = $dataProvider->getModels();
$dateToday = date('d-m-Y');

?>

<div class="undian-index">
    <?php $form = ActiveForm::begin([
        'method' => 'get',
        'action' => ['index'], // pastikan diarahkan ke action yang sesuai
    ]); ?>

    <div class="lomba-form" style="margin-bottom: 30px;">
        <?php $form = ActiveForm::begin([
            'action' => ['index'],
            'method' => 'post',
        ]); ?>


        <?php
        $tanggalInput = Yii::$app->request->get('tanggal', '');
        $id = Yii::$app->request->get('id', null);
        ?>

        <?php if (empty($id) && empty($tanggalInput)): ?>
            <h1>Undian (No. Lapak)</h1>
            <div class="col-lg-3">
                <?= $form->field($tanggal, 'tanggal')->textInput([
                    'type' => 'date',
                    'value' => $tanggal->tanggal ?? ''
                ]) ?>
            </div>
            <div class="form-group">
                <?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
            </div>
        <?php elseif (!empty($id) && !empty($tanggalInput)): ?>
            <div style="margin-bottom: 10px;">
                <!-- Tambahkan input pencarian -->
                <input style="font-size:2rem; font-weight:bold;" type="text" id="search-input" class="form-control"
                    placeholder="Cari Nama Customer..." oninput="filterTable()"
                    onkeydown="if(event.key === 'Enter'){ event.preventDefault(); return false; }">
            </div> <?php endif; ?>

    </div>

    <?php if ($lomba_id !== null): ?>

        <div style="display: flex;">
            <div style="flex: 1; padding-right: 20px;">
                <p>
                    <?= Html::a('Cetak Daftar Undian', ['undian/print', 'id' => Yii::$app->request->get('id'), 'tanggal' => Yii::$app->request->get('tanggal')], ['class' => 'btn btn-primary', 'target' => '_blank']) ?>
                </p>
                <table class="table table-bordered">
                    <thead style="text-align: center;">
                        <tr>
                            <th style="text-align: center;">
                                <input type="checkbox" id="check-all" style="transform: scale(1.3);">
                            </th>
                            <th>Nama</th>
                            <th>Lapak</th>
                            <th>NO Lapak</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        usort($customers, function ($a, $b) {
                            return $b->lapak - $a->lapak;
                        });
                        ?>

                        <?php foreach ($customers as $customer): ?>
                            <?php
                            // Cek apakah customer sudah diundi berdasarkan lomba_id
                            $undian = Undian::find()
                                ->where(['customer_id' => $customer->id, 'lomba_id' => $lomba_id])
                                ->one();

                            $sudahDiundi = $undian !== null;
                            ?>
                            <tr class="customer-row" data-name="<?= Html::encode($customer->nama) ?>">
                                <!-- <td style="text-align: center;">
                                    <?php if (!$sudahDiundi): ?>
                                        <input type="checkbox" class="customer-checkbox" data-lapak="<?= $customer->lapak ?>"
                                            value="<?= $customer->id ?>" style="transform: scale(1.5); background-color: blue;">
                                    <?php else: ?>
                                        <span style="color: gray;">Sudah</span>
                                    <?php endif; ?>
                                </td> -->

                                <td style="text-align: center;">
                                    <?php if (!$sudahDiundi): ?>
                                        <input type="checkbox" class="customer-checkbox" data-lapak="<?= $customer->lapak ?>"
                                            value="<?= $customer->id ?>" style="transform: scale(1.5); background-color: blue;">
                                    <?php else: ?>
                                        <span style="color: gray;">Sudah</span>
                                    <?php endif; ?>
                                </td>

                                <td style="text-align: center;"><?= Html::encode($customer->nama) ?></td>
                                <td style="text-align: center;"><?= Html::encode($customer->lapak) ?></td>
                                <td class="lapak-number" style="font-weight: bold; text-align: center;"
                                    id="lapak-<?= $customer->id ?>">
                                    <?php if ($sudahDiundi): ?>
                                        <?php
                                        echo Html::encode($undian->lapak);
                                        ?>
                                    <?php else: ?>
                                        ---
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>

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


    <?php endif; ?>



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
            if (cb) cb.parentElement.innerHTML = '';

            const urlParams = new URLSearchParams(window.location.search);
            const lombaId = urlParams.get('id');

            $.post(`http://localhost/pancing/web/undian/index?id=${lombaId}`, {
                undian_data: JSON.stringify({
                    customer_id: customerId,
                    customer_name: customerName,
                    lapak: lapakList.join(' - ')
                }),
                _csrf: '<?= Yii::$app->request->csrfToken ?>'
            }).done(function (response) {
                console.log('Data berhasil disimpan:', response);
            }).fail(function (xhr, status, error) {
                console.error('Gagal simpan:', error);
            });

            i++;
            setTimeout(undiBerikutnya, 1100);
        });
    }

    function animateLotteryNumber(finalNumber, callback) {
        let numberElement = document.getElementById('lottery-number');
        let duration = 1000;
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
    document.getElementById('check-all').addEventListener('change', function () {
        let isChecked = this.checked;
        document.querySelectorAll('.customer-checkbox').forEach(function (checkbox) {
            checkbox.checked = isChecked;
        });
    });

    function filterTable() {
        let input = document.getElementById('search-input');
        let filter = input.value.toLowerCase();
        let rows = document.querySelectorAll('.customer-row'); // Gantilah selector untuk target tabel yang sesuai

        rows.forEach(function (row) {
            let name = row.getAttribute('data-name').toLowerCase();
            if (name.includes(filter)) {
                row.style.display = '';  // Tampilkan baris jika nama sesuai pencarian
            } else {
                row.style.display = 'none';  // Sembunyikan baris jika nama tidak sesuai pencarian
            }
        });
    }


</script>