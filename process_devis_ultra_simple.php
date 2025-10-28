<?php
// Version ultra-simple devis qui fonctionne - comme le test qui marchait
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Récupérer les données
    $fullName = htmlspecialchars(trim($_POST['fullName'] ?? ''));
    $email = htmlspecialchars(trim($_POST['email'] ?? ''));
    $phone = htmlspecialchars(trim($_POST['phone'] ?? ''));
    $company = htmlspecialchars(trim($_POST['company'] ?? ''));
    $projectType = htmlspecialchars(trim($_POST['projectType'] ?? ''));
    $budget = htmlspecialchars(trim($_POST['budget'] ?? ''));
    $projectDescription = htmlspecialchars(trim($_POST['projectDescription'] ?? ''));
    $timeline = htmlspecialchars(trim($_POST['timeline'] ?? ''));
    
    // Validation simple
    if (!empty($fullName) && !empty($email) && !empty($projectType) && !empty($projectDescription) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
        
        // Email EXACTEMENT comme le test qui fonctionnait
        $to = "sambasy837@gmail.com";
        $email_subject = "Demande de Devis - " . $fullName;
        $email_body = "
NOUVELLE DEMANDE DE DEVIS
Portfolio Samba SY

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
        ";
        
        // Headers EXACTEMENT comme le test qui fonctionnait
        $headers = "From: Portfolio Samba SY <sambasy837@gmail.com>\r\n";
        $headers .= "Reply-To: $email\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
        
        // Envoyer
        $result = mail($to, $email_subject, $email_body, $headers);
        
        // Redirection
        header("Location: devis_success.php?name=" . urlencode($fullName) . "&project=" . urlencode($projectType));
        exit();
    }
}

// Redirection par défaut
header("Location: devis.html");
exit();
?>
