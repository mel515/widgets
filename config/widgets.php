<?php

return [

    /*
     * Настройки изображений
     */

    'images' => [
        'quality' => 75,
        'conversions' => [
            'gallery_widget' => [
                'gallery' => [
                    'default' => [
                        [
                            'name' => 'gallery_admin',
                            'size' => [
                                'width' => 140,
                            ],
                        ],
                        [
                            'name' => 'gallery_front',
                            'quality' => 70,
                            'size' => [
                                'width' => 512,
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
];
