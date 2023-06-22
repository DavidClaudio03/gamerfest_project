<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Reporte Inscripciones Individuales</title>
    </head>
    <body style="font-family: Arial, Helvetica, sans-serif;">
        <div class="report-header" style="text-align: center;">
            <h2>{{ $title }}</h2>
        </div>
        <div class="game-card" style="margin-bottom: 1em;">
            <h3 style="font-size: 1.2em;">Número de participantes: {{ count($inscripciones) }}</h3>
        </div>
        <table style="width: 100%; border-collapse: collapse;" border="1">
            <thead>
                <tr>
                    <th>Nombre de Usuario</th>
                    <th>Teléfono</th>
                    <th>Estado del Pago</th>
                    <th>Asistencia</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($inscripciones as $inscripcion)
                    <tr>
                        <td>{{ $inscripcion->name }}</td>
                        <td>{{ $inscripcion->phone }}</td>
                        <td>{{ $inscripcion->estado_pago }}</td>
                        <td></td> <!-- Columna de asistencia -->
                    </tr>
                @endforeach
            </tbody>
        </table>
    </body>
</html>
