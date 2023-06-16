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
        .tg  {border-collapse:collapse;border-spacing:0;}
        .tg td{border-color:black;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:14px;
        overflow:hidden;padding:10px 5px;word-break:normal;}
        .tg th{border-color:black;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:14px;
        font-weight:normal;overflow:hidden;padding:10px 5px;word-break:normal;}
        .tg .tg-zv4m{border-color:#ffffff;text-align:left;vertical-align:top}
        .tg .tg-v6d6{border-color:#ffffff;font-size:small;text-align:left;vertical-align:top}
        .tg .tg-t0vf{border-color:#ffffff;font-size:100%;text-align:left;vertical-align:top}
        .tg .tg-7u00{border-color:#ffffff;font-size:large;text-align:center;vertical-align:top}

        .tb  {border-collapse:collapse;border-spacing:0;}
        .tb td{border-color:black;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:14px;
        overflow:hidden;padding:10px 5px;word-break:normal;}
        .tb .tb-0pky{border-color:inherit;text-align:left;vertical-align:top}

        .ti  {border-collapse:collapse;border-spacing:0;}
        .ti td{border-color:black;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:14px;
        overflow:hidden;padding:10px 5px;word-break:normal;}
        .ti th{border-color:black;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:14px;
        font-weight:normal;overflow:hidden;padding:10px 5px;word-break:normal;}
        .ti .ti-1wig{font-weight:bold;text-align:left;vertical-align:top}
        .ti .ti-wa1i{font-weight:bold;text-align:center;vertical-align:middle}
        .ti .ti-amwm{font-weight:bold;text-align:center;vertical-align:top}
        .ti .ti-0lax{text-align:left;vertical-align:top}

        .tz  {border-collapse:collapse;border-spacing:0;}
        .tz td{border-color:black;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:14px;
        overflow:hidden;padding:10px 5px;word-break:normal;}
        .tz th{border-color:black;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:14px;
        font-weight:normal;overflow:hidden;padding:10px 5px;word-break:normal;}
        .tz .tz-zv4m{border-color:#ffffff;text-align:left;vertical-align:top}
    </style>
        <table class="tg" width="100%">
            <thead>
                <tr>
                    <th class="tg-zv4m" colspan="2" rowspan="2"><img src="{{ $logoBase64 }}" alt="Logo" style="max-width: 100px; max-height: 50px;"></th>
                    <th class="tg-t0vf" colspan="4">PT. CITRA MARGA NUSAPHALA PERSADA Tbk.</th>
                </tr>
                <tr>
                    <th class="tg-v6d6" colspan="4">Divisi Umum</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="tg-7u00" colspan="6">FORMULIR</td>
                </tr>
                <tr>
                    <td class="tg-7u00" colspan="6">USULAN CALON PENYEDIA JASA/VENDOR</td>
                </tr>
            </tbody>
        </table>
        <br>
        <table class="tb" width="100%">
            <tbody>
                <tr>
                    <td class="tb-0pky" width=22%>Nama Pekerjaan</td>
                    <td class="tb-0pky" width=3%>:</td>
                    <td class="tb-0pky" colspan="4">{{ $procurement->name }}</td>
                </tr>
                <tr>
                    <td class="tb-0pky" width=22%>No. PP</td>
                    <td class="tb-0pky" width=3%>:</td>
                    <td class="tb-0pky" colspan="4">{{ $procurement->number }}</td>
                </tr>
                <tr>
                    <td class="tb-0pky" width=22%>Waktu Pekerjaan</td>
                    <td class="tb-0pky" width=3%>:</td>
                    <td class="tb-0pky" colspan="4">{{ $procurement->estimation_time }}</td>
                </tr>
                <tr>
                    <td class="tb-0pky" width=22%>Pengguna Barang/Jasa</td>
                    <td class="tb-0pky" width=3%>:</td>
                    <td class="tb-0pky" colspan="4">{{ $procurement->division->name }}</td>
                </tr>
                <tr>
                    <td class="tb-0pky" width=22%>P.I.C</td>
                    <td class="tb-0pky" width=3%>:</td>
                    <td class="tb-0pky" colspan="4">{{ $procurement->person_in_charge }}</td>
                </tr>
            </tbody>
        </table>
        <br>
        <table class="ti" width="100%">
            <thead>
                <tr>
                    <th class="ti-amwm" colspan="6">Kualifikasi Calon Penyedia Jasa/Vendor</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="ti-wa1i" rowspan="2">No.</td>
                    <td class="ti-wa1i" rowspan="2">Nama Calon Penyedia Jasa/Vendor</td>
                    <td class="ti-amwm" colspan="4">Keterangan</td>
                </tr>
                <tr>
                    <td class="ti-1wig">Status</td>
                    <td class="ti-1wig">PIC</td>
                    <td class="ti-1wig">No. Telp.</td>
                    <td class="ti-1wig">Email</td>
                </tr>
                @foreach ($procurement->vendors as $vendor)
                <tr>
                    <td class="ti-0lax">{{ $loop->iteration }}</td>
                    <td class="ti-0lax">{{ $vendor->name }}</td>
                    <td class="ti-0lax">
                        @if($vendor->status == 0)
                        Registered
                        @elseif($vendor->status == 1)
                            Active
                        @elseif($vendor->status == 2)
                            Expired
                        @else
                            Rekanan
                        @endif
                    </td>
                    <td class="ti-0lax">{{ $vendor->director }}</td>
                    <td class="ti-0lax">{{ $vendor->phone }}</td>
                    <td class="ti-0lax">{{ $vendor->email }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <br>
        <table class="tz" width="100%">
            <thead>
                <tr>
                    <th class="tz-zv4m" colspan="6">Jakarta, {{ date('d-m-Y') }}</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="tz-zv4m" colspan="3" width="50%">Penyusun Laporan</td>
                    <td class="tz-zv4m" colspan="3" width="50%">Menyetujui</td>
                </tr>
                <tr>
                    <td class="tz-zv4m" colspan="3" rowspan="5"></td>
                    <td class="tz-zv4m" colspan="3" rowspan="5"></td>
                </tr>
                <tr>
                </tr>
                <tr>
                </tr>
                <tr>
                </tr>
                <tr>
                </tr>
                <tr>
                    <td class="tz-zv4m" colspan="3">{{ $creatorName }}</td>
                    <td class="tz-zv4m" colspan="3">{{ $supervisorName }}</td>
                </tr>
                <tr>
                    <td class="tz-zv4m" colspan="3">{{ $creatorPosition }}</td>
                    <td class="tz-zv4m" colspan="3">{{ $supervisorPosition }}</td>
                </tr>
            </tbody>
        </table>
    </body>
</html>
