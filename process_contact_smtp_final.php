<?php
/**
 * Formulaire de contact avec SMTP (évite les spams)
 */

// Utiliser la configuration centralisée
require_once 'smtp_config.php';

function send_smtp_email($to, $subject, $body, $reply_to = null) {
    global $smtp_config;
    
    // Essayer d'utiliser PHPMailer si disponible
    if (class_exists('PHPMailer\PHPMailer\PHPMailer')) {
        require_once 'phpmailer/src/Exception.php';
        require_once 'phpmailer/src/PHPMailer.php';
        require_once 'phpmailer/src/SMTP.php';
        
        $mail = new \PHPMailer\PHPMailer\PHPMailer(true);
        
        try {
            // Configuration SMTP
            $mail->isSMTP();
            $mail->Host = $smtp_config['host'];
            $mail->SMTPAuth = true;
            $mail->Username = $smtp_config['username'];
            $mail->Password = $smtp_config['password'];
            $mail->SMTPSecure = $smtp_config['encryption'];
            $mail->Port = $smtp_config['port'];
            
            // Expéditeur et destinataire
            $mail->setFrom($smtp_config['from_email'], $smtp_config['from_name']);
            $mail->addAddress($to);
            if ($reply_to) {
                $mail->addReplyTo($reply_to);
            }
            
            // Contenu
            $mail->isHTML(false);
            $mail->Subject = $subject;
            $mail->Body = $body;
            
            $mail->send();
            return true;
        } catch (\Exception $e) {
            error_log("Erreur SMTP: " . $mail->ErrorInfo);
            return false;
        }
    } else {
        // Fallback avec mail() native
        $headers = "From: " . $smtp_config['from_name'] . " <" . $smtp_config['from_email'] . ">\r\n";
        if ($reply_to) {
            $headers .= "Reply-To: $reply_to\r\n";
        }
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
        $headers .= "X-Mailer: PHP/" . phpversion() . "\r\n";
        
        return mail($to, $subject, $body, $headers);
    }
}

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
    
    // Validation
    if (!empty($name) && !empty($email) && !empty($subject) && !empty($message) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
        
        // Mapper les sujets
        $subject_map = [
            'ia' => '🤖 Projet Intelligence Artificielle',
            'cloud' => '☁️ Solution Cloud & DevOps',
            'data' => '📊 Data Analytics & BI',
            'web' => '🌐 Développement Web',
            'consultation' => '💼 Consultation',
            'autre' => '🔧 Autre'
        ];
        
        $email_subject = "📧 Contact Portfolio - " . $name;
        $email_body = "
NOUVEAU MESSAGE DE CONTACT
Portfolio Samba SY - Expert Data Science & IA

=== INFORMATIONS CLIENT ===
Nom complet : $name
Email : $email
Téléphone : " . ($phone ?: 'Non renseigné') . "
Entreprise : " . ($company ?: 'Non renseignée') . "

=== DÉTAILS DU PROJET ===
Sujet : " . ($subject_map[$subject] ?? $subject) . "
Budget estimé : " . ($budget ?: 'Non renseigné') . "
Délai souhaité : " . ($timeline ?: 'Non renseigné') . "

=== MESSAGE ===
$message

=== ACTIONS RECOMMANDÉES ===
1. Répondre dans les 24h
2. Analyser les besoins du client  
3. Proposer une solution adaptée
4. Programmer un appel si nécessaire

---
Message reçu le " . date('d/m/Y à H:i:s') . "
Portfolio Samba SY
📧 sambasy837@gmail.com
📱 +221 77 378 48 14
🌍 Dakar, Sénégal

✅ Email envoyé via SMTP authentifié (évite les spams)
        ";
        
        // Envoyer via SMTP
        $mail_result = send_smtp_email("sambasy837@gmail.com", $email_subject, $email_body, $email);
        
        // Sauvegarder dans un fichier (backup)
        $log_file = 'messages_contact_smtp.txt';
        $log_entry = "\n=== MESSAGE REÇU LE " . date('d/m/Y H:i:s') . " ===\n";
        $log_entry .= "Nom : $name\n";
        $log_entry .= "Email : $email\n";
        $log_entry .= "Téléphone : " . ($phone ?: 'Non renseigné') . "\n";
        $log_entry .= "Entreprise : " . ($company ?: 'Non renseignée') . "\n";
        $log_entry .= "Sujet : " . ($subject_map[$subject] ?? $subject) . "\n";
        $log_entry .= "Budget : " . ($budget ?: 'Non renseigné') . "\n";
        $log_entry .= "Délai : " . ($timeline ?: 'Non renseigné') . "\n";
        $log_entry .= "Message : $message\n";
        $log_entry .= "IP : " . ($_SERVER['REMOTE_ADDR'] ?? 'inconnue') . "\n";
        $log_entry .= "Status SMTP : " . ($mail_result ? 'Envoyé' : 'Échec') . "\n";
        $log_entry .= "================================\n";
        
        file_put_contents($log_file, $log_entry, FILE_APPEND | LOCK_EX);
        
        // Redirection vers la page de succès
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
    <p>Message envoyé via SMTP, redirection... <a href='contact_success_simple.php?name=" . urlencode($name) . "'>Cliquez ici</a></p>
</body>
</html>";
        exit();
    }
}

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
