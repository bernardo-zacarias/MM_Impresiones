<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Transbank\Webpay\WebpayPlus\Transaction;
use Transbank\Webpay\Options;
use App\Models\Pedido;
use App\Models\User;
use App\Mail\PedidoConfirmado;
use App\Mail\NuevoPedidoAdmin;

class TransbankController extends Controller
{
    /**
     * Obtener instancia de Transaction configurada
     */
    private function getTransaction()
    {
        $environment = config('services.transbank.environment', 'test');
        
        if ($environment === 'production') {
            // PRODUCCIÓN: Usar credenciales reales desde .env
            return Transaction::buildForProduction(
                config('services.transbank.api_key'),
                config('services.transbank.commerce_code')
            );
        } else {
            // INTEGRACIÓN (TEST): Usar credenciales de prueba de Transbank
            return Transaction::buildForIntegration(
                '579B532A7440BB0C9079DED94D31EA1615BACEB56610332264630D42D0A36B1C',
                '597055555532'
            );
        }
    }

    /**
     * Inicia el proceso de pago con Transbank
     */
    public function iniciarPago(Pedido $pedido)
    {
        try {
            // Validar que el pedido pertenece al usuario autenticado
            if ($pedido->usuario_id !== auth()->id()) {
                abort(403, 'No autorizado para pagar este pedido.');
            }

            // Validar que el pedido está pendiente de pago
            if ($pedido->estado !== 'pendiente_pago') {
                return redirect()->route('pedidos.show', $pedido->id)
                    ->with('error', 'Este pedido ya fue procesado.');
            }

            // Generar un identificador único para la orden de compra
            $buyOrder = 'MM-' . $pedido->id . '-' . time();
            $sessionId = 'session-' . $pedido->id;
            $amount = (int) $pedido->total; // Transbank requiere monto en pesos chilenos sin decimales
            
            // URLs de retorno
            $returnUrl = route('transbank.callback');

            // Crear la transacción en Transbank
            $transaction = $this->getTransaction();
            $response = $transaction->create($buyOrder, $sessionId, $amount, $returnUrl);

            // Guardar el token en el pedido
            $pedido->update([
                'transbank_token' => $response->getToken(),
                'transbank_buy_order' => $buyOrder,
            ]);

            // Redirigir a Transbank
            return view('transbank.redirect', [
                'token' => $response->getToken(),
                'url' => $response->getUrl()
            ]);

        } catch (\Exception $e) {
            Log::error('Error al iniciar pago Transbank: ' . $e->getMessage());
            return redirect()->route('pedidos.show', $pedido->id)
                ->with('error', 'Error al conectar con el sistema de pago. Intenta nuevamente.');
        }
    }

    /**
     * Callback de Transbank (cuando el usuario vuelve desde Webpay)
     */
    public function callback(Request $request)
    {
        $token = $request->input('token_ws');

        if (!$token) {
            return redirect()->route('carrito.index')
                ->with('error', 'Transacción cancelada o inválida.');
        }

        try {
            // Confirmar la transacción con Transbank
            $transaction = $this->getTransaction();
            $response = $transaction->commit($token);

            // Buscar el pedido por el buy_order
            $buyOrder = $response->getBuyOrder();
            $pedidoId = explode('-', $buyOrder)[1]; // Extraer ID del formato "MM-123-timestamp"
            $pedido = Pedido::find($pedidoId);

            if (!$pedido) {
                throw new \Exception('Pedido no encontrado: ' . $buyOrder);
            }

            // Verificar el estado de la transacción
            if ($response->isApproved()) {
                // Pago APROBADO
                $pedido->update([
                    'estado' => 'pagado',
                    'metodo_pago' => 'webpay',
                    'transbank_authorization_code' => $response->getAuthorizationCode(),
                    'transbank_payment_type_code' => $response->getPaymentTypeCode(),
                    'transbank_amount' => $response->getAmount(),
                    'transbank_transaction_date' => now(),
                    'transbank_response' => [
                        'vci' => $response->getVci(),
                        'status' => $response->getStatus(),
                        'card_number' => $response->getCardDetail()['card_number'] ?? null,
                    ]
                ]);

                // Enviar emails de confirmación
                $items = $pedido->items()->with(['producto', 'cotizacion'])->get();
                
                // Email al cliente
                Mail::to($pedido->usuario->email)->send(new PedidoConfirmado($pedido, $items));
                
                // Email al administrador
                $adminEmails = User::where('rol', 'admin')->pluck('email')->toArray();
                if (!empty($adminEmails)) {
                    Mail::to($adminEmails)->send(new NuevoPedidoAdmin($pedido, $items, $pedido->usuario));
                }

                return redirect()->route('pedidos.show', $pedido->id)
                    ->with('success', '¡Pago confirmado exitosamente! Tu pedido está siendo procesado.');
            } else {
                // Pago RECHAZADO
                $pedido->update([
                    'estado' => 'pago_rechazado',
                    'transbank_response' => [
                        'status' => $response->getStatus(),
                        'response_code' => $response->getResponseCode(),
                    ]
                ]);

                return redirect()->route('pedidos.show', $pedido->id)
                    ->with('error', 'El pago fue rechazado. Por favor, intenta con otro medio de pago.');
            }

        } catch (\Exception $e) {
            Log::error('Error en callback Transbank: ' . $e->getMessage());
            return redirect()->route('carrito.index')
                ->with('error', 'Error al procesar el pago. Contacta a soporte.');
        }
    }

    /**
     * Obtener el estado de una transacción
     */
    public function estado($token)
    {
        try {
            $transaction = $this->getTransaction();
            $response = $transaction->status($token);
            
            return response()->json([
                'success' => true,
                'data' => $response
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
