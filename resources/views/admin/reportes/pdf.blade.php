<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; font-size: 11px; color: #1A2533; }

        .header { background: #1A3A5C; color: white; padding: 20px 30px; margin-bottom: 20px; }
        .header h1 { font-size: 20px; font-weight: bold; }
        .header p  { font-size: 10px; color: #C9AA71; margin-top: 4px; }

        .periodo { background: #F4F6F9; padding: 10px 30px; margin-bottom: 16px;
                   font-size: 10px; color: #666; }

        .metricas { display: flex; gap: 12px; padding: 0 30px; margin-bottom: 20px; }
        .metrica  { flex: 1; border: 1px solid #E2E8F2; border-radius: 8px;
                    padding: 12px; text-align: center; }
        .metrica .valor { font-size: 18px; font-weight: bold; color: #1A3A5C; }
        .metrica .label { font-size: 9px; color: #888; margin-top: 3px; }

        .seccion { padding: 0 30px; margin-bottom: 20px; }
        .seccion h2 { font-size: 13px; font-weight: bold; color: #1A3A5C;
                      border-bottom: 2px solid #C9AA71; padding-bottom: 6px; margin-bottom: 10px; }

        table { width: 100%; border-collapse: collapse; font-size: 10px; }
        thead tr { background: #1A3A5C; color: white; }
        thead th { padding: 8px 10px; text-align: left; }
        tbody tr:nth-child(even) { background: #F7FAFF; }
        tbody td { padding: 7px 10px; border-bottom: 1px solid #EEE; }

        .badge { padding: 2px 8px; border-radius: 10px; font-size: 9px; font-weight: bold; }
        .pendiente  { background: #FEF3C7; color: #92400E; }
        .confirmada { background: #D1FAE5; color: #065F46; }
        .en_curso   { background: #DBEAFE; color: #1E3A8A; }
        .completada { background: #E5E7EB; color: #374151; }
        .cancelada  { background: #FEE2E2; color: #991B1B; }

        .footer { margin-top: 30px; padding: 10px 30px;
                  border-top: 1px solid #EEE; font-size: 9px; color: #AAA;
                  display: flex; justify-content: space-between; }
    </style>
</head>
<body>

{{-- Header --}}
<div class="header">
    <h1>Reporte de Reservas e Ingresos</h1>
    <p>DoubleTree by Hilton Trujillo · Av. El Golf 591, Trujillo, Perú · RUC: 20123456789</p>
</div>

{{-- Período --}}
<div class="periodo">
    Período: {{ \Carbon\Carbon::parse($desde)->format('d/m/Y') }}
    al {{ \Carbon\Carbon::parse($hasta)->format('d/m/Y') }}
    &nbsp;·&nbsp; Generado: {{ now()->format('d/m/Y H:i') }}
</div>

{{-- Métricas --}}
<div class="metricas">
    <div class="metrica">
        <div class="valor">S/ {{ number_format($totalIngresos, 2) }}</div>
        <div class="label">Ingresos del período</div>
    </div>
    <div class="metrica">
        <div class="valor">{{ $totalReservas }}</div>
        <div class="label">Total reservas</div>
    </div>
    <div class="metrica">
        <div class="valor">{{ $habitacionesOcupadas }} / {{ $totalHabitaciones }}</div>
        <div class="label">Habitaciones ocupadas</div>
    </div>
    <div class="metrica">
        <div class="valor">{{ $ocupacion }}%</div>
        <div class="label">Ocupación actual</div>
    </div>
</div>

{{-- Reservas por estado --}}
<div class="seccion">
    <h2>Reservas por estado</h2>
    <table>
        <thead>
            <tr>
                <th>Estado</th>
                <th>Cantidad</th>
                <th>Porcentaje</th>
            </tr>
        </thead>
        <tbody>
            @foreach(['pendiente','confirmada','en_curso','completada','cancelada'] as $est)
                @php $cant = $reservasPorEstado[$est] ?? 0; @endphp
                <tr>
                    <td><span class="badge {{ $est }}">{{ ucfirst($est) }}</span></td>
                    <td>{{ $cant }}</td>
                    <td>{{ $totalReservas > 0 ? round($cant/$totalReservas*100,1) : 0 }}%</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

{{-- Detalle de reservas --}}
<div class="seccion">
    <h2>Detalle de reservas</h2>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Cliente</th>
                <th>Habitación</th>
                <th>Ingreso</th>
                <th>Salida</th>
                <th>Total</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @forelse($reservas as $r)
                <tr>
                    <td>{{ $r->id }}</td>
                    <td>{{ $r->cliente->nombre }} {{ $r->cliente->apellido }}</td>
                    <td>{{ $r->habitacion->numero }} · {{ $r->habitacion->tipo->nombre }}</td>
                    <td>{{ \Carbon\Carbon::parse($r->fecha_ingreso)->format('d/m/Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($r->fecha_salida)->format('d/m/Y') }}</td>
                    <td>S/ {{ number_format($r->total, 2) }}</td>
                    <td><span class="badge {{ $r->estado }}">{{ ucfirst($r->estado) }}</span></td>
                </tr>
            @empty
                <tr><td colspan="7" style="text-align:center;color:#AAA;">Sin reservas en este período</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- Footer --}}
<div class="footer">
    <span>DoubleTree by Hilton Trujillo — Sistema de Reservas Online</span>
    <span>Reporte generado automáticamente</span>
</div>

</body>
</html>