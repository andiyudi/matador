<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Rekap Penilaian CMNP Terhadap Vendor</title>
</head>
<body>
    <style type="text/css">
        .ta  {border-collapse:collapse;border-spacing:0;}
            .ta td{border-color:black;border-style:hidden;border-width:1px;font-family:'Times New Roman', Times, serif;font-size:12px;
            overflow:hidden;padding:10px 5px;word-break:normal;}
            .ta th{border-color:black;border-style:solid;border-width:1px;font-family:'Times New Roman', Times, serif;font-size:12px;
            font-weight:normal;overflow:hidden;padding:10px 5px;word-break:normal;}
            .ta .ta-zv4m{border-color:#ffffff;text-align:left;vertical-align:top}
        .tb  {border-collapse:collapse;border-spacing:0;}
            .tb td{border-color:black;border-style:hidden;border-width:1px;font-family:'Times New Roman', Times, serif;font-size:12px;
                overflow:hidden;padding:10px 5px;word-break:normal;}
            .tb th{border-color:black;border-style:hidden;border-width:1px;font-family:'Times New Roman', Times, serif;font-size:18px;
                font-weight:normal;overflow:hidden;padding:10px 5px;word-break:normal;}
            .tb .tb-aw21{border-color:#ffffff;font-weight:bold;text-align:center;vertical-align:top}
        .tc  {border-collapse:collapse;border-spacing:0;}
            .tc td{border-color:black;border-style:solid;border-width:1px;font-family:'Times New Roman', Times, serif;font-size:14px;
            overflow:hidden;padding:10px 5px;word-break:normal;}
            .tc th{border-color:black;border-style:solid;border-width:1px;font-family:'Times New Roman', Times, serif;font-size:14px;
            font-weight:normal;overflow:hidden;padding:10px 5px;word-break:normal;}
            .tc .tc-baqh{text-align:center;vertical-align:center}
            .tc .tc-amwm{font-weight:bold;text-align:center;vertical-align:top}
            .tc .tc-0lax{text-align:left;vertical-align:top}
            .tc .tc-1lax{text-align:center;vertical-align:top}
        .tg  {border-collapse:collapse;border-spacing:0;}
            .tg td{border-color:black;border-style:hidden;border-width:1px;font-family:'Times New Roman', Times, serif;font-size:12px;
            overflow:hidden;padding:10px 5px;word-break:normal;}
            .tg th{border-color:black;border-style:hidden;border-width:1px;font-family:'Times New Roman', Times, serif;font-size:12px;
            font-weight:normal;overflow:hidden;padding:10px 5px;word-break:normal;}
            .tg .tg-8jgo{border-color:#ffffff;text-align:center;vertical-align:top}
    </style>
    <table class="ta">
        <thead>
            <tr>
                <td class="ta-zv4m" rowspan="2"><img src="{{ $logoBase64 }}" alt="Logo" style="max-width: 100px; max-height: 50px;">
                </td>
                <td class="ta-zv4m">PT. CITRA MARGA NUSAPHALA PERSADA, Tbk</td>
            </tr>
            <tr>
                <td class="ta-zv4m">Divisi Umum - Dept Pengadaan</td>
            </tr>
        </thead>
    </table>
    <table class="tb" width="100%">
        <thead>
            <tr>
                <th class="tb-aw21">Rekapitulasi Penilaian Kinerja Penyedia Jasa / Vendor</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td class="tb-aw21">Oleh Masing-Masing Unit Kerja</td>
            </tr>
            <tr>
                <td class="tb-aw21">Periode Tahun {{ $periodeAwal }} - {{ $periodeAkhir }}</td>
            </tr>
        </tbody>
    </table>
    <table class="tc" width="100%">
        <thead>
            <tr>
                <th class="tc-baqh" rowspan="2">No</th>
                <th class="tc-baqh" rowspan="2">Unit Kerja</th>
                <th class="tc-baqh" rowspan="2">Jumlah Form Penilaian Yang Diserahkan</th>
                <th class="tc-baqh" colspan="2">Penilaian</th>
            </tr>
            <tr>
                <th class="tc-amwm">Buruk (Tidak Layak: &le; 60)</th>
                <th class="tc-amwm">Baik (Dipertahankan: 61-100)</th>
            </tr>
            </thead>
            <tbody>
            <tr>
            @foreach ($divisions as $division)
            <tr>
                <td class="tc-1lax">{{ $loop->iteration }}</td>
                <td class="tc-0lax">{{ $division->name }}</td>
                <td class="tc-1lax">{{ $jumlahPenilaian[$division->id] }}</td>
                <td class="tc-1lax">{{ $jumlahPenilaianBuruk[$division->id] }}</td>
                <td class="tc-1lax">{{ $jumlahPenilaianBaik[$division->id] }}</td>
            </tr>
            @endforeach
            </tr>
            <tr>
                <td class="tc-amwm" colspan="2">Jumlah Total Penilaian</td>
                <td class="tc-amwm">{{ array_sum($jumlahPenilaian) }}</td>
                <td class="tc-amwm">{{ array_sum($jumlahPenilaianBuruk) }}</td>
                <td class="tc-amwm">{{ array_sum($jumlahPenilaianBaik) }}</td>
            </tr>
        </tbody>
    </table>
    <table class="tg" width="100%">
        <thead>
            <tr>
                <th class="tg-8jgo">Jakarta, {{ date('d-m-Y') }}</th>
                <th class="tg-8jgo"></th>
                <th class="tg-8jgo"></th>
                <th class="tg-8jgo"></th>
                <th class="tg-8jgo"></th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td class="tg-8jgo">Dibuat Oleh,</td>
                <td class="tg-8jgo"></td>
                <td class="tg-8jgo"></td>
                <td class="tg-8jgo"></td>
                <td class="tg-8jgo">Disetujui Oleh,</td>
            </tr>
            <tr>
                <td class="tg-8jgo"></td>
                <td class="tg-8jgo"></td>
                <td class="tg-8jgo"></td>
                <td class="tg-8jgo"></td>
                <td class="tg-8jgo"></td>
            </tr>
            <tr>
                <td class="tg-8jgo"></td>
                <td class="tg-8jgo"></td>
                <td class="tg-8jgo"></td>
                <td class="tg-8jgo"></td>
                <td class="tg-8jgo"></td>
            </tr>
            <tr>
                <td class="tg-8jgo">{{ $nameCreator }}</td>
                <td class="tg-8jgo"></td>
                <td class="tg-8jgo"></td>
                <td class="tg-8jgo"></td>
                <td class="tg-8jgo">{{ $nameSupervisor }}</td>
            </tr>
            <tr>
                <td class="tg-8jgo">{{ $positionCreator }}</td>
                <td class="tg-8jgo"></td>
                <td class="tg-8jgo"></td>
                <td class="tg-8jgo"></td>
                <td class="tg-8jgo">{{ $positionSupervisor }}</td>
            </tr>
        </tbody>
    </table>
</body>
</html>
