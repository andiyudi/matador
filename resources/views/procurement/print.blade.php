<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Print Data</title>
    <style type="text/css" media="print">
        @page {
            size: A4;
            margin: 2cm;
        }
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table td, table th {
            border: 1px solid #000;
            padding: 8px;
        }
        table th {
            background-color: #f2f2f2;
        }
        .logo {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }
        .logo img {
            width: 150px;
        }
        .logo .company-name {
            font-size: 18px;
            font-weight: bold;
            margin-left: 20px;
        }
        .title {
            text-align: center;
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 20px;
        }
        .section-title {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .date-section {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <h1 class="title">FORMULIR USULAN CALON PENYEDIA JASA/VENDOR</h1>

    <table>
        <thead>
            <tr>
                <td colspan="2" rowspan="2"><img src="{{ asset ('') }}assets/logo/cmnplogo.png" alt="Logo"></td>
                <th colspan="4">PT. CITRA MARGA NUSAPHALA PERSADA Tbk.</th>
            </tr>
            <tr>
                <th colspan="4">Divisi Umum</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="6">FORMULIR</td>
            </tr>
            <tr>
                <td colspan="6">USULAN CALON PENYEDIA JASA/VENDOR</td>
            </tr>
            <tr>
                <td colspan="2">Nama Pekerjaan</td>
                <td>:</td>
                <td colspan="3">{{ $procurement->name }}</td>
            </tr>
            <tr>
                <td colspan="2">No. PP</td>
                <td>:</td>
                <td colspan="3">{{ $procurement->number }}</td>
            </tr>
            <tr>
                <td colspan="2">Waktu Pekerjaan</td>
                <td>:</td>
                <td colspan="3">{{ $procurement->estimation_time }}</td>
            </tr>
            <tr>
                <td colspan="2">Pengguna Barang/Jasa</td>
                <td>:</td>
                <td colspan="3">{{ $procurement->division }}</td>
            </tr>
            <tr>
                <td colspan="2">PIC</td>
                <td>:</td>
                <td colspan="3">{{ $procurement->person_in_charge }}</td>
            </tr>
            <tr>
                <td colspan="6"></td>
            </tr>
            <tr>
                <td colspan="6">Kualifikasi Calon Penyedia Jasa/Vendor</td>
            </tr>
            <tr>
                <td colspan="6"></td>
            </tr>
            <tr>
                <td rowspan="2">No.</td>
                <td rowspan="2">Nama Calon Penyedia Jasa/Vendor</td>
                <td colspan="4">Keterangan</td>
            </tr>
            <tr>
                <td>Status</td>
                <td>PIC</td>
                <td>No. Telp</td>
                <td>E-Mail</td>
            </tr>
            @foreach ($procurement->vendors as $vendor)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $vendor->name }}</td>
                <td>{{ $vendor->status }}</td>
                <td>{{ $vendor->director }}</td>
                <td>{{ $vendor->phone }}</td>
                <td>{{ $vendor->email }}</td>
            </tr>
            @endforeach
            <tr>
                <td colspan="2">Jakarta, {{ date('d-m-Y') }}</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td colspan="2">Penyusun Laporan</td>
                <td></td>
                <td></td>
                <td colspan="2">Menyetujui</td>
            </tr>
            <tr>
                <td colspan="2" rowspan="3">{{ $creatorName }}</td>
                <td colspan="2" rowspan="4"></td>
                <td colspan="2" rowspan="3">{{ $supervisorName }}</td>
            </tr>
            <tr>
            </tr>
            <tr>
            </tr>
            <tr>
                <td colspan="2">{{ $creatorPosition }}</td>
                <td colspan="2">{{ $supervisorPosition }}</td>
            </tr>
        </tbody>
    </table>
</body>
</html>
