<?php
/**
 * Test de configuration - Affichage des paramètres
 */

// Configuration Gmail SMTP
$smtp_config = [
    'host' => 'smtp.gmail.com',
    'port' => 587,
    'username' => 'sambasy837@gmail.com',
    'password' => 'REMPLACEZ_PAR_VOTRE_MOT_DE_PASSE_APP', // ← Remplacez ici
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

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Configuration - Portfolio Samba SY</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            line-height: 1.6;
            background: #f8f9fa;
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        .config-box {
            background: #f8fafc;
            padding: 20px;
            border-radius: 8px;
            border-left: 4px solid #007bff;
            margin: 20px 0;
        }
        .warning {
            background: #fff3cd;
            border-left-color: #ffc107;
            color: #856404;
        }
        .success {
            background: #d4edda;
            border-left-color: #28a745;
            color: #155724;
        }
        .test-form {
            background: #e3f2fd;
            padding: 25px;
            border-radius: 8px;
            text-align: center;
            margin: 20px 0;
        }
        .test-button {
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            color: white;
            padding: 15px 30px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .test-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 123, 255, 0.3);
        }
        h1, h2, h3 {
            color: #1f2937;
        }
        .status-ok {
            color: #28a745;
            font-weight: bold;
        }
        .status-error {
            color: #dc3545;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔧 Test de Configuration Email</h1>
        
        <div class="config-box">
            <h3>📧 Configuration actuelle</h3>
            <ul>
                <li><strong>Serveur SMTP :</strong> <?php echo $smtp_config['host']; ?>:<?php echo $smtp_config['port']; ?></li>
                <li><strong>Email expéditeur :</strong> <?php echo $smtp_config['from_email']; ?></li>
                <li><strong>Nom expéditeur :</strong> <?php echo $smtp_config['from_name']; ?></li>
                <li><strong>Email destinataire :</strong> <?php echo $smtp_config['to_email']; ?></li>
            </ul>
        </div>

        <?php
        // Vérifier la configuration
        if ($smtp_config['password'] === 'REMPLACEZ_PAR_VOTRE_MOT_DE_PASSE_APP') {
            echo '<div class="config-box warning">';
            echo '<h3>⚠️ Configuration incomplète</h3>';
            echo '<p>Le mot de passe Gmail n\'est pas configuré. Le système utilisera les headers optimisés sans authentification SMTP.</p>';
            echo '<p><strong>Pour configurer :</strong> Modifiez le fichier smtp_simple.php et remplacez le mot de passe.</p>';
            echo '</div>';
        } else {
            echo '<div class="config-box success">';
            echo '<h3>✅ Configuration détectée</h3>';
            echo '<p>Mot de passe Gmail configuré. Le système est prêt.</p>';
            echo '</div>';
        }

        // Vérifier la fonction mail()
        if (function_exists('mail')) {
            echo '<div class="config-box success">';
            echo '<h3>✅ Fonction mail() disponible</h3>';
            echo '<p>Le serveur supporte l\'envoi d\'emails.</p>';
            echo '</div>';
        } else {
            echo '<div class="config-box warning">';
            echo '<h3>❌ Fonction mail() non disponible</h3>';
            echo '<p>Le serveur ne supporte pas l\'envoi d\'emails natif.</p>';
            echo '</div>';
        }

        // Test d'envoi
        if (isset($_POST['test_email'])) {
            echo '<h3>🚀 Test d\'envoi en cours...</h3>';
            
            $test_subject = "TEST CONFIG - Portfolio Samba SY";
            $test_body = "
TEST DE CONFIGURATION EMAIL
Portfolio Samba SY

Ceci est un test pour vérifier que la configuration email fonctionne.

Détails du test :
- Date : " . date('d/m/Y H:i:s') . "
- Serveur : " . $_SERVER['SERVER_NAME'] . "
- IP : " . $_SERVER['SERVER_ADDR'] . "

Si vous recevez cet email, la configuration fonctionne !

---
Portfolio Samba SY
📧 sambasy837@gmail.com
📱 +221 77 378 48 14
🌍 Dakar, Sénégal
            ";
            
            $result = send_email_optimized($smtp_config['to_email'], $test_subject, $test_body);
            
            if ($result) {
                echo '<div class="config-box success">';
                echo '<h4>✅ Email envoyé avec succès !</h4>';
                echo '<p>Vérifiez votre boîte email : ' . $smtp_config['to_email'] . '</p>';
                echo '<p><small>Note : L\'email peut prendre quelques minutes pour arriver. Vérifiez aussi le dossier spam.</small></p>';
                echo '</div>';
            } else {
                echo '<div class="config-box warning">';
                echo '<h4>❌ Échec de l\'envoi</h4>';
                echo '<p>Il y a un problème avec la configuration email du serveur.</p>';
                echo '</div>';
            }
        }
        ?>

        <div class="test-form">
            <h3>🧪 Tester l'envoi d'email</h3>
            <p>Cliquez pour envoyer un email de test à sambasy837@gmail.com</p>
            
            <form method="POST">
                <button type="submit" name="test_email" class="test-button">
                    📧 Envoyer un test
                </button>
            </form>
        </div>

        <div class="config-box">
            <h3>🔗 Liens utiles</h3>
            <ul>
                <li><a href="contact.html">📝 Formulaire de contact</a></li>
                <li><a href="devis.html">💰 Formulaire de devis</a></li>
                <li><a href="test_simple.php">🧪 Test simple</a></li>
            </ul>
        </div>
    </div>
</body>
</html>
