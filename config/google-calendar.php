<?php

return [
    'service_account_credentials_json' => storage_path('app/google-calendar/service-account-credentials.json'),
    'calendar_id' => env('GOOGLE_CALENDAR_ID'),
    'format' => 'Y-m-d\TH:i:s\Z',

];
