<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Sekolah</title>

    <style>
        body {
            font-family: "Times New Roman", serif;
            font-size: 12px;
            margin: 40px;
            color: #000;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h2 {
            margin: 0;
            font-size: 18px;
            text-transform: uppercase;
        }

        .header p {
            margin: 2px 0;
            font-size: 12px;
        }

        hr {
            border: 1px solid #000;
            margin: 10px 0 20px;
        }

        .report-info {
            margin-bottom: 15px;
        }

        .report-info table {
            width: 100%;
        }

        .report-info td {
            padding: 3px;
            font-size: 12px;
        }

        table.report-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table.report-table th,
        table.report-table td {
            border: 1px solid #000;
            padding: 6px;
            text-align: center;
        }

        table.report-table th {
            background-color: #f0f0f0;
            font-weight: bold;
        }

        .signature {
            width: 100%;
            margin-top: 50px;
            text-align: right;
        }

        .signature p {
            margin: 4px 0;
        }

        @media print {
            body {
                margin: 20px;
            }
        }
    </style>
</head>
<body>

<!-- HEADER -->
<div class="header">
    <h2>SEKOLAH MENENGAH ATAS XYZ</h2>
    <p>Alamat Sekolah · Telp (021) 123456</p>
</div>

<hr>

<!-- JUDUL LAPORAN -->
<div class="header">
    <h2>LAPORAN NILAI SISWA</h2>
</div>

<!-- INFO LAPORAN -->
<div class="report-info">
    <table>
        <tr>
            <td width="20%">Kelas</td>
            <td width="2%">:</td>
            <td><?= isset($kelas) ? $kelas : '-' ?></td>

            <td width="20%">Semester</td>
            <td width="2%">:</td>
            <td><?= isset($semester) ? $semester : '-' ?></td>
        </tr>
        <tr>
            <td>Tahun Ajaran</td>
            <td>:</td>
            <td><?= isset($academic_year) ? $academic_year : '-' ?></td>

            <td>Tanggal Cetak</td>
            <td>:</td>
            <td><?= date('d-m-Y') ?></td>
        </tr>
    </table>
</div>

<!-- TABEL LAPORAN -->
<table class="report-table">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Siswa</th>
            <th>Mata Pelajaran</th>
            <th>Nilai Akhir</th>
            <th>Grade</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($reports)): ?>
            <?php $no = 1; foreach ($reports as $r): ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= $r['fname'].' '.$r['lname'] ?></td>
                <td><?= $r['subject'] ?></td>
                <td><?= $r['nilai_akhir'] ?></td>
                <td><?= $r['grade'] ?></td>
            </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="5">Data tidak tersedia</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<!-- TANDA TANGAN -->
<div class="signature">
    <p><?= date('d F Y') ?></p>
    <p><b>Kepala Sekolah</b></p>
    <br><br><br>
    <p><b>( _____________________ )</b></p>
</div>

</body>
</html>
