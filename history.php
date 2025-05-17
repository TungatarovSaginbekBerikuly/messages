<?php
header('Content-Type: application/json');
$apiKey = 'WyeEyalhWfSkoAVfz7xOLCkzStWXDVqK-GbSoM88yyc-Tu2VJwOIQ7bM5AIiyyj686VBXTNl316PbPVsig1r5w';
$body = json_decode(file_get_contents('php://input'), true);
if (empty($body['visitor_id'])) {
    http_response_code(400);
    exit(json_encode(['error'=>'visitor_id required']));
}
$visitorId = preg_replace('/[^A-Za-z0-9_\-]/','',$body['visitor_id']);
$channel   = 'user_' . $visitorId;
$data = [
  'method' => 'history',
  'params' => ['channel'=>$channel,'limit'=>100]
];
$ch = curl_init('http://localhost:8000/api');
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
  'Content-Type: application/json',
  'Authorization: apikey ' . $apiKey
]);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
echo curl_exec($ch);
curl_close($ch);