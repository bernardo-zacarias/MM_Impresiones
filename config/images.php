<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Imágenes del Sitio
    |--------------------------------------------------------------------------
    |
    | Aquí puedes configurar las rutas de las imágenes principales del sitio.
    | Solo necesitas cambiar el nombre del archivo en esta configuración.
    |
    */

    // Logo de la empresa
    'logo' => env('SITE_LOGO', '/images/assets/logo.enc'),
    
    // Imagen de fondo del home para usuarios logueados
    'home_background' => env('HOME_BACKGROUND', '/images/banners/home-bg.png'),
    
    // Imagen de banner del home
    'home_banner' => env('HOME_BANNER', '/images/banners/home-banner.png'),
    
    // Imagen por defecto para productos sin imagen
    'product_placeholder' => env('PRODUCT_PLACEHOLDER', '/images/site/placeholder-product.png'),
    
    // Imagen de avatar por defecto
    'avatar_placeholder' => env('AVATAR_PLACEHOLDER', '/images/site/avatar-placeholder.png'),
    
    // Banner de la página welcome
    'welcome_banner' => env('WELCOME_BANNER', '/images/banners/welcome-banner.jpg'),
    
    // Imágenes de servicios
    'services' => [
        'impresion' => env('SERVICE_IMPRESION_IMG', '/images/site/servicio-impresion.jpg'),
        'diseno' => env('SERVICE_DISENO_IMG', '/images/site/servicio-diseno.jpg'),
        'rotulacion' => env('SERVICE_ROTULACION_IMG', '/images/site/servicio-rotulacion.jpg'),
    ],

];
