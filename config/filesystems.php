<?php

return [

    /*
     * Расширение файла конфигурации app/config/filesystems.php
     * добавляет локальные диски для хранения изображений постов и пользователей
     */

    'widgets' => [
        'driver' => 'local',
        'root' => storage_path('app/public/widgets'),
        'url' => env('APP_URL').'/storage/widgets',
        'visibility' => 'public',
    ],

];
