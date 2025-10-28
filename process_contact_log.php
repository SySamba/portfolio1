<?php
// Version avec logging pour diagnostiquer l'envoi d'email
function log_debug($message) {
    $log_file = 'email_debug.log';
    $timestamp = date('Y-m-d H:i:s');
    file_put_contents($log_file, "[$timestamp] $message\n", FILE_APPEND | LOCK_EX);
}

log_debug("=== DÉBUT TRAITEMENT CONTACT ===");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    log_debug("Méthode POST détectée");
    
    // Récupérer les données
    $name = htmlspecialchars(trim($_POST['name'] ?? ''));
    $email = htmlspecialchars(trim($_POST['email'] ?? ''));
    $phone = htmlspecialchars(trim($_POST['phone'] ?? ''));
    $company = htmlspecialchars(trim($_POST['company'] ?? ''));
    $subject = htmlspecialchars(trim($_POST['subject'] ?? ''));
    $budget = htmlspecialchars(trim($_POST['budget'] ?? ''));
    $timeline = htmlspecialchars(trim($_POST['timeline'] ?? ''));
    $message = htmlspecialchars(trim($_POST['message'] ?? ''));
    
    log_debug("Données reçues - Nom: $name, Email: $email, Sujet: $subject");
    
    // Validation
    if (!empty($name) && !empty($email) && !empty($subject) && !empty($message) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
        log_debug("Validation réussie");
        
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
Portfolio Samba SY - Expert Data Science & IA

=== INFORMATIONS CLIENT ===
Nom : $name
Email : $email
Téléphone : " . ($phone ?: 'Non renseigné') . "
Entreprise : " . ($company ?: 'Non renseignée') . "

=== DÉTAILS DU PROJET ===
Sujet : " . ($subject_map[$subject] ?? $subject) . "
Budget : " . ($budget ?: 'Non renseigné') . "
Délai : " . ($timeline ?: 'Non renseigné') . "

=== MESSAGE ===
$message

=== INFORMATIONS TECHNIQUES ===
Date : " . date('d/m/Y à H:i:s') . "
IP : " . ($_SERVER['REMOTE_ADDR'] ?? 'inconnue') . "
User Agent : " . ($_SERVER['HTTP_USER_AGENT'] ?? 'inconnu') . "

---
Portfolio Samba SY
📧 sambasy837@gmail.com
📱 +221 77 378 48 14
🌍 Dakar, Sénégal
        ";
        
        $headers = "From: Portfolio Samba SY <noreply@sambasy.com>\r\n";
        $headers .= "Reply-To: $email\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
        $headers .= "X-Mailer: PHP/" . phpversion() . "\r\n";
        
        log_debug("Email préparé - Destinataire: $to, Sujet: $email_subject");
        log_debug("Longueur du message: " . strlen($email_body) . " caractères");
        
        // Tentative d'envoi
        log_debug("Tentative d'envoi avec mail()...");
        $mail_result = mail($to, $email_subject, $email_body, $headers);
        
        if ($mail_result) {
            log_debug("✅ mail() a retourné TRUE - Email supposé envoyé");
        } else {
            log_debug("❌ mail() a retourné FALSE - Échec de l'envoi");
            
            // Log des erreurs PHP
            $last_error = error_get_last();
            if ($last_error) {
                log_debug("Erreur PHP: " . $last_error['message']);
            }
        }
        
        // Redirection forcée (même si l'email échoue)
        log_debug("Redirection vers page de succès");
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
    <p>Redirection en cours... <a href='contact_success_simple.php?name=" . urlencode($name) . "'>Cliquez ici</a></p>
</body>
</html>";
        exit();
        
    } else {
        log_debug("❌ Validation échouée - Champs manquants ou email invalide");
    }
} else {
    log_debug("Accès direct - Redirection vers contact.html");
}

log_debug("=== FIN TRAITEMENT ===");

// Redirection par défaut
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
    <p>Redirection... <a href='contact.html'>Cliquez ici</a></p>
</body>
</html>";
?>
