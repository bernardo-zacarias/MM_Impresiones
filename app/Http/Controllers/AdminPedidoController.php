<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pedido;
use App\Models\User;

class AdminPedidoController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    /**
     * Lista todos los pedidos con filtros
     */
    public function index(Request $request)
    {
        $query = Pedido::with(['usuario', 'items'])->orderBy('created_at', 'desc');

        // Filtro por estado
        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        // Filtro por fecha
        if ($request->filled('fecha_desde')) {
            $query->whereDate('created_at', '>=', $request->fecha_desde);
        }
        if ($request->filled('fecha_hasta')) {
            $query->whereDate('created_at', '<=', $request->fecha_hasta);
        }

        // Búsqueda por ID o nombre de usuario
        if ($request->filled('buscar')) {
            $buscar = $request->buscar;
            $query->where(function($q) use ($buscar) {
                $q->where('id', 'like', "%{$buscar}%")
                  ->orWhereHas('usuario', function($q2) use ($buscar) {
                      $q2->where('name', 'like', "%{$buscar}%")
                         ->orWhere('email', 'like', "%{$buscar}%");
                  });
            });
        }

        $pedidos = $query->paginate(20);

        // Estadísticas rápidas
        $stats = [
            'total' => Pedido::count(),
            'pendientes' => Pedido::where('estado', 'pendiente_pago')->count(),
            'pagados' => Pedido::where('estado', 'pagado')->count(),
            'en_proceso' => Pedido::where('estado', 'en_proceso')->count(),
            'completados' => Pedido::where('estado', 'completado')->count(),
        ];

        return view('administracion.pedidos.index', compact('pedidos', 'stats'));
    }

    /**
     * Ver detalle de un pedido
     */
    public function show(Pedido $pedido)
    {
        $pedido->load(['usuario', 'items.producto', 'items.cotizacion']);
        return view('administracion.pedidos.show', compact('pedido'));
    }

    /**
     * Actualizar estado del pedido
     */
    public function updateEstado(Request $request, Pedido $pedido)
    {
        $request->validate([
            'estado' => 'required|in:pendiente_pago,pagado,pago_rechazado,en_proceso,completado,cancelado'
        ]);

        $pedido->update(['estado' => $request->estado]);

        return back()->with('success', 'Estado del pedido actualizado correctamente.');
    }

    /**
     * Agregar notas del administrador
     */
    public function agregarNotas(Request $request, Pedido $pedido)
    {
        $request->validate([
            'notas_admin' => 'required|string|max:1000'
        ]);

        $pedido->update(['notas_admin' => $request->notas_admin]);

        return back()->with('success', 'Notas agregadas correctamente.');
    }

    /**
     * Descargar archivos del pedido
     */
    public function descargarArchivos(Pedido $pedido)
    {
        $items = $pedido->items()->whereNotNull('ruta_archivo')->get();
        
        if ($items->isEmpty()) {
            return back()->with('error', 'Este pedido no tiene archivos adjuntos.');
        }

        // Si hay un solo archivo, descargarlo directamente
        if ($items->count() === 1) {
            $ruta = storage_path('app/public/' . $items->first()->ruta_archivo);
            if (file_exists($ruta)) {
                return response()->download($ruta);
            }
        }

        // Si hay múltiples archivos, crear un ZIP
        $zip = new \ZipArchive();
        $zipName = 'pedido_' . $pedido->id . '_archivos.zip';
        $zipPath = storage_path('app/public/' . $zipName);

        if ($zip->open($zipPath, \ZipArchive::CREATE) === TRUE) {
            foreach ($items as $index => $item) {
                $ruta = storage_path('app/public/' . $item->ruta_archivo);
                if (file_exists($ruta)) {
                    $zip->addFile($ruta, 'archivo_' . ($index + 1) . '_' . basename($ruta));
                }
            }
            $zip->close();
            
            return response()->download($zipPath)->deleteFileAfterSend(true);
        }

        return back()->with('error', 'Error al crear el archivo ZIP.');
    }
}
