<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 9pt; /* Diperkecil dari 11pt */
            margin: 0.5cm;
        }

        .kop-container {
            text-align: center;
            position: relative;
            padding-bottom: 5px;
            border-bottom: 2px solid #000; /* Garis lebih tipis */
            margin-bottom: 10px;
        }

        .kop-container:after {
            content: '';
            display: block;
            margin-top: 2px;
            border-bottom: 1px solid #000;
        }

        .logo {
            position: absolute;
            left: 0;
            top: 0;
            width: 60px; /* Diperkecil dari 80px */
            height: auto;
        }

        .instansi-name {
            font-size: 13pt; /* Diperkecil dari 16pt */
            font-weight: bold;
            margin: 0;
            text-transform: uppercase;
            line-height: 1.2;
        }

        .instansi-sub {
            font-size: 11pt; /* Diperkecil dari 14pt */
            font-weight: bold;
            margin: 0;
            text-transform: uppercase;
            line-height: 1.2;
        }

        .alamat {
            font-size: 8pt; /* Diperkecil agar muat 1 baris */
            margin: 2px 0 0 0;
        }

        .title-doc {
            text-align: center;
            margin-top: 10px;
            margin-bottom: 10px;
        }

        .title-doc h4 {
            font-size: 11pt;
            margin: 0;
            text-transform: uppercase;
            text-decoration: underline;
        }

        .title-doc p {
            margin: 2px 0;
            font-weight: bold;
            font-size: 9pt;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 9pt; /* Memastikan isi tabel kecil */
        }

        th {
            background-color: #E2EFDA;
            border: 1px solid #000;
            padding: 3px; /* Padding diperkecil */
            font-size: 9pt;
            text-transform: uppercase;
        }

        td {
            border: 1px solid #000;
            padding: 2px 4px; /* Padding baris diperkecil agar hemat tempat */
            font-size: 9pt;
            vertical-align: middle;
        }

        .text-center {
            text-align: center;
        }

        .text-capitalize {
            text-transform: capitalize;
        }

        .gender-header {
            background-color: #f2f2f2;
            font-weight: bold;
            text-align: center;
            font-size: 9pt;
            padding: 4px;
        }
    </style>
</head>

<body>
    <div class="kop-container">
        <img src="{{ public_path('assets/kop/logo-kop-pondok.png') }}" class="logo">
        
        <div class="instansi-name">YAYASAN PONDOK PESANTREN</div>
        <div class="instansi-sub">SUBULUL HUDA KEMBANGSAWIT</div>
        
        <div class="alamat">
            Dsn. Kembangsawit, Ds. Rejosari, Kec. Kebonsari, Kab. Madiun, Jawa Timur 63173
        </div>
    </div>

    <div class="title-doc">
        <h4>DATA SANTRI/WATI</h4>
        <p>TAHUN AJARAN {{ date('Y') }}/{{ date('Y') + 1 }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th width="4%">No.</th> <th width="12%">NIS</th>
                <th width="30%">Nama Santri/wati</th>
                <th width="15%">Asrama</th>
                <th width="19%">Kamar / No</th>
                <th width="20%">Sekolah</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="6" class="gender-header">LAKI-LAKI</td>
            </tr>
            @foreach ($santris as $s)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}.</td>
                    <td class="text-center">{{ $s->nis ?? '-' }}</td>
                    <td class="text-capitalize">{{ strtolower($s->pendaftar->nama_lengkap ?? '-') }}</td>
                    <td class="text-center text-capitalize">
                        {{ $s->romkam && $s->romkam->asrama ? strtolower($s->romkam->asrama->nama_asrama) : '-' }}
                    </td>
                    <td class="text-center text-capitalize">
                        @if ($s->romkam)
                            {{ strtolower($s->romkam->nama_romkam) }} / no.
                            {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}
                        @else
                            -
                        @endif
                    </td>
                    <td class="text-center">
                        {{ $s->sekolah->nama_sekolah ?? '-' }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table> 
</body>
</html>