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
                size: 210mm 670mm;
                /* A4 width, 75cm height */
                margin: 10mm;
                /* Opsional: atur margin cetak */
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
                column-count: 2;
                column-gap: 20px;
            }

            .table-wrapper {
                break-inside: avoid;
                margin-bottom: 20px;
            }

            table {
                width: 100%;
                font-size: 0.8rem;
                border-collapse: collapse;
            }

            th {
                background-color: yellow !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }
    </style>
</head>

<body>
    <div style="text-align: center; margin-top: 30px;">
        <button onclick="window.print()">Print ke HVS A4 (Portrait)</button>
    </div>

    <div class="print-area">
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr style="text-align: center; background-color: yellow;">
                        <th rowspan="2">L</th>
                        <th rowspan="2">N</th>
                        <th colspan="3">SS</th>
                        <th colspan="4">C</th>
                    </tr>
                    <tr style="text-align: center; background-color: yellow;">
                        <th>1</th>
                        <th>2</th>
                        <th>3</th>
                        <th>1</th>
                        <th>2</th>
                        <th>3</th>
                        <th>4</th>
                    </tr>
                </thead>

                <tbody>
                    <?php if ($lomba_id !== null): ?>
                        <?php
                        $groupedEntries = [];

                        foreach ($customers as $customer) {
                            $lapaks = [];

                            foreach ($customer->undians as $undian) {
                                if (!empty($undian->lapak)) {
                                    $lapakValues = explode('-', $undian->lapak);
                                    foreach ($lapakValues as $lapak) {
                                        $lapaks[] = (int) trim($lapak);
                                    }
                                }
                            }

                            sort($lapaks);
                            $groupedEntries[] = [
                                'nama' => $customer->nama,
                                'ss1' => $customer->ss1,
                                'ss2' => $customer->ss2,
                                'ss3' => $customer->ss3,
                                'merah' => $customer->merah,
                                'hitam' => $customer->hitam,
                                'lapaks' => $lapaks,
                            ];
                        }

                        usort($groupedEntries, fn($a, $b) => ($a['lapaks'][0] ?? 0) <=> ($b['lapaks'][0] ?? 0));

                        $no = 1;
                        foreach ($groupedEntries as $entry):
                            // Selalu 2 baris
                            $lapakCount = 2;
                            for ($i = 0; $i < $lapakCount; $i++):
                                ?>
                                <tr>
                                    <!-- Kolom Lapak -->
                                    <?php if (count($entry['lapaks']) === 1): ?>
                                        <?php if ($i == 0): ?>
                                            <td rowspan="2" style="text-align:center; font-weight: bold;">
                                                <?= $entry['lapaks'][0] ?>
                                            </td>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <td style="text-align:center; font-weight: bold;">
                                            <?= $entry['lapaks'][$i] ?? '' ?>
                                        </td>
                                    <?php endif; ?>

                                    <!-- Kolom Nama -->
                                    <?php if (count($entry['lapaks']) === 1): ?>
                                        <?php if ($i == 0): ?>
                                            <td rowspan="2" style="text-align:center; font-weight: bold;">
                                                <?= Html::encode($entry['nama']) ?>
                                            </td>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <td style="text-align:center; font-weight: bold;">
                                            <?= Html::encode($entry['nama']) ?>
                                        </td>
                                    <?php endif; ?>


                                    <!-- Kolom SS -->
                                    <?php if ($i == 0): ?>
                                        <td rowspan="2">
                                            <?= $entry['ss1'] == 1 ? '<div style="text-align: center; color:blue;"><i class="fas fa-check"></i></div>' : '' ?>
                                        </td>
                                        <td rowspan="2">
                                            <?= $entry['ss2'] == 1 ? '<div style="text-align: center; color:blue;"><i class="fas fa-check"></i></div>' : '' ?>
                                        </td>
                                        <td rowspan="2">
                                            <?= $entry['ss3'] == 1 ? '<div style="text-align: center; color:blue;"><i class="fas fa-check"></i></div>' : '' ?>
                                        </td>
                                    <?php endif; ?>

                                    <!-- Kolom M/H -->


                                    <!-- Kolom Warna -->
                                    <?php
                                    $warna = $i == 0 ? 'merah' : 'hitam';
                                    $color = $i == 0 ? 'red' : 'black';
                                    ?>

                                    <?php if (count($entry['lapaks']) === 2): ?>


                                        <td>
                                            <?= isset($entry[$warna]) && is_object($entry[$warna]) && $entry[$warna]->c1 == 1
                                                ? '<div style="text-align: center; color:' . $color . ';"><i class="fas fa-check"></i></div>'
                                                : '' ?>
                                        </td>

                                        <td>
                                            <?= isset($entry[$warna]) && is_object($entry[$warna]) && $entry[$warna]->c2 == 1
                                                ? '<div style="text-align: center; color:' . $color . ';"><i class="fas fa-check"></i></div>'
                                                : '' ?>
                                        </td>
                                        </td>
                                        <td>
                                            <?= isset($entry[$warna]) && is_object($entry[$warna]) && $entry[$warna]->c3 == 1
                                                ? '<div style="text-align: center; color:' . $color . ';"><i class="fas fa-check"></i></div>'
                                                : '' ?>
                                        </td>
                                        <td>
                                            <?= isset($entry[$warna]) && is_object($entry[$warna]) && $entry[$warna]->c4 == 1
                                                ? '<div style="text-align: center; color:' . $color . ';"><i class="fas fa-check"></i></div>'
                                                : '' ?>
                                        </td>
                                    <?php endif; ?>

                                    <?php if (count($entry['lapaks']) === 1): ?>
                                        <td>
                                            <?= isset($entry[$warna]) && is_object($entry[$warna]) && $entry[$warna]->c1 == 1
                                                ? '<div style="text-align: center; color:' . $color . ';"><i class="fas fa-check"></i></div>'
                                                : '' ?>
                                        </td>
                                        <td>
                                            <?= isset($entry[$warna]) && is_object($entry[$warna]) && $entry[$warna]->c2 == 1
                                                ? '<div style="text-align: center; color:' . $color . ';"><i class="fas fa-check"></i></div>'
                                                : '' ?>
                                        </td>
                                        <td>
                                            <?= isset($entry[$warna]) && is_object($entry[$warna]) && $entry[$warna]->c3 == 1
                                                ? '<div style="text-align: center; color:' . $color . ';"><i class="fas fa-check"></i></div>'
                                                : '' ?>
                                        </td>
                                        <td>
                                            <?= isset($entry[$warna]) && is_object($entry[$warna]) && $entry[$warna]->c4 == 1
                                                ? '<div style="text-align: center; color:' . $color . ';"><i class="fas fa-check"></i></div>'
                                                : '' ?>
                                        </td>
                                    <?php endif; ?>

                                </tr>
                            <?php endfor; endforeach; ?>

                    <?php endif; ?>
                </tbody>


            </table>

        </div>
    </div>
</body>

</html>