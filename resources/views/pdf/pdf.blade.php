<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Surat PDF</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        .header { font-size: 20px; font-weight: bold; margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="header">Detail Surat</div>
    <p><strong>Nomor Surat:</strong> {{ $surat->nomor }}</p>
    <p><strong>Judul:</strong> {{ $surat->judul }}</p>
    <p><strong>Tanggal:</strong> {{ $surat->tanggal }}</p>
    <p><strong>Isi:</strong></p>
    <div>{!! nl2br(e($surat->isi)) !!}</div>
</body>
</html>
