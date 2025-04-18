<?php
use yii\helpers\Html;
$customers = $dataProvider->getModels();
$dateToday = date('d-m-Y');
?>

<!DOCTYPE html>
<html>
<div style="text-align: center; margin-top: 30px;">
    <button onclick="window.print()">Print ke HVS A4</button>
</div>

<head>
    <title>Data Undian</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        h1 {
            text-align: center;
        }

        .tanggal {
            text-align: center;
            margin-top: 10px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            font-size: 14px;
        }

        table,
        th,
        td {
            border: 1px solid black;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }

        @media print {
            body * {
                visibility: hidden;
            }

            h1,
            table,
            table *,
            .tanggal {
                visibility: visible;
                margin-top: 0;
            }

            h1,
            .tanggal {
                top: 0;
                left: 0;
            }

            table {
                top: 0;
                left: 0;
            }

            button {
                display: none;
            }

            /* Menambahkan margin atas dan bawah 25mm */
            html,
            body {
                margin: 0;
                padding: 0;
                height: 50%;
            }
        }
    </style>
</head>

<h1 style="">Daftar Undian Customer</h1>
<div class="tanggal" style="">Tanggal: <?= Html::encode($dateToday) ?></div>
<table>
    <thead>
        <tr>
            <th>Nama Customer</th>
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
                // Cek apakah ada minimal satu undian yang punya lapak
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
                        <td><?= Html::encode($customer->lapak) ?></td>
                        <td>
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
                        <td><?= $customer->ss1 == 1 ? '<div style="text-align: center;"><i class="fas fa-check"></i></div>' : '<div style="text-align: center;"><i class="fas fa-ban" style="color:#f31212;"></i></div>'; ?>
                        </td>
                        <td><?= $customer->ss2 == 1 ? '<div style="text-align: center;"><i class="fas fa-check"></i></div>' : '<div style="text-align: center;"><i class="fas fa-ban" style="color:#f31212;"></i></div>'; ?>
                        </td>
                        <td><?= $customer->ss3 == 1 ? '<div style="text-align: center;"><i class="fas fa-check"></i></div>' : '<div style="text-align: center;"><i class="fas fa-ban" style="color:#f31212;"></i></div>'; ?>
                        </td>
                        <td></td>

                        <!-- Merah Section -->
                        <td><?= is_object($customer->merah) && $customer->merah->c1 == 1 ? '<div style="text-align: center;"><i class="fas fa-check"></i></div>' : '<div style="text-align: center;"><i class="fas fa-ban" style="color:#f31212;"></i></div>'; ?>
                        </td>
                        <td><?= is_object($customer->merah) && $customer->merah->c2 == 1 ? '<div style="text-align: center;"><i class="fas fa-check"></i></div>' : '<div style="text-align: center;"><i class="fas fa-ban" style="color:#f31212;"></i></div>'; ?>
                        </td>
                        <td><?= is_object($customer->merah) && $customer->merah->c3 == 1 ? '<div style="text-align: center;"><i class="fas fa-check"></i></div>' : '<div style="text-align: center;"><i class="fas fa-ban" style="color:#f31212;"></i></div>'; ?>
                        </td>
                        <td><?= is_object($customer->merah) && $customer->merah->c4 == 1 ? '<div style="text-align: center;"><i class="fas fa-check"></i></div>' : '<div style="text-align: center;"><i class="fas fa-ban" style="color:#f31212;"></i></div>'; ?>
                        </td>

                        <td></td>

                        <!-- Hitam Section -->
                        <td><?= is_object($customer->hitam) && $customer->hitam->c1 == 1 ? '<div style="text-align: center;"><i class="fas fa-check"></i></div>' : '<div style="text-align: center;"><i class="fas fa-ban" style="color:#f31212;"></i></div>'; ?>
                        </td>
                        <td><?= is_object($customer->hitam) && $customer->hitam->c2 == 1 ? '<div style="text-align: center;"><i class="fas fa-check"></i></div>' : '<div style="text-align: center;"><i class="fas fa-ban" style="color:#f31212;"></i></div>'; ?>
                        </td>
                        <td><?= is_object($customer->hitam) && $customer->hitam->c3 == 1 ? '<div style="text-align: center;"><i class="fas fa-check"></i></div>' : '<div style="text-align: center;"><i class="fas fa-ban" style="color:#f31212;"></i></div>'; ?>
                        </td>
                        <td><?= is_object($customer->hitam) && $customer->hitam->c4 == 1 ? '<div style="text-align: center;"><i class="fas fa-check"></i></div>' : '<div style="text-align: center;"><i class="fas fa-ban" style="color:#f31212;"></i></div>'; ?>
                        </td>
                    </tr>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>


</table>