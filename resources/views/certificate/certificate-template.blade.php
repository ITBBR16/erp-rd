<!DOCTYPE html>
<html>
<head>
    <style>
        @page {
            margin: 0cm;
        }

        body {
            margin: 0cm;
            padding: 0cm;
            background-image: url('data:image/png;base64,{{ base64_encode(file_get_contents(public_path("img/sertifikat/new-sertifikat.jpg"))) }}');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            font-family: Arial, sans-serif;
        }

        .name {
            color: white;
            font-size: 50px;
            font-weight: bold;
            text-align: center;
            margin-top: 360px;
        }
    </style>
</head>
<body>
    <div class="name">{{ $name }}</div>
</body>
</html>
