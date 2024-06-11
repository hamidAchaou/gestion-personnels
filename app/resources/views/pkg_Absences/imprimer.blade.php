<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>maquette d'absentéisme</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 20px;
        }

        .document-absenteisme {
            width: 100%;
        }

        .document-absenteisme table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
        }

        .document-absenteisme thead {
            background-color: #b3b325;
            color: #fff;
        }

        .document-absenteisme th,
        .document-absenteisme td {
            padding: 12px 15px;
            border: 1px solid #000;
            text-align: left;
        }

        .document-absenteisme th {
            background-color: #eeee24;
            color: #000;
            font-weight: bold;
            text-align: center;
            text-transform: capitalize;
        }

        .document-absenteisme caption {
            font-size: 1.5em;
            text-align: center;
            text-transform: uppercase;
        }

        .absenteisme-date-container {
            width: 100%;
            display: flex;
            justify-content: flex-end;
        }

        .absenteisme-date {
            width: 70%;
            font-weight: normal;
            margin-left: 70%;
        }




        page {
            background: white;
            display: block;
            margin: 0 auto;
            margin-bottom: 0.5cm;
        }

        page[size="A4"] {
            width: 21cm;
            height: 29.7cm;
            padding: 20px
        }

        page[size="A4"][layout="landscape"] {
            width: 29.7cm;
            height: 21cm;
        }

        page[size="A3"] {
            width: 29.7cm;
            height: 42cm;
        }

        page[size="A3"][layout="landscape"] {
            width: 42cm;
            height: 29.7cm;
        }

        page[size="A5"] {
            width: 14.8cm;
            height: 21cm;
        }

        page[size="A5"][layout="landscape"] {
            width: 21cm;
            height: 14.8cm;
        }

        @media print {
            body {
                font-family: Arial, sans-serif;
                background-color: #f9f9f9;
                margin: 0;
                padding: 20px;
            }
            page {
                background: white;
                margin: 0;
                box-shadow: 0;
            }

            .document-absenteisme {
                width: 100%;
            }

            .document-absenteisme table {
                width: 100%;
                border-collapse: collapse;
                background-color: #fff;
            }

            .document-absenteisme thead {
                background-color: #b3b325;
                color: #fff;
            }

            .document-absenteisme th,
            .document-absenteisme td {
                padding: 12px 15px;
                border: 1px solid #000;
                text-align: left;
            }

            .document-absenteisme th {
                background-color: #eeee24;
                color: #000;
                font-weight: bold;
                text-align: center;
                text-transform: capitalize;
            }

            .document-absenteisme caption {
                font-size: 1.5em;
                text-align: center;
                text-transform: uppercase;
            }

            .absenteisme-date-container {
                width: 100%;
                display: flex;
                justify-content: flex-end;
            }

            .absenteisme-date {
                width: 70%;
                font-weight: normal;
                margin-left: 70%;
            }
        }

    </style>
</head>

<body>
    <page size="A4">

        <div class="document-absenteisme">
            <table>
                <caption>maquette d'absentéisme</caption>
            </table>
            <div class="absenteisme-date-container">
                @php
                    use Carbon\Carbon;
                    $formattedDate = strtolower(Carbon::now()->locale('fr_FR')->isoFormat('MMM-YY'));
                @endphp
                <span class="absenteisme-date">{{ $formattedDate }}</span>
            </div>
            <table style="font-size: 12px;">
                <thead>
                    <tr>
                        <th>Matricule</th>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Motif</th>
                        <th>Date début</th>
                        <th>Date fin</th>
                        <th>Durée absence</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($absences as $absence)
                        <tr>
                            <td>{{ $absence->personnel->matricule }}</td>
                            <td>{{ $absence->personnel->nom }}</td>
                            <td>{{ $absence->personnel->prenom }}</td>
                            <td>{{ $absence->motif->nom }}</td>
                            <td>{{ $absence->date_debut }}</td>
                            <td>{{ $absence->date_fin }}</td>
                            <td>{{ App\Helpers\pkg_Absences\AbsenceHelper::calculateAbsenceDurationForPersonnel($absence) }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">Aucune absence ñ'a</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </page>
    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</body>

</html>
