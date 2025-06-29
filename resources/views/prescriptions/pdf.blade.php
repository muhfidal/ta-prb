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
        }
        .kop-surat {
            text-align: center;
            border-bottom: 2px solid black;
            margin-bottom: 20px;
            padding-bottom: 10px;
            position: relative;
        }
        .kop-surat img {
            width: 50px;
            position: absolute;
            top: 0;
            border: none;
        }
        .kop-surat .left-logo {
            left: 0;
        }
        .kop-surat .right-logo {
            right: 0;
        }
        .kop-surat h1, .kop-surat p {
            margin: 0;
        }
        .kop-surat .title {
            font-weight: bold;
            margin-top: 10px;
        }
        .content {
            margin-top: 20px;
        }
        .content .info {
            margin-bottom: 20px;
        }
        .content .info p {
            margin: 5px 0;
        }
    </style>
</head>
<body>
    <div class="kop-surat">
        <img src="{{ public_path('images/left-logo.png') }}" alt="Logo Kiri" class="left-logo">
        <img src="{{ public_path('images/right-logo.png') }}" alt="Logo Kanan" class="right-logo">
        <h1>PEMERINTAH KABUPATEN BANJARNEGARA</h1>
        <p>DINAS KESEHATAN</p>
        <p>UPTD PUSKESMAS PURWANEGARA 1</p>
        <p>Jln. Desa Kalipelus Rt.03/Rw.02 Telepon (0286) 5988540</p>
        <p>Email: puskesmas.purwanegara1@gmail.com</p>
        <p>BANJARNEGARA 53472</p>
        <hr>
        <div class="title">SALINAN RESEP</div>
        <p>Purwanegara, {{ \Carbon\Carbon::parse($validated['taken_at'])->format('d F Y') }}</p>
    </div>

    <div class="content">
        <div class="info">
            <p><strong>Nama Pasien:</strong> {{ $patient->name }}</p>
            <p><strong>No BPJS:</strong> {{ $patient->no_bpjs }}</p>
            <p><strong>Alamat:</strong> {{ $patient->address }}</p>
            <p><strong>Penyakit:</strong> {{ $patient->diseases->pluck('name')->join(', ') }}</p>
            <p><strong>Obat:</strong> {{ $patient->medicines->pluck('name')->join(', ') }}</p>
            <p><strong>Dokter:</strong> {{ $doctor->name }}</p>
        </div>
    </div>
</body>
</html>
