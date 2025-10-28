<?php
// Version qui force la redirection sans aucune interférence
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Récupérer les données
    $name = htmlspecialchars(trim($_POST['name'] ?? ''));
    $email = htmlspecialchars(trim($_POST['email'] ?? ''));
    $phone = htmlspecialchars(trim($_POST['phone'] ?? ''));
    $company = htmlspecialchars(trim($_POST['company'] ?? ''));
    $subject = htmlspecialchars(trim($_POST['subject'] ?? ''));
    $budget = htmlspecialchars(trim($_POST['budget'] ?? ''));
    $timeline = htmlspecialchars(trim($_POST['timeline'] ?? ''));
    $message = htmlspecialchars(trim($_POST['message'] ?? ''));
    
    // Validation minimale
    if (!empty($name) && !empty($email) && !empty($subject) && !empty($message) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
        
        // Mapper les valeurs
        $subject_map = [
            'ia' => '🤖 Projet Intelligence Artificielle',
            'cloud' => '☁️ Solution Cloud & DevOps',
            'data' => '📊 Data Analytics & BI',
            'web' => '🌐 Développement Web',
            'consultation' => '💼 Consultation',
            'autre' => '🔧 Autre'
        ];
        
        // Préparer l'email
        $to = "sambasy837@gmail.com";
        $email_subject = "📧 Contact Portfolio - " . $name;
        $email_body = "
NOUVEAU MESSAGE DE CONTACT
Portfolio Samba SY

Nom : $name
Email : $email
Téléphone : " . ($phone ?: 'Non renseigné') . "
Entreprise : " . ($company ?: 'Non renseignée') . "
Sujet : " . ($subject_map[$subject] ?? $subject) . "
Budget : " . ($budget ?: 'Non renseigné') . "
Délai : " . ($timeline ?: 'Non renseigné') . "

Message :
$message

Reçu le " . date('d/m/Y à H:i:s') . "
        ";
        
        // Envoyer l'email
        mail($to, $email_subject, $email_body, "From: Portfolio <noreply@sambasy.com>\r\nReply-To: $email\r\n");
        
        // Redirection JavaScript forcée (au cas où header() ne marche pas)
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
    <p>Redirection en cours... <a href='contact_success_simple.php?name=" . urlencode($name) . "'>Cliquez ici si la redirection ne fonctionne pas</a></p>
</body>
</html>";
        exit();
    }
}

// Si erreur ou accès direct, redirection vers contact
echo "<!DOCTYPE html>
<html>
<head>
    <meta charset='UTF-8'>
    <title>Redirection...</title>
</head>
<body>
    <script>
        window.location.href = 'contact.html';
    </script>
    <p>Redirection vers le formulaire... <a href='contact.html'>Cliquez ici</a></p>
</body>
</html>";
?>
