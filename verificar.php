<?php
// TU SECRET KEY (Mantenla siempre en PHP, nunca en HTML)
$secretKey = "0x4AAAAAAC4pl4F_xTMXCRHIE6CzDWND4fo";
$token = $_POST['cf-turnstile-response'];
$ip = $_SERVER['REMOTE_ADDR'];

// Validación con Cloudflare
$url = "https://challenges.cloudflare.com/turnstile/v0/siteverify";
$data = [
    'secret' => $secretKey,
    'response' => $token,
    'remoteip' => $ip
];

$options = [
    'http' => [
        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        'method'  => 'POST',
        'content' => http_build_query($data)
    ]
];

$context  = stream_context_create($options);
$response = file_get_contents($url, false, $context);
$res = json_decode($response);

if ($res->success) {
    // SI ES HUMANO: Lo mandas a la web real
    header("Location: contenido-real.php"); 
} else {
    // SI ES BOT: Lo mandas a Google o lo bloqueas
    header("Location: https://www.google.com");
}
exit();
?>