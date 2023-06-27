<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <style type="text/css">
        .ta  {border-collapse:collapse;border-spacing:0;}
            .ta td{border-color:black;border-style:solid;border-width:1px;font-family:'Times New Roman', Times, serif;font-size:12px;
            overflow:hidden;padding:10px 5px;word-break:normal;}
            .ta th{border-color:black;border-style:solid;border-width:1px;font-family:'Times New Roman', Times, serif;font-size:12px;
            font-weight:normal;overflow:hidden;padding:10px 5px;word-break:normal;}
            .ta .ta-zv4m{border-color:#ffffff;text-align:left;vertical-align:top}
        .tb  {border-collapse:collapse;border-spacing:0;}
            .tb td{border-color:black;border-style:solid;border-width:1px;font-family:'Times New Roman', Times, serif;font-size:12px;
                overflow:hidden;padding:10px 5px;word-break:normal;}
            .tb th{border-color:black;border-style:solid;border-width:1px;font-family:'Times New Roman', Times, serif;font-size:18px;
                font-weight:normal;overflow:hidden;padding:10px 5px;word-break:normal;}
            .tb .tb-aw21{border-color:#ffffff;font-weight:bold;text-align:center;vertical-align:top}
        .tc  {border-collapse:collapse;border-spacing:0;}
            .tc td{border-color:black;border-style:solid;border-width:1px;font-family:'Times New Roman', Times, serif;font-size:12px;
            overflow:hidden;padding:10px 5px;word-break:normal;}
            .tc th{border-color:black;border-style:solid;border-width:1px;font-family:'Times New Roman', Times, serif;font-size:12px;
            font-weight:normal;overflow:hidden;padding:10px 5px;word-break:normal;}
            .tc .tc-yxfa{font-size:x-small;text-align:center;vertical-align:middle}
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
                <th class="tb-aw21">REKAPITULASI FORMULIR PENILAIAN PENYEDIA JASA / VENDOR</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td class="tb-aw21">Terhadap PT. Citra Marga Nusaphala Persada, Tbk</td>
            </tr>
            <tr>
                <td class="tb-aw21">Periode Tahun {{ $periodeAwal }} - {{ $periodeAkhir }}</td>
            </tr>
        </tbody>
    </table>
    <table class="tc" width="100%">
        <thead>
            <tr>
                <th class="tc-yxfa" rowspan="3">No</th>
                <th class="tc-yxfa" rowspan="3">Nama Perusahaan</th>
                <th class="tc-yxfa" rowspan="3">Core Business</th>
                <th class="tc-yxfa" rowspan="3">Grade</th>
                <th class="tc-yxfa" rowspan="3">Jumlah Penilaian Pekerjaan</th>
                <th class="tc-yxfa" colspan="3">Nilai Pekerjaan</th>
                <th class="tc-yxfa" colspan="15">Hasil Penilaian Complain Vendor</th>
            </tr>
            <tr>
                <th class="tc-yxfa" rowspan="2">0 s.d &lt; 100 Jt</th>
                <th class="tc-yxfa" rowspan="2">&ge; 100 Jt s.d &lt; 1 Miliar</th>
                <th class="tc-yxfa" rowspan="2">&ge; 1 Miliar</th>
                <th class="tc-yxfa" colspan="3">Penerbitan Kontrak / PO</th>
                <th class="tc-yxfa" colspan="3">Pelaksanaan Pekerjaan (Koordinasi)</th>
                <th class="tc-yxfa" colspan="3">Pengajuan &amp; Pelaksanaan PHO</th>
                <th class="tc-yxfa" colspan="3">Pengajuan &amp; Pelaksanaan FHO</th>
                <th class="tc-yxfa" colspan="3">Pengajuan Invoice &amp; Real Pembayaran</th>
            </tr>
            <tr>
                <th class="tc-yxfa">Cepat</th>
                <th class="tc-yxfa">Lama</th>
                <th class="tc-yxfa">Sangat Lama</th>
                <th class="tc-yxfa">Mudah</th>
                <th class="tc-yxfa">Sulit</th>
                <th class="tc-yxfa">Sangat Sulit</th>
                <th class="tc-yxfa">Cepat</th>
                <th class="tc-yxfa">Lama</th>
                <th class="tc-yxfa">Sangat Lama</th>
                <th class="tc-yxfa">Cepat</th>
                <th class="tc-yxfa">Lama</th>
                <th class="tc-yxfa">Sangat Lama</th>
                <th class="tc-yxfa">Cepat</th>
                <th class="tc-yxfa">Lama</th>
                <th class="tc-yxfa">Sangat Lama</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($vendorData as $index => $data)
            <tr>
                <td class="tc-yxfa">{{ $loop->iteration }}</td>
                <td class="tc-yxfa">{{ $data['nama_perusahaan'] }}</td>
                <td class="tc-yxfa">{{ $data['core_business'] }}</td>
                <td class="tc-yxfa">{{ $data['grade'] }}</td>
                <td class="tc-yxfa">{{ $jumlahPenilaian }}</td>
                <td class="tc-yxfa"></td>
                <td class="tc-yxfa"></td>
                <td class="tc-yxfa"></td>
                <td class="tc-yxfa"></td>
                <td class="tc-yxfa"></td>
                <td class="tc-yxfa"></td>
                <td class="tc-yxfa"></td>
                <td class="tc-yxfa"></td>
                <td class="tc-yxfa"></td>
                <td class="tc-yxfa"></td>
                <td class="tc-yxfa"></td>
                <td class="tc-yxfa"></td>
                <td class="tc-yxfa"></td>
                <td class="tc-yxfa"></td>
                <td class="tc-yxfa"></td>
                <td class="tc-yxfa"></td>
                <td class="tc-yxfa"></td>
                <td class="tc-yxfa"></td>
            </tr>
            @endforeach
            <tr>
                <td class="tc-yxfa" colspan="4">Jumlah Total</td>
                <td class="tc-yxfa"></td>
                <td class="tc-yxfa"></td>
                <td class="tc-yxfa"></td>
                <td class="tc-yxfa"></td>
                <td class="tc-yxfa"></td>
                <td class="tc-yxfa"></td>
                <td class="tc-yxfa"></td>
                <td class="tc-yxfa"></td>
                <td class="tc-yxfa"></td>
                <td class="tc-yxfa"></td>
                <td class="tc-yxfa"></td>
                <td class="tc-yxfa"></td>
                <td class="tc-yxfa"></td>
                <td class="tc-yxfa"></td>
                <td class="tc-yxfa"></td>
                <td class="tc-yxfa"></td>
                <td class="tc-yxfa"></td>
                <td class="tc-yxfa"></td>
                <td class="tc-yxfa"></td>
            </tr>
        </tbody>
    </table>
</body>
</html>
