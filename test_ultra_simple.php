<?php
/**
 * Test ultra-simple - Version qui fonctionne
 */

if (isset($_POST['test_email'])) {
    echo "<h3>🚀 Test d'envoi en cours...</h3>";
    
    $to = "sambasy837@gmail.com";
    $subject = "TEST ULTRA SIMPLE - Portfolio";
    $message = "
TEST ULTRA SIMPLE

Ceci est un test ultra-simple pour vérifier que l'envoi d'email fonctionne.

Date : " . date('d/m/Y H:i:s') . "
Serveur : " . ($_SERVER['SERVER_NAME'] ?? 'localhost') . "

Si vous recevez cet email, tout fonctionne !
    ";
    
    // Headers simples
    $headers = "From: Portfolio Samba SY <sambasy837@gmail.com>\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
    
    $result = mail($to, $subject, $message, $headers);
    
    if ($result) {
        echo "<div style='background: #d4edda; color: #155724; padding: 20px; border-radius: 8px; margin: 20px 0;'>";
        echo "<h4>✅ Email envoyé avec succès !</h4>";
        echo "<p>Vérifiez sambasy837@gmail.com (et le dossier spam)</p>";
        echo "</div>";
    } else {
        echo "<div style='background: #f8d7da; color: #721c24; padding: 20px; border-radius: 8px; margin: 20px 0;'>";
        echo "<h4>❌ Échec de l'envoi</h4>";
        echo "<p>Problème avec le serveur</p>";
        echo "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Test Ultra Simple</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            line-height: 1.6;
        }
        .test-form {
            background: #f8f9fa;
            padding: 30px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        .test-button {
            background: #28a745;
            color: white;
            padding: 15px 30px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
        }
        .test-button:hover {
            background: #1e7e34;
        }
    </style>
</head>
<body>
    <div class="test-form">
        <h2>🧪 Test Ultra Simple</h2>
        <p>Version basique - Exactement comme le test qui fonctionnait</p>
        
        <form method="POST">
            <button type="submit" name="test_email" class="test-button">
                📧 Test Ultra Simple
            </button>
        </form>
        
        <p style="margin-top: 30px;">
            <a href="contact.html">📝 Formulaire de contact</a> |
            <a href="devis.html">💰 Formulaire de devis</a>
        </p>
    </div>
</body>
</html>
