<!DOCTYPE html>
<html lang="en" class="scrollbar-none">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title }} | RD</title>
    <link rel="icon" href="{{ asset('/img/RD Tab Icon.png') }}" sizes="16x16 32x32" type="image/png">
    <link rel="stylesheet" href="{{ public_path('css/pdf.css') }}" type="text/css">

</head>
<body>
    <div style="margin-bottom: 1rem;">
        <div style="background-color: white; border-radius: 0.5rem; border: 1px solid #E5E7EB;">
            <div style="position: relative;">
                <table style="width: 100%; font-size: 0.875rem; text-align: left; color: #6B7280;">
                    <thead style="font-size: 0.75rem; color: #374151; text-transform: uppercase; background-color: #F3F4F6;">
                        <tr>
                            <th scope="col" style="padding: 0.5rem; width: 30%; text-align: left">Pengecekkan Fisik</th>
                            <th scope="col" style="padding: 0.5rem; width: 10%; text-align: center">Check</th>
                            <th scope="col" style="padding: 0.5rem; width: 20%; text-align: left">Kondisi</th>
                            <th scope="col" style="padding: 0.5rem; width: 40%; text-align: left">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($case->qualityControl->cekFisik as $index => $fisik)
                            <tr style="background-color: white; border-bottom: 1px solid #E5E7EB;">
                                <td style="padding: 0.5rem;">{{ $fisik->qcKategori->nama }}</td>
                                <td style="padding: 0.5rem; text-align: center;">
                                    @if ($fisik->check == 1)
                                        <img src="{{ public_path('img/check-box.png') }}" alt="Selected" style="width: 18px;">
                                    @else
                                        <img src="{{ public_path('img/unselect.png') }}" alt="Unselectd" style="width: 20px;">
                                    @endif
                                </td>
                                <td style="padding: 0.5rem;">{{ $fisik->qcKondisi->nama ?? "-" }}</td>
                                <td style="padding: 0.5rem;">{{ $fisik->keterangan ?? "-" }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    
        <div style="display: grid; grid-template-columns: repeat(3, 1fr); margin-top: 1rem;">
            {{-- Table Calibrasi --}}
            <div style="background-color: white; border-radius: 0.5rem; border: 1px solid #E5E7EB; grid-column: span 2;">
                <div style="position: relative;">
                    <table style="width: 100%; font-size: 0.875rem; text-align: left; color: #6B7280;">
                        <thead style="font-size: 0.75rem; color: #374151; text-transform: uppercase; background-color: #F3F4F6;">
                            <tr>
                                <th scope="col" style="padding: 0.5rem; width: 30%; text-align: left">Calibrasi</th>
                                <th scope="col" style="padding: 0.5rem; width: 10%; text-align: center">Check</th>
                                <th scope="col" style="padding: 0.5rem; width: 60%; text-align: left">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($case->qualityControl->cekCalibrasi as $calibrasi)
                                <tr style="background-color: white; border-bottom: 1px solid #E5E7EB;">
                                    <td style="padding: 0.5rem;">{{ $calibrasi->qcKategori->nama }}</td>
                                    <td style="padding: 0.5rem; text-align: center">
                                    @if ($calibrasi->check == 1)
                                        <img src="{{ public_path('img/check-box.png') }}" alt="Logo RD" style="width: 18px;">
                                    @else
                                        <img src="{{ public_path('img/unselect.png') }}" alt="Unselectd" style="width: 20px;">
                                    @endif
                                    </td>
                                    <td style="padding: 0.5rem;">{{ $calibrasi->keterangan ?? "-" }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            {{-- Table Firmware --}}
            <div style="grid-column: span 1; margin-left: 0.5rem; padding: 0.5rem; background-color: white;">
                <h3 style="font-size: 0.875rem; text-align: left; color: #6B7280;">Firmware Version</h3>
                <ol style="position: relative; border-left: 1px solid #E5E7EB;">
                    <li style="margin-bottom: 1rem; margin-left: 1rem;">
                        <div style="position: absolute; width: 0.75rem; height: 0.75rem; background-color: #E5E7EB; border-radius: 50%; margin-top: 0.5rem; margin-left: -22px; border: 1px solid white;"></div>
                        <p style="padding: 0.25rem; font-size: 0.75rem; font-weight: normal; color: #9CA3AF;">Aircraft</p>
                        <h3 style="padding: 0.25rem; font-size: 0.875rem; font-weight: bold; color: #111827;">{{ ($case->qualityControl->fv_aircraft) ? $case->qualityControl->fv_aircraft : '-' }}</h3>
                    </li>
                    <li style="margin-bottom: 1rem; margin-left: 1rem;">
                        <div style="position: absolute; width: 0.75rem; height: 0.75rem; background-color: #E5E7EB; border-radius: 50%; margin-top: 0.5rem; margin-left: -22px; border: 1px solid white;"></div>
                        <p style="padding: 0.25rem; font-size: 0.75rem; font-weight: normal; color: #9CA3AF;">RC</p>
                        <h3 style="padding: 0.25rem; font-size: 0.875rem; font-weight: bold; color: #111827;">{{ ($case->qualityControl->fv_rc) ? $case->qualityControl->fv_rc : '-' }}</h3>
                    </li>
                    <li style="margin-bottom: 1rem; margin-left: 1rem;">
                        <div style="position: absolute; width: 0.75rem; height: 0.75rem; background-color: #E5E7EB; border-radius: 50%; margin-top: 0.5rem; margin-left: -22px; border: 1px solid white;"></div>
                        <p style="padding: 0.25rem; font-size: 0.75rem; font-weight: normal; color: #9CA3AF;">Battery</p>
                        <h3 style="padding: 0.25rem; font-size: 0.875rem; font-weight: bold; color: #111827;">{{ ($case->qualityControl->fv_battery) ? $case->qualityControl->fv_battery : '-' }}</h3>
                    </li>
                </ol>
            </div>
        </div>
        
        <div style="background-color: white; margin-top: 1rem; padding: 1rem; border: 1px solid #E5E7EB;">
            <h3 style="font-size: 0.875rem; font-weight: bold; padding-left: 0.5rem; transform: translateY(-50%);">Kesimpulan</h3>
            <textarea rows="4" style="display: block; padding: 0.625rem; width: 100%; font-size: 0.875rem; color: #111827; border-radius: 0.5rem; border: none; background-color: white;" readonly>{{ $case->qualityControl->kesimpulan }}</textarea>
        </div>
    </div>    
</body>
</html>