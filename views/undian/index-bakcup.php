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
        <?php endif; ?>

    </div>

    <?php if ($lomba_id !== null): ?>

        <div style="display: flex;">
            <div style="flex: 1; padding-right: 20px;">
                <div style="margin-bottom: 10px;">
                    <!-- Tambahkan input pencarian -->
                    <input style="font-size:2rem; font-weight:bold;" type="text" id="search-input" class="form-control"
                        placeholder="Cari Nama Customer..." oninput="filterTable()"
                        onkeydown="if(event.key === 'Enter'){ event.preventDefault(); return false; }">
                </div>
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
                                    id="lapak-<?= Html::encode($customer->id) ?>">
                                    <?php if ($sudahDiundi): ?>
                                        <?= Html::encode(
                                            $undian->lapak2
                                            ? "{$undian->lapak1} - {$undian->lapak2}"
                                            : $undian->lapak1
                                        ) ?>
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
            <div style="text-align: center; padding-left: 20px; ">
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
<!-- 
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


</script> -->

<!-- 
<script>
    const totalLapak = 152;
    let lapakUsed = [];
    const customersDone = [];
    let orderedCustomers = [];
    let i = 0;

    const customerData = <?= json_encode($customers) ?>;

    // Load data lapak yang sudah dipakai dari database
    function loadUsedLapak() {
        const urlParams = new URLSearchParams(window.location.search);
        const lombaId = urlParams.get('id');

        $.getJSON(`http://localhost/pancing/web/undian/get-lapak-used?id=${lombaId}`, function (data) {
            data.forEach(item => {
                if (!lapakUsed.includes(item.lapak1)) {
                    lapakUsed.push(item.lapak1);
                }
                if (!lapakUsed.includes(item.lapak2)) {
                    lapakUsed.push(item.lapak2);
                }
            });

            console.log("Lapak yang sudah dipakai:", lapakUsed);
        });
    }

    // Event klik tombol Spin Lottery
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

        undiBerikutnya(); // Mulai undian setelah tombol ditekan
    });

    function undiBerikutnya() {
        if (i >= orderedCustomers.length || lapakUsed.length >= totalLapak) return;

        const customerId = orderedCustomers[i];
        const cb = document.querySelector(`.customer-checkbox[value="${customerId}"]`);
        const jumlahLapak = parseInt(cb.getAttribute('data-lapak'));
        const customer = customerData.find(c => c.id == customerId);
        const customerName = customer ? customer.nama : 'Unknown';

        let lapakList = [];

        function getRandomOddEvenPair() {
            const availablePairs = [];
            for (let n = 1; n < totalLapak; n += 2) {
                if (!lapakUsed.includes(n) && !lapakUsed.includes(n + 1) && n + 1 <= totalLapak) {
                    availablePairs.push([n, n + 1]);
                }
            }
            if (availablePairs.length === 0) return null;
            return availablePairs[Math.floor(Math.random() * availablePairs.length)];
        }

        function getRandomAvailableNumber() {
            const available = [];
            for (let n = 1; n <= totalLapak; n++) {
                if (!lapakUsed.includes(n)) {
                    available.push(n);
                }
            }
            if (available.length === 0) return null;
            return available[Math.floor(Math.random() * available.length)];
        }

        if (jumlahLapak === 2) {
            const pair = getRandomOddEvenPair();
            if (!pair) {
                alert('Tidak ada lagi pasangan ganjil-genap tersedia untuk 2 lapak.');
                i++;
                setTimeout(undiBerikutnya, 100);
                return;
            }
            lapakUsed.push(...pair);
            lapakList = pair;
        } else {
            const lapak = getRandomAvailableNumber();
            if (!lapak) {
                alert('Tidak ada lagi nomor tersedia untuk 1 lapak.');
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

    // Checkbox selected state persist
    let selectedCustomers = JSON.parse(localStorage.getItem('selectedCustomers')) || [];

    selectedCustomers.forEach(id => {
        const checkbox = document.getElementById('checkbox-' + id);
        if (checkbox) checkbox.checked = true;
    });

    document.querySelectorAll('.customer-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', function () {
            const customerId = this.value;
            if (this.checked && !selectedCustomers.includes(customerId)) {
                selectedCustomers.push(customerId);
            } else {
                selectedCustomers = selectedCustomers.filter(id => id !== customerId);
            }
            localStorage.setItem('selectedCustomers', JSON.stringify(selectedCustomers));
        });
    });

    document.getElementById('check-all').addEventListener('change', function () {
        const isChecked = this.checked;
        document.querySelectorAll('.customer-checkbox').forEach(checkbox => {
            checkbox.checked = isChecked;
            checkbox.dispatchEvent(new Event('change'));
        });
    });

    function filterTable() {
        const filter = document.getElementById('search-input').value.toLowerCase();
        document.querySelectorAll('.customer-row').forEach(row => {
            const name = row.getAttribute('data-name').toLowerCase();
            row.style.display = name.includes(filter) ? '' : 'none';
        });
    }

    // Panggil saat dokumen siap
    document.addEventListener('DOMContentLoaded', function () {
        loadUsedLapak();
    });

</script> -->

<script>
    const totalLapak = 152;
    let lapakUsed = [];
    const customersDone = [];
    let orderedCustomers = [];
    let i = 0;

    const urlParams = new URLSearchParams(window.location.search);
    const lombaId = urlParams.get('id');
    const tanggal = urlParams.get('tanggal');

    const customerData = <?= json_encode($customers) ?>;

    // Load lapak dari database (get-lapak-used)
    function loadUsedLapak() {
        return new Promise((resolve, reject) => {
            const urlParams = new URLSearchParams(window.location.search);
            const lombaId = urlParams.get('id');
            const tanggal = urlParams.get('tanggal');

            $.getJSON(`http://localhost/pancing/web/undian/index?id=${lombaId}&tanggal=${tanggal}`, function (data) {
                data.forEach(item => {
                    if (!lapakUsed.includes(item.lapak1)) lapakUsed.push(item.lapak1);
                    if (!lapakUsed.includes(item.lapak2)) lapakUsed.push(item.lapak2);

                    // Simpan hasil undian ke localStorage
                    if (!localStorage.getItem('hasilUndian')) {
                        localStorage.setItem('hasilUndian', JSON.stringify({}));
                    }

                    const hasilUndian = JSON.parse(localStorage.getItem('hasilUndian'));
                    hasilUndian[item.customer_id] = [item.lapak1, item.lapak2];
                    localStorage.setItem('hasilUndian', JSON.stringify(hasilUndian));
                });

                console.log("Lapak yang sudah dipakai:", lapakUsed);
                resolve(); // Menandakan proses selesai
            }).fail(reject);
        });
    }

    // Menghapus hasil undian dari localStorage saat berpindah halaman
    window.addEventListener("beforeunload", function () {
        localStorage.removeItem('hasilUndian');
        localStorage.removeItem('selectedCustomers');
    });

    // Spin tombol
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

        undiBerikutnya();
    });

    function undiBerikutnya() {
        if (i >= orderedCustomers.length || lapakUsed.length >= totalLapak) return;

        const customerId = orderedCustomers[i];
        const cb = document.querySelector(`.customer-checkbox[value="${customerId}"]`);
        const jumlahLapak = parseInt(cb.getAttribute('data-lapak'));
        const customer = customerData.find(c => c.id == customerId);
        const customerName = customer ? customer.nama : 'Unknown';

        let lapakList = [];

        function getRandomOddEvenPair() {
            const availablePairs = [];
            for (let n = 1; n < totalLapak; n += 2) {
                if (!lapakUsed.includes(n) && !lapakUsed.includes(n + 1) && n + 1 <= totalLapak) {
                    availablePairs.push([n, n + 1]);
                }
            }
            if (availablePairs.length === 0) return null;
            return availablePairs[Math.floor(Math.random() * availablePairs.length)];
        }

        function getRandomAvailableNumber() {
            const available = [];
            for (let n = 1; n <= totalLapak; n++) {
                if (!lapakUsed.includes(n)) {
                    available.push(n);
                }
            }
            if (available.length === 0) return null;
            return available[Math.floor(Math.random() * available.length)];
        }

        if (jumlahLapak === 2) {
            const pair = getRandomOddEvenPair();
            if (!pair) {
                alert('Tidak ada lagi pasangan ganjil-genap tersedia untuk 2 lapak.');
                i++;
                setTimeout(undiBerikutnya, 100);
                return;
            }

            // Cek jika nomor yang dipilih sudah ada di database
            if (lapakUsed.includes(pair[0]) || lapakUsed.includes(pair[1])) {
                console.log(`Nomor lapak ${pair[0]} atau ${pair[1]} sudah ada di database!`);
            }

            lapakUsed.push(...pair);
            lapakList = pair;
        } else {
            const lapak = getRandomAvailableNumber();
            if (!lapak) {
                alert('Tidak ada lagi nomor tersedia untuk 1 lapak.');
                i++;
                setTimeout(undiBerikutnya, 100);
                return;
            }

            // Cek jika nomor yang dipilih sudah ada di database
            if (lapakUsed.includes(lapak)) {
                console.log(`Nomor lapak ${lapak} sudah ada di database!`);
            }

            lapakUsed.push(lapak);
            lapakList = [lapak];
        }

        animateLotteryNumber(lapakList[0], () => {
            document.getElementById('lapak-' + customerId).textContent = lapakList.join(' - ');
            customersDone.push(customerId);
            if (cb) cb.parentElement.innerHTML = '';

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

                // Simpan juga ke localStorage untuk tampilkan ulang saat reload
                const hasilUndian = JSON.parse(localStorage.getItem('hasilUndian')) || {};
                hasilUndian[customerId] = lapakList;
                localStorage.setItem('hasilUndian', JSON.stringify(hasilUndian));
            }).fail((xhr, status, error) => {
                console.error('Gagal simpan:', error);
            });

            i++;
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

    // Checkbox persist
    let selectedCustomers = JSON.parse(localStorage.getItem('selectedCustomers')) || [];

    selectedCustomers.forEach(id => {
        const checkbox = document.getElementById('checkbox-' + id);
        if (checkbox) checkbox.checked = true;
    });

    document.querySelectorAll('.customer-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', function () {
            const customerId = this.value;
            if (this.checked && !selectedCustomers.includes(customerId)) {
                selectedCustomers.push(customerId);
            } else {
                selectedCustomers = selectedCustomers.filter(id => id !== customerId);
            }
            localStorage.setItem('selectedCustomers', JSON.stringify(selectedCustomers));
        });
    });

    document.getElementById('check-all').addEventListener('change', function () {
        const isChecked = this.checked;
        document.querySelectorAll('.customer-checkbox').forEach(checkbox => {
            checkbox.checked = isChecked;
            checkbox.dispatchEvent(new Event('change'));
        });
    });

    function filterTable() {
        const filter = document.getElementById('search-input').value.toLowerCase();
        document.querySelectorAll('.customer-row').forEach(row => {
            const name = row.getAttribute('data-name').toLowerCase();
            row.style.display = name.includes(filter) ? '' : 'none';
        });
    }

    // Panggil saat dokumen siap
    document.addEventListener('DOMContentLoaded', async function () {
        await loadUsedLapak();

        // Tampilkan hasil undian dari localStorage
        const hasilUndian = JSON.parse(localStorage.getItem('hasilUndian')) || {};
        Object.keys(hasilUndian).forEach(customerId => {
            const lapakList = hasilUndian[customerId];
            const span = document.getElementById('lapak-' + customerId);
            if (span) span.textContent = lapakList.join(' - ');

            const cb = document.querySelector(`.customer-checkbox[value="${customerId}"]`);
            if (cb) cb.parentElement.innerHTML = '';

            if (!customersDone.includes(customerId)) customersDone.push(customerId);
        });
    });
</script>