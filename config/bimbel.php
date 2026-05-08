<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Location Settings
    |--------------------------------------------------------------------------
    |
    | Configuration for GPS-based attendance verification
    |
    */
    'location' => [
        'accuracy_threshold' => env('LOCATION_ACCURACY_METERS', 100), // meters
        'allow_mock' => env('ALLOW_MOCK_LOCATION', false),
        'google_maps_api_key' => env('GOOGLE_MAPS_API_KEY', ''),
    ],

    /*
    |--------------------------------------------------------------------------
    | Salary Settings
    |--------------------------------------------------------------------------
    |
    | Default rates and calculation settings for tutor salaries
    |
    */
    'salary' => [
        // Harga satu sesi yang dibayar client
        'session_price_client' => env('SESSION_PRICE_CLIENT', 50000),  // Rp 50.000 per sesi

        // Bagian yang diterima tutor per sesi
        'session_rate_tutor'   => env('SESSION_RATE_TUTOR', 40000),   // Rp 40.000 per sesi

        // Margin/keuntungan perusahaan per sesi
        'session_rate_company' => env('SESSION_RATE_COMPANY', 10000), // Rp 10.000 per sesi

        'payment_period' => 'monthly', // monthly, bi-weekly
    ],

    /*
    |--------------------------------------------------------------------------
    | Quality Assessment Settings
    |--------------------------------------------------------------------------
    |
    | Settings for tutor quality control and assessment
    |
    */
    'quality' => [
        'min_rating_threshold' => 4.0,
        'assessment_required' => true,
        'criteria' => [
            'punctuality' => 'Ketepatan waktu',
            'clarity' => 'Kejelasan penjelasan',
            'engagement' => 'Keterlibatan siswa',
            'professionalism' => 'Profesionalitas',
            'communication' => 'Komunikasi dengan orang tua',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Schedule Settings
    |--------------------------------------------------------------------------
    |
    | Settings for scheduling and session management
    |
    */
    'schedule' => [
        'session_duration' => 90, // minutes
        'grace_period' => 15, // minutes late tolerance
        'cancellation_limit' => 24, // hours before session
    ],

    /*
    |--------------------------------------------------------------------------
    | Notification Settings
    |--------------------------------------------------------------------------
    |
    | Settings for system notifications
    |
    */
    'notification' => [
        'email_enabled' => env('NOTIFICATION_EMAIL', true),
        'whatsapp_enabled' => env('NOTIFICATION_WHATSAPP', false),
        'whatsapp_api_key' => env('WHATSAPP_API_KEY', ''),
    ],
];
