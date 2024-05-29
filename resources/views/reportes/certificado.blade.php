<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Certificado Gamerfest</title>
        <style>
            body {
                font-family: Arial, Helvetica, sans-serif;
                margin: 0;
                padding: 60px;
                color: black;
            }
            .header {
                display: flex;
                justify-content: start;
                align-items: center;
                margin-bottom: 60px;
            }
            .header .logo {
                width: 100px;
                height: auto;
                margin-right: 20px;
            }
            .header .title {
                font-size: 2em;
            }
            .content {
                font-size: 1.1em;
                margin-bottom: 60px;
            }
            .footer {
                display: flex;
                justify-content: space-between;
            }
            .footer .signature {
                border-bottom: 1px solid black;
                width: 200px;
                text-align: center;
            }
            @page {
                margin: 0;
            }
        </style>
    </head>
    <body>
        <div class="header">
            <img class="logo" src="{{ public_path('img/logoGTA.png') }}" alt="Logo">
            <div>
                <h1 class="title">Certificado Gamerfest</h1>
                <p>Latacunga, {{ \Carbon\Carbon::now()->locale('es')->isoFormat('LL') }}</p>
            </div>
        </div>
        <div class="content">
            <p>Por medio de la presente se certifica que <strong>{{ $user->name }}</strong> participó en el Gamerfest 2024, uno de los eventos más destacados en el ámbito de los videojuegos durante este año.</p>
            <p>La participación de {{ $user->name }} incluyó los siguientes juegos:</p>
            <ul>
                @foreach($inscripciones as $inscripcion)
                    <li>{{ $inscripcion['juego_nombre'] }} ({{ $inscripcion['tipo'] }})</li>
                @endforeach
            </ul>
            <p>Agradecemos a {{ $user->name }} por su dedicación y entusiasmo en la comunidad gamer y esperamos contar con su presencia en futuros eventos.</p>
        </div>
        <div class="footer">
            <div class="signature">
                <img src="{{ public_path('img/firma.png') }}" width="150px" alt="Firma">
            </div>
            <p style="text-align: center;">Staff Gamerfest</p>
        </div>
    </body>
</html>
