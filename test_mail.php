 <?php
/**
 * Test simple de la fonction mail()
 */

echo "<h2>🧪 Test de la fonction mail()</h2>";

// Vérifier si la fonction existe
if (!function_exists('mail')) {
    echo "<p style='color: red;'>❌ La fonction mail() n'est pas disponible sur ce serveur.</p>";
    echo "<p><strong>Solutions :</strong></p>";
    echo "<ul>";
    echo "<li>Vérifier que PHP mail est activé dans php.ini</li>";
    echo "<li>Contacter votre hébergeur</li>";
    echo "<li>Utiliser SMTP avec PHPMailer</li>";
    echo "</ul>";
    exit;
}

echo "<p style='color: green;'>✅ La fonction mail() est disponible.</p>";

// Configuration du serveur
echo "<h3>Configuration du serveur :</h3>";
echo "<ul>";
echo "<li><strong>Version PHP :</strong> " . phpversion() . "</li>";
echo "<li><strong>SMTP :</strong> " . (ini_get('SMTP') ?: 'Non configuré') . "</li>";
echo "<li><strong>Port SMTP :</strong> " . (ini_get('smtp_port') ?: 'Non configuré') . "</li>";
echo "<li><strong>Sendmail Path :</strong> " . (ini_get('sendmail_path') ?: 'Non configuré') . "</li>";
echo "</ul>";

// Test d'envoi
if (isset($_POST['test_email'])) {
    echo "<h3>Résultat du test :</h3>";
    
    $to = "sambasy837@gmail.com";
    $subject = "Test Email - Portfolio Samba SY";
    $message = "
    <html>
    <head>
        <title>Test Email</title>
    </head>
    <body>
        <h2>🧪 Email de Test</h2>
        <p>Ceci est un email de test envoyé depuis le portfolio de Samba SY.</p>
        <p><strong>Date :</strong> " . date('d/m/Y H:i:s') . "</p>
        <p><strong>Serveur :</strong> " . $_SERVER['SERVER_NAME'] . "</p>
        <p><strong>IP :</strong> " . $_SERVER['SERVER_ADDR'] . "</p>
        <hr>
        <p>Si vous recevez cet email, la fonction mail() fonctionne correctement !</p>
    </body>
    </html>
    ";
    
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= "From: Portfolio Test <noreply@sambasy.com>" . "\r\n";
    $headers .= "X-Mailer: PHP/" . phpversion();
    
    $result = mail($to, $subject, $message, $headers);
    
    if ($result) {
        echo "<p style='color: green; background: #d4edda; padding: 15px; border-radius: 5px;'>";
        echo "✅ <strong>Email envoyé avec succès !</strong><br>";
        echo "Vérifiez votre boîte email (et les spams) : sambasy837@gmail.com";
        echo "</p>";
    } else {
        echo "<p style='color: red; background: #f8d7da; padding: 15px; border-radius: 5px;'>";
        echo "❌ <strong>Échec de l'envoi de l'email.</strong><br>";
        echo "Problème possible avec la configuration du serveur.";
        echo "</p>";
        
        // Informations supplémentaires pour le debug
        $last_error = error_get_last();
        if ($last_error) {
            echo "<p><strong>Dernière erreur PHP :</strong></p>";
            echo "<pre style='background: #f8f9fa; padding: 10px; border-radius: 4px;'>";
            echo htmlspecialchars(print_r($last_error, true));
            echo "</pre>";
        }
    }
}
?>

<style>
body {
    font-family: Arial, sans-serif;
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
    line-height: 1.6;
}
.test-form {
    background: #f8f9fa;
    padding: 20px;
    border-radius: 8px;
    margin: 20px 0;
}
.test-button {
    background: #007bff;
    color: white;
    padding: 12px 24px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
}
.test-button:hover {
    background: #0056b3;
}
</style>

<div class="test-form">
    <h3>Tester l'envoi d'email</h3>
    <p>Cliquez sur le bouton ci-dessous pour envoyer un email de test à sambasy837@gmail.com</p>
    <form method="POST">
        <button type="submit" name="test_email" class="test-button">
            📧 Envoyer un email de test
        </button>
    </form>
</div>

<p><a href="debug_contact.php">🔍 Diagnostic complet du formulaire</a></p>
<p><a href="contact.html">← Retour au formulaire de contact</a></p>
