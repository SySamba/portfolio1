<?php
// Version qui copie exactement le test qui fonctionne
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Récupérer les données
    $name = $_POST['name'] ?? 'Visiteur';
    $email = $_POST['email'] ?? 'inconnu@example.com';
    $phone = $_POST['phone'] ?? '';
    $company = $_POST['company'] ?? '';
    $subject = $_POST['subject'] ?? '';
    $budget = $_POST['budget'] ?? '';
    $timeline = $_POST['timeline'] ?? '';
    $message = $_POST['message'] ?? '';
    
    // Email EXACTEMENT comme le test qui fonctionne
    $to = "sambasy837@gmail.com";
    $email_subject = "Contact Portfolio - " . $name;
    $email_body = "
NOUVEAU MESSAGE DE CONTACT - Portfolio

Nom : $name
Email : $email
Téléphone : $phone
Entreprise : $company
Sujet : $subject
Budget : $budget
Délai : $timeline

Message :
$message

Date : " . date('d/m/Y H:i:s') . "
Serveur : " . ($_SERVER['SERVER_NAME'] ?? 'localhost') . "
    ";
    
    // Headers EXACTEMENT comme le test qui fonctionne
    $headers = "From: Portfolio Debug <debug@sambasy.com>\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
    
    // Envoi
    $result = mail($to, $email_subject, $email_body, $headers);
    
    // Toujours rediriger (même si l'email échoue)
    echo "<!DOCTYPE html>
<html>
<head>
    <meta charset='UTF-8'>
    <title>Redirection...</title>
</head>
<body>
    <script>
        window.location.href = 'contact_success_simple.php?name=" . urlencode($name) . "';
    </script>
    <p>Redirection... <a href='contact_success_simple.php?name=" . urlencode($name) . "'>Cliquez ici</a></p>
</body>
</html>";
    exit();
}

// Redirection par défaut
header("Location: contact.html");
exit();
?>
