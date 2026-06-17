<!DOCTYPE html>

<html>

<head>
    <meta charset="utf-8">

    ```
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
        }

        .logo {
            width: 90px;
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

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead {
            background: #1f4e8c;
            color: white;
        }

        th {
            padding: 12px;
            border: 1px solid #d9d9d9;
        }

        td {
            padding: 10px;
            border: 1px solid #d9d9d9;
        }

        tbody tr:nth-child(even) {
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
    ```

</head>

<body>

    ```
    <!-- ENTETE -->

    <div class="header">

        <table class="header-table">

            <tr>

                <td width="20%">
                    <img src="{{ public_path('image/logo-hope.png') }}" class="logo">
                </td>

                <td width="80%" class="company">

                    <h1>HOPE GROUPE</h1>

                    <p>www.hopegroupe.com</p>

                    <p>contact.hopegroupe@gmail.com</p>

                    <p>(+229) 01 48 64 79 09</p>

                </td>

            </tr>

        </table>

    </div>

    <!-- TITRE -->

    <div class="title">
        <h2>RAPPORT DES CONGÉS</h2>
    </div>

    <div class="date-generation">
        Généré le : {{ now()->format('d/m/Y à H:i') }}
    </div>

    <!-- TABLEAU -->

    <table>

        <thead>

            <tr>
                <th>Employé</th>
                <th>Type</th>
                <th>Motif</th>
                <th>Date début</th>
                <th>Date fin</th>
                <th>Statut</th>
            </tr>

        </thead>

        <tbody>

            @foreach($conges as $conge)

            <tr>

                <td>{{ $conge->user->name ?? '-' }}</td>
                <td>{{ ucfirst($conge->type) }}</td>
                <td>{{ $conge->motif }}</td>
                <td>{{ \Carbon\Carbon::parse($conge->date_debut)->format('d/m/Y') }}</td>
                <td>{{ \Carbon\Carbon::parse($conge->date_fin)->format('d/m/Y') }}</td>
                <td>{{ ucfirst($conge->statut) }}</td>

            </tr>

            @endforeach

        </tbody>

    </table>

    <!-- PIED DE PAGE -->

    <div class="footer">

        HOPE GROUPE • www.hopegroupe.com • contact.hopegroupe@gmail.com • (+229) 01 48 64 79 09

    </div>
    ```

</body>

</html>