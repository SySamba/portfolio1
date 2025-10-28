<?php
/**
 * Test SMTP Gmail - Configuration et envoi
 */

require_once 'smtp_config.php';

echo "<h2>🧪 Test SMTP Gmail</h2>";

// Tester la configuration
test_smtp_config();

if (isset($_POST['test_smtp'])) {
    echo "<h3>🚀 Test d'envoi en cours...</h3>";
    
    $test_subject = "TEST SMTP - Portfolio Samba SY";
    $test_body = "
TEST SMTP GMAIL - Portfolio

Ceci est un test d'envoi via SMTP Gmail pour vérifier que la configuration fonctionne.

Détails du test :
- Date : " . date('d/m/Y H:i:s') . "
- Méthode : SMTP Gmail authentifié
- Serveur : smtp.gmail.com:587
- Email : sambasy837@gmail.com

Si vous recevez cet email, la configuration SMTP fonctionne parfaitement !

---
Portfolio Samba SY
Expert Data Science & Intelligence Artificielle
📧 sambasy837@gmail.com
📱 +221 77 378 48 14
🌍 Dakar, Sénégal
    ";
    
    $result = send_smtp_email("sambasy837@gmail.com", $test_subject, $test_body, null, 'normal');
    
    if ($result['success']) {
        echo "<div style='background: #d4edda; color: #155724; padding: 20px; border-radius: 8px; margin: 20px 0;'>";
        echo "<h4 style='margin: 0 0 10px 0;'>✅ Email envoyé avec succès !</h4>";
        echo "<p style='margin: 0;'><strong>Méthode :</strong> " . $result['method'] . "</p>";
        echo "<p style='margin: 10px 0 0 0;'><strong>Vérifiez votre boîte email :</strong> sambasy837@gmail.com</p>";
        echo "<p style='margin: 10px 0 0 0; font-size: 14px; color: #6c757d;'>Note : L'email peut prendre quelques minutes pour arriver.</p>";
        echo "</div>";
    } else {
        echo "<div style='background: #f8d7da; color: #721c24; padding: 20px; border-radius: 8px; margin: 20px 0;'>";
        echo "<h4 style='margin: 0 0 10px 0;'>❌ Échec de l'envoi</h4>";
        echo "<p style='margin: 0;'>Vérifiez votre configuration SMTP dans smtp_config.php</p>";
        echo "</div>";
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
    background: #f8f9fa;
}
.test-container {
    background: white;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    margin-bottom: 20px;
}
.test-form {
    background: #f8fafc;
    padding: 25px;
    border-radius: 8px;
    border-left: 4px solid #007bff;
    text-align: center;
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
h2, h3 {
    color: #1f2937;
    border-bottom: 2px solid #e5e7eb;
    padding-bottom: 10px;
}
.config-info {
    background: #e3f2fd;
    border: 1px solid #bbdefb;
    border-radius: 8px;
    padding: 20px;
    margin: 20px 0;
}
</style>

<div class="test-container">
    <div class="config-info">
        <h4 style="color: #1565c0; margin: 0 0 15px 0;">📋 Instructions de configuration</h4>
        <ol style="margin: 0; padding-left: 20px;">
            <li><strong>Ouvrez</strong> le fichier <code>smtp_config.php</code></li>
            <li><strong>Remplacez</strong> 'REMPLACEZ_PAR_VOTRE_MOT_DE_PASSE_APP' par votre mot de passe d'application Gmail</li>
            <li><strong>Sauvegardez</strong> le fichier</li>
            <li><strong>Testez</strong> ci-dessous</li>
        </ol>
    </div>
    
    <div class="test-form">
        <h3 style="border: none; color: #374151; margin-bottom: 20px;">Test d'envoi SMTP</h3>
        <p style="margin-bottom: 25px; color: #6b7280;">Cliquez pour tester l'envoi d'email via SMTP Gmail</p>
        
        <form method="POST">
            <button type="submit" name="test_smtp" class="test-button">
                📧 Tester SMTP Gmail
            </button>
        </form>
    </div>
    
    <div style="text-align: center; margin-top: 30px;">
        <a href="smtp_config_guide.html" style="color: #007bff; text-decoration: none; margin-right: 20px;">📖 Guide de configuration</a>
        <a href="contact.html" style="color: #007bff; text-decoration: none; margin-right: 20px;">📝 Formulaire de contact</a>
        <a href="devis.html" style="color: #007bff; text-decoration: none;">💰 Formulaire de devis</a>
    </div>
</div>
