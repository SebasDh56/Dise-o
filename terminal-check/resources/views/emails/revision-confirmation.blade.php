<!DOCTYPE html>
<html>
<head>
    <title>Confirmación de Revisión</title>
</head>
<body>
    <h1>Confirmación de Revisión - {{ $cooperativa->nombre }}</h1>
    <p>Se han completado las siguientes revisiones:</p>
    <ul>
        @foreach ($revisiones as $revision => $checked)
            <li><strong>{{ str_replace('_', ' ', ucfirst($revision)) }}:</strong> {{ $checked ? '✅ Completada' : '❌ No completada' }}</li>
        @endforeach
    </ul>
    <p><strong>Boletos Vendidos:</strong> {{ number_format($cooperativa->ventas->sum('cantidad_boletos')) }}</p>
    <p><strong>Capacidad Total:</strong> {{ number_format($cooperativa->cantidad_pasajeros) }}</p>
    <p><strong>Fecha:</strong> {{ now()->format('d/m/Y H:i') }}</p>
</body>
</html>