<?php
use app\models\Undian;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Customer;
use app\models\Lomba;

$customers = $dataProvider->getModels();
$dateToday = date('d-m-Y');

?>

<div class="undian-index">
    <?php $form = ActiveForm::begin([
        'method' => 'get',
        'action' => ['index'], // Pastikan diarahkan ke action yang sesuai
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
        <?php endif; ?>

    </div>

    <?php if ($lomba_id !== null): ?>
        <div style="display: flex;">
            <div style="flex: 1; padding-right: 20px;">
                <input style="font-size:2rem; font-weight:bold;" type="text" id="search-input" class="form-control"
                    placeholder="Cari Nama Customer..." oninput="filterTable()"
                    onkeydown="if(event.key === 'Enter'){ event.preventDefault(); return false; }">
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
                            $undian = Undian::find()
                                ->where(['customer_id' => $customer->id, 'lomba_id' => $lomba_id])
                                ->one();
                            $sudahDiundi = $undian !== null;
                            ?>
                            <tr class="customer-row" data-name="<?= Html::encode($customer->nama) ?>">
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
                                    id="lapak-<?= Html::encode($customer->id) ?>">
                                    <?php if ($sudahDiundi): ?>
                                        <?= Html::encode(
                                            $undian->lapak2 && $undian->lapak1 != $undian->lapak2
                                            ? "{$undian->lapak1} - {$undian->lapak2}"
                                            : $undian->lapak1
                                        ) ?>

                                    <?php else: ?>
                                        ---
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if (!$sudahDiundi): ?>
                                        <p>
                                            <span style="color: gray;">--</span>
                                        </p>
                                    <?php else: ?>
                                        <?= Html::a('Cetak Nota ', ['undian/print', 'id' => Yii::$app->request->get('id'), 'tanggal' => Yii::$app->request->get('tanggal')], ['class' => 'btn btn-primary', 'target' => '_blank']) ?>

                                    <?php endif; ?>

                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

            </div>

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
    let lapakUsed = [];
    const customersDone = [];
    let orderedCustomers = [];
    let i = 0;

    const customerData = <?= json_encode($customers) ?>;

    function loadUsedLapak(callback) {
        const urlParams = new URLSearchParams(window.location.search);
        const lombaId = urlParams.get('id');

        $.getJSON(`http://localhost/pancing/web/undian/get-lapak-used?id=${lombaId}`, function (data) {
            data.forEach(item => {
                if (!lapakUsed.includes(item.lapak1)) lapakUsed.push(item.lapak1);
                if (!lapakUsed.includes(item.lapak2)) lapakUsed.push(item.lapak2);
            });
            console.log("Lapak yang sudah dipakai:", lapakUsed);
            if (callback) callback();
        });
    }

    document.getElementById('spin-lottery').addEventListener('click', function () {
        const checkboxes = document.querySelectorAll('.customer-checkbox:checked');
        const groupTwo = [];
        const groupOne = [];

        checkboxes.forEach(cb => {
            const id = cb.value;
            const jumlahLapak = parseInt(cb.getAttribute('data-lapak'));
            if (!customersDone.includes(id) && !orderedCustomers.includes(id)) {
                jumlahLapak === 2 ? groupTwo.push(id) : groupOne.push(id);
                orderedCustomers.push(id);
            }
        });

        orderedCustomers = [...groupTwo, ...groupOne];
        i = 0;

        if (orderedCustomers.length === 0) {
            alert('Semua customer sudah diundi atau belum ada yang dipilih!');
            return;
        }

        if (lapakUsed.length >= totalLapak) {
            alert('Semua lapak telah terisi!');
            return;
        }

        undiBerikutnya();
    });

    function undiBerikutnya() {
        if (i >= orderedCustomers.length || lapakUsed.length >= totalLapak) {
            if (lapakUsed.length >= totalLapak) {
                alert('Semua lapak telah terisi!');
            }
            return;
        }

        const customerId = orderedCustomers[i];
        const cb = document.querySelector(`.customer-checkbox[value="${customerId}"]`);
        const jumlahLapak = parseInt(cb.getAttribute('data-lapak'));
        const customer = customerData.find(c => c.id == customerId);
        const customerName = customer ? customer.nama : 'Unknown';

        let lapakList = [];

        function getRandomOddEvenPair() {
            const availablePairs = [];
            for (let n = 1; n < totalLapak; n += 2) {
                if (!lapakUsed.includes(n) && !lapakUsed.includes(n + 1)) {
                    availablePairs.push([n, n + 1]);
                }
            }
            if (availablePairs.length === 0) return null;
            return availablePairs[Math.floor(Math.random() * availablePairs.length)];
        }

        function getRandomAvailableNumber() {
            const available = [];
            for (let n = 1; n <= totalLapak; n++) {
                if (!lapakUsed.includes(n)) available.push(n);
            }
            if (available.length === 0) return null;
            return available[Math.floor(Math.random() * available.length)];
        }

        function getAvailableNumbers() {
            const available = [];
            for (let n = 1; n <= totalLapak; n++) {
                if (!lapakUsed.includes(n)) available.push(n);
            }
            return available;
        }

        function getRandomTwoFromArray(array) {
            const shuffled = array.sort(() => 0.5 - Math.random());
            return shuffled.slice(0, 2);
        }

        if (jumlahLapak === 2) {
            let pair = getRandomOddEvenPair();
            if (!pair) {
                const available = getAvailableNumbers();
                if (available.length < 2) {
                    alert('Lapak tidak tersedia untuk 2 slot.');
                    i++;
                    setTimeout(undiBerikutnya, 100);
                    return;
                }
                pair = getRandomTwoFromArray(available);
            }
            lapakUsed.push(...pair);
            lapakList = pair;
        } else {
            const lapak = getRandomAvailableNumber();
            if (!lapak) {
                alert('Lapak tidak tersedia untuk 1 slot.');
                i++;
                setTimeout(undiBerikutnya, 100);
                return;
            }
            lapakUsed.push(lapak);
            lapakList = [lapak];
        }

        animateLotteryNumber(lapakList[0], () => {
            document.getElementById('lapak-' + customerId).textContent = lapakList.join(' - ');
            customersDone.push(customerId);
            if (cb) cb.parentElement.innerHTML = '';

            const urlParams = new URLSearchParams(window.location.search);
            const lombaId = urlParams.get('id');

            const lapak1 = lapakList.length === 2 ? lapakList[0] : lapakList[0];
            const lapak2 = lapakList.length === 2 ? lapakList[1] : lapakList[0];

            $.post(`http://localhost/pancing/web/undian/index?id=${lombaId}`, {
                undian_data: JSON.stringify({
                    customer_id: parseInt(customerId),
                    customer_name: customerName,
                    lapak1: lapak1,
                    lapak2: lapak2
                }),
                _csrf: '<?= Yii::$app->request->csrfToken ?>'
            }).done(response => {
                console.log('Data berhasil disimpan:', response);
            }).fail((xhr, status, error) => {
                console.error('Gagal simpan:', error);
            });

            i++;

            if (lapakUsed.length >= totalLapak) {
                alert('Semua lapak telah terisi!');
                return;
            }

            setTimeout(undiBerikutnya, 500);
        });
    }

    function animateLotteryNumber(finalNumber, callback) {
        const numberElement = document.getElementById('lottery-number');
        const duration = 1000;
        let startTime = null;

        function animate(time) {
            if (!startTime) startTime = time;
            const progress = time - startTime;
            const speed = Math.max(10, 300 - progress / 5);
            numberElement.textContent = Math.floor(Math.random() * totalLapak) + 1;

            if (progress < duration) {
                setTimeout(() => requestAnimationFrame(animate), speed);
            } else {
                numberElement.textContent = finalNumber;
                callback();
            }
        }

        requestAnimationFrame(animate);
    }

    function filterTable() {
        const filter = document.getElementById('search-input').value.toLowerCase();
        document.querySelectorAll('.customer-row').forEach(row => {
            const name = row.getAttribute('data-name').toLowerCase();
            row.style.display = name.includes(filter) ? '' : 'none';
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        loadUsedLapak();
    });
</script>