<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ide írd a saját e-mail címed, ahova az üzenetet várod
    $cimtett = "toth.istvan.milan1023@gmail.com";
    
    $nev = strip_tags(trim($_POST["nev"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $uzenet = trim($_POST["uzenet"]);

    // Ellenőrzés
    if (empty($nev) || empty($uzenet) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        echo "Kérlek tölts ki minden mezőt helyesen.";
        exit;
    }

    // Resend API kulcs beolvasása biztonságosan a Wasmer környezeti változójából
    $apiKey = getenv('RESEND_API_KEY'); 

    if (empty($apiKey)) {
        http_response_code(500);
        echo "Szerver konfigurációs hiba: Hiányzik az API kulcs.";
        exit;
    }
    
    $data = [
        'from' => 'Weboldal <onboarding@resend.dev>',
        'to' => [$cimtett],
        'subject' => "Istvandev weboldal üzenet tőle: $nev",
        'html' => "<p><strong>Név:</strong> $nev</p><p><strong>E-mail:</strong> $email</p><p><strong>Üzenet:</strong><br>$uzenet</p>"
    ];

    $ch = curl_init('https://api.resend.com/emails');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . $apiKey,
        'Content-Type: application/json'
    ]);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if ($httpCode >= 200 && $httpCode < 300) {
        http_response_code(200);
        echo "Köszönjük! Az üzenetet elküldtük.";
    } else {
        http_response_code(500);
        echo "Hiba történt az üzenet küldése közben.";
    }
} else {
    http_response_code(403);
    echo "Hibás kérés.";
}
?>