<x-mail::message>
{{-- Logo --}}
<center>
<img src="{{ asset('img/gamerfest.png') }}" alt="Logo" style="width: 150px; height: auto; margin: 0.5em;">
</center>

{{-- Saludo --}}
@if (! empty($greeting))
# {{ $greeting }}
@else
@if ($level === 'error')
# ¡Ups!
@else
# ¡Hola!
@endif
@endif

{{-- Líneas de introducción --}}
@foreach ($introLines as $line)
{{ $line }}

@endforeach

{{-- Botón de acción --}}
@isset($actionText)
<?php
    $color = match ($level) {
        'success', 'error' => $level,
        default => 'primary',
    };
?>
<x-mail::button :url="$actionUrl" :color="$color">
{{ $actionText }}
</x-mail::button>
@endisset

{{-- Líneas de cierre --}}
@foreach ($outroLines as $line)
{{ $line }}

@endforeach

{{-- Despedida --}}
@if (! empty($salutation))
{{ $salutation }}
@else
Saludos,<br>
{{ config('app.name') }}
@endif

{{-- Copia --}}
@isset($actionText)
<x-slot:subcopy>
Si tienes problemas para hacer clic en el botón "{{ $actionText }}", copia y pega la URL de abajo
en tu navegador web: <span class="break-all">[{{ $displayableActionUrl }}]({{ $actionUrl }})</span>
</x-slot:subcopy>
@endisset
</x-mail::message>
