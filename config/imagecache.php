<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Name of route
    |--------------------------------------------------------------------------
    |
    | Enter the routes name to enable dynamic imagecache manipulation.
    | This handle will define the first part of the URI:
    |
    | {route}/{template}/{filename}
    |
    | Examples: "images", "img/cache"
    |
    */

    'route' => 'img/cache',

    /*
    |--------------------------------------------------------------------------
    | Storage paths
    |--------------------------------------------------------------------------
    |
    | The following paths will be searched for the image filename, submitted
    | by URI.
    |
    | Define as many directories as you like.
    |
    */

    'paths' => [
        public_path('uploads'),
        //public_path('images')
    ],

    /*
    |--------------------------------------------------------------------------
    | Manipulation templates
    |--------------------------------------------------------------------------
    |
    | Here you may specify your own manipulation filter templates.
    | The keys of this array will define which templates
    | are available in the URI:
    |
    | {route}/{template}/{filename}
    |
    | The values of this array will define which filter class
    | will be applied, by its fully qualified name.
    |
    */

    'templates' => [
        'small' => 'Intervention\Image\Templates\Small',
        'medium' => 'Intervention\Image\Templates\Medium',
        'large' => 'Intervention\Image\Templates\Large',

        '120x120' => function($image) {
            return $image->fit(120, 120);
        },
        '120x84' => function($image) {
            return $image->fit(120, 84);
        },
        '100x80' => function($image) {
            return $image->fit(100, 80);
        },
        '130x80' => function($image) {
            return $image->fit(130, 80);
        },
        '303x130' => function($image) {
            return $image->fit(303, 130);
        },
        '400x289' => function($image) {
            return $image->fit(400, 289);
        },
        '320x180' => function($image) {
            return $image->fit(320, 180);
        },
        '188x125' => function($image) {
            return $image->fit(188, 125);
        },
        '274x174' => function($image) {
            return $image->fit(274, 174);
        },
        '310x230' => function($image) {
            return $image->fit(310, 230);
        },
        '300x177' => function($image) {
            return $image->fit(300, 177);
        },
        '105x69' => function($image) {
            return $image->fit(105, 69);
        },
        '218x128' => function($image) {
            return $image->fit(218, 128);
        },
        '110x70' => function($image) {
            return $image->fit(110, 70);
        },
        '212x126' => function($image) {
            return $image->fit(212, 126);
        },
        '287x143' => function($image) {
            return $image->fit(287, 143);
        },
        '188x188' => function($image) {
            return $image->fit(188, 188);
        },
        '130x130' => function($image) {
            return $image->fit(130, 130);
        },
        '200x200' => function($image) {
            return $image->fit(200, 200);
        },
        '93x93' => function($image) {
            return $image->fit(93, 93);
        },
        '344x234' => function($image) {
            return $image->fit(344, 234);
        },

        '310x530' => function($image) {
            return $image->fit(310, 530);
        },
        '507x310' => function($image) {
            return $image->fit(507, 310);
        },
        '226x148' => function($image) {
            return $image->fit(226, 148);
        },
        '301x183' => function($image) {
            return $image->fit(301, 183);
        },
        '126x90' => function($image) {
            return $image->fit(126, 90);
        },
        '276x157' => function($image) {
            return $image->fit(276, 157);
        },
    ],

    /*
    |--------------------------------------------------------------------------
    | Image Cache Lifetime
    |--------------------------------------------------------------------------
    |
    | Lifetime in minutes of the images handled by the imagecache route.
    |
    */

    'lifetime' => 43200,

];
