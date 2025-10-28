<?php
/**
 * Configuration SMTP centralisée
 * MODIFIEZ UNIQUEMENT CE FICHIER POUR CHANGER LES PARAMÈTRES SMTP
 */

// Configuration SMTP Gmail
$smtp_config = [
    'host' => 'smtp.gmail.com',
    'port' => 587,
    'username' => 'sambasy837@gmail.com',
    'password' => 'REMPLACEZ_PAR_VOTRE_MOT_DE_PASSE_APP', // ← IMPORTANT : Remplacez ici
    'encryption' => 'tls',
    'from_email' => 'sambasy837@gmail.com',
    'from_name' => 'Portfolio Samba SY',
    'to_email' => 'sambasy837@gmail.com'
];

/**
 * Instructions pour obtenir le mot de passe d'application Gmail :
 * 
 * 1. Allez sur https://myaccount.google.com
 * 2. Cliquez sur "Sécurité"
 * 3. Activez la "Validation en deux étapes" si ce n'est pas fait
 * 4. Cliquez sur "Mots de passe des applications"
 * 5. Sélectionnez "Autre" et tapez "Portfolio Samba SY"
 * 6. Copiez le mot de passe généré (16 caractères)
 * 7. Remplacez 'REMPLACEZ_PAR_VOTRE_MOT_DE_PASSE_APP' ci-dessus
 */

function send_smtp_email($to, $subject, $body, $reply_to = null, $priority = 'normal') {
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
            
            // Priorité
            if ($priority === 'high') {
                $mail->Priority = 1;
            }
            
            // Contenu
            $mail->isHTML(false);
            $mail->Subject = $subject;
            $mail->Body = $body;
            
            $mail->send();
            return ['success' => true, 'method' => 'PHPMailer SMTP'];
        } catch (Exception $e) {
            error_log("Erreur SMTP PHPMailer: " . $mail->ErrorInfo);
            // Fallback vers mail() natif
        }
    }
    
    // Fallback avec mail() natif mais headers optimisés anti-spam
    $headers = "From: " . $smtp_config['from_name'] . " <" . $smtp_config['from_email'] . ">\r\n";
    if ($reply_to) {
        $headers .= "Reply-To: $reply_to\r\n";
    }
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
    $headers .= "X-Mailer: Portfolio-SMTP/1.0\r\n";
    $headers .= "Message-ID: <" . time() . "." . uniqid() . "@sambasy.com>\r\n";
    
    if ($priority === 'high') {
        $headers .= "X-Priority: 1\r\n";
        $headers .= "Importance: High\r\n";
    }
    
    $result = mail($to, $subject, $body, $headers);
    return ['success' => $result, 'method' => 'PHP mail() optimisé'];
}

// Test de configuration
function test_smtp_config() {
    global $smtp_config;
    
    echo "<h3>🧪 Test de la configuration SMTP</h3>";
    
    // Vérifier si le mot de passe a été configuré
    if ($smtp_config['password'] === 'REMPLACEZ_PAR_VOTRE_MOT_DE_PASSE_APP') {
        echo "<div style='background: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px; margin: 10px 0;'>";
        echo "<strong>⚠️ Configuration incomplète</strong><br>";
        echo "Vous devez remplacer 'REMPLACEZ_PAR_VOTRE_MOT_DE_PASSE_APP' par votre vrai mot de passe d'application Gmail.";
        echo "</div>";
        return false;
    }
    
    echo "<div style='background: #d4edda; color: #155724; padding: 15px; border-radius: 5px; margin: 10px 0;'>";
    echo "<strong>✅ Configuration SMTP détectée</strong><br>";
    echo "Serveur : " . $smtp_config['host'] . ":" . $smtp_config['port'] . "<br>";
    echo "Email : " . $smtp_config['username'] . "<br>";
    echo "Chiffrement : " . strtoupper($smtp_config['encryption']);
    echo "</div>";
    
    return true;
}
?>
