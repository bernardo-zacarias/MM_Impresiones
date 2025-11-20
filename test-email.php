<?php

/**
 * Script para probar el envío de correos
 * 
 * Uso:
 * php test-email.php tu_correo@ejemplo.com
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

if (!isset($argv[1])) {
    echo "\n❌ Error: Debes proporcionar un correo de destino\n";
    echo "Uso: php test-email.php tu_correo@ejemplo.com\n\n";
    exit(1);
}

$destinatario = $argv[1];

echo "\n📧 Probando envío de correo...\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";

try {
    echo "📤 Enviando correo de prueba a: {$destinatario}\n";
    
    \Illuminate\Support\Facades\Mail::raw(
        "¡Hola! Este es un correo de prueba desde MM Impresiones.\n\n" .
        "Si recibes este mensaje, la configuración SMTP está funcionando correctamente.\n\n" .
        "Fecha y hora: " . now()->format('d/m/Y H:i:s') . "\n" .
        "Ambiente: " . config('app.env') . "\n" .
        "Mailer: " . config('mail.default') . "\n\n" .
        "Saludos,\n" .
        "MM Impresiones",
        function ($message) use ($destinatario) {
            $message->to($destinatario)
                    ->subject('✅ Prueba de Correo - MM Impresiones');
        }
    );
    
    echo "\n✅ ¡Correo enviado exitosamente!\n";
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
    echo "📋 Configuración utilizada:\n";
    echo "   Mailer: " . config('mail.default') . "\n";
    echo "   Host: " . config('mail.mailers.smtp.host') . "\n";
    echo "   Port: " . config('mail.mailers.smtp.port') . "\n";
    echo "   From: " . config('mail.from.address') . "\n";
    echo "   From Name: " . config('mail.from.name') . "\n";
    echo "\n💡 Revisa tu bandeja de entrada (y spam) en: {$destinatario}\n\n";
    
} catch (\Exception $e) {
    echo "\n❌ Error al enviar el correo:\n";
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
    echo $e->getMessage() . "\n\n";
    
    echo "🔧 Verificaciones:\n";
    echo "   1. ¿Configuraste las credenciales SMTP en .env?\n";
    echo "   2. ¿El puerto está correcto? (465 para SSL, 587 para TLS)\n";
    echo "   3. ¿La contraseña es correcta?\n";
    echo "   4. ¿Ejecutaste: php artisan config:clear?\n\n";
    
    if (config('mail.default') === 'log') {
        echo "ℹ️  Nota: Estás usando MAIL_MAILER=log\n";
        echo "   Los correos se guardan en: storage/logs/laravel.log\n";
        echo "   Para enviar correos reales, cambia a MAIL_MAILER=smtp\n\n";
    }
    
    exit(1);
}
