<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $title }}</title>
        <style>
            .certificate {
                padding: 30px 60px;
                text-align: center;
            }
            .certificate-title {
                font-size: 2em;
                margin-bottom: 15px;
            }
            .certificate-user {
                font-size: 1.3em;
                margin-top: 20px;
                margin-bottom: 30px;
            }
            .certificate-logo {
                max-width: 200px;
                height: auto;
            }
            @page {
                margin: 0px;
            }
            body {
                margin: 0px;
            }
            .certificado-footer{
                position: fixed;
                bottom: 0;
                background-color: white;
                width: 100%;
                height: 200px;
            }
        </style>
    </head>
    <body style="font-family: Arial, Helvetica, sans-serif; color: white; background-color: #60278B;">
        <div class="certificate">
            <img class="certificate-logo" src="{{ public_path('img/logoGTA.png') }}" alt="Logo">
            <h1 class="certificate-title">Certificado de Participación</h1>
            <p class="certificate-user">Se otorga el presente diploma a {{ $user->name }} por su destacada participación en el Gamerfest 2024, el evento más importante de videojuegos del año, donde demostró sus habilidades y pasión por los siguientes juegos:
            @foreach($inscripciones as $inscripcion)
                {{ $inscripcion['juego_nombre'] }} ({{ $inscripcion['tipo'] }})
            @endforeach
            </p>
            @if($esGanador)
                <p>Felicitaciones! Has obtenido el puesto {{ $posicionGanador }} en uno de los juegos.</p>
            @endif
            <p>Este diploma reconoce su esfuerzo, dedicación y entusiasmo por el mundo gamer, así como su contribución a la diversión y el aprendizaje de todos los asistentes.</p>
            <p>¡Felicidades y gracias por formar parte de esta gran aventura!</p>
            @php
                setlocale(LC_TIME, 'es_ES.UTF-8');
            @endphp

            <!-- Resto del código de tu vista Blade -->
            <p class="certificate-footer">{{ \Carbon\Carbon::parse(date('Y-m-d'))->locale('es')->isoFormat('LL') }}</p>
        </div>
        <div class="certificado-footer">
            <img class="certificate-sponsors" src="{{ public_path('img/sponsors-footer.png') }}" alt="Logo">
        </div>
    </body>
</html>
