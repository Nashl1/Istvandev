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

    $targy = "Istvandev weboldal üzenet tőle: $nev";
    
    $tartalom = "Név: $nev\n";
    $tartalom .= "E-mail: $email\n\n";
    $tartalom .= "Üzenet:\n$uzenet\n";

    $fejlec = "From: $nev <$email>";

    // E-mail küldése
    if (mail($cimtett, $targy, $tartalom, $fejlec)) {
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