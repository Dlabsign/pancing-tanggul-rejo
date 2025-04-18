<?php
use yii\helpers\Html;
$customers = $dataProvider->getModels();
$dateToday = date('d-m-Y');
?>

<!DOCTYPE html>
<html>

<head>
    <title>Data Undian</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        h1 {
            text-align: center;
            margin: 0;
        }

        .tanggal {
            text-align: center;
            margin: 5px 0 20px 0;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            font-size: 12px;
        }

        table,
        th,
        td {
            border: 1px solid black;
            padding: 6px;
        }

        th {
            background-color: #f2f2f2;
        }

        button {
            margin-top: 30px;
            display: block;
            margin-left: auto;
            margin-right: auto;
        }

        @media print {
            @page {
                size: A4 landscape;
                margin: 15mm;
            }

            body {
                margin: 0;
                padding: 0;
            }

            body * {
                visibility: hidden;
            }

            .print-area,
            .print-area * {
                visibility: visible;
            }

            .print-area {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
            }

            button {
                display: none;
            }

            /* Tambahan agar warna latar tetap muncul saat print */
            th {
                background-color: yellow !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            td.bg-merah {
                background-color: red !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            td.bg-hitam {
                background-color: grey !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            table {
                border-collapse: collapse;
                width: 100%;
                font-size: 1rem;
                /* diubah dari 12px */
            }

            table,
            th,
            td {
                border: 1px solid black;
                padding: 6px;
            }

        }
    </style>
</head>

<body>
    <div style="text-align: center; margin-top: 30px;">
        <button onclick="window.print()">Print ke HVS A4 (Landscape)</button>
    </div>

    <div class="print-area">
        <h1>Daftar Undian Customer</h1>
        <div class="tanggal">Tanggal: <?= Html::encode($dateToday) ?></div>

        <table>
            <thead>
                <tr style="text-align: center; background-color: yellow;">
                    <th>Nama</th>
                    <th>Jumlah Lapak</th>
                    <th>NO Lapak</th>
                    <th>SS1</th>
                    <th>SS2</th>
                    <th>SS3</th>
                    <th>MERAH</th>
                    <th>C1</th>
                    <th>C2</th>
                    <th>C3</th>
                    <th>C4</th>
                    <th>HITAM</th>
                    <th>C1</th>
                    <th>C2</th>
                    <th>C3</th>
                    <th>C4</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($lomba_id !== null): ?>
                    <?php foreach ($customers as $customer): ?>
                        <?php
                        $hasValidUndian = false;
                        foreach ($customer->undians as $undian) {
                            if (!empty($undian->lapak)) {
                                $hasValidUndian = true;
                                break;
                            }
                        }
                        ?>
                        <?php if ($hasValidUndian): ?>
                            <tr>
                                <td><?= Html::encode($customer->nama) ?></td>
                                <td style="text-align:center; font-weight: bold;"><?= Html::encode($customer->lapak) ?></td>
                                <td style="text-align:center; font-weight: bold; font-size: 1rem;">
                                    <?php if (!empty($customer->undians)): ?>
                                        <?php foreach ($customer->undians as $index => $undian): ?>
                                            <?php if (!empty($undian->lapak)): ?>
                                                <?= Html::encode($undian->lapak) ?>
                                                <?= $index < count($customer->undians) - 1 ? ', ' : '' ?>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        -
                                    <?php endif; ?>
                                </td>

                                <!-- SS Section -->
                                <td><?= $customer->ss1 == 1 ? '<div style="text-align: center;"><i class="fas fa-check"></i></div>' : '<div style="text-align: center;"><i class="fas fa-ban" style="color:#f31212;"></i></div>' ?>
                                </td>
                                <td><?= $customer->ss2 == 1 ? '<div style="text-align: center;"><i class="fas fa-check"></i></div>' : '<div style="text-align: center;"><i class="fas fa-ban" style="color:#f31212;"></i></div>' ?>
                                </td>
                                <td><?= $customer->ss3 == 1 ? '<div style="text-align: center;"><i class="fas fa-check"></i></div>' : '<div style="text-align: center;"><i class="fas fa-ban" style="color:#f31212;"></i></div>' ?>
                                </td>
                                <td class="bg-merah"></td>

                                <!-- Merah Section -->
                                <td><?= is_object($customer->merah) && $customer->merah->c1 == 1 ? '<div style="text-align: center;"><i class="fas fa-check"></i></div>' : '<div style="text-align: center;"><i class="fas fa-ban" style="color:#f31212;"></i></div>' ?>
                                </td>
                                <td><?= is_object($customer->merah) && $customer->merah->c2 == 1 ? '<div style="text-align: center;"><i class="fas fa-check"></i></div>' : '<div style="text-align: center;"><i class="fas fa-ban" style="color:#f31212;"></i></div>' ?>
                                </td>
                                <td><?= is_object($customer->merah) && $customer->merah->c3 == 1 ? '<div style="text-align: center;"><i class="fas fa-check"></i></div>' : '<div style="text-align: center;"><i class="fas fa-ban" style="color:#f31212;"></i></div>' ?>
                                </td>
                                <td><?= is_object($customer->merah) && $customer->merah->c4 == 1 ? '<div style="text-align: center;"><i class="fas fa-check"></i></div>' : '<div style="text-align: center;"><i class="fas fa-ban" style="color:#f31212;"></i></div>' ?>
                                </td>

                                <td class="bg-hitam"></td>

                                <!-- Hitam Section -->
                                <td><?= is_object($customer->hitam) && $customer->hitam->c1 == 1 ? '<div style="text-align: center;"><i class="fas fa-check"></i></div>' : '<div style="text-align: center;"><i class="fas fa-ban" style="color:#f31212;"></i></div>' ?>
                                </td>
                                <td><?= is_object($customer->hitam) && $customer->hitam->c2 == 1 ? '<div style="text-align: center;"><i class="fas fa-check"></i></div>' : '<div style="text-align: center;"><i class="fas fa-ban" style="color:#f31212;"></i></div>' ?>
                                </td>
                                <td><?= is_object($customer->hitam) && $customer->hitam->c3 == 1 ? '<div style="text-align: center;"><i class="fas fa-check"></i></div>' : '<div style="text-align: center;"><i class="fas fa-ban" style="color:#f31212;"></i></div>' ?>
                                </td>
                                <td><?= is_object($customer->hitam) && $customer->hitam->c4 == 1 ? '<div style="text-align: center;"><i class="fas fa-check"></i></div>' : '<div style="text-align: center;"><i class="fas fa-ban" style="color:#f31212;"></i></div>' ?>
                                </td>
                            </tr>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>

</html>