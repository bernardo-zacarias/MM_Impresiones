<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmación de Pedido</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
            border-radius: 10px 10px 0 0;
        }
        .content {
            background: #f9fafb;
            padding: 30px;
            border: 1px solid #e5e7eb;
        }
        .order-details {
            background: white;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            border: 1px solid #e5e7eb;
        }
        .item {
            border-bottom: 1px solid #e5e7eb;
            padding: 15px 0;
        }
        .item:last-child {
            border-bottom: none;
        }
        .total {
            background: #10b981;
            color: white;
            padding: 15px;
            border-radius: 8px;
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            margin: 20px 0;
        }
        .payment-info {
            background: #ecfdf5;
            border: 2px solid #10b981;
            padding: 15px;
            border-radius: 8px;
            margin: 20px 0;
        }
        .footer {
            text-align: center;
            padding: 20px;
            color: #6b7280;
            font-size: 14px;
        }
        .button {
            display: inline-block;
            padding: 12px 24px;
            background: #667eea;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>✅ ¡Pedido Confirmado!</h1>
        <p>Gracias por tu compra en MM Impresiones</p>
    </div>

    <div class="content">
        <p>Hola <strong>{{ $pedido->usuario->name }}</strong>,</p>
        
        <p>Tu pedido <strong>#{{ $pedido->id }}</strong> ha sido confirmado exitosamente.</p>

        @if($pedido->transbank_authorization_code)
        <div class="payment-info">
            <p style="margin: 0; font-weight: bold;">✓ Pago Confirmado</p>
            <p style="margin: 5px 0 0 0; font-size: 14px;">
                Código de autorización: <strong>{{ $pedido->transbank_authorization_code }}</strong>
            </p>
        </div>
        @endif

        <div class="order-details">
            <h3 style="margin-top: 0;">Detalles del Pedido</h3>
            <p><strong>Fecha:</strong> {{ $pedido->created_at->format('d/m/Y H:i') }}</p>
            <p><strong>Estado:</strong> {{ ucfirst($pedido->estado) }}</p>
            
            <h4>Productos:</h4>
            @foreach($items as $item)
                <div class="item">
                    <p style="margin: 0; font-weight: bold;">
                        {{ $item->producto->nombre ?? $item->cotizacion->nombre ?? 'Producto' }}
                    </p>
                    <p style="margin: 5px 0; font-size: 14px; color: #6b7280;">
                        Cantidad: {{ $item->cantidad }}
                        @if($item->ancho > 0 || $item->alto > 0)
                            | Medidas: {{ $item->ancho }}m x {{ $item->alto }}m
                        @endif
                    </p>
                    <p style="margin: 5px 0; font-weight: bold; color: #667eea;">
                        ${{ number_format($item->costo_final, 0, ',', '.') }}
                    </p>
                </div>
            @endforeach
        </div>

        <div class="total">
            TOTAL: ${{ number_format($pedido->total, 0, ',', '.') }}
        </div>

        <p style="text-align: center;">
            <a href="{{ route('pedidos.show', $pedido->id) }}" class="button">
                Ver Mi Pedido
            </a>
        </p>

        <p><strong>Próximos pasos:</strong></p>
        <ol>
            <li>Nuestro equipo procesará tu pedido en las próximas 24 horas</li>
            <li>Te contactaremos para coordinar la entrega</li>
            <li>Recibirás actualizaciones del estado de tu pedido</li>
        </ol>
    </div>

    <div class="footer">
        <p>© {{ date('Y') }} MM Impresiones. Todos los derechos reservados.</p>
        <p>Si tienes alguna pregunta, contáctanos respondiendo este email.</p>
    </div>
</body>
</html>
