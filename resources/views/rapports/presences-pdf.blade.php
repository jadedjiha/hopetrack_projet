<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            color: #333;
            font-size: 12px;
            margin: 0;
            padding: 0;
        }

        .header {
            width: 100%;
            border-bottom: 3px solid #1f4e8c;
            padding-bottom: 15px;
            margin-bottom: 30px;
        }

        .header-table {
            width: 100%;
            border-collapse: collapse;
        }

        /* Correction : Suppression des bordures sur le tableau d'en-tête */
        .header-table td {
            border: none;
            padding: 0;
        }

        .logo {
            max-width: 90px;
            height: auto;
        }

        .company {
            text-align: right;
        }

        .company h1 {
            margin: 0;
            color: #1f4e8c;
            font-size: 24px;
        }

        .company p {
            margin: 3px 0;
            font-size: 12px;
        }

        .title {
            text-align: center;
            margin-top: 30px;
            margin-bottom: 25px;
        }

        .title h2 {
            color: #1f4e8c;
            font-size: 28px;
            margin: 0;
        }

        .date-generation {
            text-align: right;
            margin-bottom: 20px;
            color: #666;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
        }

        .data-table thead {
            background: #1f4e8c;
            color: white;
        }

        .data-table th {
            padding: 12px;
            border: 1px solid #d9d9d9;
            font-weight: bold;
        }

        .data-table td {
            padding: 10px;
            border: 1px solid #d9d9d9;
        }

        .data-table tbody tr:nth-child(even) {
            background: #f5f7fa;
        }

        .footer {
            position: fixed;
            bottom: -20px;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 11px;
            color: #666;
            border-top: 2px solid #1f4e8c;
            padding-top: 8px;
        }
    </style>
</head>

<body>

    <!-- ENTETE -->
    <div class="header">
        <table class="header-table">
            <tr>
                <td style="width: 20%; vertical-align: middle;">
                    <img src="{{ public_path('image/logo-hope.png') }}" class="logo" alt="Logo">
                </td>
                <td style="width: 80%;" class="company">
                    <h1>HOPE GROUPE</h1>
                    <p>://hopegroupe.com</p>
                    <p>contact@hopegroupe.com</p>
                    <p>(+229) 01 48 64 79 09</p>
                </td>
            </tr>
        </table>
    </div>

    <!-- TITRE -->
    <div class="title">
        <h2>RAPPORT DES PRESENCES</h2>
    </div>

    <div class="date-generation">
        Généré le : {{ now()->format('d/m/Y à H:i') }}
    </div>

    <!-- TABLEAU -->
    <table class="data-table">
        <thead>
            <tr>
                <th>Employé</th>
                <th>Date</th>
                <th>Heure</th>
                <th>Type</th>
                <th>Statut</th>
                <th>Site</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pointages as $pointage)

            <tr>

                <td>{{ $pointage->user->name ?? '-' }}</td>

                <td>
                    {{ \Carbon\Carbon::parse($pointage->date)->format('d/m/Y') }}
                </td>

                <td>{{ $pointage->heure }}</td>

                <td>{{ ucfirst($pointage->type) }}</td>

                <td>{{ ucfirst($pointage->statut) }}</td>

                <td class="px-4 py-2">
                    {{ $pointage->site }}
                </td>

            </tr>

            @endforeach
        </tbody>
    </table>

    <!-- PIED DE PAGE -->
    <div class="footer">
        HOPE GROUPE • ://hopegroupe.com • contact@hopegroupe.com • (+229) 01 48 64 79 09
    </div>

</body>

</html>