<?php
// Version devis qui copie exactement le test qui fonctionne
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Récupérer les données
    $fullName = $_POST['fullName'] ?? 'Visiteur';
    $email = $_POST['email'] ?? 'inconnu@example.com';
    $phone = $_POST['phone'] ?? '';
    $company = $_POST['company'] ?? '';
    $projectType = $_POST['projectType'] ?? '';
    $budget = $_POST['budget'] ?? '';
    $projectDescription = $_POST['projectDescription'] ?? '';
    $timeline = $_POST['timeline'] ?? '';
    
    // Email EXACTEMENT comme le test qui fonctionne
    $to = "sambasy837@gmail.com";
    $email_subject = "Demande de Devis - " . $fullName;
    $email_body = "
NOUVELLE DEMANDE DE DEVIS - Portfolio

Nom : $fullName
Email : $email
Téléphone : $phone
Entreprise : $company
Type de projet : $projectType
Budget : $budget
Délai : $timeline

Description du projet :
$projectDescription

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
        window.location.href = 'devis_success.php?name=" . urlencode($fullName) . "&project=" . urlencode($projectType) . "';
    </script>
    <p>Redirection... <a href='devis_success.php?name=" . urlencode($fullName) . "&project=" . urlencode($projectType) . "'>Cliquez ici</a></p>
</body>
</html>";
    exit();
}

// Redirection par défaut
header("Location: devis.html");
exit();
?>
