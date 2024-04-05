<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $subject = $_POST['subject'];
    $budget = isset($_POST['budget']) ? $_POST['budget'] : '';
    $message = $_POST['message'];

    // Empfänger-E-Mail-Adresse (deine E-Mail-Adresse)
    $empfaenger = "svrn.richter@outlook.de";

    // Betreff der E-Mail
    $betreff = "Neue Nachricht: $subject";

    // E-Mail-Inhalt
    $nachricht = "Name: $name\n";
    $nachricht .= "E-Mail: $email\n";
    $nachricht .= "Telefonnummer: $phone\n";
    $nachricht .= "Betreff: $subject\n";
    $nachricht .= "Budget: $budget\n\n";
    $nachricht .= "Nachricht:\n$message";

    // Dateiupload verarbeiten (falls eine Datei hochgeladen wurde)
    if (isset($_FILES['file']) && $_FILES['file']['error'] == UPLOAD_ERR_OK) {
        $dateiname = $_FILES['file']['name'];
        $dateipfad = $_FILES['file']['tmp_name'];
        $anhang = chunk_split(base64_encode(file_get_contents($dateipfad)));
        $header = "Content-Type: application/octet-stream\r\n";
        $header .= "Content-Disposition: attachment; filename=\"$dateiname\"\r\n\r\n";
        $nachricht .= "--$dateiname\r\n$anhang\r\n";
    }

    // E-Mail senden
    $success = mail($empfaenger, $betreff, $nachricht);

    if ($success) {
        // Erfolgsmeldung durch URL-Parameter übergeben
        header("Location: index.html?success=true");
        exit;
    } else {
        echo '<p style="color: red;">Es gab ein Problem beim Senden Ihrer Nachricht. Bitte versuchen Sie es später erneut.</p>';
    }
}
?>