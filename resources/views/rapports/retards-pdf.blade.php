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
        }

        .header {
            border-bottom: 3px solid #1f4e8c;
            padding-bottom: 15px;
            margin-bottom: 25px;
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
        }

        .title {
            text-align: center;
            margin: 25px 0;
        }

        .title h2 {
            color: #1f4e8c;
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
            padding: 10px;
            border: 1px solid #ddd;
        }

        td {
            padding: 10px;
            border: 1px solid #ddd;
        }

        tbody tr:nth-child(even) {
            background: #f5f7fa;
        }

        .footer {
            position: fixed;
            bottom: -10px;
            left: 0;
            right: 0;
            text-align: center;
            border-top: 2px solid #1f4e8c;
            padding-top: 8px;
            font-size: 11px;
            color: #666;
        }
    </style>
    ```

</head>

<body>

    <div class="header">

        ```
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
        ```

    </div>

    <div class="title">
        <h2>RAPPORT DES RETARDS</h2>
    </div>

    <div class="date-generation">
        Généré le : {{ now()->format('d/m/Y à H:i') }}
    </div>

    <table>

        ```
        <thead>

            <tr>
                <th>Employé</th>
                <th>Date</th>
                <th>Heure</th>
                <th>Minutes retard</th>
            </tr>

        </thead>

        <tbody>

            @foreach($retards as $retard)

            <tr>

                <td>{{ $retard->user->name ?? '-' }}</td>

                <td>
                    {{ \Carbon\Carbon::parse($retard->date)->format('d/m/Y') }}
                </td>

                <td>{{ $retard->heure }}</td>

                <td>{{ $retard->minutes_retard }} min</td>

            </tr>

            @endforeach

        </tbody>
        ```

    </table>

    <div class="footer">
        HOPE GROUPE • www.hopegroupe.com • contact.hopegroupe@gmail.com • (+229) 01 48 64 79 09
    </div>

</body>

</html>