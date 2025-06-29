<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salinan Resep</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            border: 1px solid black;
            padding: 20px;
            margin-top: 600px;
            font-size: 10px;
        }
        .kop-surat {
            text-align: center;
            margin-bottom: 10px;
            padding-bottom: 5px;
            position: relative;
        }
        .kop-surat img {
            position: absolute;
            top: 0;
            border: none;
        }
        .kop-surat .left-logo {
            left: 0;
            width: 40px;
        }
        .kop-surat .right-logo {
            right: 0;
            width: 55px;
        }
        .kop-surat h1, .kop-surat p {
            margin: 0;
        }
        .kop-surat .small-text {
            font-size: 10px;
        }
        .kop-surat .large-text {
            font-size: 16px;
            font-weight: bold;
        }
        .kop-surat .smaller-text {
            font-size: 8px;
        }
        .kop-surat .title {
            font-weight: bold;
            margin-top: 5px;
        }
        .content {
            margin-top: 10px;
            padding-top: 10px;
        }
        .info {
            margin-bottom: 10px;
            display: flex;
            flex-direction: column;
            gap: 3px;
        }
        .info-item {
            display: flex;
            justify-content: flex-start;
        }
        .info-item .label {
            width: 100px;
            font-weight: bold;
        }
        .info-item .colon {
            width: 5px;
        }
        .info-item .value {
            flex-grow: 1;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid black;
            padding: 4px;
            text-align: left;
        }
        th {
            background-color: #d3d3d3;
            color: black;
        }
        .footer-message {
            margin-top: 20px;
            font-size: 10px;
            text-align: center;
            font-weight: bold;
        }
        @media print {
            th {
                background-color: #d3d3d3 !important;
            }
            .no-print {
                display: none;
            }
            body {
                font-size: 8px;
            }
        }
    </style>
</head>
<body>
    <div class="kop-surat">
        <img src="{{ asset('images/left-logo.png') }}" alt="Logo Kiri" class="left-logo">
        <img src="{{ asset('images/right-logo.png') }}" alt="Logo Kanan" class="right-logo">
        <p class="small-text">PEMERINTAH KABUPATEN BANJARNEGARA</p>
        <p class="small-text">DINAS KESEHATAN</p>
        <p class="large-text">UPTD PUSKESMAS PURWANEGARA 1</p>
        <p class="smaller-text">Jln. Desa Kalipelus Rt.03/Rw.02 Telepon (0286) 5988540</p>
        <p class="smaller-text">Email: puskesmas.purwanegara1@gmail.com</p>
        <p class="small-text">BANJARNEGARA 53472</p>
        <hr>
        <div class="title">SALINAN RESEP</div>
        <p>Purwanegara, {{ \Carbon\Carbon::parse($history->taken_at)->translatedFormat('d F Y') }}</p>
    </div>

    <div class="content">
        <div class="info">
            <div class="info-item">
                <div class="label">No. Resep</div>
                <div class="colon">:</div>
                <div class="value">{{ $prescription->prescription_number }}</div>
            </div>
            <div class="info-item">
                <div class="label">Nama Pasien</div>
                <div class="colon">:</div>
                <div class="value">{{ $prescription->patient->name }}</div>
            </div>
            <div class="info-item">
                <div class="label">No BPJS</div>
                <div class="colon">:</div>
                <div class="value">{{ $prescription->patient->no_bpjs }}</div>
            </div>
            <div class="info-item">
                <div class="label">Alamat</div>
                <div class="colon">:</div>
                <div class="value">{{ $prescription->patient->address }}</div>
            </div>
            <div class="info-item">
                <div class="label">Penyakit</div>
                <div class="colon">:</div>
                <div class="value">{{ $prescription->diseases->pluck('name')->join(', ') }}</div>
            </div>
            <div class="info-item">
                <div class="label">Petugas</div>
                <div class="colon">:</div>
                <div class="value">{{ $doctorModel->name }}</div>
            </div>
        </div>

        <h3>Daftar Obat</h3>
        <table>
            <thead>
                <tr>
                    <th>Nama Obat</th>
                    <th>Jumlah</th>
                    <th>Dosis</th>
                    <th>Catatan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($prescription->medicines as $medicine)
                    <tr>
                        <td>{{ $medicine->name }}</td>
                        <td>{{ $medicine->pivot->quantity }}</td>
                        <td>{{ $medicine->pivot->dosage }}</td>
                        <td>{{ $medicine->pivot->notes }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        @if($prescription->notes)
            <div class="mt-6">
                <h3>Catatan Resep</h3>
                <p>{{ $prescription->notes }}</p>
            </div>
        @endif
    </div>

    <div class="footer-message">
        Obat tsb, tidak boleh diganti tanpa sepengetahuan Dokter.
    </div>

    <script>
        window.onload = function() {
            window.print();
        };
    </script>
</body>
</html>
