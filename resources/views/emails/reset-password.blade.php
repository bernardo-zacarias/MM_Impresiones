@component('mail::message')
# Restablecimiento de Contraseña

Has recibido este correo porque hemos recibido una solicitud de restablecimiento de contraseña para tu cuenta.

@component('mail::button', ['url' => $url])
Restablecer Contraseña
@endcomponent

Este enlace de restablecimiento de contraseña expirará en {{ config('auth.passwords.'.config('auth.defaults.passwords').'.expire') }} minutos.

Si no solicitaste un restablecimiento de contraseña, no es necesario que hagas nada.

Saludos,<br>
{{ config('app.name') }}

---

Si tienes problemas al hacer clic en el botón "Restablecer Contraseña", copia y pega la siguiente URL en tu navegador web:

{{ $url }}
@endcomponent
