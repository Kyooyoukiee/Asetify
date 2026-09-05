<?php
header('Content-Type: application/json');
echo json_encode([
    'LOG_CHANNEL' => getenv('LOG_CHANNEL'),
    'APP_KEY' => getenv('APP_KEY') ? 'SET (hidden)' : 'NOT SET',
    'APP_ENV' => getenv('APP_ENV'),
    '_ENV_LOG_CHANNEL' => $_ENV['LOG_CHANNEL'] ?? 'undefined',
    '_SERVER_LOG_CHANNEL' => $_SERVER['LOG_CHANNEL'] ?? 'undefined',
]);