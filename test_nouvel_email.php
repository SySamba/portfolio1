<?php
/**
 * Test du nouvel email sambasy@teranganumerique.com
 */

echo "<h2>🧪 Test du nouvel email sambasy@teranganumerique.com</h2>";

if (isset($_POST['test_email'])) {
    echo "<h3>🚀 Test en cours...</h3>";
    
    $to = "sambasy837@gmail.com";
    $subject = "TEST - Nouvel Email sambasy@teranganumerique.com";
    $message = "
TEST DU NOUVEL EMAIL DE DOMAINE

Ceci est un test pour vérifier que l'email sambasy@teranganumerique.com fonctionne correctement.

Détails du test :
- Email expéditeur : sambasy@teranganumerique.com
- Email destinataire : sambasy837@gmail.com
- Date : " . date('d/m/Y H:i:s') . "
- Serveur : " . ($_SERVER['SERVER_NAME'] ?? 'localhost') . "

Si vous recevez cet email, la configuration fonctionne parfaitement !

---
Portfolio Samba SY
Expert Data Science & IA
📧 sambasy@teranganumerique.com
📱 +221 77 378 48 14
🌍 Dakar, Sénégal
    ";
    
    // Headers avec le nouvel email
    $headers = "From: Portfolio Samba SY <sambasy@teranganumerique.com>\r\n";
    $headers .= "Reply-To: sambasy@teranganumerique.com\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
    $headers .= "X-Mailer: PHP/" . phpversion() . "\r\n";
    
    $result = mail($to, $subject, $message, $headers);
    
    if ($result) {
        echo "<div style='background: #d4edda; color: #155724; padding: 20px; border-radius: 8px; border-left: 4px solid #28a745; margin: 20px 0;'>";
        echo "<h4 style='margin: 0 0 10px 0;'>✅ Email envoyé avec succès !</h4>";
        echo "<p style='margin: 0;'><strong>Vérifiez maintenant votre boîte email :</strong> sambasy837@gmail.com</p>";
        echo "<p style='margin: 10px 0 0 0; font-size: 14px;'><strong>Important :</strong> Vérifiez aussi le dossier SPAM si vous ne voyez pas l'email dans la boîte de réception.</p>";
        echo "</div>";
    } else {
        echo "<div style='background: #f8d7da; color: #721c24; padding: 20px; border-radius: 8px; border-left: 4px solid #dc3545; margin: 20px 0;'>";
        echo "<h4 style='margin: 0 0 10px 0;'>❌ Échec de l'envoi</h4>";
        echo "<p style='margin: 0;'>Il y a un problème avec la configuration de l'email sambasy@teranganumerique.com</p>";
        
        $last_error = error_get_last();
        if ($last_error) {
            echo "<p style='margin: 10px 0 0 0; font-size: 14px;'><strong>Erreur :</strong> " . htmlspecialchars($last_error['message']) . "</p>";
        }
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
    border-left: 4px solid #667eea;
    text-align: center;
}
.test-button {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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
    box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
}
h2, h3 {
    color: #1f2937;
    border-bottom: 2px solid #e5e7eb;
    padding-bottom: 10px;
}
.info-box {
    background: #eff6ff;
    border: 1px solid #bfdbfe;
    border-radius: 8px;
    padding: 20px;
    margin: 20px 0;
}
.info-box h4 {
    color: #1e40af;
    margin: 0 0 10px 0;
}
</style>

<div class="test-container">
    <div class="info-box">
        <h4>📧 Configuration actuelle</h4>
        <ul style="margin: 0; padding-left: 20px;">
            <li><strong>Email expéditeur :</strong> sambasy@teranganumerique.com</li>
            <li><strong>Email destinataire :</strong> sambasy837@gmail.com</li>
            <li><strong>Serveur :</strong> Hostinger</li>
            <li><strong>Statut :</strong> Prêt pour test</li>
        </ul>
    </div>
    
    <div class="test-form">
        <h3 style="border: none; color: #374151; margin-bottom: 20px;">Test de l'email de domaine</h3>
        <p style="margin-bottom: 25px; color: #6b7280;">Cliquez sur le bouton ci-dessous pour tester l'envoi d'email depuis sambasy@teranganumerique.com vers sambasy837@gmail.com</p>
        
        <form method="POST">
            <button type="submit" name="test_email" class="test-button">
                📧 Tester l'envoi d'email
            </button>
        </form>
    </div>
    
    <div class="info-box">
        <h4>🎯 Après le test</h4>
        <p style="margin: 0;">Si le test fonctionne, vos formulaires de contact et devis enverront automatiquement les emails depuis sambasy@teranganumerique.com vers sambasy837@gmail.com</p>
    </div>
</div>

<p style="text-align: center; margin-top: 30px;">
    <a href="contact.html" style="color: #667eea; text-decoration: none; margin-right: 20px;">📝 Tester le formulaire de contact</a>
    <a href="devis.html" style="color: #667eea; text-decoration: none;">💰 Tester le formulaire de devis</a>
</p>
