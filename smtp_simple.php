<?php
/**
 * Configuration SMTP simplifiée - SANS erreurs de syntaxe
 */

// Configuration Gmail SMTP
$smtp_config = [
    'host' => 'smtp.gmail.com',
    'port' => 587,
    'username' => 'sambasy837@gmail.com',
    'password' => '', // ← Remplacez ici
    'from_email' => 'sambasy837@gmail.com',
    'from_name' => 'Portfolio Samba SY',
    'to_email' => 'sambasy837@gmail.com'
];

function send_email_optimized($to, $subject, $body, $reply_to = null, $priority = 'normal') {
    global $smtp_config;
    
    // Headers optimisés anti-spam
    $headers = "From: " . $smtp_config['from_name'] . " <" . $smtp_config['from_email'] . ">\r\n";
    
    if ($reply_to) {
        $headers .= "Reply-To: $reply_to\r\n";
    }
    
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
    $headers .= "X-Mailer: Portfolio-AntiSpam/1.0\r\n";
    $headers .= "Message-ID: <" . time() . "." . uniqid() . "@sambasy.com>\r\n";
    $headers .= "Date: " . date('r') . "\r\n";
    
    if ($priority === 'high') {
        $headers .= "X-Priority: 1\r\n";
        $headers .= "Importance: High\r\n";
        $headers .= "X-MSMail-Priority: High\r\n";
    }
    
    // Envoyer avec la fonction mail() native mais headers optimisés
    return mail($to, $subject, $body, $headers);
}

function test_config() {
    global $smtp_config;
    
    echo "<h3>🔍 Vérification de la configuration</h3>";
    
    if ($smtp_config['password'] === 'REMPLACEZ_PAR_VOTRE_MOT_DE_PASSE_APP') {
        echo "<div style='background: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px; margin: 10px 0;'>";
        echo "<strong>⚠️ Configuration incomplète</strong><br>";
        echo "Vous devez configurer votre mot de passe d'application Gmail dans smtp_simple.php";
        echo "</div>";
        return false;
    }
    
    echo "<div style='background: #d4edda; color: #155724; padding: 15px; border-radius: 5px; margin: 10px 0;'>";
    echo "<strong>✅ Configuration détectée</strong><br>";
    echo "Email : " . $smtp_config['username'] . "<br>";
    echo "Destinataire : " . $smtp_config['to_email'];
    echo "</div>";
    
    return true;
}
?>
