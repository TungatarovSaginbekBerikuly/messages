<?php
$centrifugo_secret = 'BXKNHgKQtP_ca7mzezikNISoKciTP6Vn_PiKM0b-C9t8ixs8dN-SPvGPNlIEcdmQ5r8obWtkq6fn_Wa1Yu6FZg';
$token_ttl = 3600; // 1 час

if (isset($_COOKIE['visitor_id'])) {
    $visitor_id = $_COOKIE['visitor_id'];
} else {
    $visitor_id = generate_uuid();
    setcookie('visitor_id', $visitor_id, time() + 60 * 60 * 24 * 30, "/"); // 30 дней
}

$payload = [
    "sub" => $visitor_id,
    "exp" => time() + $token_ttl
];

$jwt = generate_jwt($payload, $centrifugo_secret);

header('Content-Type: application/json');
echo json_encode([
    "token" => $jwt,
    "visitor_id" => $visitor_id
]);

function generate_uuid() {
    return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
        mt_rand(0, 0xffff), mt_rand(0, 0xffff),
        mt_rand(0, 0xffff),
        mt_rand(0, 0x0fff) | 0x4000,
        mt_rand(0, 0x3fff) | 0x8000,
        mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
    );
}

function base64url_encode($data) {
    return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
}

function generate_jwt($payload, $secret) {
    $header = ['typ' => 'JWT', 'alg' => 'HS256'];
    $segments = [
        base64url_encode(json_encode($header)),
        base64url_encode(json_encode($payload))
    ];
    
    $signing_input = implode('.', $segments);
    $signature = hash_hmac('sha256', $signing_input, $secret, true);
    $segments[] = base64url_encode($signature);

    return implode('.', $segments);
}