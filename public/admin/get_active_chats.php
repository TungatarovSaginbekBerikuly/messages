<?php
session_start();
header('Content-Type: application/json');
if (empty($_SESSION['is_admin'])) {
    http_response_code(403);
    echo json_encode(['error'=>'Unauthorized']);
    exit;
}

const API_URL = 'http://localhost:8000/api';
const API_KEY = 'WyeEyalhWfSkoAVfz7xOLCkzStWXDVqK-GbSoM88yyc-Tu2VJwOIQ7bM5AIiyyj686VBXTNl316PbPVsig1r5w';

// Запрашиваем все каналы user_*
$payload = [
    'method' => 'channels',
    'params' => ['pattern' => 'user_*']
];
$response = centrifugoApiRequest(API_URL, API_KEY, $payload);
$channels = $response['result']['channels'] ?? [];

$result = [];
foreach ($channels as $channelName => $chInfo) {
    if (!empty($chInfo['num_clients'])) {
        $result[] = [
            'channel' => $channelName,
            'clients' => $chInfo['num_clients']
        ];
    }
}

echo json_encode($result);
exit;

function centrifugoApiRequest(string $url, string $apiKey, array $payload): array {
    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_POST           => true,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER     => [
            'Content-Type: application/json',
            'Authorization: apikey ' . $apiKey
        ],
        CURLOPT_POSTFIELDS     => json_encode($payload),
        CURLOPT_TIMEOUT        => 5,
    ]);
    $raw = curl_exec($ch);
    curl_close($ch);
    return json_decode($raw, true) ?: [];
}
?>