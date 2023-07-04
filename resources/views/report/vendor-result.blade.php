<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Rekap Vendor</title>
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
            .tb th{border-color:black;border-style:hidden;border-width:1px;font-family:'Times New Roman', Times, serif;font-size:12px;
                font-weight:normal;overflow:hidden;padding:10px 5px;word-break:normal;}
            .tb .tb-aw21{border-color:#ffffff;font-weight:bold;text-align:center;vertical-align:top}
        .tc  {border-collapse:collapse;border-spacing:0;}
            .tc td{border-color:black;border-style:solid;border-width:1px;font-family:'Times New Roman', Times, serif;font-size:12px;
                overflow:hidden;padding:10px 5px;word-break:normal;}
            .tc th{border-color:black;border-style:solid;border-width:1px;font-family:'Times New Roman', Times, serif;font-size:12px;
                font-weight:normal;overflow:hidden;padding:10px 5px;word-break:normal;}
            .tc .tc-baqh{text-align:center;vertical-align:top}
            .tc .tc-0lax{text-align:left;vertical-align:top}
        .tg  {border-collapse:collapse;border-spacing:0;}
            .tg td{border-color:black;border-style:hidden;border-width:1px;font-family:'Times New Roman', Times, serif;font-size:12px;
                overflow:hidden;padding:10px 5px;word-break:normal;}
            .tg th{border-color:black;border-style:hidden;border-width:1px;font-family:'Times New Roman', Times, serif;font-size:12px;
                font-weight:normal;overflow:hidden;padding:10px 5px;word-break:normal;}
            .tg .tg-zv4m{border-color:#ffffff;text-align:left;vertical-align:top}
            .tg .tg-vs63{border-color:#ffffff;font-size:x-small;text-align:center;vertical-align:top}
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
                    <th class="tb-aw21">Daftar Penyedia Jasa / Vendor {{ $status }}</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td class="tb-aw21">PT. Citra Marga Nusaphala Persada, Tbk</td>
                </tr>
                <tr>
                    <td class="tb-aw21">Periode : {{ $formattedStartDate }} - {{ $formattedEndDate }}</td>
                </tr>
            </tbody>
        </table>
        <table class="tc" width="100%">
            <thead>
                <tr>
                    <th class="tc-baqh">No</th>
                    <th class="tc-baqh">Timestamp</th>
                    <th class="tc-baqh">Nama Perusahaan</th>
                    <th class="tc-baqh">Core Business</th>
                    <th class="tc-baqh">Klasifikasi</th>
                    <th class="tc-baqh">Alamat Legalitas</th>
                    <th class="tc-baqh">Alamat Domisili</th>
                    <th class="tc-baqh">Direktur/PIC</th>
                    <th class="tc-baqh">No. Telp</th>
                    <th class="tc-baqh">Email</th>
                    <th class="tc-baqh">Modal Perusahaan</th>
                </tr>
            </thead>
            <tbody>
                @if(count($vendors) > 0)
                @foreach($vendors as $key => $vendor)
                <tr>
                    <td class="tc-0lax">{{ $key + 1 }}</td>
                    <td class="tc-0lax">{{ $vendor->join_date }}</td>
                    <td class="tc-0lax">{{ $vendor->name }}</td>
                    <td class="tc-0lax">{{ $vendor->core_businesses }}</td>
                    <td class="tc-0lax">{{ $vendor->classifications }}</td>
                    <td class="tc-0lax">{{ $vendor->address }}</td>
                    <td class="tc-0lax">{{ $vendor->domicility }}</td>
                    <td class="tc-0lax">{{ $vendor->director }}</td>
                    <td class="tc-0lax">{{ $vendor->phone }}</td>
                    <td class="tc-0lax">{{ $vendor->email }}</td>
                    <td class="tc-0lax">{{ $vendor->capital }}</td>
                </tr>
                @endforeach
                @else
                <tr>
                    <td class="tc-baqh" colspan="11"><h1>Data tidak ditemukan</h1></td>
                </tr>
                @endif
            </tbody>
        </table>
        <table class="tg" width="100%">
            <thead>
                <tr>
                    <th class="tg-vs63">Jakarta, {{ date('d-m-Y') }}</th>
                    <th class="tg-zv4m"></th>
                    <th class="tg-zv4m"></th>
                    <th class="tg-zv4m"></th>
                    <th class="tg-zv4m"></th>
                    <th class="tg-zv4m"></th>
                    <th class="tg-zv4m"></th>
                    <th class="tg-zv4m"></th>
                    <th class="tg-zv4m"></th>
                    <th class="tg-zv4m"></th>
                    <th class="tg-vs63"></th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td class="tg-vs63">Dibuat Oleh,</td>
                    <td class="tg-zv4m"></td>
                    <td class="tg-zv4m"></td>
                    <td class="tg-zv4m"></td>
                    <td class="tg-zv4m"></td>
                    <td class="tg-zv4m"></td>
                    <td class="tg-zv4m"></td>
                    <td class="tg-zv4m"></td>
                    <td class="tg-zv4m"></td>
                    <td class="tg-zv4m"></td>
                    <td class="tg-vs63">Disetujui Oleh,</td>
                </tr>
                <tr>
                    <td class="tg-vs63" rowspan="2"></td>
                    <td class="tg-zv4m"></td>
                    <td class="tg-zv4m"></td>
                    <td class="tg-zv4m"></td>
                    <td class="tg-zv4m"></td>
                    <td class="tg-zv4m"></td>
                    <td class="tg-zv4m"></td>
                    <td class="tg-zv4m"></td>
                    <td class="tg-zv4m"></td>
                    <td class="tg-zv4m"></td>
                    <td class="tg-vs63" rowspan="2"></td>
                </tr>
                <tr>
                    <td class="tg-zv4m"></td>
                    <td class="tg-zv4m"></td>
                    <td class="tg-zv4m"></td>
                    <td class="tg-zv4m"></td>
                    <td class="tg-zv4m"></td>
                    <td class="tg-zv4m"></td>
                    <td class="tg-zv4m"></td>
                    <td class="tg-zv4m"></td>
                    <td class="tg-zv4m"></td>
                </tr>
                <tr>
                    <td class="tg-vs63">{{ $creatorName }}</td>
                    <td class="tg-zv4m"></td>
                    <td class="tg-zv4m"></td>
                    <td class="tg-zv4m"></td>
                    <td class="tg-zv4m"></td>
                    <td class="tg-zv4m"></td>
                    <td class="tg-zv4m"></td>
                    <td class="tg-zv4m"></td>
                    <td class="tg-zv4m"></td>
                    <td class="tg-zv4m"></td>
                    <td class="tg-vs63">{{ $supervisorName }}</td>
                </tr>
                <tr>
                    <td class="tg-vs63">{{ $creatorPosition }}</td>
                    <td class="tg-zv4m"></td>
                    <td class="tg-zv4m"></td>
                    <td class="tg-zv4m"></td>
                    <td class="tg-zv4m"></td>
                    <td class="tg-zv4m"></td>
                    <td class="tg-zv4m"></td>
                    <td class="tg-zv4m"></td>
                    <td class="tg-zv4m"></td>
                    <td class="tg-zv4m"></td>
                    <td class="tg-vs63">{{ $supervisorPosition }}</td>
                </tr>
            </tbody>
        </table>
</body>
</html>
