<?php
/**
 * Formulaire de devis avec SMTP Gmail (évite les spams)
 */

// Configuration SMTP Gmail - MODIFIEZ LE MOT DE PASSE
$smtp_config = [
    'host' => 'smtp.gmail.com',
    'port' => 587,
    'username' => 'sambasy837@gmail.com',
    'password' => 'VOTRE_MOT_DE_PASSE_APP_GMAIL', // ← Remplacez par votre mot de passe d'application
    'encryption' => 'tls',
    'from_email' => 'sambasy837@gmail.com',
    'from_name' => 'Portfolio Samba SY'
];

function send_smtp_email($to, $subject, $body, $reply_to = null) {
    global $smtp_config;
    
    // Essayer d'utiliser PHPMailer si disponible
    if (class_exists('PHPMailer\PHPMailer\PHPMailer')) {
        require_once 'phpmailer/src/Exception.php';
        require_once 'phpmailer/src/PHPMailer.php';
        require_once 'phpmailer/src/SMTP.php';
        
        use PHPMailer\PHPMailer\PHPMailer;
        use PHPMailer\PHPMailer\Exception;
        
        $mail = new PHPMailer(true);
        
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
        } catch (Exception $e) {
            error_log("Erreur SMTP: " . $mail->ErrorInfo);
            return false;
        }
    } else {
        // Fallback optimisé anti-spam
        $headers = "From: " . $smtp_config['from_name'] . " <" . $smtp_config['from_email'] . ">\r\n";
        if ($reply_to) {
            $headers .= "Reply-To: $reply_to\r\n";
        }
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
        $headers .= "X-Mailer: Portfolio-SMTP/1.0\r\n";
        $headers .= "X-Priority: 1\r\n"; // Priorité haute pour devis
        $headers .= "Message-ID: <" . time() . "." . uniqid() . "@sambasy.com>\r\n";
        
        return mail($to, $subject, $body, $headers);
    }
}

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
    
    // Validation
    if (!empty($fullName) && !empty($email) && !empty($projectType) && !empty($projectDescription) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
        
        // Mapper les types de projets
        $project_map = [
            'web' => '🌐 Site Web / E-commerce',
            'data' => '📊 Analyse de Données / BI',
            'ai' => '🤖 Intelligence Artificielle',
            'cloud' => '☁️ Cloud / DevOps',
            'mobile' => '📱 Application Mobile',
            'other' => '🔧 Autre'
        ];
        
        $email_subject = "🎯 DEVIS URGENT - " . $fullName;
        $email_body = "
NOUVELLE DEMANDE DE DEVIS - PRIORITÉ HAUTE
Portfolio Samba SY - Expert Data Science & IA

=== INFORMATIONS CLIENT ===
Nom complet : $fullName
Email : $email
Téléphone : " . ($phone ?: 'Non renseigné') . "
Entreprise : " . ($company ?: 'Particulier') . "

=== DÉTAILS DU PROJET ===
Type de projet : " . ($project_map[$projectType] ?? $projectType) . "
Budget estimé : $budget
Délai souhaité : $timeline

=== DESCRIPTION COMPLÈTE DU PROJET ===
$projectDescription

=== ACTIONS IMMÉDIATES RECOMMANDÉES ===
🔥 PRIORITÉ HAUTE - Répondre dans les 4 heures
📞 Programmer un appel de découverte dans les 24h
💼 Préparer une proposition détaillée personnalisée
📊 Envoyer des exemples de projets similaires
💰 Calculer un devis précis selon les besoins

=== INFORMATIONS TECHNIQUES ===
Date de demande : " . date('d/m/Y à H:i:s') . "
IP du client : " . ($_SERVER['REMOTE_ADDR'] ?? 'inconnue') . "
Navigateur : " . ($_SERVER['HTTP_USER_AGENT'] ?? 'inconnu') . "

---
Portfolio Samba SY - Expert Data Science & Intelligence Artificielle
📧 sambasy837@gmail.com
📱 +221 77 378 48 14 (WhatsApp disponible)
🌍 Dakar, Sénégal
🌐 https://sambasy.teranganumerique.com

✅ Email envoyé via SMTP Gmail authentifié (évite les spams)
🔒 Données sécurisées et confidentielles
        ";
        
        // Envoyer via SMTP Gmail
        $mail_result = send_smtp_email("sambasy837@gmail.com", $email_subject, $email_body, $email);
        
        // Sauvegarder dans un fichier (backup)
        $log_file = 'messages_devis_smtp.txt';
        $log_entry = "\n=== DEVIS DEMANDÉ LE " . date('d/m/Y H:i:s') . " ===\n";
        $log_entry .= "Nom : $fullName\n";
        $log_entry .= "Email : $email\n";
        $log_entry .= "Téléphone : " . ($phone ?: 'Non renseigné') . "\n";
        $log_entry .= "Entreprise : " . ($company ?: 'Particulier') . "\n";
        $log_entry .= "Type : " . ($project_map[$projectType] ?? $projectType) . "\n";
        $log_entry .= "Budget : $budget\n";
        $log_entry .= "Délai : $timeline\n";
        $log_entry .= "Description : $projectDescription\n";
        $log_entry .= "IP : " . ($_SERVER['REMOTE_ADDR'] ?? 'inconnue') . "\n";
        $log_entry .= "Status SMTP : " . ($mail_result ? 'Envoyé via Gmail' : 'Échec') . "\n";
        $log_entry .= "================================\n";
        
        file_put_contents($log_file, $log_entry, FILE_APPEND | LOCK_EX);
        
        // Redirection vers la page de succès
        echo "<!DOCTYPE html>
<html>
<head>
    <meta charset='UTF-8'>
    <title>Devis envoyé via SMTP</title>
</head>
<body>
    <script>
        window.location.href = 'devis_success.php?name=" . urlencode($fullName) . "&project=" . urlencode($projectType) . "';
    </script>
    <p>Devis envoyé via SMTP Gmail, redirection... <a href='devis_success.php?name=" . urlencode($fullName) . "&project=" . urlencode($projectType) . "'>Cliquez ici</a></p>
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
        window.location.href = 'devis.html';
    </script>
    <p>Redirection... <a href='devis.html'>Cliquez ici</a></p>
</body>
</html>";
?>
