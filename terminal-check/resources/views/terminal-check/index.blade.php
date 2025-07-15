@extends('layouts.app')

@section('title', 'Consulta de Cooperativa')

@section('content')
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h4>Seleccionar Cooperativa</h4>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('terminal-check.index') }}" class="mb-4">
                <div class="row">
                    <div class="col-md-4">
                        <select name="cooperativa_id" class="form-select" onchange="this.form.submit()">
                            @foreach ($cooperativas as $coop)
                                <option value="{{ $coop->id }}" {{ $coop->id == request('cooperativa_id', $cooperativas->first()->id ?? 1) ? 'selected' : '' }}>
                                    {{ $coop->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </form>

            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4>Información de la Cooperativa: {{ $cooperativa->nombre ?? 'Sin nombre' }}</h4>
                </div>
                <div class="card-body">
                    <p><strong>Boletos Vendidos:</strong> {{ number_format($boletosVendidos, 0) }}</p>
                    <p><strong>Capacidad Total:</strong> {{ number_format($capacidadTotal, 0) }}</p>
                    <p><strong>Boletos Disponibles:</strong> {{ number_format(max(0, $capacidadTotal - $boletosVendidos), 0) }}</p>

                    <h5>Listado de Pasajeros</h5>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Cédula</th>
                                <th>Edad</th>
                                <th>Cantidad de Boletos</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($pasajeros && $pasajeros->isNotEmpty())
                                @foreach ($pasajeros as $item)
                                    <tr>
                                        <td>{{ $item->persona->nombre ?? 'Sin nombre' }}</td>
                                        <td>{{ $item->persona->cedula ?? 'Sin cédula' }}</td>
                                        <td>{{ $item->persona->edad ?? 'Sin edad' }}</td>
                                        <td>{{ number_format($item->boletos_totales, 0) }}</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="4" class="text-warning">No hay pasajeros registrados para esta cooperativa.</td>
                                </tr>
                            @endif
                            @if ($boletosVendidos < $capacidadTotal)
                                @for ($i = $boletosVendidos; $i < $capacidadTotal; $i++)
                                    <tr>
                                        <td colspan="4" class="text-muted">Asiento vacío #{{ $i + 1 }}</td>
                                    </tr>
                                @endfor
                            @endif
                        </tbody>
                    </table>

                    {{-- Revisión y envío de correo --}}
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <h6>Revisar:</h6>
                            <div class="form-check">
                                <input class="form-check-input revision-check" type="checkbox" id="iluminacion">
                                <label class="form-check-label" for="iluminacion">Sistema de iluminación</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input revision-check" type="checkbox" id="llantas">
                                <label class="form-check-label" for="llantas">Llantas</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input revision-check" type="checkbox" id="visual">
                                <label class="form-check-label" for="visual">Revisión visual</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h6>&nbsp;</h6>
                            <div class="form-check">
                                <input class="form-check-input revision-check" type="checkbox" id="documental">
                                <label class="form-check-label" for="documental">Documental</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input revision-check" type="checkbox" id="seguridad">
                                <label class="form-check-label" for="seguridad">Seguridad</label>
                            </div>
                        </div>
                    </div>

                    <div class="mt-3">
                        <button id="btnEnviarCorreo" class="btn btn-success">
                            <i class="fas fa-envelope"></i> Generar y Enviar Correo
                        </button>
                        <div id="mensajeCorreo" class="mt-2" style="display: none;"></div>
                    </div>

                    <script>
                        document.getElementById('btnEnviarCorreo').addEventListener('click', function () {
                            const btn = this;
                            btn.disabled = true;
                            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Enviando...';

                            const checks = document.querySelectorAll('.revision-check:checked');
                            const revisiones = {};
                            checks.forEach(ch => {
                                revisiones[ch.id] = true;
                            });

                            fetch('{{ route("terminal-check.enviar-correo") }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: JSON.stringify({
                                    cooperativa_id: {{ $cooperativa->id }},
                                    revisiones
                                })
                            })
                            .then(res => res.json())
                            .then(data => {
                                const mensaje = document.getElementById('mensajeCorreo');
                                mensaje.style.display = 'block';
                                if (data.success) {
                                    mensaje.className = 'alert alert-success';
                                    mensaje.textContent = data.message;
                                } else {
                                    mensaje.className = 'alert alert-danger';
                                    mensaje.textContent = 'Error al enviar el correo.';
                                }
                                btn.disabled = false;
                                btn.innerHTML = '<i class="fas fa-envelope"></i> Generar y Enviar Correo';
                            });
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>
@endsection