<?php
return [
    'api_url' => env("SMS_API_URL", FALSE),
    'api_key' => env("SMS_API_KEY"),
    'api_user' => env("SMS_API_USER"),
    'api_mask' => env("SMS_API_MASK"),
    'api_method' => env("SMS_API_METHOD", 'xml'),
    'api_channel' => env("SMS_API_CHANNEL", 'Normal'),
    'api_dcs' => env("SMS_API_CHANNEL", 0),
    'api_campaign' => env("SMS_API_CAMPAIGN", ''),
    'api_flash_sms' => env("SMS_API_FLASH", 0),
    'keys' => [
        'user' => env("SMS_KEYS_USER", 'Username'),
        'password' => env("SMS_KEYS_PASSWORD", 'Password'),
        'from' => env("SMS_KEYS_FROM", "From"),
        'to' => env("SMS_KEYS_TO", "To"),
        'message' => env("SMS_KEYS_MESSAGE", 'Message'),
        'channel' => env("SMS_KEYS_CHANNEL", 'Channel'),
        'campaign' => env("SMS_KEYS_CAMPAIGN", 'Campaign'),
        'dcs' => env("SMS_KEYS_DCS", "DCS"),
        'flashsms' => env("SMS_KEYS_FLASHMESSAGE", 'flashsms')
    ]
];