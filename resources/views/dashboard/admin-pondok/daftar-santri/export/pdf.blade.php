<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 9pt;
            margin: 0.5cm;
        }

        .kop-container {
            text-align: center;
            position: relative;
            padding-bottom: 5px;
            border-bottom: 2px solid #000;
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
            width: 60px;
            height: auto;
        }

        .instansi-name {
            font-size: 13pt;
            font-weight: bold;
            margin: 0;
            text-transform: uppercase;
            line-height: 1.2;
        }

        .instansi-sub {
            font-size: 11pt;
            font-weight: bold;
            margin: 0;
            text-transform: uppercase;
            line-height: 1.2;
        }

        .alamat {
            font-size: 8pt;
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
            font-size: 9pt;
            margin-bottom: 20px;
        }

        th {
            background-color: #E2EFDA;
            border: 1px solid #000;
            padding: 5px;
            text-transform: uppercase;
        }

        td {
            border: 1px solid #000;
            padding: 4px;
            vertical-align: middle;
        }

        .text-center {
            text-align: center;
        }

        .text-capitalize {
            text-transform: capitalize;
        }

        .asrama-banner {
            margin-top: 15px;
            margin-bottom: 8px;
            background-color: #f0f0f0;
            padding: 6px;
            border: 1px solid #000;
            border-left: 5px solid #000;
        }
    </style>
</head>

<body>
    {{-- Kop Surat Dinamis Berdasarkan Auth User (Sekolah/Pondok) --}}
    <div class="kop-container">
        <img src="{{ public_path('assets/kop/logo-kop-pondok.png') }}" class="logo">

        <div class="instansi-name">YAYASAN PONDOK PESANTREN</div>

        <div class="instansi-sub">
            {{ strtoupper($namaInstansi) }} SUBULUL HUDA
        </div>

        <div class="alamat">
            {{ $instansi->alamat ?? 'Dsn. Kembangsawit, Ds. Rejosari, Kec. Kebonsari, Kab. Madiun, Jawa Timur 63173' }}
        </div>
    </div>

    <div class="title-doc">
        <h4>LAPORAN PENEMPATAN SANTRI/WATI BARU</h4>
        <p>UNIT: {{ strtoupper($namaInstansi) }} - TA {{ date('Y') }}/{{ date('Y') + 1 }}</p>
    </div>

    @foreach ($santriPerAsrama as $namaAsrama => $daftarSantri)
        <div class="asrama-banner">
            <strong style="font-size: 10pt;">GEDUNG ASRAMA: {{ strtoupper($namaAsrama) }}</strong>
        </div>

        <table>
            <thead>
                <tr>
                    <th width="5%">NO.</th>
                    <th width="15%">NIS</th>
                    <th width="35%">NAMA SANTRI</th>
                    <th width="25%">KAMAR / NO. LEMARI</th>
                    <th width="20%">UNIT SEKOLAH</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($daftarSantri as $s)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}.</td>
                        <td class="text-center">{{ $s->nis ?? '-' }}</td>
                        <td class="text-capitalize">{{ strtolower($s->pendaftar->nama_lengkap ?? '-') }}</td>
                        <td class="text-center">
                            @if ($s->romkam)
                                {{ strtoupper($s->romkam->nama_romkam) }} / NO. {{ $loop->iteration }}
                            @else
                                <span style="color: red;">Belum Diatur</span>
                            @endif
                        </td>
                        <td class="text-center">
                            {{ $s->sekolah->nama_sekolah ?? '-' }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endforeach

    <div style="margin-top: 30px; float: right; width: 250px; text-align: center; font-size: 9pt;">
        Madiun, {{ now()->translatedFormat('d F Y') }} <br>
        Mengetahui, <br>
        Admin {{ $namaInstansi }} <br><br><br><br><br>
        <strong>( ____________________ )</strong>
    </div>

    <div style="clear: both;"></div>

    <div style="margin-top: 20px; font-size: 8pt; color: #666; font-style: italic;">
        * Laporan ini dicetak secara otomatis melalui Sistem Informasi Pondok.<br>
        * Dicetak pada {{ date('d-m-Y H:i') }} WIB.
    </div>
</body>

</html>
